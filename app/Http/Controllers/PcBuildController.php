<?php

namespace App\Http\Controllers;

use App\Models\PcBuild;
use App\Models\PcBuildComponent;
use App\Models\Product;
use App\Models\CustomPcBuild;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PcBuildController extends Controller
{
    /**
     * Display curated PC build recommendations for customers.
     */
    public function catalog(Request $request): View
    {
        $budget = $request->input('budget');
        $useCase = $request->input('use_case');

        $pcBuilds = PcBuild::with(['components.product.category'])
            ->when($budget, fn ($query) => $query->byBudget((float) $budget))
            ->when($useCase, fn ($query) => $query->where('use_case', $useCase))
            ->orderBy('budget_min')
            ->paginate(6)
            ->withQueryString();

        $useCases = PcBuild::select('use_case')->distinct()->pluck('use_case');

        return view('pc-builds.catalog', [
            'pcBuilds' => $pcBuilds,
            'selectedBudget' => $budget,
            'selectedUseCase' => $useCase,
            'useCases' => $useCases,
        ]);
    }

    /**
     * Display a single PC build with its components.
     */
    public function show(PcBuild $pcBuild): View
    {
        $pcBuild->load(['components.product.category']);

        return view('pc-builds.show', compact('pcBuild'));
    }

    /**
     * Interactive configurator that suggests a build based on budget and use case.
     */
    public function configurator(Request $request): View
    {
        $budget = (int) $request->input('budget', 15_000_000);
        $useCase = $request->input('use_case');
        $customSelections = collect($request->input('custom', []))
            ->mapWithKeys(fn ($productId, $componentId) => [(int) $componentId => (int) $productId]);

        $useCases = PcBuild::select('use_case')->distinct()->pluck('use_case')->filter()->values();
        if (! $useCase && $useCases->isNotEmpty()) {
            $useCase = $useCases->first();
        }

        $baseQuery = PcBuild::with(['components.product'])->when($useCase, fn ($query) => $query->where('use_case', $useCase));

        $build = (clone $baseQuery)
            ->orderByRaw('ABS(((budget_min + budget_max) / 2) - ?) asc', [$budget])
            ->first();

        if (! $build) {
            $build = PcBuild::with(['components.product'])->first();
        }

        $componentAlternatives = collect();
        if ($build) {
            $build->loadMissing('components.product.category');

            foreach ($build->components as $component) {
                if ($customSelections->has($component->id)) {
                    $replacement = Product::find($customSelections->get($component->id));
                    if ($replacement) {
                        $component->setRelation('product', $replacement);
                    }
                }

                $product = $component->product;
                if (! $product || ! $product->category_id) {
                    $componentAlternatives[$component->id] = collect();
                    continue;
                }

                $componentAlternatives[$component->id] = Product::where('category_id', $product->category_id)
                    ->whereKeyNot($product->id)
                    ->orderByDesc('is_featured')
                    ->orderByDesc('rating')
                    ->limit(6)
                    ->get();
            }
        }

        $totalPrice = $build?->components->sum(fn ($component) => optional($component->product)->price * $component->quantity) ?? 0;
        $remainingBudget = max($budget - $totalPrice, 0);

        $benchmarks = [
            ['title' => 'Valorant', 'fps' => $totalPrice ? min(400, (int) ($totalPrice / 40_000)) : 240],
            ['title' => 'Cyberpunk 2077', 'fps' => $totalPrice ? min(140, (int) ($totalPrice / 120_000)) : 75],
        ];

        return view('pc-builds.configurator', [
            'build' => $build,
            'budget' => $budget,
            'totalPrice' => $totalPrice,
            'remainingBudget' => $remainingBudget,
            'useCases' => $useCases,
            'selectedUseCase' => $useCase,
            'benchmarks' => $benchmarks,
            'componentAlternatives' => $componentAlternatives,
            'customSelections' => $customSelections,
        ]);
    }

    /**
     * Admin view of all PC builds.
     */
    public function index(): View
    {
        $pcBuilds = PcBuild::withCount('components')->latest()->paginate(15);

        return view('admin.pc-builds.index', compact('pcBuilds'));
    }

    /**
     * Show the form to create a new PC build.
     */
    public function create(): View
    {
        return view('admin.pc-builds.create');
    }

    /**
     * Store a new PC build and its components.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data) {
            $components = $data['components'];
            unset($data['components']);

            /** @var PcBuild $pcBuild */
            $pcBuild = PcBuild::create($data);

            foreach ($components as $component) {
                PcBuildComponent::create([
                    'pc_build_id' => $pcBuild->id,
                    'component_type' => $component['component_type'],
                    'product_id' => $component['product_id'],
                    'quantity' => $component['quantity'] ?? 1,
                ]);
            }
        });

        return redirect()
            ->route('admin.pc-builds.index')
            ->with('status', 'Rekomendasi PC berhasil dibuat.');
    }

    /**
     * Show the edit form for an existing build.
     */
    public function edit(PcBuild $pcBuild): View
    {
        $pcBuild->load('components.product');

        return view('admin.pc-builds.edit', compact('pcBuild'));
    }

    /**
     * Update a PC build information and component list.
     */
    public function update(Request $request, PcBuild $pcBuild): RedirectResponse
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($pcBuild, $data) {
            $components = $data['components'];
            unset($data['components']);

            $pcBuild->update($data);
            $pcBuild->components()->delete();

            foreach ($components as $component) {
                PcBuildComponent::create([
                    'pc_build_id' => $pcBuild->id,
                    'component_type' => $component['component_type'],
                    'product_id' => $component['product_id'],
                    'quantity' => $component['quantity'] ?? 1,
                ]);
            }
        });

        return redirect()
            ->route('admin.pc-builds.edit', $pcBuild)
            ->with('status', 'Rekomendasi PC berhasil diperbarui.');
    }

    /**
     * Remove a build from the catalog.
     */
    public function destroy(PcBuild $pcBuild): RedirectResponse
    {
        $pcBuild->delete();

        return redirect()
            ->route('admin.pc-builds.index')
            ->with('status', 'Rekomendasi PC dihapus.');
    }

    /**
     * Validate build payload including nested components.
     */
    protected function validatePayload(Request $request): array
    {
        $messages = [
            'components.required' => 'Minimal satu komponen harus dipilih.',
            'components.*.component_type.required' => 'Jenis komponen wajib diisi.',
            'components.*.product_id.required' => 'Produk komponen wajib dipilih.',
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'budget_min' => ['required', 'numeric', 'min:0'],
            'budget_max' => ['required', 'numeric', 'gte:budget_min'],
            'performance_tier' => ['required', 'string', 'max:255'],
            'use_case' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'components' => ['required', 'array', 'min:1'],
            'components.*.component_type' => ['required', 'string', 'max:255'],
            'components.*.product_id' => ['required', 'exists:products,id'],
            'components.*.quantity' => ['nullable', 'integer', 'min:1'],
        ], $messages);

        $validated['components'] = collect($validated['components'])
            ->map(function ($component) {
                return [
                    'component_type' => $component['component_type'],
                    'product_id' => $component['product_id'],
                    'quantity' => $component['quantity'] ?? 1,
                ];
            })
            ->all();

        return $validated;
    }

    /**
     * Custom builder for manual component selection.
     */
    public function customBuilder(Request $request): View
    {
        $budget = (int) $request->input('budget', 15_000_000);
        $useCase = $request->input('use_case', 'Gaming');
        $tier = $request->input('tier', 'Best Value');
        $selectedComponents = $request->input('components', []);

        // Get budget allocation based on use case and tier
        $budgetAllocation = $this->getBudgetAllocation($useCase, $tier);
        
        // Define core components (required)
        $coreComponents = [
            'processor' => ['label' => 'Processor (CPU)', 'icon' => 'memory', 'desc' => 'Otak dari PC yang mengatur semua proses komputasi', 'required' => true],
            'motherboard' => ['label' => 'Motherboard', 'icon' => 'developer_board', 'desc' => 'Papan sirkuit yang menghubungkan semua komponen', 'required' => true],
            'ram' => ['label' => 'RAM (Memory)', 'icon' => 'memory_alt', 'desc' => 'Penunjang kecepatan multitasking dan performa sistem', 'required' => true],
            'storage' => ['label' => 'Storage (SSD/HDD)', 'icon' => 'hard_drive', 'desc' => 'Media penyimpanan data dan sistem operasi', 'required' => true],
            'psu' => ['label' => 'Power Supply (PSU)', 'icon' => 'power', 'desc' => 'Penyuplai daya listrik ke seluruh komponen', 'required' => true],
            'casing' => ['label' => 'Casing', 'icon' => 'computer', 'desc' => 'Wadah fisik untuk melindungi komponen', 'required' => true],
        ];

        // Define optional components
        $optionalComponents = [
            'gpu' => ['label' => 'Graphics Card (GPU)', 'icon' => 'stadia_controller', 'desc' => 'Wajib untuk gaming berat atau desain grafis profesional', 'required' => false],
            'cpu_cooler' => ['label' => 'CPU Cooler', 'icon' => 'ac_unit', 'desc' => 'Pendingin tambahan jika processor tidak menyertakan cooler bawaan', 'required' => false],
        ];

        // Get smart recommendations based on budget allocation
        $recommendations = $this->getSmartRecommendations($budget, $budgetAllocation);

        // Calculate total price based on selected components
        $totalPrice = 0;
        $componentDetails = [];
        
        foreach (array_merge($coreComponents, $optionalComponents) as $type => $info) {
            if (isset($selectedComponents[$type])) {
                $product = Product::find($selectedComponents[$type]);
                if ($product) {
                    $totalPrice += $product->price;
                    $componentDetails[$type] = [
                        'info' => $info,
                        'product' => $product,
                        'allocated_budget' => isset($budgetAllocation[$type]) ? $budget * ($budgetAllocation[$type] / 100) : 0,
                    ];
                } else {
                    $componentDetails[$type] = [
                        'info' => $info,
                        'product' => null,
                        'allocated_budget' => isset($budgetAllocation[$type]) ? $budget * ($budgetAllocation[$type] / 100) : 0,
                    ];
                }
            } else {
                // Use recommended product if not selected
                $recommendedProduct = $recommendations[$type] ?? null;
                $componentDetails[$type] = [
                    'info' => $info,
                    'product' => $recommendedProduct,
                    'allocated_budget' => isset($budgetAllocation[$type]) ? $budget * ($budgetAllocation[$type] / 100) : 0,
                ];
                if ($recommendedProduct) {
                    $totalPrice += $recommendedProduct->price;
                }
            }
        }

        $remainingBudget = max($budget - $totalPrice, 0);

        $benchmarks = [
            ['title' => 'Valorant', 'fps' => $totalPrice ? min(400, (int) ($totalPrice / 40_000)) : 240],
            ['title' => 'Cyberpunk 2077', 'fps' => $totalPrice ? min(140, (int) ($totalPrice / 120_000)) : 75],
        ];

        return view('pc-builds.builder', [
            'budget' => $budget,
            'useCase' => $useCase,
            'tier' => $tier,
            'totalPrice' => $totalPrice,
            'remainingBudget' => $remainingBudget,
            'coreComponents' => $coreComponents,
            'optionalComponents' => $optionalComponents,
            'componentDetails' => $componentDetails,
            'benchmarks' => $benchmarks,
            'budgetAllocation' => $budgetAllocation,
        ]);
    }

    /**
     * Get budget allocation percentage for each component based on use case and tier.
     */
    protected function getBudgetAllocation(string $useCase, string $tier): array
    {
        $allocations = [
            'Gaming' => [
                'Best Performance' => [
                    'gpu' => 40,
                    'processor' => 20,
                    'ram' => 12,
                    'storage' => 10,
                    'motherboard' => 10,
                    'psu' => 5,
                    'casing' => 3,
                ],
                'Best Value' => [
                    'gpu' => 35,
                    'processor' => 22,
                    'ram' => 13,
                    'motherboard' => 12,
                    'storage' => 10,
                    'psu' => 5,
                    'casing' => 3,
                ],
                'Future Proof' => [
                    'processor' => 25,
                    'gpu' => 30,
                    'motherboard' => 15,
                    'ram' => 12,
                    'storage' => 10,
                    'psu' => 6,
                    'casing' => 2,
                ],
            ],
            'Office' => [
                'Best Performance' => [
                    'processor' => 30,
                    'ram' => 20,
                    'storage' => 20,
                    'motherboard' => 15,
                    'psu' => 8,
                    'casing' => 5,
                    'gpu' => 2,
                ],
                'Best Value' => [
                    'processor' => 28,
                    'storage' => 22,
                    'ram' => 18,
                    'motherboard' => 15,
                    'psu' => 10,
                    'casing' => 5,
                    'gpu' => 2,
                ],
                'Future Proof' => [
                    'processor' => 32,
                    'ram' => 22,
                    'storage' => 18,
                    'motherboard' => 15,
                    'psu' => 8,
                    'casing' => 4,
                    'gpu' => 1,
                ],
            ],
            'Editing' => [
                'Best Performance' => [
                    'processor' => 35,
                    'ram' => 25,
                    'gpu' => 15,
                    'storage' => 15,
                    'motherboard' => 6,
                    'psu' => 3,
                    'casing' => 1,
                ],
                'Best Value' => [
                    'processor' => 32,
                    'ram' => 28,
                    'storage' => 18,
                    'gpu' => 12,
                    'motherboard' => 6,
                    'psu' => 3,
                    'casing' => 1,
                ],
                'Future Proof' => [
                    'processor' => 38,
                    'ram' => 28,
                    'storage' => 15,
                    'gpu' => 10,
                    'motherboard' => 6,
                    'psu' => 2,
                    'casing' => 1,
                ],
            ],
        ];

        return $allocations[$useCase][$tier] ?? $allocations['Gaming']['Best Value'];
    }

    /**
     * Get smart product recommendations based on budget allocation.
     */
    protected function getSmartRecommendations(int $budget, array $allocation): array
    {
        $recommendations = [];
        
        $componentMapping = [
            'processor' => 'Processor',
            'gpu' => 'Graphics Card',
            'motherboard' => 'Motherboard',
            'ram' => 'Memory',
            'storage' => 'Storage',
            'psu' => 'Power Supply',
            'casing' => 'Casing',
            'cpu_cooler' => 'Cooling',
        ];

        // Define core components that MUST have recommendations
        $coreComponents = ['processor', 'motherboard', 'ram', 'storage', 'psu', 'casing'];

        foreach ($allocation as $component => $percentage) {
            $allocatedBudget = $budget * ($percentage / 100);
            $categoryName = $componentMapping[$component] ?? null;
            
            if (!$categoryName) continue;

            // Find products in price range (±15% tolerance for initial search)
            $minPrice = $allocatedBudget * 0.85;
            $maxPrice = $allocatedBudget * 1.15;

            $product = Product::whereHas('category', function ($query) use ($categoryName) {
                    $query->where('name', 'LIKE', "%{$categoryName}%");
                })
                ->whereBetween('price', [$minPrice, $maxPrice])
                ->where('stock', '>', 0)
                ->orderByDesc('rating')
                ->orderByDesc('is_featured')
                ->first();

            // If no product found in initial range AND it's a core component, expand search
            if (!$product && in_array($component, $coreComponents)) {
                // Try wider range (±30%)
                $minPrice = $allocatedBudget * 0.7;
                $maxPrice = $allocatedBudget * 1.3;
                
                $product = Product::whereHas('category', function ($query) use ($categoryName) {
                        $query->where('name', 'LIKE', "%{$categoryName}%");
                    })
                    ->whereBetween('price', [$minPrice, $maxPrice])
                    ->where('stock', '>', 0)
                    ->orderByDesc('rating')
                    ->orderByDesc('is_featured')
                    ->first();
            }

            // If still no product for core components, get closest available product
            if (!$product && in_array($component, $coreComponents)) {
                $product = Product::whereHas('category', function ($query) use ($categoryName) {
                        $query->where('name', 'LIKE', "%{$categoryName}%");
                    })
                    ->where('stock', '>', 0)
                    ->orderByRaw('ABS(price - ?) ASC', [$allocatedBudget])
                    ->orderByDesc('rating')
                    ->first();
            }

            if ($product) {
                $recommendations[$component] = $product;
            }
        }

        // Final check: ensure ALL core components have recommendations
        foreach ($coreComponents as $coreComponent) {
            if (!isset($recommendations[$coreComponent])) {
                $categoryName = $componentMapping[$coreComponent];
                
                // Get any available product from this category
                $fallbackProduct = Product::whereHas('category', function ($query) use ($categoryName) {
                        $query->where('name', 'LIKE', "%{$categoryName}%");
                    })
                    ->where('stock', '>', 0)
                    ->orderByDesc('rating')
                    ->orderByDesc('is_featured')
                    ->first();
                
                if ($fallbackProduct) {
                    $recommendations[$coreComponent] = $fallbackProduct;
                }
            }
        }

        return $recommendations;
    }

    /**
     * Get alternative products for a specific component type and budget.
     */
    public function getAlternativeProducts(Request $request)
    {
        $componentType = $request->input('component_type');
        $budget = (float) $request->input('budget', 0);
        $currentProductId = $request->input('current_product_id');
        
        // Component to category mapping
        $componentMapping = [
            'processor' => 'Processor',
            'gpu' => 'Graphics Card',
            'motherboard' => 'Motherboard',
            'ram' => 'Memory',
            'storage' => 'Storage',
            'psu' => 'Power Supply',
            'casing' => 'Casing',
            'cpu_cooler' => 'Cooling',
        ];

        if (!isset($componentMapping[$componentType])) {
            return response()->json(['error' => 'Invalid component type'], 400);
        }

        $categoryName = $componentMapping[$componentType];
        
        // Query products in same category with wider price range (±30%)
        $minPrice = $budget * 0.7;
        $maxPrice = $budget * 1.3;
        
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', 'LIKE', "%{$categoryName}%");
            })
            ->whereBetween('price', [$minPrice, $maxPrice])
            ->when($currentProductId, function($query) use ($currentProductId) {
                return $query->where('id', '!=', $currentProductId);
            })
            ->orderBy('price', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                // Format specifications as readable string
                $specsString = '';
                if ($product->specifications && is_array($product->specifications)) {
                    $specs = [];
                    foreach ($product->specifications as $key => $value) {
                        $specs[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
                    }
                    $specsString = implode(' • ', $specs);
                }
                
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'rating' => $product->rating,
                    'image' => $product->image,
                    'description' => $product->description,
                    'specifications' => $specsString, // Send formatted specifications
                ];
            });

        return response()->json([
            'component_type' => $componentType,
            'category' => $categoryName,
            'budget' => $budget,
            'products' => $products,
        ]);
    }

    /**
     * Save custom PC build.
     */
    public function saveBuild(Request $request)
    {
        $request->validate([
            'build_name' => 'nullable|string|max:255',
            'budget' => 'required|numeric',
            'use_case' => 'required|string',
            'tier' => 'required|string',
            'components' => 'required|array',
        ]);

        $components = $request->input('components');
        $productIds = array_values(array_filter($components));
        $totalPrice = Product::whereIn('id', $productIds)->sum('price');

        $build = CustomPcBuild::create([
            'user_id' => Auth::id(),
            'session_id' => !Auth::check() ? session()->getId() : null,
            'build_name' => $request->input('build_name', 'My PC Build'),
            'budget' => $request->input('budget'),
            'use_case' => $request->input('use_case'),
            'tier' => $request->input('tier'),
            'components' => $components,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Build berhasil disimpan!',
            'build_id' => $build->id,
        ]);
    }

    /**
     * Add all build components to cart.
     */
    public function addBuildToCart(Request $request)
    {
        $request->validate([
            'components' => 'required|array',
        ]);

        $components = $request->input('components');
        $productIds = array_values(array_filter($components));
        
        if (empty($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada komponen untuk ditambahkan ke keranjang',
            ], 400);
        }

        // Get or create cart
        $cart = Cart::firstOrCreate(
            Auth::check() 
                ? ['user_id' => Auth::id()] 
                : ['session_id' => session()->getId()]
        );

        $addedCount = 0;
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
            if (!$product) continue;

            // Check if product already in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // Update quantity
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                // Create new cart item
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
            $addedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "{$addedCount} komponen berhasil ditambahkan ke keranjang!",
            'cart_count' => $cart->getItemCount(),
        ]);
    }

    /**
     * View saved builds for current user.
     */
    public function myBuilds()
    {
        $builds = CustomPcBuild::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pc-builds.my-builds', compact('builds'));
    }

    /**
     * Delete saved build.
     */
    public function deleteBuild(CustomPcBuild $build)
    {
        // Authorization check
        if ($build->user_id !== Auth::id()) {
            abort(403);
        }

        $build->delete();

        return redirect()->route('pc-builds.my-builds')
            ->with('success', 'Build berhasil dihapus!');
    }
}
