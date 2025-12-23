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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // max 5MB per image
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.max' => 'Ulasan maksimal 1000 karakter.',
            'images.max' => 'Maksimal 5 foto dapat diupload.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
            'images.*.max' => 'Ukuran gambar maksimal 5MB.',
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

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('reviews', $filename, 'public');
                $imagePaths[] = 'storage/' . $path;
            }
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'images' => $imagePaths,
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
