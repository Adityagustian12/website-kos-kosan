@extends('layouts.app')

@section('title', 'Detail Booking - Admin Dashboard')

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
                        <i class="fas fa-calendar-check me-2"></i>Detail Booking #{{ $booking->id }}
                    </h2>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Booking Information -->
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Booking
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">ID Booking</label>
                                        <p class="mb-0">#{{ $booking->id }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="mb-0">
                                            @switch($booking->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge bg-info">Dikonfirmasi</span>
                                                    @break
                                                @case('occupied')
                                                    <span class="badge bg-success">Ditempati</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-secondary">Dibatalkan</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-dark">Selesai</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                            @endswitch
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tanggal Masuk</label>
                                        <p class="mb-0">{{ $booking->check_in_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tanggal Keluar</label>
                                        <p class="mb-0">{{ $booking->check_out_date ? $booking->check_out_date->format('d M Y') : 'Tidak ditentukan' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Booking Fee</label>
                                        <p class="mb-0">Rp {{ number_format($booking->booking_fee, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tanggal Booking</label>
                                        <p class="mb-0">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    @if($booking->notes)
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Catatan Pemesan</label>
                                            <p class="mb-0">{{ $booking->notes }}</p>
                                        </div>
                                    @endif
                                    @if($booking->admin_notes)
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Catatan Admin</label>
                                            <p class="mb-0">{{ $booking->admin_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Room Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-bed me-2"></i>Informasi Kamar
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nomor Kamar</label>
                                        <p class="mb-0">{{ $booking->room->room_number }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Harga per Bulan</label>
                                        <p class="mb-0">Rp {{ number_format($booking->room->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kapasitas</label>
                                        <p class="mb-0">{{ $booking->room->capacity }} Orang</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Status Kamar</label>
                                        <p class="mb-0">
                                            <span class="badge bg-{{ $booking->room->status === 'available' ? 'success' : ($booking->room->status === 'occupied' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($booking->room->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    @if($booking->room->description)
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Deskripsi</label>
                                            <p class="mb-0">{{ $booking->room->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Information & Actions -->
                    <div class="col-lg-4">
                        <!-- User Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Informasi Pemesan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    @if($booking->user->profile_picture)
                                        <img src="{{ asset('storage/' . $booking->user->profile_picture) }}" 
                                             alt="Profile Picture" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <h6 class="mb-1">{{ $booking->user->name }}</h6>
                                    <p class="text-muted mb-2">{{ $booking->user->email }}</p>
                                    <span class="badge bg-{{ $booking->user->role === 'admin' ? 'danger' : ($booking->user->role === 'tenant' ? 'success' : 'info') }}">
                                        {{ ucfirst($booking->user->role) }}
                                    </span>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Telepon</small>
                                        <p class="mb-0">{{ $booking->user->phone }}</p>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Alamat</small>
                                        <p class="mb-0">{{ $booking->user->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($booking->status === 'pending')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cogs me-2"></i>Aksi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="mb-3">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="admin_notes" class="form-label">Catatan Admin (Opsional)</label>
                                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                                      placeholder="Tambahkan catatan untuk konfirmasi...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100" 
                                                onclick="return confirm('Konfirmasi booking ini? User akan menjadi penghuni.')">
                                            <i class="fas fa-check me-2"></i>Konfirmasi Booking
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="reject_reason" class="form-label">Alasan Penolakan</label>
                                            <textarea class="form-control" id="reject_reason" name="admin_notes" rows="3" 
                                                      placeholder="Berikan alasan penolakan..." required>{{ old('admin_notes') }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" 
                                                onclick="return confirm('Tolak booking ini?')">
                                            <i class="fas fa-times me-2"></i>Tolak Booking
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Move Into Room Action -->
                        @if($booking->status === 'confirmed')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-home me-2"></i>Pindahkan ke Kamar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.bookings.move-in', $booking) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="move_in_notes" class="form-label">Catatan Admin (Opsional)</label>
                                            <textarea class="form-control" id="move_in_notes" name="admin_notes" rows="3" 
                                                      placeholder="Tambahkan catatan untuk pemindahan ke kamar...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100" 
                                                onclick="return confirm('Pindahkan user ke kamar? User akan menjadi penghuni dan kamar akan terisi.')">
                                            <i class="fas fa-home me-2"></i>Pindahkan ke Kamar (User Menjadi Penghuni)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Complete Booking Action -->
                        @if($booking->status === 'occupied')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cogs me-2"></i>Selesaikan Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="complete_notes" class="form-label">Catatan Admin (Opsional)</label>
                                            <textarea class="form-control" id="complete_notes" name="admin_notes" rows="3" 
                                                      placeholder="Tambahkan catatan untuk penyelesaian booking...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-warning w-100" 
                                                onclick="return confirm('Selesaikan booking ini? Status akan berubah menjadi Completed dan kamar akan tersedia kembali.')">
                                            <i class="fas fa-check-circle me-2"></i>Selesaikan Booking (Penghuni Keluar/Pindah)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Documents -->
                        @if($booking->documents && count($booking->documents) > 0)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-alt me-2"></i>Dokumen Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @foreach($booking->documents as $document)
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $document) }}" target="_blank" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>Lihat Dokumen
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Payment Proof -->
                        @if($booking->payment_proof)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-credit-card me-2"></i>Bukti Pembayaran
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download me-1"></i>Lihat Bukti Pembayaran
                                    </a>
                                </div>
                            </div>
                        @endif
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

.form-label {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}
</style>
@endsection
