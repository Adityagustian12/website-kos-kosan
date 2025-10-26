# Kos-Kosan Management System

Sistem manajemen kos-kosan yang komprehensif dengan fitur lengkap untuk admin, penghuni, dan pencari kosan.

## 🚀 Fitur Utama

### 👥 Multi-Role System
- **Admin**: Kelola kamar, booking, tagihan, komplain, dan penghuni
- **Penghuni**: Lihat tagihan, upload pembayaran, ajukan komplain
- **Pencari Kosan**: Cari kamar, booking, upload dokumen

### 🏠 Manajemen Kamar
- Daftar kamar dengan filter pencarian
- Detail kamar dengan fasilitas dan gambar
- Status kamar (Tersedia, Terisi, Maintenance)
- Kelola kamar oleh admin

### 📅 Sistem Booking
- Booking kamar dengan upload dokumen
- Konfirmasi booking oleh admin
- Upload bukti pembayaran booking fee
- Tracking status booking

### 💰 Manajemen Tagihan
- Buat tagihan bulanan oleh admin
- Upload bukti pembayaran oleh penghuni
- Verifikasi pembayaran oleh admin
- Tracking status pembayaran

### 📝 Sistem Komplain
- Ajukan komplain dengan kategori dan prioritas
- Upload foto bukti masalah
- Tindak lanjut komplain oleh admin
- Tracking status komplain

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: SQLite
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Auth
- **File Upload**: Laravel Storage

## 📋 Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- SQLite (sudah termasuk dalam Laravel)

## 🚀 Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd kosku-v2
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Setup Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## 👤 Akun Default

### Admin
- **Email**: admin@koskosan.com
- **Password**: password

### Penghuni
- **Email**: john@example.com
- **Password**: password

### Pencari Kosan
- **Email**: jane@example.com
- **Password**: password

## 📱 User Flow

### Pencari Kosan
1. Akses halaman utama
2. Cari kamar dengan filter
3. Lihat detail kamar
4. Login/Register untuk booking
5. Upload dokumen dan bukti pembayaran
6. Tunggu konfirmasi admin

### Penghuni
1. Login ke dashboard
2. Lihat tagihan bulanan
3. Upload bukti pembayaran
4. Ajukan komplain jika ada masalah
5. Tracking status komplain

### Admin
1. Login ke dashboard admin
2. Kelola kamar dan status
3. Konfirmasi/tolak booking
4. Buat tagihan bulanan
5. Verifikasi pembayaran
6. Tindak lanjut komplain

## 🗂️ Struktur Database

### Tabel Utama
- **users**: Data pengguna (admin, penghuni, pencari)
- **rooms**: Data kamar kos
- **bookings**: Data booking kamar
- **bills**: Data tagihan bulanan
- **payments**: Data pembayaran
- **complaints**: Data komplain

### Relasi
- User hasMany Bookings, Bills, Payments, Complaints
- Room hasMany Bookings, Bills
- Bill hasMany Payments
- Booking belongsTo User, Room
- Payment belongsTo User, Bill

## 🔐 Keamanan

- Role-based access control
- CSRF protection
- File upload validation
- Input validation dan sanitization
- Password hashing

## 📁 Struktur File

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Tenant/
│   │   ├── Auth/
│   │   └── PublicController.php
│   └── Middleware/
├── Models/
├── Policies/
resources/
├── views/
│   ├── admin/
│   ├── tenant/
│   ├── auth/
│   └── public/
routes/
├── web.php
database/
├── migrations/
└── seeders/
```

## 🚀 Deployment

1. **Production Environment**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Web Server Configuration**
   - Set document root ke folder `public`
   - Enable mod_rewrite untuk Apache
   - Configure SSL jika diperlukan

## 🤝 Kontribusi

1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file LICENSE untuk detail.

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi:
- Email: support@koskosan.com
- GitHub Issues: [Repository Issues]

---

**Dibuat dengan ❤️ menggunakan Laravel**