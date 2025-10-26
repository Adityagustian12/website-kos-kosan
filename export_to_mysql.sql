-- Script untuk migrasi data dari SQLite ke MySQL
-- Jalankan setelah membuat database kosku_db di MySQL

-- 1. Export data dari SQLite (gunakan sqlite3 command line)
-- sqlite3 database/database.sqlite .dump > export_data.sql

-- 2. Atau gunakan query berikut untuk export data:

-- Export Users
INSERT INTO users (id, name, email, password, phone, address, role, created_at, updated_at) VALUES
(1, 'Admin Kos-Kosan', 'admin@koskosan.com', '$2y$12$clMi9/t/6KH4N5GDkskrBucC25bXRYRIJnF46tmFJrYKxPZGN4neC', '081234567890', 'Jl. Admin No. 1, Jakarta', 'admin', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(2, 'John Doe', 'john@example.com', '$2y$12$clMi9/t/6KH4N5GDkskrBucC25bXRYRIJnF46tmFJrYKxPZGN4neC', '081234567891', 'Jl. Pencari No. 1, Jakarta', 'tenant', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(3, 'Jane Smith', 'jane@example.com', '$2y$12$clMi9/t/6KH4N5GDkskrBucC25bXRYRIJnF46tmFJrYKxPZGN4neC', '081234567892', 'Jl. Pencari No. 2, Jakarta', 'seeker', '2025-10-07 11:34:25', '2025-10-07 11:34:25');

-- Export Rooms
INSERT INTO rooms (id, room_number, price, capacity, area, description, facilities, status, images, created_at, updated_at) VALUES
(1, 'A101', 1500000, 2, '20m²', 'Kamar nyaman dengan AC dan WiFi', '["AC", "WiFi", "Kamar Mandi Dalam", "Lemari"]', 'available', '["rooms/room1.jpg"]', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(2, 'A102', 1200000, 1, '15m²', 'Kamar single dengan fasilitas lengkap', '["AC", "WiFi", "Kamar Mandi Dalam"]', 'available', '["rooms/room2.jpg"]', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(3, 'B201', 1800000, 3, '25m²', 'Kamar family dengan balkon', '["AC", "WiFi", "Kamar Mandi Dalam", "Balkon", "Dapur Kecil"]', 'occupied', '["rooms/room3.jpg"]', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(4, 'B202', 1600000, 2, '22m²', 'Kamar double dengan view bagus', '["AC", "WiFi", "Kamar Mandi Dalam", "Lemari Besar"]', 'available', '["rooms/room4.jpg"]', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(5, 'C301', 2000000, 4, '30m²', 'Kamar premium dengan semua fasilitas', '["AC", "WiFi", "Kamar Mandi Dalam", "Balkon", "Dapur", "Lemari Besar"]', 'maintenance', '["rooms/room5.jpg"]', '2025-10-07 11:34:25', '2025-10-07 11:34:25');

-- Export Bookings
INSERT INTO bookings (id, user_id, room_id, check_in_date, check_out_date, booking_fee, status, admin_notes, created_at, updated_at) VALUES
(1, 2, 3, '2025-10-01', '2025-11-01', 1800000, 'confirmed', 'Booking dikonfirmasi', '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(2, 3, 1, '2025-10-15', '2025-11-15', 1500000, 'pending', NULL, '2025-10-07 11:34:25', '2025-10-07 11:34:25');

-- Export Bills
INSERT INTO bills (id, user_id, room_id, month, year, amount, total_amount, status, due_date, paid_at, created_at, updated_at) VALUES
(1, 2, 4, 10, 2025, 1200000, 1200000, 'pending', '2025-10-14', NULL, '2025-10-07 11:34:25', '2025-10-07 11:34:25'),
(2, 2, 4, 9, 2025, 1200000, 1200000, 'paid', '2025-09-14', '2025-09-10', '2025-10-07 11:34:25', '2025-10-07 11:34:25');

-- Export Complaints
INSERT INTO complaints (id, user_id, room_id, title, category, priority, description, status, admin_response, resolved_at, created_at, updated_at) VALUES
(1, 2, 3, 'AC tidak dingin', 'facility', 'medium', 'AC di kamar B201 tidak dingin sejak kemarin', 'in_progress', 'Teknisi akan datang besok', NULL, '2025-10-07 11:34:25', '2025-10-07 11:34:25');

-- Export Payments
INSERT INTO payments (id, user_id, bill_id, amount, payment_method, payment_proof, status, verified_by, verified_at, admin_notes, created_at, updated_at) VALUES
(1, 2, 2, 1200000, 'bank_transfer', 'payment-proofs/payment1.jpg', 'verified', 1, '2025-09-10', 'Pembayaran diterima', '2025-10-07 11:34:25', '2025-10-07 11:34:25');
