<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Wishlist::with('product.category')
            ->where('user_id', $user->id);
        
        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }
        
        $wishlists = $query->latest()->get();
        
        return view('wishlist.index', compact('wishlists'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        $user = auth()->user();
        
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();
        
        if ($exists) {
            return back()->with('error', 'Produk sudah ada di daftar keinginan!');
        }
        
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);
        
        return back()->with('success', 'Produk ditambahkan ke daftar keinginan!');
    }
    
    public function destroy(Wishlist $wishlist)
    {
        // Ensure user owns this wishlist item
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }
        
        $wishlist->delete();
        
        return back()->with('success', 'Produk dihapus dari daftar keinginan!');
    }
    
    public function destroyAll()
    {
        Wishlist::where('user_id', auth()->id())->delete();
        
        return back()->with('success', 'Semua item dihapus dari daftar keinginan!');
    }
    
    public function addAllToCart()
    {
        $user = auth()->user();
        $wishlists = Wishlist::with('product')
            ->where('user_id', $user->id)
            ->get();
        
        if ($wishlists->isEmpty()) {
            return back()->with('error', 'Tidak ada item di daftar keinginan!');
        }
        
        // Get or create cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        $addedCount = 0;
        foreach ($wishlists as $wishlist) {
            $product = $wishlist->product;
            
            // Skip if out of stock
            if ($product->stock <= 0) {
                continue;
            }
            
            // Check if already in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();
            
            if ($cartItem) {
                // Increase quantity if already in cart
                if ($cartItem->quantity < $product->stock) {
                    $cartItem->increment('quantity');
                    $addedCount++;
                }
            } else {
                // Add new item to cart
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
                $addedCount++;
            }
        }
        
        if ($addedCount > 0) {
            return redirect()->route('cart.index')->with('success', "$addedCount produk ditambahkan ke keranjang!");
        }
        
        return back()->with('error', 'Tidak ada produk yang bisa ditambahkan (stok habis atau sudah di keranjang)!');
    }
}
