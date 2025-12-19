<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'items']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $orders = $query->latest()->paginate(20);
        
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }
    
    public function show(Order $order): View
    {
        $order->load(['user', 'items.product', 'items.product.category']);
        
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,qc,shipped,delivered,cancelled'
        ]);
        
        $order->update([
            'status' => $request->status
        ]);
        
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        }
        
        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}
