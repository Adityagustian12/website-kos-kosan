@extends('layouts.app')

@section('title', 'Dashboard Pencari Kosan - Kos-Kosan Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="p-3">
                <h6 class="text-muted text-uppercase mb-3">Menu Pencari Kosan</h6>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="{{ route('seeker.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('bookings.my') }}">
                        <i class="fas fa-calendar-check me-2"></i>Booking Saya
                    </a>
                    <a class="nav-link" href="{{ route('profile.show') }}">
                        <i class="fas fa-user me-2"></i>Data Diri
                    </a>
                    <a class="nav-link" href="{{ route('public.home') }}">
                        <i class="fas fa-bed me-2"></i>Cari Kamar
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-search me-2"></i>Dashboard Pencari Kosan
                    </h2>
                    <span class="badge bg-info fs-6">Selamat datang, {{ auth()->user()->name }}</span>
                </div>

                <!-- Role Transition Alert -->
                @if($can_become_tenant)
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">
                            <i class="fas fa-check-circle me-2"></i>Selamat! Booking Anda Dikonfirmasi
                        </h5>
                        <p class="mb-2">Booking Anda telah dikonfirmasi oleh admin. Anda sekarang adalah <strong>Penghuni</strong>!</p>
                        <p class="mb-0">Silakan refresh halaman untuk mengakses dashboard penghuni.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $stats['total_bookings'] }}</h4>
                                        <p class="mb-0">Total Booking</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-calendar-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $stats['pending_bookings'] }}</h4>
                                        <p class="mb-0">Booking Menunggu</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $stats['confirmed_bookings'] }}</h4>
                                        <p class="mb-0">Booking Dikonfirmasi</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $stats['rejected_bookings'] }}</h4>
                                        <p class="mb-0">Booking Ditolak</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-times-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <a href="{{ route('public.home') }}" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-bed me-2"></i>Cari Kamar Baru
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="{{ route('bookings.my') }}" class="btn btn-outline-info w-100">
                                            <i class="fas fa-calendar-check me-2"></i>Lihat Booking
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="{{ route('profile.show') }}" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-user me-2"></i>Update Profil
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="{{ route('public.room.detail', 1) }}" class="btn btn-outline-success w-100">
                                            <i class="fas fa-eye me-2"></i>Lihat Kamar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-calendar-check me-2"></i>Booking Terbaru
                                </h5>
                            </div>
                            <div class="card-body">
                                @forelse($recent_bookings as $booking)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-bed fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Kamar {{ $booking->room->room_number }}</h6>
                                            <p class="mb-1 text-muted">Kapasitas: {{ $booking->room->capacity }} orang - Rp {{ number_format($booking->room->price, 0, ',', '.') }}/bulan</p>
                                            <small class="text-muted">Tanggal Masuk: {{ $booking->check_in_date->format('d M Y') }}</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada booking</h5>
                                        <p class="text-muted">Mulai booking kamar yang Anda inginkan.</p>
                                        <a href="{{ route('public.home') }}" class="btn btn-primary">
                                            <i class="fas fa-bed me-2"></i>Cari Kamar
                                        </a>
                                    </div>
                                @endforelse
                                
                                @if($recent_bookings->count() > 0)
                                    <div class="text-center">
                                        <a href="{{ route('bookings.my') }}" class="btn btn-outline-primary btn-sm">
                                            Lihat Semua Booking
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($can_become_tenant)
<script>
    // Auto refresh after 3 seconds to show tenant dashboard
    setTimeout(function() {
        window.location.reload();
    }, 3000);
</script>
@endif
@endsection
