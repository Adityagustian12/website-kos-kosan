<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Bill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Kos-Kosan',
            'email' => 'admin@koskosan.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Jakarta',
            'role' => 'admin',
        ]);

        // Create Sample Seeker
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'address' => 'Jl. Seeker No. 1, Jakarta',
            'role' => 'seeker',
        ]);

        // Create Sample Rooms
        $rooms = [
            [
                'room_number' => 'A-101',
                'price' => 1500000,
                'description' => 'Kamar single dengan fasilitas lengkap, AC, WiFi, dan kamar mandi dalam.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'Lemari', 'Meja Belajar'],
                'status' => 'available',
                'capacity' => 1,
                'area' => '3x4 meter',
            ],
            [
                'room_number' => 'A-102',
                'price' => 2000000,
                'description' => 'Kamar double yang nyaman untuk pasangan atau teman sekamar.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'Lemari', 'Meja Belajar', 'Kulkas'],
                'status' => 'available',
                'capacity' => 2,
                'area' => '4x4 meter',
            ],
            [
                'room_number' => 'B-201',
                'price' => 3000000,
                'description' => 'Kamar family dengan ruang yang luas, cocok untuk keluarga kecil.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'Lemari', 'Meja Belajar', 'Kulkas', 'TV'],
                'status' => 'available',
                'capacity' => 4,
                'area' => '5x5 meter',
            ],
            [
                'room_number' => 'B-202',
                'price' => 1200000,
                'description' => 'Kamar single ekonomis dengan fasilitas dasar.',
                'facilities' => ['Kipas Angin', 'WiFi', 'Kamar Mandi Luar', 'Lemari'],
                'status' => 'occupied',
                'capacity' => 1,
                'area' => '3x3 meter',
            ],
            [
                'room_number' => 'C-301',
                'price' => 1800000,
                'description' => 'Kamar double dengan pemandangan yang indah.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'Lemari', 'Meja Belajar'],
                'status' => 'maintenance',
                'capacity' => 2,
                'area' => '4x4 meter',
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        // Create Sample Bills
        $bills = [
            [
                'user_id' => 2,
                'room_id' => 4,
                'month' => 10,
                'year' => 2025,
                'amount' => 1200000,
                'total_amount' => 1200000,
                'status' => 'pending',
                'due_date' => now()->addDays(7),
            ],
            [
                'user_id' => 2,
                'room_id' => 4,
                'month' => 9,
                'year' => 2025,
                'amount' => 1200000,
                'total_amount' => 1200000,
                'status' => 'paid',
                'due_date' => now()->subDays(10),
                'paid_at' => now()->subDays(5),
            ],
        ];

        foreach ($bills as $billData) {
            Bill::create($billData);
        }
    }
}