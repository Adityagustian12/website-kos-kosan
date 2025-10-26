@extends('layouts.app')

@section('title', 'Detail Booking - Dashboard Penghuni')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <div class="p-3">
                <h6 class="text-muted text-uppercase mb-3">Menu Penghuni</h6>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('tenant.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('tenant.bills') }}">
                        <i class="fas fa-file-invoice me-2"></i>Tagihan Saya
                    </a>
                    <a class="nav-link active" href="{{ route('tenant.complaints') }}">
                        <i class="fas fa-exclamation-triangle me-2"></i>Keluhan Saya
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
                            <i class="fas fa-calendar-check me-2"></i>Detail Booking #{{ $booking->id }}
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('bookings.my') }}">Booking Saya</a></li>
                                <li class="breadcrumb-item active">Detail Booking</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('bookings.my') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Booking Information -->
                    <div class="col-lg-8">
                        <!-- Basic Info Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Booking
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Nomor Booking:</strong>
                                        <p class="text-muted mb-0">#{{ $booking->id }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Status:</strong>
                                        <p class="text-muted mb-0">
                                            @if($booking->status === 'pending')
                                                <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                            @elseif($booking->status === 'confirmed')
                                                <span class="badge bg-success">Dikonfirmasi</span>
                                            @elseif($booking->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="badge bg-secondary">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Tanggal Check-in:</strong>
                                        <p class="text-muted mb-0">{{ $booking->check_in_date->format('d M Y') }}</p>
                                    </div>
                                    @if($booking->check_out_date)
                                        <div class="col-md-6 mb-3">
                                            <strong>Tanggal Check-out:</strong>
                                            <p class="text-muted mb-0">{{ $booking->check_out_date->format('d M Y') }}</p>
                                        </div>
                                    @endif
                                    <div class="col-md-6 mb-3">
                                        <strong>Booking Fee:</strong>
                                        <p class="text-muted mb-0">Rp {{ number_format($booking->booking_fee, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Tanggal Dibuat:</strong>
                                        <p class="text-muted mb-0">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                @if($booking->notes)
                                    <div class="mt-3">
                                        <strong>Catatan:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $booking->notes }}
                                        </div>
                                    </div>
                                @endif

                                @if($booking->admin_notes)
                                    <div class="mt-3">
                                        <strong>Catatan Admin:</strong>
                                        <div class="mt-2 p-3 bg-primary text-white rounded">
                                            {{ $booking->admin_notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Documents Card -->
                        @if($booking->documents && count($booking->documents) > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-alt me-2"></i>Dokumen Booking
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($booking->documents as $index => $document)
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    @if(pathinfo($document, PATHINFO_EXTENSION) === 'pdf')
                                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                                        <h6 class="card-title">Dokumen PDF</h6>
                                                    @else
                                                        <img src="{{ asset('storage/' . $document) }}" 
                                                             class="img-fluid rounded mb-3" 
                                                             alt="Dokumen Booking"
                                                             style="height: 150px; width: 100%; object-fit: cover;">
                                                        <h6 class="card-title">Dokumen {{ $index + 1 }}</h6>
                                                    @endif
                                                    <a href="{{ asset('storage/' . $document) }}" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Payment Proof Card -->
                        @if($booking->payment_proof)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-credit-card me-2"></i>Bukti Pembayaran
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if(pathinfo($booking->payment_proof, PATHINFO_EXTENSION) === 'pdf')
                                            <div class="text-center">
                                                <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                                <h6>Bukti Pembayaran PDF</h6>
                                            </div>
                                        @else
                                            <img src="{{ asset('storage/' . $booking->payment_proof) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="Bukti Pembayaran"
                                                 style="height: 300px; width: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center h-100">
                                            <div>
                                                <h6>Status Pembayaran:</h6>
                                                @if($booking->status === 'confirmed')
                                                    <span class="badge bg-success fs-6">Diverifikasi</span>
                                                @else
                                                    <span class="badge bg-warning fs-6">Menunggu Verifikasi</span>
                                                @endif
                                                <div class="mt-3">
                                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-download me-2"></i>Download Bukti
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Quick Actions -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('public.room.detail', $booking->room) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail Kamar
                                    </a>
                                    
                                    @if($booking->status === 'pending' && !$booking->payment_proof)
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                            <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                        </button>
                                    @endif

                                    @if($booking->status === 'pending')
                                        <button type="button" class="btn btn-danger" onclick="cancelBooking({{ $booking->id }})">
                                            <i class="fas fa-times me-2"></i>Batalkan Booking
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Room Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-bed me-2"></i>Info Kamar
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <strong>Nomor Kamar:</strong> {{ $booking->room->room_number }}
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Harga:</strong> Rp {{ number_format($booking->room->price, 0, ',', '.') }}/bulan
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Kapasitas:</strong> {{ $booking->room->capacity }} orang
                                    </div>
                                    <div class="col-12">
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ $booking->room->status === 'available' ? 'success' : ($booking->room->status === 'occupied' ? 'warning' : 'danger') }}">
                                            {{ $booking->room->status === 'available' ? 'Tersedia' : ($booking->room->status === 'occupied' ? 'Terisi' : 'Maintenance') }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($booking->room->description)
                                    <div class="mt-3">
                                        <strong>Deskripsi:</strong>
                                        <p class="text-muted">{{ Str::limit($booking->room->description, 100) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i>Timeline
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Booking Dibuat</h6>
                                            <small class="text-muted">{{ $booking->created_at->format('d M Y H:i') }}</small>
                                        </div>
                                    </div>
                                    
                                    @if($booking->payment_proof)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-warning"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Bukti Pembayaran Diupload</h6>
                                                <small class="text-muted">{{ $booking->updated_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($booking->status === 'confirmed')
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Booking Dikonfirmasi</h6>
                                                <small class="text-muted">{{ $booking->updated_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </div>
                                    @elseif($booking->status === 'rejected')
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-danger"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Booking Ditolak</h6>
                                                <small class="text-muted">{{ $booking->updated_at->format('d M Y H:i') }}</small>
                                            </div>
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
</div>

<!-- Payment Modal -->
@if($booking->status === 'pending' && !$booking->payment_proof)
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bookings.payment-proof', $booking) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required>
                        <div class="form-text">
                            Upload bukti pembayaran (format: JPG, PNG, PDF, maksimal 2MB)
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 14px;
}

.timeline-content small {
    font-size: 12px;
}
</style>

<script>
function cancelBooking(bookingId) {
    if (confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/bookings/${bookingId}/cancel`;
        
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
        methodField.value = 'POST';
        form.appendChild(methodField);
        
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
