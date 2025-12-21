<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PcBuild;
use App\Models\Product;
use App\Models\Order;
use App\Models\CustomPcBuild;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with quick metrics.
     */
    public function index(): View
    {
        // Calculate total revenue from orders (if orders exist)
        $totalRevenue = Order::whereIn('status', ['paid', 'delivered'])
            ->sum('total') ?? 0;
        
        // Orders today
        $ordersToday = Order::whereDate('created_at', today())->count();
        
        // Pending orders
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        
        // Low stock products (stock <= 10)
        $lowStockCount = Product::where('stock', '<=', 10)->count();
        
        $stats = [
            'total_products' => Product::count(),
            'categories' => Category::count(),
            'total_revenue' => $totalRevenue,
            'revenue_formatted' => $totalRevenue <= 50000000 
                ? number_format($totalRevenue / 1000000, 1) . ' Juta'
                : number_format($totalRevenue, 0, ',', '.'),
            'orders_today' => $ordersToday,
            'pending_orders' => $pendingOrders,
            'low_stock_count' => $lowStockCount,
            'out_of_stock' => Product::where('stock', 0)->count(),
            'pc_builds' => PcBuild::count(),
            'custom_builds' => CustomPcBuild::count(),
        ];
        
        // Get low stock products (stock <= 10)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(10)
            ->get();
        
        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Get top selling categories
        $productsByCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();
        
        // Get top brands
        $topBrands = Product::select('brand', DB::raw('count(*) as count'))
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'lowStockProducts', 
            'recentOrders',
            'productsByCategory',
            'topBrands'
        ));
    }
}
