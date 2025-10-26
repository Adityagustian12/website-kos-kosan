# 🔄 Panduan Migrasi SQLite ke MySQL

## 📋 **Status Saat Ini**
- ✅ Aplikasi berjalan dengan SQLite
- ✅ Semua migration sudah dijalankan (12 migrations)
- ✅ Data sample sudah ada
- ✅ Fitur hapus tagihan sudah diimplementasi

## 🛠️ **Langkah-langkah Migrasi**

### **1. Setup MySQL Server**
```bash
# Buka XAMPP Control Panel
# Start Apache dan MySQL services
# Atau buka phpMyAdmin di http://localhost/phpmyadmin
```

### **2. Buat Database MySQL**
```sql
-- Buka phpMyAdmin atau MySQL command line
CREATE DATABASE kosku_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### **3. Update Konfigurasi .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosku_db
DB_USERNAME=root
DB_PASSWORD=
```

### **4. Migrate Schema ke MySQL**
```bash
php artisan migrate:fresh
```

### **5. Import Data Sample**
```bash
php artisan db:seed
```

## 📊 **Struktur Database**

### **Tables yang Akan Dibuat:**
1. **users** - Data pengguna (admin, tenant, seeker)
2. **rooms** - Data kamar kos
3. **bookings** - Data pemesanan kamar
4. **bills** - Data tagihan (disederhanakan - hanya sewa kamar)
5. **complaints** - Data keluhan penghuni
6. **payments** - Data pembayaran
7. **migrations** - Log migration Laravel
8. **cache** - Cache table
9. **jobs** - Queue jobs table

### **Relationships:**
- User → Bookings (1:N)
- User → Bills (1:N)
- User → Complaints (1:N)
- Room → Bookings (1:N)
- Room → Bills (1:N)
- Room → Complaints (1:N)
- Bill → Payments (1:N)

## 🔧 **Keuntungan MySQL untuk Laporan KP**

### **1. Dokumentasi Database**
- ERD (Entity Relationship Diagram) yang lebih lengkap
- Query SQL yang lebih representatif
- Performance analysis yang lebih baik

### **2. Aspek Teknis**
- Database server management
- User privileges dan security
- Backup dan recovery procedures
- Indexing strategies

### **3. Skalabilitas**
- Support untuk data besar
- Query optimization
- Connection pooling
- Replication capabilities

## 🚀 **Setelah Migrasi**

### **Test Aplikasi:**
1. Login sebagai admin (admin@koskosan.com / password)
2. Test semua fitur admin
3. Test fitur tenant
4. Test fitur seeker
5. Test fitur hapus tagihan

### **Dokumentasi untuk Laporan:**
1. **ERD** - Buat diagram relasi tabel
2. **Query Examples** - Contoh query SQL yang digunakan
3. **Database Schema** - Export struktur tabel
4. **Performance** - Analisis query performance
5. **Security** - Konfigurasi keamanan database

## ⚠️ **Catatan Penting**

### **Backup Data:**
```bash
# Backup SQLite sebelum migrasi
cp database/database.sqlite database/database_backup.sqlite
```

### **Rollback (jika perlu):**
```env
# Kembali ke SQLite
DB_CONNECTION=sqlite
# DB_DATABASE=laravel (comment out)
```

### **Troubleshooting:**
- Pastikan MySQL service running
- Cek koneksi database di .env
- Pastikan database kosku_db sudah dibuat
- Cek user privileges MySQL

## 📈 **Hasil Akhir**

Setelah migrasi berhasil:
- ✅ Database MySQL dengan 9 tabel
- ✅ Data sample lengkap
- ✅ Aplikasi berjalan normal
- ✅ Siap untuk dokumentasi laporan KP
- ✅ ERD dan query examples siap dibuat

**Total Migrations:** 12
**Total Tables:** 9
**Total Sample Data:** ~20 records

