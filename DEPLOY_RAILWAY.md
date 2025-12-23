# 🚀 PANDUAN DEPLOY KE RAILWAY

## Langkah 1: Persiapan Repository Git

```bash
# Initialize git (jika belum)
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit - Ready for Railway deployment"

# Push ke GitHub
git remote add origin https://github.com/username/sebatas_pc.git
git branch -M main
git push -u origin main
```

## Langkah 2: Setup Railway Project

1. **Buka Railway.app** dan login
2. **Klik "New Project"**
3. **Pilih "Deploy from GitHub repo"**
4. **Pilih repository** `sebatas_pc`

## Langkah 3: Tambahkan MySQL Database

1. Di Railway project, klik **"New"** → **"Database"** → **"Add MySQL"**
2. Railway akan membuat MySQL database otomatis
3. Copy kredensial database dari tab **"Variables"**

## Langkah 4: Set Environment Variables

Di **Laravel service** → **"Variables"** → Tambahkan:

```env
APP_NAME=Sebatas PC
APP_ENV=production
APP_KEY=base64:GLsXljgM01Ncc/BJczxvlKdLLiZ7CqRTdhlOAj86wPI=
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

LOG_LEVEL=error

# Database - Railway akan provide ini otomatis
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

SESSION_DRIVER=file
QUEUE_CONNECTION=database
CACHE_STORE=file
```

**PENTING**: 
- Gunakan APP_KEY yang sama dari `.env` lokal Anda
- Variabel `${{MYSQLHOST}}` dll akan otomatis diisi Railway

## Langkah 5: Konfigurasi Build Settings (Opsional)

Di **Settings** → **Build**:
- Build Command: (biarkan kosong, nixpacks.toml sudah handle)
- Start Command: (sudah ada di Procfile)

## Langkah 6: Deploy

1. Railway akan otomatis build dan deploy
2. Tunggu sampai status **"Success"**
3. Klik **"Settings"** → **"Networking"** → **"Generate Domain"**
4. Akses domain yang digenerate

## Langkah 7: Jalankan Migration & Seeder (Pertama Kali)

Setelah deploy pertama kali:

1. Buka **"Deployments"** → Pilih deployment terakhir
2. Klik **"View Logs"**
3. Pastikan migration sudah jalan

Atau jalankan manual:

```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link project
railway link

# Jalankan migration & seeder
railway run php artisan migrate:fresh --seed --force
```

## Langkah 8: Verifikasi

Akses website Anda di:
- `https://your-app.railway.app`

Login dengan:
- **Admin**: admin@sebataspc.com / admin123
- **Customer**: customer@sebataspc.com / customer123

## Tips Production

### Update Procfile untuk Production (Jangan Fresh!)

Setelah seeding pertama kali, update `Procfile`:

```procfile
web: php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```

### Monitoring

- Cek logs di Railway Dashboard → "Deployments" → "View Logs"
- Monitor CPU/Memory usage di tab "Metrics"

### Update Deployment

Setiap kali push ke GitHub:
```bash
git add .
git commit -m "Update features"
git push origin main
```

Railway akan otomatis re-deploy.

## Troubleshooting

### Error: "No APP_KEY"
```bash
php artisan key:generate
# Copy key dari .env dan paste ke Railway Variables
```

### Error: Database Connection
- Pastikan MySQL service sudah running
- Check environment variables sudah benar
- Pastikan reference `${{MYSQLHOST}}` menggunakan kurung kurawal ganda

### Error: Storage Permission
```bash
railway run php artisan storage:link
```

### Images Tidak Muncul
- Update APP_URL di Railway variables dengan domain Railway
- Pastikan folder `public/images` ter-commit ke git

---

## 🎯 Summary Checklist

- [x] File `Procfile` dibuat
- [x] File `nixpacks.toml` dibuat  
- [x] File `.railwayignore` dibuat
- [x] Commit & push ke GitHub
- [x] Create Railway project
- [x] Add MySQL database
- [x] Set environment variables
- [x] Deploy & generate domain
- [x] Jalankan migration & seeder
- [x] Test website & login

---

**Database sudah siap untuk Railway! 🚀**

Total produk: **69 items**
Total kategori: **8 categories**
Admin user: **admin@sebataspc.com**
