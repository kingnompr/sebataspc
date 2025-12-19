# Panduan Gambar Produk - Smart PC Builder

## 📸 Status Gambar Saat Ini

Saat ini sistem menggunakan **placeholder images** dengan warna berbeda untuk setiap kategori:
- 🔵 **Processor** - Indigo
- 🔴 **Graphics Card** - Red
- 🟢 **Motherboard** - Green
- 🟠 **Memory (RAM)** - Orange
- 🟣 **Storage** - Purple
- 🟡 **Power Supply** - Yellow
- 🔷 **Casing** - Cyan
- 🔵 **Cooling** - Blue

## 🎯 Cara Menambahkan Gambar Real

### Opsi 1: Upload Manual (Recommended)

1. **Siapkan gambar** dengan format:
   - Format: JPG, PNG, WEBP
   - Ukuran optimal: 400x400px atau 800x800px
   - Naming: sesuai dengan slug produk
   
2. **Upload ke folder**:
   ```
   public/images/products/
   ```

3. **Contoh penamaan**:
   - `intel-core-i5-12400f.jpg`
   - `nvidia-gtx-1650-4gb.jpg`
   - `corsair-cv550-550w-bronze.jpg`

4. **Update database** (opsional):
   ```sql
   UPDATE products 
   SET image = 'images/products/intel-core-i5-12400f.jpg' 
   WHERE slug = 'intel-core-i5-12400f';
   ```

### Opsi 2: Download dari Internet

**Sumber gambar yang direkomendasikan**:

1. **Manufacturer Official**:
   - Intel: https://www.intel.com/content/www/us/en/products
   - AMD: https://www.amd.com/en/products/processors
   - NVIDIA: https://www.nvidia.com/en-us/geforce/graphics-cards/
   - ASUS, MSI, Gigabyte: Website resmi masing-masing

2. **Tech Review Sites**:
   - TechPowerUp
   - AnandTech
   - Tom's Hardware

3. **E-commerce** (dengan permission):
   - Tokopedia
   - Shopee
   - Bukalapak

### Opsi 3: Gunakan URL External (Tidak Recommended)

Update model untuk langsung menggunakan URL eksternal:

```php
// Update seeder dengan URL gambar
'image' => 'https://example.com/product-image.jpg'
```

⚠️ **Risiko**: Link bisa broken sewaktu-waktu

## 🔧 Script Helper untuk Update Gambar

Jalankan script ini untuk update semua produk dengan gambar yang sudah di-upload:

```php
php artisan tinker

// Update gambar berdasarkan file yang ada
$products = App\Models\Product::all();
foreach($products as $product) {
    $imagePath = "images/products/{$product->slug}.jpg";
    if(file_exists(public_path($imagePath))) {
        $product->update(['image' => $imagePath]);
        echo "Updated: {$product->name}\n";
    }
}
```

## 📦 Struktur Folder

```
public/
├── images/
│   └── products/
│       ├── intel-core-i5-12400f.jpg
│       ├── amd-ryzen-5-3600.jpg
│       ├── nvidia-gtx-1650-4gb.jpg
│       ├── corsair-cv550-550w-bronze.jpg
│       └── ... (89 produk lainnya)
```

## 🎨 Placeholder Service (Current)

Sistem saat ini menggunakan **placehold.co** untuk generate placeholder:
- URL Pattern: `https://placehold.co/400x400/{COLOR}/white?text={CATEGORY}`
- Otomatis dengan warna per kategori
- Tidak perlu download/upload
- Perfect untuk development dan testing

## ✅ Rekomendasi

**Untuk Production**:
1. ✅ Upload gambar real ke `public/images/products/`
2. ✅ Gunakan optimized images (400-800px, compressed)
3. ✅ Naming konsisten dengan slug produk
4. ✅ Update database dengan path yang benar

**Untuk Development**:
- ✅ Gunakan placeholder (sudah aktif sekarang)
- ✅ Fokus ke functionality dulu
- ✅ Upload gambar belakangan saat mau production

## 🚀 Quick Start

Sistem sudah siap pakai dengan placeholder! Tidak perlu action apapun untuk melihat gambar di website. Gambar placeholder akan otomatis muncul dengan warna berbeda per kategori.

Refresh browser di http://127.0.0.1:8000/pc-builds/builder untuk melihat hasilnya.
