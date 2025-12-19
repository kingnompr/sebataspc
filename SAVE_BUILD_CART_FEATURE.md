# FITUR SAVE BUILD & ADD TO CART - SMART PC BUILDER

## ✨ Fitur Baru yang Telah Ditambahkan

### 1. **Simpan Build (Save Build)**
Customer dapat menyimpan konfigurasi PC yang mereka buat untuk dilihat dan diedit nanti.

### 2. **Tambah ke Keranjang (Add to Cart)**
Customer dapat langsung menambahkan semua komponen yang dipilih ke keranjang belanja.

### 3. **Halaman Rakitan Tersimpan (My Builds)**
Dashboard khusus untuk melihat, mengedit, dan menghapus rakitan PC yang tersimpan.

---

## 🎯 Cara Menggunakan

### A. **Menyimpan Build**

1. Buka **Smart PC Builder**: http://127.0.0.1:8000/pc-builds/builder
2. Atur budget dan preferensi, klik **"Perbarui Rekomendasi"**
3. Lihat komponen yang direkomendasikan
4. Klik tombol **"Simpan Build"** di summary bar
5. Masukkan nama untuk build Anda (misalnya: "Gaming 15jt")
6. Build tersimpan dan dapat diakses di **Account > Rakitan Tersimpan**

**Catatan:** Fitur ini hanya tersedia untuk user yang sudah login. Guest akan diminta login terlebih dahulu.

### B. **Menambahkan ke Keranjang**

1. Pastikan Anda sudah memilih komponen (minimal processor)
2. Klik tombol **"Tambah ke Keranjang"** di summary bar
3. Sistem akan menambahkan SEMUA komponen yang dipilih ke keranjang
4. Konfirmasi akan muncul dengan jumlah item yang ditambahkan
5. Pilih "Ya" untuk langsung ke halaman keranjang atau "Tidak" untuk lanjut browsing

**Catatan:** Fitur ini bekerja untuk guest dan logged-in user.

### C. **Melihat Rakitan Tersimpan**

1. Login ke akun Anda
2. Klik menu **Profil** > **Rakitan Tersimpan**
3. Atau akses langsung: http://127.0.0.1:8000/account/my-builds
4. Anda akan melihat grid card semua build yang tersimpan

**Di setiap card build, Anda dapat:**
- ✏️ **Edit**: Load build ke PC Builder untuk modifikasi
- 🗑️ **Hapus**: Menghapus build dari daftar tersimpan

---

## 📋 Struktur Database

### Table: `custom_pc_builds`
```sql
CREATE TABLE custom_pc_builds (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NULL,                    -- Foreign key ke users
    session_id VARCHAR(255) NULL,           -- Untuk guest users
    build_name VARCHAR(255) DEFAULT 'My PC Build',
    budget DECIMAL(12,2) NULL,
    use_case VARCHAR(255) NULL,             -- gaming, office, editing
    tier VARCHAR(255) NULL,                 -- best_performance, best_value, future_proof
    components JSON NOT NULL,               -- {"processor":1,"gpu":2,...}
    total_price DECIMAL(12,2) DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX(user_id, created_at)
);
```

**Contoh data components JSON:**
```json
{
  "processor": 5,
  "gpu": 23,
  "motherboard": 12,
  "ram": 18,
  "storage": 31,
  "psu": 8,
  "casing": 13,
  "cpu_cooler": 42
}
```

---

## 🔧 File yang Dimodifikasi/Dibuat

### 1. **Migration**
- ✅ `2025_12_19_105352_create_custom_pc_builds_table.php`

### 2. **Model**
- ✅ `app/Models/CustomPcBuild.php`
  - Relationships: `user()`, `products`
  - Methods: `calculateTotalPrice()`

### 3. **Controller**
- ✅ `app/Http/Controllers/PcBuildController.php`
  - `saveBuild()` - Save custom build
  - `addBuildToCart()` - Add all components to cart
  - `myBuilds()` - View saved builds
  - `deleteBuild()` - Delete saved build

### 4. **Routes**
```php
// Public routes
Route::post('/pc-builds/save', [PcBuildController::class, 'saveBuild']);
Route::post('/pc-builds/add-to-cart', [PcBuildController::class, 'addBuildToCart']);

// Auth routes
Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/my-builds', [PcBuildController::class, 'myBuilds']);
    Route::delete('/my-builds/{build}', [PcBuildController::class, 'deleteBuild']);
});
```

### 5. **Views**
- ✅ `resources/views/pc-builds/my-builds.blade.php` - Halaman rakitan tersimpan
- ✅ `resources/views/pc-builds/builder.blade.php` - Update dengan tombol & JavaScript
- ✅ `resources/views/account/layout.blade.php` - Tambah menu "Rakitan Tersimpan"

---

## 🎨 UI/UX Features

### Summary Bar (Builder Page):
- ✅ **Tombol "Simpan Build"**
  - Border style dengan hover effect
  - Icon save material symbol
  - Trigger modal input nama build
  - Auth guard untuk login requirement

- ✅ **Tombol "Tambah ke Keranjang"**
  - Primary button dengan shadow
  - Icon shopping cart
  - Konfirmasi jumlah item ditambahkan
  - Auto-redirect option ke cart

### My Builds Page:
- ✅ **Empty State**
  - Icon computer placeholder
  - CTA button "Mulai Rakit PC"
  - Friendly message

- ✅ **Build Cards**
  - Build name & badges (use case + tier)
  - Budget & created date
  - Component count & total price
  - Edit & Delete buttons
  - Hover effects

- ✅ **Pagination**
  - 12 builds per page
  - Laravel default pagination styling

---

## 🔐 Authorization & Security

### Save Build:
```php
@auth
    // User logged in - save to database with user_id
    CustomPcBuild::create([
        'user_id' => Auth::id(),
        'build_name' => $request->input('build_name'),
        // ...
    ]);
@else
    // Guest user - redirect to login
    alert('Please login to save builds');
    window.location.href = '/login?redirect=...';
@endauth
```

### Add to Cart:
```php
// Works for both auth and guest
$cart = Cart::firstOrCreate(
    Auth::check() 
        ? ['user_id' => Auth::id()] 
        : ['session_id' => session()->getId()]
);
```

### Delete Build:
```php
// Authorization check
if ($build->user_id !== Auth::id()) {
    abort(403); // Forbidden
}
```

---

## 🚀 API Endpoints

### 1. **POST /pc-builds/save**
**Request:**
```json
{
  "build_name": "Gaming PC 15jt",
  "budget": 15000000,
  "use_case": "gaming",
  "tier": "best_value",
  "components": {
    "processor": 5,
    "gpu": 23,
    "motherboard": 12,
    "ram": 18,
    "storage": 31,
    "psu": 8,
    "casing": 13,
    "cpu_cooler": 42
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Build berhasil disimpan!",
  "build_id": 1
}
```

### 2. **POST /pc-builds/add-to-cart**
**Request:**
```json
{
  "components": {
    "processor": 5,
    "gpu": 23,
    "motherboard": 12,
    "ram": 18,
    "storage": 31,
    "psu": 8,
    "casing": 13,
    "cpu_cooler": null
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "7 komponen berhasil ditambahkan ke keranjang!",
  "cart_count": 7
}
```

### 3. **GET /account/my-builds**
**Response:** Blade view dengan paginated builds

### 4. **DELETE /account/my-builds/{build}**
**Response:** Redirect dengan success message

---

## 🧪 Testing Scenarios

### Test 1: Save Build (Logged In)
```
1. Login sebagai user
2. Buka /pc-builds/builder
3. Set budget Rp 15jt, Gaming, Best Value
4. Klik "Perbarui Rekomendasi"
5. Klik "Simpan Build"
6. Input nama: "Test Gaming Build"
7. Verify: Alert "Build berhasil disimpan"
8. Buka /account/my-builds
9. Verify: Build muncul di list
```

### Test 2: Save Build (Guest)
```
1. Logout / buka incognito
2. Buka /pc-builds/builder
3. Set budget & klik "Perbarui Rekomendasi"
4. Klik "Simpan Build"
5. Verify: Alert "Silakan login terlebih dahulu"
6. Verify: Redirect ke /login
```

### Test 3: Add to Cart
```
1. Buka /pc-builds/builder
2. Set budget Rp 10jt, Gaming, Best Performance
3. Klik "Perbarui Rekomendasi"
4. Klik "Tambah ke Keranjang"
5. Verify: Alert "7 komponen berhasil ditambahkan"
6. Klik "Ya" pada konfirmasi
7. Verify: Redirect ke /cart
8. Verify: 7 items di keranjang
```

### Test 4: Delete Build
```
1. Login sebagai user
2. Buka /account/my-builds
3. Klik tombol "Hapus" di salah satu build
4. Confirm dialog
5. Verify: Build terhapus dari list
6. Verify: Success message muncul
```

---

## 📊 Database Queries

### Get User's Builds:
```php
$builds = CustomPcBuild::where('user_id', Auth::id())
    ->orderBy('created_at', 'desc')
    ->paginate(12);
```

### Calculate Total Price:
```php
$productIds = array_values(array_filter($components));
$totalPrice = Product::whereIn('id', $productIds)->sum('price');
```

### Get Products in Build:
```php
public function getProductsAttribute()
{
    $productIds = array_values(array_filter($this->components));
    return Product::whereIn('id', $productIds)->get();
}
```

---

## 💡 Future Enhancements

### Fitur yang Bisa Ditambahkan:
1. ⏳ **Share Build**: Generate link untuk share build ke teman
2. ⏳ **Build Templates**: Save build sebagai template untuk reuse
3. ⏳ **Price Tracking**: Notifikasi jika harga komponen turun
4. ⏳ **Build Comparison**: Compare 2+ saved builds side-by-side
5. ⏳ **Community Builds**: Share dan vote build dari community
6. ⏳ **Build Notes**: Tambah catatan/notes di setiap build
7. ⏳ **Export Build**: Download build sebagai PDF atau image

---

## 📝 Notes

### Kelebihan Implementasi:
- ✅ Support both authenticated & guest users (untuk cart)
- ✅ JSON components storage (flexible untuk future changes)
- ✅ Authorization checks untuk delete build
- ✅ Responsive UI dengan empty states
- ✅ Clear error messages & confirmations
- ✅ Integration dengan existing Cart system
- ✅ Pagination untuk scalability

### Best Practices:
- Validasi input di backend
- CSRF protection pada semua POST/DELETE
- Authorization checks sebelum modify data
- Friendly error messages untuk user
- Consistent UI/UX dengan design system

---

**Terakhir diupdate:** 19 Desember 2025  
**Developer:** Sebatas PC Development Team
