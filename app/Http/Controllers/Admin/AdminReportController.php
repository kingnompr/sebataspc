<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(): View
    {
        // Revenue statistics
        $totalRevenue = Order::whereIn('status', ['paid', 'delivered'])->sum('total');
        $monthlyRevenue = Order::whereIn('status', ['paid', 'delivered'])
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        
        // Order statistics
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $pendingOrders = Order::whereIn('status', ['pending', 'processing'])->count();
        
        // Product statistics
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        
        // Top selling products (based on order items)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'delivered'])
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Sales by category
        $salesByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'delivered'])
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as revenue'), DB::raw('COUNT(DISTINCT orders.id) as orders_count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();
        
        // Monthly sales trend (last 12 months)
        $monthlySales = Order::whereIn('status', ['paid', 'delivered'])
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return view('admin.reports.index', compact(
            'totalRevenue',
            'monthlyRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'topProducts',
            'salesByCategory',
            'monthlySales'
        ));
    }
}
