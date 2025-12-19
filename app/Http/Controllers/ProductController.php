<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display public product catalog with optional filters.
     */
    public function catalog(Request $request)
    {
        $perPage = (int) $request->input('per_page', 12);
        $sort = $request->input('sort', 'relevance');
        $viewMode = $request->input('view', 'grid');
        if (! in_array($viewMode, ['grid', 'list'], true)) {
            $viewMode = 'grid';
        }
        $search = $request->input('search');
        $selectedCategories = array_filter((array) $request->input('categories'));
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        $priceStats = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        $productsQuery = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($productQuery) use ($search) {
                    $productQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                });
            })
            ->when(! empty($selectedCategories), function ($query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            })
            ->when($priceMin, fn ($query) => $query->where('price', '>=', $priceMin))
            ->when($priceMax, fn ($query) => $query->where('price', '<=', $priceMax));

        $productsQuery = match ($sort) {
            'price-desc' => $productsQuery->orderByDesc('price'),
            'price-asc' => $productsQuery->orderBy('price'),
            'latest' => $productsQuery->orderByDesc('created_at'),
            default => $productsQuery->orderByDesc('is_featured')->orderByDesc('updated_at'),
        };

        $products = $productsQuery
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('products.catalog', [
            'products' => $products,
            'categories' => $categories,
            'priceStats' => $priceStats,
            'selectedCategories' => $selectedCategories,
            'priceMin' => $priceMin ?? $priceStats?->min_price,
            'priceMax' => $priceMax ?? $priceStats?->max_price,
            'sort' => $sort,
            'viewMode' => $viewMode,
            'search' => $search,
        ]);
    }

    /**
     * Display a single product detail page.
     */
    public function show(Product $product, Request $request)
    {
        $related = Product::where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Load reviews with user info, filtered by rating if specified
        $reviewsQuery = $product->reviews()->with('user')->latest();
        
        $filterRating = $request->input('rating');
        if ($filterRating && in_array($filterRating, [1, 2, 3, 4, 5])) {
            $reviewsQuery->where('rating', $filterRating);
        }

        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        // Calculate rating distribution
        $ratingCounts = $product->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = array_sum($ratingCounts);
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingCounts[$i] ?? 0;
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        $avgRating = $product->rating ?? 0;
        $userHasReviewed = auth()->check() 
            ? $product->reviews()->where('user_id', auth()->id())->exists()
            : false;

        return view('products.show', compact(
            'product', 
            'related', 
            'reviews', 
            'ratingDistribution', 
            'totalReviews', 
            'avgRating',
            'userHasReviewed',
            'filterRating'
        ));
    }

    /**
     * Display admin product list with management controls.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('status'), function ($query) use ($request) {
                return match ($request->input('status')) {
                    'featured' => $query->where('is_featured', true),
                    'recommended' => $query->where('is_recommended', true),
                    'out-of-stock' => $query->where('stock', '<=', 0),
                    default => $query,
                };
            })
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show form for creating a product.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Persist a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data) {
            Product::create($data);
        });

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk baru berhasil dibuat.');
    }

    /**
     * Show the edit form for an existing product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatePayload($request, $product);

        DB::transaction(function () use ($product, $data) {
            $product->update($data);
        });

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Produk berhasil diperbarui.');
    }

    /**
     * Delete a product from catalog.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk telah dihapus.');
    }

    /**
     * Validate and normalize incoming payload.
     */
    protected function validatePayload(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore(optional($product)->id),
            ],
            'description' => ['required', 'string'],
            'specifications' => ['nullable'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_recommended' => ['sometimes', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['specifications'] = $this->normalizeSpecifications($request->input('specifications'));
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_recommended'] = $request->boolean('is_recommended');

        return $validated;
    }

    /**
     * Ensure specifications data is a clean associative array.
     */
    protected function normalizeSpecifications($specifications): array
    {
        if (is_array($specifications)) {
            return $specifications;
        }

        if (empty($specifications)) {
            return [];
        }

        if (is_string($specifications)) {
            // Try parsing JSON first.
            try {
                $decoded = json_decode($specifications, true, 512, JSON_THROW_ON_ERROR);

                return is_array($decoded) ? $decoded : [];
            } catch (Throwable $exception) {
                // Fall through and attempt parsing line-based key:value pairs.
            }

            $lines = preg_split('/\r?\n/', trim($specifications));
            $result = [];

            foreach ($lines as $line) {
                if (! str_contains($line, ':')) {
                    continue;
                }

                [$key, $value] = array_map('trim', explode(':', $line, 2));

                if ($key !== '' && $value !== '') {
                    $result[$key] = $value;
                }
            }

            return $result;
        }

        return [];
    }
}
