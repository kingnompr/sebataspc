<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        
        // Filter by stock status
        if ($request->stock_status == 'low') {
            $query->whereRaw('stock <= min_stock_alert');
        } elseif ($request->stock_status == 'out') {
            $query->where('stock', 0);
        } elseif ($request->stock_status == 'in') {
            $query->whereRaw('stock > min_stock_alert');
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%");
            });
        }
        
        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $products = $query->paginate(20)->withQueryString();
        
        // Get distinct brands for filter
        $brands = Product::distinct()->pluck('brand')->filter()->sort();
        
        // Get categories
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'sku' => 'nullable|unique:products,sku|max:255',
            'cost_price' => 'nullable|numeric|min:0',
            'markup_percentage' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:500',
            
            // Compatibility fields
            'socket' => 'nullable|string|max:100',
            'chipset' => 'nullable|string|max:100',
            'memory_type' => 'nullable|string|max:50',
            'memory_speed' => 'nullable|integer',
            'memory_slots' => 'nullable|integer',
            'interface' => 'nullable|string|max:100',
            'capacity_gb' => 'nullable|integer',
            'tdp' => 'nullable|integer',
            'wattage' => 'nullable|integer',
            'efficiency_rating' => 'nullable|string|max:50',
            'form_factor' => 'nullable|string|max:50',
            'length_mm' => 'nullable|integer',
            'height_mm' => 'nullable|integer',
            'supported_memory_types' => 'nullable|array',
            'compatible_sockets' => 'nullable|array',
            'rgb_support' => 'nullable|boolean',
        ]);
        
        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Don't store images locally on Railway (ephemeral filesystem)
        // Use external Unsplash URLs instead
        if (!isset($validated['image']) || empty($validated['image'])) {
            $validated['image'] = 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop';
        }
        
        // Convert arrays to JSON
        if (isset($validated['supported_memory_types'])) {
            $validated['supported_memory_types'] = json_encode($validated['supported_memory_types']);
        }
        if (isset($validated['compatible_sockets'])) {
            $validated['compatible_sockets'] = json_encode($validated['compatible_sockets']);
        }
        
        // Set default min_stock_alert if not provided
        if (!isset($validated['min_stock_alert'])) {
            $validated['min_stock_alert'] = 5;
        }
        
        try {
            $product = Product::create($validated);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        
        // Decode JSON fields for form
        if ($product->supported_memory_types) {
            $product->supported_memory_types = json_decode($product->supported_memory_types, true);
        }
        if ($product->compatible_sockets) {
            $product->compatible_sockets = json_decode($product->compatible_sockets, true);
        }
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'sku' => 'nullable|unique:products,sku,' . $product->id . '|max:255',
            'cost_price' => 'nullable|numeric|min:0',
            'markup_percentage' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:500',
            
            // Compatibility fields
            'socket' => 'nullable|string|max:100',
            'chipset' => 'nullable|string|max:100',
            'memory_type' => 'nullable|string|max:50',
            'memory_speed' => 'nullable|integer',
            'memory_slots' => 'nullable|integer',
            'interface' => 'nullable|string|max:100',
            'capacity_gb' => 'nullable|integer',
            'tdp' => 'nullable|integer',
            'wattage' => 'nullable|integer',
            'efficiency_rating' => 'nullable|string|max:50',
            'form_factor' => 'nullable|string|max:50',
            'length_mm' => 'nullable|integer',
            'height_mm' => 'nullable|integer',
            'supported_memory_types' => 'nullable|array',
            'compatible_sockets' => 'nullable|array',
            'rgb_support' => 'nullable|boolean',
        ]);
        
        // Update slug if name changed
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Don't store images locally on Railway (ephemeral filesystem)
        // Use external Unsplash URLs instead
        if (!isset($validated['image']) || empty($validated['image'])) {
            // Keep existing image if no new one provided
            unset($validated['image']);
        }
        
        // Convert arrays to JSON
        if (isset($validated['supported_memory_types'])) {
            $validated['supported_memory_types'] = json_encode($validated['supported_memory_types']);
        }
        if (isset($validated['compatible_sockets'])) {
            $validated['compatible_sockets'] = json_encode($validated['compatible_sockets']);
        }
        
        try {
            $product->update($validated);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
    
    /**
     * Get low stock products
     */
    public function lowStock()
    {
        $products = Product::whereRaw('stock <= min_stock_alert')
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get();
            
        return view('admin.products.low-stock', compact('products'));
    }
    
    /**
     * Preview mass price update
     */
    public function massUpdatePreview(Request $request)
    {
        $query = Product::query();
        
        // Apply filters
        if ($request->filled('category_ids')) {
            $query->whereIn('category_id', $request->category_ids);
        }
        
        if ($request->filled('brands')) {
            $query->whereIn('brand', $request->brands);
        }
        
        $products = $query->get();
        $preview = [];
        
        foreach ($products as $product) {
            $newPrice = $this->calculateNewPrice($product->price, $request);
            
            $preview[] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'current_price' => $product->price,
                'new_price' => $newPrice,
                'difference' => $newPrice - $product->price,
                'percentage_change' => round((($newPrice - $product->price) / $product->price) * 100, 2),
            ];
        }
        
        return response()->json([
            'success' => true,
            'count' => count($preview),
            'products' => $preview,
        ]);
    }
    
    /**
     * Apply mass price update
     */
    public function massUpdate(Request $request)
    {
        $validated = $request->validate([
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'brands' => 'nullable|array',
            'update_type' => 'required|in:percentage,fixed',
            'percentage' => 'required_if:update_type,percentage|numeric',
            'percentage_direction' => 'required_if:update_type,percentage|in:increase,decrease',
            'fixed_amount' => 'required_if:update_type,fixed|numeric',
            'fixed_direction' => 'required_if:update_type,fixed|in:increase,decrease',
        ]);
        
        $query = Product::query();
        
        // Apply filters
        if ($request->filled('category_ids')) {
            $query->whereIn('category_id', $request->category_ids);
        }
        
        if ($request->filled('brands')) {
            $query->whereIn('brand', $request->brands);
        }
        
        $products = $query->get();
        $updatedCount = 0;
        
        foreach ($products as $product) {
            $newPrice = $this->calculateNewPrice($product->price, $request);
            $product->update(['price' => round($newPrice)]);
            $updatedCount++;
        }
        
        return redirect()->back()
            ->with('success', "{$updatedCount} produk berhasil diupdate!");
    }
    
    /**
     * Calculate new price based on update type
     */
    private function calculateNewPrice($currentPrice, $request)
    {
        $newPrice = $currentPrice;
        
        if ($request->update_type === 'percentage') {
            $percentage = $request->percentage / 100;
            if ($request->percentage_direction === 'increase') {
                $newPrice = $currentPrice * (1 + $percentage);
            } else {
                $newPrice = $currentPrice * (1 - $percentage);
            }
        } elseif ($request->update_type === 'fixed') {
            if ($request->fixed_direction === 'increase') {
                $newPrice = $currentPrice + $request->fixed_amount;
            } else {
                $newPrice = $currentPrice - $request->fixed_amount;
            }
        }
        
        return max(0, $newPrice); // Ensure price doesn't go negative
    }
}
