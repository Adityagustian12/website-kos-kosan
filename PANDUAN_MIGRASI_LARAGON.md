# Panduan Migrasi dari XAMPP ke Laragon

## 📋 Pendahuluan

Laragon adalah alternatif modern untuk XAMPP yang lebih cepat dan user-friendly untuk development Laravel di Windows. Panduan ini akan membantu Anda memindahkan project kosku-v2 dari XAMPP ke Laragon.

## 🎯 Perbedaan Utama

### XAMPP
- Lokasi: `C:\xampp\htdocs\`
- Database: MySQL (port 3306)
- Apache: port 80
- PHP: versi terintegrasi

### Laragon
- Lokasi: `C:\laragon\www\`
- Database: MySQL (port 3306)
- Nginx/Apache: port 80
- PHP: versi terintegrasi (lebih cepat)

## 🚀 Langkah-langkah Migrasi

### 1. Install Laragon

1. Download Laragon dari: https://laragon.org/download/
2. Install Laragon di lokasi default: `C:\laragon\`
3. Jalankan Laragon (akan otomatis start Apache dan MySQL)

### 2. Pindahkan Project

#### Option A: Copy Project (Cara Aman)
```bash
# Copy seluruh folder project
copy C:\xampp\htdocs\kosku-v2 C:\laragon\www\kosku-v2
```

#### Option B: Move Project (Menghemat Disk)
```bash
# Pindahkan folder project
move C:\xampp\htdocs\kosku-v2 C:\laragon\www\kosku-v2
```

### 3. Setup Database

#### A. Export Database dari XAMPP (jika menggunakan MySQL)

Jika project Anda menggunakan MySQL di XAMPP:

1. Buka phpMyAdmin di XAMPP: `http://localhost/phpmyadmin`
2. Pilih database `kosku_v2` (atau nama database Anda)
3. Klik tab "Export"
4. Pilih format "SQL"
5. Klik "Go" untuk download file SQL

#### B. Import ke Laragon

1. Buka phpMyAdmin di Laragon: `http://localhost/phpmyadmin`
2. Klik "New" untuk membuat database baru
3. Nama database: `kosku_v2`
4. Klik "Import"
5. Pilih file SQL yang sudah di-export
6. Klik "Go"

**Catatan**: Project ini menggunakan SQLite, jadi jika Anda menggunakan SQLite, cukup copy file `database/database.sqlite` saja.

### 4. Konfigurasi Environment

1. Buka file `.env` di project Laragon
2. Pastikan konfigurasi berikut:

```env
APP_NAME="Kos-Kosan Management"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration untuk MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosku_v2
DB_USERNAME=root
DB_PASSWORD=

# Atau tetap gunakan SQLite (default untuk project ini)
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### 5. Install Dependencies

Buka terminal di folder project Laragon:

```bash
cd C:\laragon\www\kosku-v2

# Install composer dependencies
composer install

# Generate application key (jika belum ada)
php artisan key:generate

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 6. Setup Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Migrations (jika perlu)

```bash
# Jika menggunakan database baru
php artisan migrate:fresh --seed

# Atau jika sudah ada data
php artisan migrate
```

### 8. Akses Aplikasi

Setelah Laragon running, aplikasi akan otomatis dapat diakses di:

```
http://kosku-v2.test
```

atau

```
http://localhost/kosku-v2/public
```

## 🔧 Konfigurasi Virtual Host (Opsional)

Laragon akan otomatis membuat virtual host untuk folder di `www`. Untuk akses yang lebih mudah:

1. Buka Laragon
2. Klik "Menu" → "Preferences" → "General"
3. Pastikan "Auto Virtual Hosts" dicentang
4. Restart Laragon

## 🗄️ Migrasi Database SQLite ke MySQL (Opsional)

Jika Anda ingin menggunakan MySQL di Laragon:

### 1. Buat Database Baru

```bash
# Masuk ke MySQL via terminal Laragon
mysql -u root -p

# Buat database
CREATE DATABASE kosku_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2. Update .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosku_v2
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Jalankan Migrations

```bash
php artisan migrate:fresh --seed
```

## ✅ Verifikasi Setup

Setelah migrasi, pastikan:

1. ✅ Laragon running (Apache dan MySQL green)
2. ✅ Aplikasi bisa diakses di browser
3. ✅ Login admin berhasil
4. ✅ Database terhubung dengan baik
5. ✅ Upload file berfungsi
6. ✅ Fitur CRUD berjalan normal

## 🐛 Troubleshooting

### Problem: Error "No php-cgi.exe in: C:\laragon\bin\php\php-X.X.X"
**Solusi**: 
Ini terjadi karena instalasi PHP tidak lengkap. Ikuti langkah berikut:

**Cara 1: Install Ulang PHP (Recommended)**
1. Tutup Laragon sepenuhnya
2. Buka Laragon → Menu → Preferences → General
3. Pilih versi PHP yang berbeda (misalnya PHP 8.2 atau PHP 8.1)
4. Klik "Ok" dan restart Laragon
5. Jika masih error, kembali ke Menu → Preferences → General
6. Klik tombol "Reinstall" atau "Update" untuk PHP yang dipilih

**Cara 2: Download PHP Manual**
1. Download PHP dari: https://windows.php.net/download/
2. Extract ke folder `C:\laragon\bin\php\`
3. Nama folder harus sesuai dengan nama yang diharapkan Laragon
4. Restart Laragon

**Cara 3: Gunakan Versi PHP yang Berbeda**
1. Di Laragon, klik Menu → Preferences → General
2. Coba ganti ke PHP 8.2 atau 8.1
3. Restart Laragon

### Problem: Error "Database connection failed"
**Solusi**: 
- Pastikan MySQL running di Laragon
- Cek kredensial di `.env`
- Run `php artisan config:clear`

### Problem: 404 Not Found
**Solusi**:
- Pastikan virtual host sudah dibuat
- Check file `.htaccess` ada di folder `public`
- Restart Laragon

### Problem: Permission denied untuk storage
**Solusi**:
- Run `php artisan storage:link`
- Pastikan folder `storage` dan `public/storage` memiliki permission write

### Problem: File upload tidak berfungsi
**Solusi**:
- Pastikan folder `storage/app/public` ada
- Check permission folder storage
- Run `php artisan config:clear`

## 🎉 Keuntungan Laragon

1. **Lebih Cepat**: Built-in caching dan optimasi
2. **Auto Virtual Host**: Tidak perlu setting manual
3. **Modern UI**: Interface yang lebih baik
4. **Tool Integration**: Git, Composer sudah terintegrasi
5. **Environment Switching**: Mudah switch PHP version
6. **Certificate SSL**: Auto-generate SSL untuk localhost

## 📝 Checklist Migrasi

- [ ] Install Laragon
- [ ] Copy/Move project ke `C:\laragon\www\`
- [ ] Export/Import database (jika perlu)
- [ ] Update file `.env`
- [ ] Run `composer install`
- [ ] Run `php artisan key:generate`
- [ ] Setup storage link
- [ ] Run migrations
- [ ] Test aplikasi di browser
- [ ] Verifikasi semua fitur berjalan

## 🔄 Backup Sebelum Migrasi

Sebelum migrasi, pastikan backup:

1. Database (export SQL atau copy file SQLite)
2. Uploaded files di folder `storage/app/public`
3. File `.env` dengan konfigurasi penting
4. Folder `vendor` (optional, bisa diinstall ulang)

## 📞 Support

Jika mengalami masalah:
1. Check Laragon logs
2. Check Laravel logs di `storage/logs/laravel.log`
3. Pastikan semua service Laragon running
4. Restart Laragon jika perlu

---

**Selamat migrasi! 🎊**

Laragon akan membuat development Laravel Anda lebih menyenangkan dan produktif.

