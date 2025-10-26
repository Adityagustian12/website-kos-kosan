@extends('layouts.app')

@section('title', 'Kelola Kamar - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="p-3">
                <h6 class="text-muted text-uppercase mb-3">Menu Admin</h6>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('admin.bookings') }}">
                        <i class="fas fa-calendar-check me-2"></i>Kelola Booking
                    </a>
                    <a class="nav-link active" href="{{ route('admin.rooms') }}">
                        <i class="fas fa-bed me-2"></i>Kelola Kamar
                    </a>
                    <a class="nav-link" href="{{ route('admin.bills') }}">
                        <i class="fas fa-file-invoice me-2"></i>Kelola Tagihan
                    </a>
                    <a class="nav-link" href="{{ route('admin.payments') }}">
                        <i class="fas fa-credit-card me-2"></i>Kelola Pembayaran
                    </a>
                    <a class="nav-link" href="{{ route('admin.complaints') }}">
                        <i class="fas fa-exclamation-triangle me-2"></i>Kelola Keluhan
                    </a>
                    <a class="nav-link" href="{{ route('admin.tenants') }}">
                        <i class="fas fa-users me-2"></i>Kelola Penghuni
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-bed me-2"></i>Kelola Kamar
                    </h2>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                            <i class="fas fa-plus me-2"></i>Tambah Kamar
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.rooms') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status Kamar</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Terisi</option>
                                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.rooms') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Rooms Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Kamar
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($rooms->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Kamar</th>
                                            <th>Harga</th>
                                            <th>Kapasitas</th>
                                            <th>Status</th>
                                            <th>Booking</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rooms as $room)
                                            <tr>
                                                <td>
                                                    <strong>{{ $room->room_number }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $room->area }}</small>
                                                </td>
                                                <td>
                                                    <strong>Rp {{ number_format($room->price, 0, ',', '.') }}</strong>
                                                    <br>
                                                    <small class="text-muted">/bulan</small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-users me-1"></i>{{ $room->capacity }} orang
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'warning' : 'danger') }}">
                                                        {{ $room->status === 'available' ? 'Tersedia' : ($room->status === 'occupied' ? 'Terisi' : 'Maintenance') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $room->bookings_count }} booking</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.room.detail', $room) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-warning" onclick="editRoom({{ $room->id }})" title="Edit Kamar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-success" onclick="duplicateRoom({{ $room->id }})" title="Duplikasi Kamar">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                        @if($room->status === 'occupied')
                                                            <button class="btn btn-sm btn-warning" onclick="vacateRoom({{ $room->id }})" title="Kosongkan Kamar">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteRoom({{ $room->id }})" title="Hapus Kamar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $rooms->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bed fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada kamar</h4>
                                <p class="text-muted">Mulai dengan menambahkan kamar pertama Anda.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Kamar Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">
                    <i class="fas fa-plus me-2"></i>Tambah Kamar Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="room_number" name="room_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga Sewa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacity" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Luas Kamar</label>
                            <input type="text" class="form-control" id="area" name="area" placeholder="Contoh: 3x4 meter">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="facilities" class="form-label">Fasilitas</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="AC" id="facility_ac">
                                        <label class="form-check-label" for="facility_ac">AC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="WiFi" id="facility_wifi">
                                        <label class="form-check-label" for="facility_wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kamar Mandi Dalam" id="facility_bathroom">
                                        <label class="form-check-label" for="facility_bathroom">Kamar Mandi Dalam</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Lemari" id="facility_wardrobe">
                                        <label class="form-check-label" for="facility_wardrobe">Lemari</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Meja Belajar" id="facility_desk">
                                        <label class="form-check-label" for="facility_desk">Meja Belajar</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kulkas" id="facility_fridge">
                                        <label class="form-check-label" for="facility_fridge">Kulkas</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="TV" id="facility_tv">
                                        <label class="form-check-label" for="facility_tv">TV</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kipas Angin" id="facility_fan">
                                        <label class="form-check-label" for="facility_fan">Kipas Angin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="images" class="form-label">Gambar Kamar</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <div class="form-text">Pilih beberapa gambar untuk kamar ini.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Room Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kamar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoomForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_room_number" class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_room_number" name="room_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_price" class="form-label">Harga Sewa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_price" name="price" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_capacity" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_capacity" name="capacity" required min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_area" class="form-label">Luas Kamar</label>
                            <input type="text" class="form-control" id="edit_area" name="area" placeholder="Contoh: 3x4 meter">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_facilities" class="form-label">Fasilitas</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="AC" id="edit_facility_ac">
                                        <label class="form-check-label" for="edit_facility_ac">AC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="WiFi" id="edit_facility_wifi">
                                        <label class="form-check-label" for="edit_facility_wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kamar Mandi Dalam" id="edit_facility_bathroom">
                                        <label class="form-check-label" for="edit_facility_bathroom">Kamar Mandi Dalam</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Lemari" id="edit_facility_wardrobe">
                                        <label class="form-check-label" for="edit_facility_wardrobe">Lemari</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Meja Belajar" id="edit_facility_desk">
                                        <label class="form-check-label" for="edit_facility_desk">Meja Belajar</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kulkas" id="edit_facility_fridge">
                                        <label class="form-check-label" for="edit_facility_fridge">Kulkas</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="TV" id="edit_facility_tv">
                                        <label class="form-check-label" for="edit_facility_tv">TV</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Kipas Angin" id="edit_facility_fan">
                                        <label class="form-check-label" for="edit_facility_fan">Kipas Angin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_images" class="form-label">Gambar Kamar</label>
                            <input type="file" class="form-control" id="edit_images" name="images[]" multiple accept="image/*">
                            <div class="form-text">Pilih gambar baru untuk mengganti gambar lama (opsional).</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.sidebar {
    background-color: #f8f9fa;
    min-height: 100vh;
    border-right: 1px solid #dee2e6;
}

.main-content {
    background-color: #fff;
}

.nav-link {
    color: #495057;
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
}

.nav-link:hover {
    background-color: #e9ecef;
    color: #495057;
}

.nav-link.active {
    background-color: #0d6efd;
    color: white;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>

<script>
// Room data untuk JavaScript
const rooms = @json($rooms->items());

function editRoom(roomId) {
    const room = rooms.find(r => r.id === roomId);
    if (!room) {
        alert('Data kamar tidak ditemukan!');
        return;
    }

    // Set form action
    document.getElementById('editRoomForm').action = `/admin/rooms/${roomId}`;
    
    // Fill form with room data
    document.getElementById('edit_room_number').value = room.room_number;
    document.getElementById('edit_price').value = room.price;
    document.getElementById('edit_capacity').value = room.capacity;
    document.getElementById('edit_area').value = room.area || '';
    document.getElementById('edit_description').value = room.description || '';
    
    // Clear all facility checkboxes first
    const facilityCheckboxes = document.querySelectorAll('#editRoomModal input[name="facilities[]"]');
    facilityCheckboxes.forEach(checkbox => checkbox.checked = false);
    
    // Check facilities that exist
    if (room.facilities && Array.isArray(room.facilities)) {
        room.facilities.forEach(facility => {
            const checkbox = document.querySelector(`#editRoomModal input[value="${facility}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
    
    // Show modal
    const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
    editModal.show();
}

function deleteRoom(roomId) {
    const room = rooms.find(r => r.id === roomId);
    if (!room) {
        alert('Data kamar tidak ditemukan!');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin menghapus kamar ${room.room_number}?\n\nPerhatian: Kamar yang memiliki booking aktif atau tagihan belum dibayar tidak dapat dihapus.`)) {
        // Create form for DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/rooms/${roomId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function duplicateRoom(roomId) {
    const room = rooms.find(r => r.id === roomId);
    if (!room) {
        alert('Data kamar tidak ditemukan!');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin menduplikasi kamar ${room.room_number}?\n\nKamar baru akan dibuat dengan nomor "${room.room_number}-Copy"`)) {
        // Create form for POST request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/rooms/${roomId}/duplicate`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function vacateRoom(roomId) {
    const room = rooms.find(r => r.id === roomId);
    if (!room) {
        alert('Data kamar tidak ditemukan!');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin mengosongkan kamar ${room.room_number}?\n\nKamar akan diubah statusnya menjadi "Tersedia" dan kapasitas akan diatur menjadi 0.`)) {
        // Create form for POST request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/rooms/${roomId}/vacate`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Show success/error messages
@if(session('success'))
    alert('{{ session('success') }}');
@endif

@if(session('error'))
    alert('{{ session('error') }}');
@endif
</script>
@endsection
