<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class AddProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all products with placeholder images based on category
        $products = Product::with('category')->get();

        foreach ($products as $product) {
            if (!$product->image) {
                // Use placeholder images from via.placeholder.com or placehold.co
                $categorySlug = $product->category->slug ?? 'default';
                
                // Generate image URL based on category
                $imageUrl = $this->getPlaceholderImage($categorySlug, $product->name);
                
                $product->update(['image' => $imageUrl]);
            }
        }

        $this->command->info('Product images updated successfully!');
    }

    /**
     * Get placeholder image URL based on category
     */
    private function getPlaceholderImage(string $category, string $productName): string
    {
        // Use placehold.co for modern placeholder images
        $width = 800;
        $height = 600;
        
        $categoryColors = [
            'cpu' => '2563eb',        // Blue
            'gpu' => '16a34a',        // Green
            'motherboard' => 'dc2626', // Red
            'ram' => 'ca8a04',        // Yellow
            'storage' => '9333ea',     // Purple
            'psu' => 'ea580c',        // Orange
            'case' => '0891b2',       // Cyan
            'cooling' => '4f46e5',    // Indigo
        ];

        $color = $categoryColors[$category] ?? '6b7280'; // Gray default
        
        // Create a simple placeholder with category name
        $categoryLabel = strtoupper(str_replace('-', ' ', $category));
        
        return "https://placehold.co/{$width}x{$height}/{$color}/ffffff?text=" . urlencode($categoryLabel);
    }
}
