# FITUR PILIH KOMPONEN CUSTOM - SMART PC BUILDER

## ✨ Fitur Baru yang Telah Ditambahkan

### 1. **Modal Pemilihan Komponen Alternatif**
Customer sekarang bisa memilih komponen sendiri dengan klik tombol **"Ganti"** atau **"Pilih"** di setiap kategori komponen.

### 2. **API Alternatif Produk**
- **Endpoint:** `/pc-builds/alternatives`
- **Method:** GET
- **Parameters:**
  - `component_type`: processor | gpu | motherboard | ram | storage | psu | casing | cpu_cooler
  - `budget`: Angka budget untuk komponen (contoh: 3000000)
  - `current_product_id`: ID produk yang sedang dipilih (opsional)
  
- **Response:** JSON dengan daftar 10 produk alternatif dalam rentang harga ±30% dari budget

### 3. **Sistem Gambar Produk Terpusat**
Semua gambar produk sekarang menggunakan data dari database `products.image`:
- ✅ Hapus sistem placeholder (placehold.co)
- ✅ Gambar diambil langsung dari field `image` di database
- ✅ Jika tidak ada gambar, tampilkan icon placeholder
- ✅ Support URL eksternal dan path lokal

---

## 🎯 Cara Menggunakan

### A. Untuk Customer (Frontend)

1. **Buka Smart PC Builder:** http://127.0.0.1:8000/pc-builds/builder
2. **Pilih Budget & Preferensi:** 
   - Atur budget maksimal (Rp 5jt - 50jt)
   - Pilih tujuan penggunaan (Gaming/Office/Editing)
   - Pilih strategi build (Best Performance/Best Value/Future Proof)
3. **Klik "Perbarui Rekomendasi"** untuk melihat komponen yang direkomendasikan
4. **Klik tombol "Ganti"** di komponen yang ingin diubah
5. **Pilih produk alternatif** dari modal yang muncul
6. Sistem akan menampilkan produk dalam rentang harga yang sesuai

### B. Untuk Admin (Upload Gambar Produk)

#### **Opsi 1: Upload File Lokal**
```bash
# 1. Simpan gambar dengan nama sesuai slug produk
nzxt-h7-flow.jpg

# 2. Copy ke folder public
Copy-Item "gambar-anda.jpg" "public/images/products/nzxt-h7-flow.jpg"

# 3. Update database
php artisan tinker
>>> $p = Product::find(13);
>>> $p->image = 'images/products/nzxt-h7-flow.jpg';
>>> $p->save();
```

#### **Opsi 2: Gunakan URL Eksternal**
```bash
php artisan tinker
>>> $p = Product::find(13);
>>> $p->image = 'https://cdn.example.com/nzxt-h7-flow.jpg';
>>> $p->save();
```

#### **Opsi 3: Bulk Update**
Lihat script: `update_product_images.php` untuk contoh bulk update.

---

## 📋 Struktur Database

### Table: `products`
```sql
- id (int)
- name (varchar)
- slug (varchar)
- price (decimal)
- image (varchar) ← Path gambar atau URL
- description (text)
- specifications (json)
- category_id (int)
- rating (decimal)
- stock (int)
```

**Contoh data image:**
```sql
-- Path lokal
UPDATE products SET image = 'images/products/nzxt-h7-flow.jpg' WHERE id = 13;

-- URL eksternal
UPDATE products SET image = 'https://example.com/products/nzxt.jpg' WHERE id = 13;

-- NULL (tidak ada gambar)
UPDATE products SET image = NULL WHERE id = 13;
```

---

## 🔧 File yang Dimodifikasi

### 1. **app/Http/Controllers/PcBuildController.php**
- ✅ Tambah method `getAlternativeProducts()`
- Query produk berdasarkan kategori dan budget dengan toleransi ±30%
- Return JSON untuk modal

### 2. **routes/web.php**
- ✅ Tambah route `/pc-builds/alternatives`

### 3. **app/Models/Product.php**
- ✅ Update accessor `getImageUrlAttribute()`
- Hapus placeholder placehold.co
- Return gambar dari database atau null

### 4. **resources/views/pc-builds/builder.blade.php**
- ✅ Tambah modal HTML untuk pemilihan komponen
- ✅ Tambah JavaScript functions:
  - `openComponentModal()` - Buka modal dan fetch data
  - `closeComponentModal()` - Tutup modal
  - `renderProducts()` - Render daftar produk
  - `selectProduct()` - Handle pilihan customer
- ✅ Update tombol "Ganti" dengan onclick event
- ✅ Update tampilan gambar (handle null image)

---

## 🎨 UI/UX Features

### Modal Komponen:
- ✅ **Responsive:** Max-width 4xl, max-height 90vh
- ✅ **Dark theme:** Consistent dengan design system
- ✅ **Loading state:** Spinner saat fetch data
- ✅ **Empty state:** Pesan jika tidak ada produk
- ✅ **Hover effects:** Border highlight dan icon arrow
- ✅ **Keyboard support:** ESC untuk close modal
- ✅ **Click outside:** Close modal saat klik backdrop

### Product Card di Modal:
- ✅ Gambar produk (fallback ke icon jika null)
- ✅ Nama produk
- ✅ Harga (formatted Rupiah)
- ✅ Rating (jika ada)
- ✅ Deskripsi singkat (line-clamp-2)
- ✅ Hover animation untuk interaktivitas

---

## 🚀 Testing

```bash
# 1. Akses builder
http://127.0.0.1:8000/pc-builds/builder

# 2. Test API langsung
http://127.0.0.1:8000/pc-builds/alternatives?component_type=processor&budget=3000000

# 3. Lihat panduan update gambar
php update_product_images.php
```

---

## 📝 Notes

### Fitur yang Sudah Selesai:
- ✅ Modal pemilihan komponen
- ✅ API alternatif produk
- ✅ Hapus placeholder image system
- ✅ Integrasi gambar dari database
- ✅ Responsive UI
- ✅ Loading & empty states

### Fitur yang Perlu Ditambah (Future):
- ⏳ Save selected product ke session/database
- ⏳ Update build total saat pilih produk baru
- ⏳ Compatibility check (socket CPU vs motherboard, dll)
- ⏳ Add to cart untuk complete build
- ⏳ Save build untuk login user

---

## 💡 Tips

1. **Upload gambar berkualitas:** 400x400px atau 600x600px
2. **Format recommended:** WebP (ukuran kecil) atau JPG
3. **Naming convention:** Gunakan slug produk untuk consistency
4. **External URL:** Pastikan CORS allow jika dari domain lain
5. **Fallback handling:** System otomatis handle image error dengan icon

---

**Terakhir diupdate:** 19 Desember 2025  
**Developer:** Sebatas PC Development Team
