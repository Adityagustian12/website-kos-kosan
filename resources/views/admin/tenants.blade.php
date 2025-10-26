@extends('layouts.app')

@section('title', 'Kelola Penghuni - Admin Dashboard')

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
                    <a class="nav-link" href="{{ route('admin.bills') }}">
                        <i class="fas fa-file-invoice me-2"></i>Kelola Tagihan
                    </a>
                    <a class="nav-link" href="{{ route('admin.payments') }}">
                        <i class="fas fa-credit-card me-2"></i>Kelola Pembayaran
                    </a>
                    <a class="nav-link" href="{{ route('admin.complaints') }}">
                        <i class="fas fa-exclamation-triangle me-2"></i>Kelola Keluhan
                    </a>
                    <a class="nav-link active" href="{{ route('admin.tenants') }}">
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
                        <i class="fas fa-users me-2"></i>Kelola Penghuni
                    </h2>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter Penghuni</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.tenants') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Cari Penghuni</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Nama atau email...">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="room" class="form-label">Kamar</label>
                                <select class="form-select" id="room" name="room">
                                    <option value="">Semua Kamar</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ request('room') == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tenants Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Penghuni
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($tenants->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Kamar</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tenants as $tenant)
                                            <tr>
                                                <td>
                                                    @if($tenant->profile_picture)
                                                        <img src="{{ asset('storage/' . $tenant->profile_picture) }}" 
                                                             class="rounded-circle" 
                                                             width="40" height="40" 
                                                             alt="Foto {{ $tenant->name }}">
                                                    @else
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px;">
                                                            {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $tenant->name }}</strong>
                                                        @if($tenant->birth_date)
                                                            <br>
                                                            <small class="text-muted">{{ $tenant->birth_date->format('d M Y') }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $tenant->email }}</strong>
                                                        @if($tenant->address)
                                                            <br>
                                                            <small class="text-muted">{{ Str::limit($tenant->address, 30) }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $tenant->phone ?? '-' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $currentRoom = $tenant->bookings()
                                                            ->where('status', 'confirmed')
                                                            ->with('room')
                                                            ->latest()
                                                            ->first();
                                                    @endphp
                                                    @if($currentRoom)
                                                        <span class="badge bg-info">{{ $currentRoom->room->room_number }}</span>
                                                        <br>
                                                        <small class="text-muted">Rp {{ number_format($currentRoom->room->price, 0, ',', '.') }}/bulan</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($currentRoom)
                                                        {{ $currentRoom->check_in_date->format('d M Y') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $currentRoom = $tenant->bookings()
                                                            ->where('status', 'confirmed')
                                                            ->with('room')
                                                            ->latest()
                                                            ->first();
                                                    @endphp
                                                    @if($currentRoom)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-sm btn-outline-info" onclick="viewTenant({{ $tenant->id }})" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning" onclick="editTenant({{ $tenant->id }})" title="Edit Data">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-primary" onclick="viewTenantHistory({{ $tenant->id }})" title="Riwayat">
                                                            <i class="fas fa-history"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteTenant({{ $tenant->id }})" title="Hapus Permanen">
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
                                {{ $tenants->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada penghuni</h4>
                                <p class="text-muted">Belum ada penghuni yang terdaftar di sistem.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Summary Cards -->
                @if($tenants->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $tenants->count() }}</h4>
                                        <p class="mb-0">Total Penghuni</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $tenants->whereNull('deleted_at')->filter(function($tenant) { return $tenant->bookings()->where('status', 'confirmed')->exists(); })->count() }}</h4>
                                        <p class="mb-0">Penghuni Aktif</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-check fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $tenants->whereNull('deleted_at')->filter(function($tenant) { return $tenant->bookings()->where('status', 'confirmed')->doesntExist(); })->count() }}</h4>
                                        <p class="mb-0">Tidak Aktif</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-times fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $tenants->filter(function($tenant) { return $tenant->complaints()->exists(); })->count() }}</h4>
                                        <p class="mb-0">Punya Keluhan</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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

.table img {
    object-fit: cover;
}
</style>

<script>
function viewTenant(tenantId) {
    // Redirect to tenant detail page
    window.location.href = `/admin/tenants/${tenantId}`;
}

function editTenant(tenantId) {
    // Implementasi edit tenant
    alert('Fitur edit data penghuni akan segera tersedia!');
}

function viewTenantHistory(tenantId) {
    // Implementasi view tenant history
    alert('Fitur riwayat penghuni akan segera tersedia!');
}

function deleteTenant(tenantId) {
    if (confirm('⚠️ PERINGATAN: Apakah Anda yakin ingin menghapus penghuni ini secara permanen?\n\n' +
                'Tindakan ini akan menghapus:\n' +
                '• Data penghuni\n' +
                '• Semua riwayat booking\n' +
                '• Semua tagihan\n' +
                '• Semua keluhan\n\n' +
                'Tindakan ini TIDAK DAPAT DIBATALKAN!\n\n' +
                'Ketik "HAPUS" untuk konfirmasi:')) {
        
        const confirmation = prompt('Ketik "HAPUS" untuk konfirmasi penghapusan permanen:');
        if (confirmation === 'HAPUS') {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/tenants/${tenantId}/delete`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method override
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Penghapusan dibatalkan.');
        }
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
