<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 💻 SEBATAS PC - E-Commerce Komponen Komputer

![Project Version](https://img.shields.io/badge/version-1.0-blue)
![Framework](https://img.shields.io/badge/Framework-Laravel-FF2D20?logo=laravel&logoColor=white)
![Deployment](https://img.shields.io/badge/Deployment-Railway-131415?logo=railway&logoColor=white)

**SEBATAS PC** adalah aplikasi e-commerce berbasis web yang berfokus pada penjualan komponen komputer. Sistem ini dirancang untuk memudahkan pengguna dalam berbelanja komponen PC dengan fitur unggulan **Smart PC Builder**, di mana pelanggan dapat merakit PC sesuai anggaran (*budget*) mereka secara otomatis dengan jaminan kompatibilitas komponen (seperti kecocokan *socket*).

---

## 📌 Fitur Utama

### Smart PC Builder (Fitur Unggulan)
Pengguna dapat menentukan rentang harga (*budget*) menggunakan *slider*. Sistem akan secara otomatis merekomendasikan kombinasi rakitan PC yang kompatibel satu sama lain dan sesuai dengan anggaran dalam waktu kurang dari 2 detik.

### E-Commerce Core
- **Katalog Produk:** Menampilkan daftar komponen (Processor, VGA, RAM, Storage, dll) dengan foto, harga, dan spesifikasi.
- **Pencarian & Filter:** Mencari produk spesifik berdasarkan nama atau filter kategori (misal: Intel / AMD).
- **Manajemen Keranjang (Cart):** Menambahkan, mengubah jumlah, dan menghapus produk sebelum *checkout*.
- **Pembayaran & Transaksi:** Finalisasi belanja dan mencetak Invoice/Nota.

### Autentikasi & Keamanan
- Login dan Registrasi akun.
- Pembagian hak akses (*Role-Based Access Control*) untuk Admin dan Pelanggan.
- Enkripsi password menggunakan sistem *Bcrypt* bawaan Laravel.
- Proteksi terhadap *SQL Injection* menggunakan *Eloquent ORM* dan *Prepared Statements*.

### Admin Dashboard
- **Manajemen Produk (CRUD):** Tambah, lihat, ubah harga/stok, dan hapus data komponen.
- **Manajemen Kategori:** Mengatur kategori komponen agar katalog tertata rapi.
- **Laporan Transaksi:** Memantau pesanan yang masuk dari pelanggan.

---

## Teknologi yang Digunakan

- **Backend:** Laravel (PHP)
- **Frontend:** Laravel Blade, HTML5, CSS/Tailwind/Bootstrap, JavaScript
- **Database:** MySQL / PostgreSQL
- **Deployment:** Railway (Cloud Hosting)
- **Arsitektur:** MVC (Model-View-Controller)

---

## Struktur Database Utama

Aplikasi ini menggunakan 5 tabel utama yang saling berelasi:
1. `users`: Menyimpan kredensial pengguna (Admin/Pelanggan).
2. `products`: Informasi komponen, termasuk `socket_type` untuk validasi *Smart PC Builder*.
3. `categories`: Pengelompokan jenis komponen PC.
4. `orders`: Mencatat data transaksi (*one-to-many* ke Order_Details).
5. `order_details`: Menyimpan daftar item spesifik dalam satu kali transaksi.

---

## Cara Instalasi & Menjalankan di Lokal (Local Setup)

Ikuti langkah-langkah berikut untuk menjalankan project Laravel ini di komputer Anda:

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB (XAMPP/Laragon)
- Git

### Langkah-langkah
1. **Clone repository ini**
   ```bash
   git clone https://github.com/username-anda/sebatas-pc.git
   cd sebatas-pc

## 🔑 Environment Variables
Pastikan Anda mengatur file `.env` dengan konfigurasi database yang sesuai:
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=sebatas_pc`

## 👥 Tim Pengembang
- Nomensen Melkisedek Pardosi (103062330101)
- Muhammad Farid Irham (103062300040)
- Azka Dhaffinanda Rahman (103062300106)
- Adha Rahmadani Putra (103062300073)
- Hasan Naqib Sa’bani (103062300072)
