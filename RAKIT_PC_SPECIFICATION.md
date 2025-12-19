# Spesifikasi Fitur Rakit PC

## Struktur Komponen

### 1. Komponen Inti (Wajib)
Komponen yang **harus** dipilih untuk melengkapi rakitan PC:

1. **Processor (CPU)** - Otak dari PC
2. **Motherboard (Mobo)** - Papan sirkuit penghubung semua komponen
3. **RAM (Memory)** - Penunjang kecepatan multitasking
4. **Storage (SSD/HDD)** - Media penyimpanan data (Sangat disarankan SSD untuk OS)
5. **Power Supply (PSU)** - Penyuplai daya listrik ke seluruh komponen
6. **Casing** - Wadah fisik komponen

### 2. Komponen Tambahan (Opsional)
Komponen yang dapat ditambahkan berdasarkan kebutuhan dan budget:

7. **Graphics Card (GPU/VGA)** - Wajib jika untuk gaming berat atau desain grafis profesional
8. **CPU Cooler** - Jika processor yang dipilih tidak menyertakan pendingin bawaan

## Implementasi

### Database Structure
- `component_type` field akan menggunakan nilai:
  - Komponen Inti: `processor`, `motherboard`, `ram`, `storage`, `psu`, `casing`
  - Komponen Tambahan: `gpu`, `cpu_cooler`

### UI/UX
- Komponen Inti akan ditampilkan dengan badge "WAJIB"
- Komponen Tambahan akan ditampilkan dengan badge "OPSIONAL"
- Komponen yang belum dipilih akan ditampilkan dengan placeholder
- Validasi untuk memastikan semua komponen inti sudah dipilih sebelum checkout

### Business Logic
- Total harga dihitung dari semua komponen yang dipilih
- Sistem rekomendasi akan menyarankan kombinasi komponen berdasarkan:
  - Budget yang diinput user
  - Use case yang dipilih (Office, Gaming, Professional, dll)
  - Kompatibilitas antar komponen
