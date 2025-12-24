# Cara Upload Gambar Produk

## Metode 1: Via Admin Dashboard (Paling Mudah) ✅

1. **Login ke Admin Panel**
   - Buka: `https://sebataspc-production.up.railway.app/admin`
   - Email: `admin@sebataspc.com`
   - Password: `admin123`

2. **Edit Produk**
   - Klik menu **"Products"** di sidebar
   - Klik tombol **"Edit"** pada produk yang ingin ditambahkan gambar
   - Scroll ke bagian **"Product Image"**
   - Klik **"Choose File"** dan pilih gambar produk
   - Klik **"Update Product"**

3. **Format Gambar yang Disarankan**
   - Format: JPG, PNG, WebP
   - Ukuran: 800x600px atau 1200x900px
   - Ukuran file: Max 2MB
   - Rasio: 4:3 atau 16:9

## Metode 2: Update Seeder dengan Gambar URL

Edit file seeder dan ganti placeholder dengan URL gambar real:

```php
// Contoh di CpuProductsSeeder.php
[
    'name' => 'Intel Core i5-12400F',
    'slug' => 'intel-core-i5-12400f',
    'image' => 'https://images.tokopedia.net/img/cache/700/VqbcmM/2022/1/12/intel-i5-12400f.jpg',
    // ... data lainnya
],
```

## Metode 3: Upload Manual ke Storage

1. Siapkan folder gambar lokal dengan struktur:
   ```
   storage/app/public/products/
   ├── cpu/
   ├── gpu/
   ├── ram/
   ├── storage/
   ├── psu/
   ├── case/
   ├── motherboard/
   └── cooling/
   ```

2. Upload gambar ke folder yang sesuai

3. Update database produk:
   ```sql
   UPDATE products 
   SET image = 'storage/products/cpu/intel-i5-12400f.jpg' 
   WHERE slug = 'intel-core-i5-12400f';
   ```

## Rekomendasi Sumber Gambar Gratis

1. **Unsplash** - https://unsplash.com/s/photos/computer-hardware
2. **Pexels** - https://pexels.com/search/pc-components
3. **Tokopedia/Shopee** - Screenshot dari marketplace (untuk referensi)
4. **Official Brand Website**:
   - Intel: https://ark.intel.com
   - AMD: https://amd.com
   - NVIDIA: https://nvidia.com
   - Corsair: https://corsair.com
   - NZXT: https://nzxt.com

## Otomatis Download Gambar (Advanced)

Jika ingin download gambar produk otomatis, bisa gunakan script:

```php
// Buat seeder baru: DownloadProductImagesSeeder.php
$products = [
    [
        'slug' => 'intel-core-i5-12400f',
        'image_url' => 'https://example.com/image.jpg'
    ],
    // ... produk lainnya
];

foreach ($products as $item) {
    $image = file_get_contents($item['image_url']);
    $filename = $item['slug'] . '.jpg';
    Storage::disk('public')->put('products/' . $filename, $image);
    
    Product::where('slug', $item['slug'])
        ->update(['image' => 'storage/products/' . $filename]);
}
```

## Tips Upload Gambar di Production (Railway)

Karena Railway menggunakan **ephemeral storage**, gambar yang di-upload akan **hilang saat redeploy**.

**Solusi terbaik:**

1. **Gunakan Cloud Storage** (Cloudinary, AWS S3, atau ImgBB)
2. **Simpan URL gambar** di database, bukan file lokal
3. **Update AddProductImagesSeeder** untuk menggunakan URL external

### Contoh dengan Cloudinary (Gratis):

```php
// Di seeder
'image' => 'https://res.cloudinary.com/yourcloud/image/upload/v1/products/cpu-i5.jpg'
```

## Next Steps

1. ✅ Deploy sudah otomatis membuat storage link
2. ✅ Admin bisa upload gambar via dashboard
3. ⚠️ Untuk production, gunakan cloud storage untuk gambar permanen
4. 📝 Update seeder dengan URL gambar real jika mau data awal sudah ada gambar

---

**Catatan:** Placeholder warna-warni sudah otomatis muncul untuk semua produk. Tinggal ganti dengan gambar asli sesuai kebutuhan!
