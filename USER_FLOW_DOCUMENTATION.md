# Dokumentasi User Flow - Aplikasi Kos-Kosan

## Gambaran Umum
Aplikasi kos-kosan ini memiliki 3 peran utama pengguna:
1. **Pencari Kosan** (Calon Penghuni)
2. **Penghuni** (Pengguna yang sudah tinggal di kosan)
3. **Admin** (Pengelola Kosan)

---

## 1. ALUR PENCARI KOSAN (Calon Penghuni)

### 1.1 Alur Eksplorasi Publik (Tanpa Login)
```
Halaman Depan (Home)
    ↓
Daftar Kosan Tersedia
    ↓
Filter Kosan (Lokasi, Harga, Fasilitas)
    ↓
Detail Kamar
    ↓
[Tombol "Booking Sekarang"]
    ↓
Cek Status Login
    ├─ Sudah Login → Lanjut ke Form Booking
    └─ Belum Login → Redirect ke Login/Register
```

### 1.2 Alur Otentikasi
```
Halaman Login/Register
    ↓
Pilih: Login atau Register
    ↓
Register:
    ├─ Isi Form Registrasi
    ├─ Verifikasi Email (Opsional)
    └─ Login Otomatis
    ↓
Login:
    ├─ Masukkan Email & Password
    └─ Redirect ke Dashboard
```

### 1.3 Alur Booking
```
Form Booking
    ├─ Pilih Kamar
    ├─ Pilih Tanggal Masuk
    ├─ Upload Dokumen (KTP, KK)
    └─ Konfirmasi Data
    ↓
Pembayaran Booking Fee
    ├─ Pilih Metode Pembayaran
    ├─ Upload Bukti Pembayaran
    └─ Konfirmasi Pembayaran
    ↓
Status Booking
    ├─ Menunggu Konfirmasi Admin
    ├─ Booking Dikonfirmasi → Status: "Dikonfirmasi"
    └─ Booking Ditolak → Status: "Ditolak"
```

---

## 2. ALUR PENGHUNI (Pengguna yang Sudah Tinggal)

### 2.1 Dashboard Penghuni
```
Login sebagai Penghuni
    ↓
Dashboard Penghuni
    ├─ Informasi Kamar
    ├─ Status Booking
    ├─ Menu Tagihan
    ├─ Menu Komplain
    └─ Profil Pengguna
```

### 2.2 Alur Tagihan Bulanan
```
Menu Tagihan
    ↓
Daftar Tagihan
    ├─ Tagihan Bulan Ini
    ├─ Riwayat Tagihan
    └─ Tagihan Belum Lunas
    ↓
Detail Tagihan
    ├─ Rincian Biaya (Sewa, Listrik, Air, dll)
    ├─ Total Tagihan
    └─ Tombol "Bayar Sekarang"
    ↓
Upload Bukti Pembayaran
    ├─ Pilih File Bukti
    ├─ Tambahkan Catatan
    └─ Submit Pembayaran
    ↓
Status Pembayaran
    ├─ Menunggu Verifikasi Admin
    ├─ Diverifikasi → Status: "Lunas"
    └─ Ditolak → Status: "Perlu Revisi"
```

### 2.3 Alur Komplain
```
Menu Komplain
    ↓
Daftar Komplain Saya
    ├─ Komplain Aktif
    ├─ Komplain Selesai
    └─ Tombol "Buat Komplain Baru"
    ↓
Form Komplain Baru
    ├─ Kategori Masalah
    ├─ Deskripsi Masalah
    ├─ Lokasi (Jika ada)
    ├─ Upload Foto (Opsional)
    └─ Prioritas
    ↓
Submit Komplain
    ↓
Status Komplain
    ├─ Baru → Status: "Menunggu Ditindaklanjuti"
    ├─ Diproses → Status: "Sedang Diproses"
    └─ Selesai → Status: "Selesai"
```

---

## 3. ALUR ADMIN (Pengelola Kosan)

### 3.1 Dashboard Admin
```
Login sebagai Admin
    ↓
Dashboard Admin
    ├─ Statistik Kosan
    ├─ Menu Kelola Kamar
    ├─ Menu Kelola Booking
    ├─ Menu Kelola Tagihan
    ├─ Menu Kelola Komplain
    └─ Menu Kelola Penghuni
```

### 3.2 Alur Kelola Booking
```
Menu Kelola Booking
    ↓
Daftar Booking
    ├─ Booking Baru (Menunggu Konfirmasi)
    ├─ Booking Dikonfirmasi
    └─ Booking Ditolak
    ↓
Detail Booking
    ├─ Data Pencari Kosan
    ├─ Data Kamar yang Dipesan
    ├─ Dokumen yang Diupload
    └─ Bukti Pembayaran Booking Fee
    ↓
Aksi Admin
    ├─ Konfirmasi Booking
    │   ├─ Update Status Kamar: "Terisi"
    │   └─ Kirim Notifikasi ke Penghuni
    └─ Tolak Booking
        ├─ Alasan Penolakan
        └─ Kirim Notifikasi ke Pencari Kosan
```

### 3.3 Alur Kelola Tagihan
```
Menu Kelola Tagihan
    ↓
Buat Tagihan Baru
    ├─ Pilih Penghuni
    ├─ Pilih Kamar
    ├─ Input Biaya (Sewa, Listrik, Air, dll)
    ├─ Periode Tagihan
    └─ Generate Tagihan
    ↓
Daftar Tagihan
    ├─ Tagihan Belum Dibayar
    ├─ Pembayaran Menunggu Verifikasi
    └─ Tagihan Lunas
    ↓
Verifikasi Pembayaran
    ├─ Lihat Bukti Pembayaran
    ├─ Verifikasi → Status: "Lunas"
    └─ Tolak → Status: "Perlu Revisi"
```

### 3.4 Alur Kelola Komplain
```
Menu Kelola Komplain
    ↓
Daftar Komplain
    ├─ Komplain Baru (Menunggu Ditindaklanjuti)
    ├─ Komplain Sedang Diproses
    └─ Komplain Selesai
    ↓
Detail Komplain
    ├─ Data Penghuni
    ├─ Kategori & Deskripsi Masalah
    ├─ Foto Bukti (Jika ada)
    └─ Prioritas
    ↓
Tindak Lanjut Komplain
    ├─ Ubah Status: "Diproses"
    ├─ Tambahkan Catatan Admin
    ├─ Ubah Status: "Selesai"
    └─ Kirim Notifikasi ke Penghuni
```

### 3.5 Alur Kelola Kamar
```
Menu Kelola Kamar
    ↓
Daftar Kamar
    ├─ Kamar Tersedia
    ├─ Kamar Terisi
    └─ Kamar Maintenance
    ↓
Detail Kamar
    ├─ Informasi Kamar
    ├─ Fasilitas
    ├─ Harga Sewa
    └─ Status Kamar
    ↓
Update Status Kamar
    ├─ Tersedia → Terisi (Setelah Booking Dikonfirmasi)
    ├─ Terisi → Tersedia (Setelah Penghuni Keluar)
    └─ Maintenance (Untuk Perbaikan)
```

---

## 4. DIAGRAM USER FLOW VISUAL

### 4.1 Flow Chart Utama
```
                    [Halaman Depan]
                         |
                    [Daftar Kosan]
                         |
                    [Detail Kamar]
                         |
                    [Booking Sekarang]
                         |
                    [Cek Login Status]
                         |
            ┌────────────┴────────────┐
            |                         |
    [Belum Login]              [Sudah Login]
            |                         |
    [Login/Register]           [Form Booking]
            |                         |
    [Dashboard] ──────────────→ [Pembayaran]
            |                         |
            └────────────┬────────────┘
                         |
                    [Status Booking]
                         |
            ┌────────────┴────────────┐
            |                         |
    [Dikonfirmasi]              [Ditolak]
            |                         |
    [Jadi Penghuni]            [End Flow]
            |
    [Dashboard Penghuni]
            |
    ┌───────┴───────┐
    |               |
[Tagihan]      [Komplain]
    |               |
[Bayar]        [Submit]
    |               |
[Upload Bukti] [Status]
    |               |
[Verifikasi]   [Tindak Lanjut]
```

### 4.2 Flow Chart Admin
```
                [Login Admin]
                     |
            [Dashboard Admin]
                     |
        ┌────────────┼────────────┐
        |            |            |
   [Kelola]      [Kelola]    [Kelola]
   [Booking]     [Tagihan]   [Komplain]
        |            |            |
   [Konfirmasi]  [Buat]      [Tindak]
   [Booking]     [Tagihan]   [Lanjut]
        |            |            |
   [Update]       [Verifikasi] [Update]
   [Status]       [Pembayaran] [Status]
   [Kamar]            |            |
        |            |            |
   [Notifikasi]  [Notifikasi] [Notifikasi]
```

---

## 5. NOTASI DAN SIMBOL

- **[]** = Halaman/Node
- **↓** = Alur Normal
- **├─** = Pilihan/Branch
- **└─** = Akhir Branch
- **→** = Redirect/Navigasi
- **┌─┐** = Decision Point
- **┴** = Split/Join Point

---

## 6. FITUR UTAMA PER PERAN

### Pencari Kosan:
- ✅ Eksplorasi kosan tanpa login
- ✅ Filter pencarian
- ✅ Booking kamar
- ✅ Upload dokumen
- ✅ Pembayaran booking fee

### Penghuni:
- ✅ Dashboard pribadi
- ✅ Lihat tagihan bulanan
- ✅ Upload bukti pembayaran
- ✅ Submit komplain
- ✅ Lihat status komplain

### Admin:
- ✅ Dashboard admin lengkap
- ✅ Kelola booking
- ✅ Buat dan verifikasi tagihan
- ✅ Tindak lanjut komplain
- ✅ Kelola status kamar
- ✅ Kelola data penghuni

---

## 7. POINTS OF INTERACTION

1. **Authentication Gate**: Semua aksi transaksional memerlukan login
2. **Admin Approval**: Booking dan pembayaran memerlukan verifikasi admin
3. **Status Updates**: Semua proses memiliki status yang dapat dilacak
4. **Notifications**: Setiap perubahan status mengirim notifikasi
5. **File Uploads**: Dokumen dan bukti pembayaran dapat diupload

---

*Dokumentasi ini dapat digunakan sebagai panduan pengembangan dan testing untuk memastikan semua alur pengguna berjalan dengan baik.*

