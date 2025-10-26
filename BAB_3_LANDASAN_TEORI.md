# BAB 3
## LANDASAN TEORI

### 3.1 Pengertian Sistem Informasi

Sistem informasi adalah suatu sistem yang terdiri dari komponen-komponen yang saling berinteraksi untuk mengumpulkan, memproses, menyimpan, dan menyebarkan informasi dalam mendukung pengambilan keputusan, koordinasi, dan kontrol dalam suatu organisasi (Laudon & Laudon, 2018). Sistem informasi mencakup teknologi informasi, prosedur, dan manusia yang bekerja bersama untuk mencapai tujuan organisasi.

Dalam konteks sistem manajemen kos-kosan, sistem informasi berfungsi untuk mengelola data kamar, penghuni, tagihan, dan komplain secara terintegrasi sehingga dapat meningkatkan efisiensi operasional dan pelayanan kepada penghuni.

### 3.2 Sistem Manajemen Kos-Kosan

Sistem manajemen kos-kosan adalah suatu sistem yang digunakan untuk mengelola operasional kos-kosan secara digital, meliputi pengelolaan kamar, penghuni, pembayaran, dan keluhan. Sistem ini bertujuan untuk meningkatkan efisiensi administrasi, mengurangi kesalahan manual, dan memberikan pelayanan yang lebih baik kepada penghuni.

Menurut penelitian oleh Sari dan Putra (2020), sistem manajemen kos-kosan digital dapat mengurangi waktu proses administrasi hingga 70% dan meningkatkan akurasi data hingga 95% dibandingkan dengan sistem manual.

### 3.3 Framework Laravel

Laravel adalah framework PHP yang menggunakan arsitektur Model-View-Controller (MVC) untuk pengembangan aplikasi web. Laravel menyediakan berbagai fitur built-in seperti routing, middleware, authentication, dan ORM (Object-Relational Mapping) yang memudahkan pengembangan aplikasi web yang kompleks.

#### 3.3.1 Arsitektur MVC

Model-View-Controller (MVC) adalah pola arsitektur yang memisahkan aplikasi menjadi tiga komponen utama:

1. **Model**: Menangani logika bisnis dan interaksi dengan database
2. **View**: Menangani presentasi data kepada pengguna
3. **Controller**: Menangani input pengguna dan koordinasi antara Model dan View

Arsitektur MVC memungkinkan pengembangan aplikasi yang lebih terstruktur, mudah dirawat, dan dapat dikembangkan secara paralel oleh tim yang berbeda.

#### 3.3.2 Eloquent ORM

Eloquent adalah ORM yang disediakan Laravel untuk berinteraksi dengan database menggunakan sintaks PHP yang ekspresif. Eloquent menyediakan berbagai fitur seperti:

- Relationship mapping (hasMany, belongsTo, dll)
- Mass assignment protection
- Model events dan observers
- Query builder yang powerful

### 3.4 Database Management System

Database Management System (DBMS) adalah sistem perangkat lunak yang digunakan untuk mengelola database. DBMS menyediakan interface untuk membuat, membaca, mengupdate, dan menghapus data dalam database.

#### 3.4.1 SQLite

SQLite adalah database engine yang embedded dalam aplikasi, tidak memerlukan server terpisah. SQLite cocok untuk aplikasi kecil hingga menengah karena:

- Tidak memerlukan konfigurasi server
- File-based database yang portable
- Mendukung SQL standar
- Performa yang baik untuk aplikasi single-user atau low-concurrency

#### 3.4.2 MySQL

MySQL adalah sistem manajemen database relasional yang open source dan populer untuk aplikasi web. MySQL cocok untuk aplikasi yang memerlukan:

- Skalabilitas tinggi
- Multi-user access
- Replikasi dan clustering
- Performa tinggi untuk aplikasi web

### 3.5 Sistem Autentikasi dan Otorisasi

#### 3.5.1 Autentikasi

Autentikasi adalah proses verifikasi identitas pengguna untuk memastikan bahwa pengguna adalah orang yang benar-benar memiliki hak akses ke sistem. Dalam sistem manajemen kos-kosan, autentikasi dilakukan melalui:

- Login dengan email dan password
- Session management
- Password hashing untuk keamanan

#### 3.5.2 Otorisasi Berbasis Role (RBAC)

Role-Based Access Control (RBAC) adalah model kontrol akses yang memberikan izin berdasarkan peran pengguna dalam sistem. Dalam sistem ini, terdapat tiga peran utama:

1. **Admin**: Memiliki akses penuh untuk mengelola sistem
2. **Tenant**: Penghuni yang dapat melihat tagihan dan mengajukan komplain
3. **Seeker**: Pencari kosan yang dapat melakukan booking

### 3.6 Sistem Pembayaran Digital

Sistem pembayaran digital memungkinkan pengguna untuk melakukan transaksi pembayaran secara online. Dalam sistem manajemen kos-kosan, sistem pembayaran mencakup:

#### 3.6.1 Upload Bukti Pembayaran

Pengguna dapat mengupload bukti pembayaran dalam bentuk gambar atau dokumen untuk verifikasi oleh admin. Sistem ini mencakup:

- Validasi format file
- Penyimpanan file yang aman
- Tracking status pembayaran

#### 3.6.2 Verifikasi Pembayaran

Admin dapat memverifikasi pembayaran dengan melihat bukti yang diupload dan mengupdate status pembayaran menjadi "Lunas" atau "Perlu Revisi".

### 3.7 Sistem Komplain dan Ticketing

Sistem komplain adalah mekanisme untuk menangani keluhan dan masalah yang dilaporkan oleh penghuni. Sistem ini mencakup:

#### 3.7.1 Kategorisasi Komplain

Komplain dikategorikan berdasarkan jenis masalah seperti:
- Masalah fasilitas
- Masalah kebersihan
- Masalah keamanan
- Masalah lainnya

#### 3.7.2 Prioritas Komplain

Sistem menentukan prioritas komplain berdasarkan tingkat urgensi:
- Tinggi: Masalah keamanan atau darurat
- Sedang: Masalah fasilitas yang mengganggu
- Rendah: Masalah minor atau permintaan perbaikan

#### 3.7.3 Tracking Status

Status komplain dapat dilacak melalui berbagai tahap:
- Baru: Komplain baru yang belum ditindaklanjuti
- Diproses: Komplain sedang dalam penanganan
- Selesai: Komplain telah diselesaikan

### 3.8 Sistem Booking dan Reservasi

Sistem booking memungkinkan pencari kosan untuk memesan kamar secara online. Proses booking mencakup:

#### 3.8.1 Proses Booking

1. Pencarian kamar berdasarkan kriteria
2. Pilih kamar yang tersedia
3. Upload dokumen identitas
4. Pembayaran booking fee
5. Konfirmasi oleh admin

#### 3.8.2 Status Booking

Status booking dapat berubah sesuai dengan proses:
- Pending: Menunggu konfirmasi admin
- Confirmed: Booking dikonfirmasi
- Rejected: Booking ditolak
- Cancelled: Booking dibatalkan

### 3.9 User Experience (UX) dan User Interface (UI)

#### 3.9.1 Prinsip User Experience

User Experience (UX) adalah pengalaman pengguna saat berinteraksi dengan sistem. Prinsip-prinsip UX yang diterapkan:

- **Usability**: Kemudahan penggunaan sistem
- **Accessibility**: Aksesibilitas untuk berbagai jenis pengguna
- **Efficiency**: Efisiensi dalam menyelesaikan tugas
- **Satisfaction**: Kepuasan pengguna

#### 3.9.2 Responsive Design

Responsive design memastikan aplikasi dapat diakses dengan baik di berbagai perangkat seperti desktop, tablet, dan smartphone. Framework Bootstrap digunakan untuk mendukung responsive design.

### 3.10 Keamanan Sistem

#### 3.10.1 Keamanan Data

Keamanan data mencakup berbagai aspek:

- **Password Hashing**: Password disimpan dalam bentuk hash menggunakan algoritma bcrypt
- **CSRF Protection**: Perlindungan terhadap Cross-Site Request Forgery
- **Input Validation**: Validasi input untuk mencegah injection attacks
- **File Upload Security**: Validasi dan sanitasi file yang diupload

#### 3.10.2 Session Management

Session management mengatur sesi pengguna yang login:

- Session timeout untuk keamanan
- Session regeneration untuk mencegah session hijacking
- Secure session storage

### 3.11 Metodologi Pengembangan Sistem

#### 3.11.1 Waterfall Model

Waterfall model adalah metodologi pengembangan sistem yang berurutan dengan tahapan:

1. **Analisis Kebutuhan**: Mengidentifikasi kebutuhan sistem
2. **Desain Sistem**: Merancang arsitektur dan struktur sistem
3. **Implementasi**: Pengembangan kode dan database
4. **Testing**: Pengujian sistem
5. **Deployment**: Implementasi sistem ke production
6. **Maintenance**: Perawatan dan update sistem

#### 3.11.2 Agile Development

Agile development adalah metodologi yang menekankan pada pengembangan iteratif dan kolaborasi tim. Prinsip-prinsip agile:

- Individu dan interaksi lebih penting daripada proses dan tools
- Software yang berfungsi lebih penting daripada dokumentasi yang lengkap
- Kolaborasi dengan customer lebih penting daripada negosiasi kontrak
- Respons terhadap perubahan lebih penting daripada mengikuti rencana

### 3.12 Testing dan Quality Assurance

#### 3.12.1 Unit Testing

Unit testing adalah pengujian pada level komponen terkecil dari sistem. Dalam Laravel, unit testing dilakukan menggunakan PHPUnit untuk menguji:

- Model relationships
- Business logic
- Helper functions

#### 3.12.2 Integration Testing

Integration testing menguji interaksi antara komponen-komponen sistem:

- Database integration
- API endpoints
- User workflows

#### 3.12.3 User Acceptance Testing (UAT)

UAT adalah pengujian yang dilakukan oleh end user untuk memastikan sistem memenuhi kebutuhan bisnis:

- Testing oleh admin untuk fitur administrasi
- Testing oleh penghuni untuk fitur tenant
- Testing oleh pencari kosan untuk fitur booking

### 3.13 Dokumentasi Sistem

#### 3.13.1 Dokumentasi Teknis

Dokumentasi teknis mencakup:

- Database schema dan ERD
- API documentation
- Code documentation
- Deployment guide

#### 3.13.2 Dokumentasi Pengguna

Dokumentasi pengguna mencakup:

- User manual untuk setiap role
- FAQ (Frequently Asked Questions)
- Troubleshooting guide
- Video tutorial

### 3.14 Referensi

Laudon, K. C., & Laudon, J. P. (2018). *Management Information Systems: Managing the Digital Firm*. 15th Edition. Pearson.

Sari, D. P., & Putra, A. (2020). "Implementasi Sistem Manajemen Kos-Kosan Digital untuk Meningkatkan Efisiensi Administrasi". *Jurnal Teknologi Informasi*, 15(2), 45-58.

Taylor, O. (2019). *Laravel: Up & Running*. O'Reilly Media.

Silberschatz, A., Galvin, P. B., & Gagne, G. (2018). *Operating System Concepts*. 10th Edition. John Wiley & Sons.

---

*Bab ini menjelaskan landasan teori yang mendasari pengembangan sistem manajemen kos-kosan, mencakup konsep sistem informasi, teknologi yang digunakan, metodologi pengembangan, dan aspek keamanan sistem.*

