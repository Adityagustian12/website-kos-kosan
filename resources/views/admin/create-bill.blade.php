@extends('layouts.app')

@section('title', 'Buat Tagihan Baru - Admin Dashboard')

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
                    <a class="nav-link" href="{{ route('admin.rooms') }}">
                        <i class="fas fa-bed me-2"></i>Kelola Kamar
                    </a>
                    <a class="nav-link active" href="{{ route('admin.bills') }}">
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
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Buat Tagihan Baru
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.bills') }}">Kelola Tagihan</a></li>
                                <li class="breadcrumb-item active">Buat Tagihan Baru</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.bills') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Create Bill Form -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-invoice me-2"></i>Form Tagihan Baru
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.bills.store') }}" method="POST">
                                    @csrf
                                    
                                    <!-- Basic Information -->
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label for="user_id" class="form-label">Penghuni <span class="text-danger">*</span></label>
                                            <select class="form-select" id="user_id" name="user_id" required>
                                                <option value="">Pilih Penghuni</option>
                                                @foreach($tenants as $tenant)
                                                    <option value="{{ $tenant->id }}" {{ old('user_id') == $tenant->id ? 'selected' : '' }}>
                                                        {{ $tenant->name }} - {{ $tenant->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="room_id" class="form-label">Kamar <span class="text-danger">*</span></label>
                                            <select class="form-select" id="room_id" name="room_id" required>
                                                <option value="">Pilih Kamar</option>
                                                <!-- Will be populated by JavaScript based on selected tenant -->
                                            </select>
                                            @error('room_id')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Period Information -->
                                    <div class="row mb-4">
                                        <div class="col-md-4 mb-3">
                                            <label for="month" class="form-label">Bulan <span class="text-danger">*</span></label>
                                            <select class="form-select" id="month" name="month" required>
                                                <option value="">Pilih Bulan</option>
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('month')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                                            <select class="form-select" id="year" name="year" required>
                                                <option value="">Pilih Tahun</option>
                                                @for($i = date('Y'); $i >= 2020; $i--)
                                                    <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @error('year')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="due_date" class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                                   value="{{ old('due_date') }}" required>
                                            @error('due_date')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Amount Information -->
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label for="amount" class="form-label">Sewa Kamar <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="amount" name="amount" 
                                                       value="{{ old('amount') }}" required min="0" step="1000">
                                            </div>
                                            @error('amount')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Total Amount Display -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6 class="mb-2">
                                                    <i class="fas fa-calculator me-2"></i>Total Tagihan
                                                </h6>
                                                <h4 class="mb-0" id="total_amount_display">Rp 0</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Buat Tagihan
                                        </button>
                                        <a href="{{ route('admin.bills') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Help Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Panduan
                                </h5>
                            </div>
                            <div class="card-body">
                                <h6>Langkah-langkah:</h6>
                                <ol class="small">
                                    <li>Pilih penghuni yang akan ditagih</li>
                                    <li>Pilih kamar yang ditempati</li>
                                    <li>Tentukan periode tagihan (bulan/tahun)</li>
                                    <li>Set tanggal jatuh tempo</li>
                                    <li>Isi detail biaya sesuai kebutuhan</li>
                                    <li>Klik "Buat Tagihan" untuk menyimpan</li>
                                </ol>
                                
                                <hr>
                                
                                <h6>Tips:</h6>
                                <ul class="small text-muted">
                                    <li>Pastikan penghuni sudah memiliki booking yang dikonfirmasi</li>
                                    <li>Tanggal jatuh tempo harus setelah tanggal hari ini</li>
                                    <li>Biaya sewa kamar wajib diisi</li>
                                    <li>Biaya lainnya bersifat opsional</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tenant Info Card -->
                        <div class="card mt-3" id="tenant_info_card" style="display: none;">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Info Penghuni
                                </h5>
                            </div>
                            <div class="card-body" id="tenant_info_content">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}
</style>

<script>
// Tenant data untuk JavaScript
const tenants = @json($tenants);

// Calculate total amount
function calculateTotal() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    document.getElementById('total_amount_display').textContent = 'Rp ' + amount.toLocaleString('id-ID');
}

// Update room options based on selected tenant
document.getElementById('user_id').addEventListener('change', function() {
    const userId = this.value;
    const roomSelect = document.getElementById('room_id');
    const tenantInfoCard = document.getElementById('tenant_info_card');
    const tenantInfoContent = document.getElementById('tenant_info_content');
    
    // Clear room options
    roomSelect.innerHTML = '<option value="">Pilih Kamar</option>';
    
    if (userId) {
        const tenant = tenants.find(t => t.id == userId);
        
        if (tenant && tenant.bookings && tenant.bookings.length > 0) {
            // Add room options from confirmed bookings
            let hasConfirmedRooms = false;
            tenant.bookings.forEach(booking => {
                if (booking.status === 'confirmed' && booking.room) {
                    const option = document.createElement('option');
                    option.value = booking.room.id;
                    option.textContent = `${booking.room.room_number} - Rp ${parseInt(booking.room.price).toLocaleString('id-ID')}/bulan`;
                    roomSelect.appendChild(option);
                    hasConfirmedRooms = true;
                }
            });
            
            // If no confirmed rooms, show message
            if (!hasConfirmedRooms) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Tidak ada kamar yang dikonfirmasi';
                option.disabled = true;
                roomSelect.appendChild(option);
            }
            
            // Show tenant info
            tenantInfoContent.innerHTML = `
                <div class="row">
                    <div class="col-12 mb-2">
                        <strong>Nama:</strong> ${tenant.name}
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Email:</strong> ${tenant.email}
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Telepon:</strong> ${tenant.phone || 'Tidak ada'}
                    </div>
                    <div class="col-12">
                        <strong>Alamat:</strong> ${tenant.address || 'Tidak ada'}
                    </div>
                </div>
            `;
            tenantInfoCard.style.display = 'block';
        } else {
            // If no bookings, show all rooms as fallback
            fetch('/admin/rooms-data')
                .then(response => response.json())
                .then(rooms => {
                    rooms.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = `${room.room_number} - Rp ${parseInt(room.price).toLocaleString('id-ID')}/bulan`;
                        roomSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching rooms:', error);
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Error loading rooms';
                    option.disabled = true;
                    roomSelect.appendChild(option);
                });
            
            // Show tenant info
            if (tenant) {
                tenantInfoContent.innerHTML = `
                    <div class="row">
                        <div class="col-12 mb-2">
                            <strong>Nama:</strong> ${tenant.name}
                        </div>
                        <div class="col-12 mb-2">
                            <strong>Email:</strong> ${tenant.email}
                        </div>
                        <div class="col-12 mb-2">
                            <strong>Telepon:</strong> ${tenant.phone || 'Tidak ada'}
                        </div>
                        <div class="col-12">
                            <strong>Alamat:</strong> ${tenant.address || 'Tidak ada'}
                        </div>
                    </div>
                `;
                tenantInfoCard.style.display = 'block';
            }
        }
    } else {
        tenantInfoCard.style.display = 'none';
    }
});

// Add event listeners for amount inputs
['amount'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculateTotal);
});

// Set default due date to next month
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
    document.getElementById('due_date').value = nextMonth.toISOString().split('T')[0];
    
    calculateTotal();
});

// Show success/error messages
@if(session('success'))
    alert('{{ session('success') }}');
@endif

@if(session('error'))
    alert('{{ session('error') }}');
@endif
</script>
@endsection
