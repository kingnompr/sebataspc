<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.max' => 'Ulasan maksimal 1000 karakter.',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->withErrors(['review' => 'Anda sudah memberikan ulasan untuk produk ini.']);
        }

        // Check if user has purchased this product (verified purchase)
        $hasPurchased = auth()->user()->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->whereIn('status', ['paid', 'processing', 'qc', 'shipped', 'delivered'])
            ->exists();

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => $hasPurchased,
        ]);

        // Update product average rating
        $avgRating = $product->reviews()->avg('rating');
        $product->update(['rating' => round($avgRating, 1)]);

        $message = $hasPurchased 
            ? 'Terima kasih! Ulasan terverifikasi Anda telah berhasil ditambahkan.' 
            : 'Terima kasih! Ulasan Anda telah berhasil ditambahkan.';

        return back()->with('success', $message);
    }
}
