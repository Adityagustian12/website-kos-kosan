@extends('layouts.app')

@section('title', 'Kelola Booking - Admin Dashboard')

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
                    <a class="nav-link active" href="{{ route('admin.bookings') }}">
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
                        <i class="fas fa-calendar-check me-2"></i>Kelola Booking
                    </h2>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.bookings', ['status' => 'all']) }}" 
                           class="btn {{ request('status') == 'all' || !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" 
                           class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" 
                           class="btn {{ request('status') == 'confirmed' ? 'btn-success' : 'btn-outline-success' }}">
                            Dikonfirmasi
                        </a>
                        <a href="{{ route('admin.bookings', ['status' => 'rejected']) }}" 
                           class="btn {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                            Ditolak
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Bookings Table -->
                <div class="card">
                    <div class="card-body">
                        @if($bookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Pemesan</th>
                                            <th>Kamar</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Booking Fee</th>
                                            <th>Status</th>
                                            <th>Tanggal Booking</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->id }}</td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $booking->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $booking->room->room_number }}</strong>
                                                        <br>
                                                        <small class="text-muted">Kapasitas: {{ $booking->room->capacity }} orang</small>
                                                    </div>
                                                </td>
                                                <td>{{ $booking->check_in_date->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($booking->booking_fee, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('admin.bookings.detail', $booking) }}" 
                                                           class="btn btn-outline-info" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        
                                                        @if($booking->status === 'pending')
                                                            <form action="{{ route('admin.bookings.confirm', $booking) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-outline-success" 
                                                                        title="Konfirmasi"
                                                                        onclick="return confirm('Konfirmasi booking ini?')">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('admin.bookings.reject', $booking) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-outline-danger" 
                                                                        title="Tolak"
                                                                        onclick="return confirm('Tolak booking ini?')">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bookings->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Tidak ada booking</h4>
                                <p class="text-muted">Belum ada booking yang dibuat.</p>
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

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group-sm > .btn, .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endsection
