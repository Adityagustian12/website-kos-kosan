@extends('layouts.app')

@section('title', 'Detail Keluhan - Dashboard Penghuni')

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
                            <i class="fas fa-exclamation-triangle me-2"></i>Detail Keluhan #{{ $complaint->id }}
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.complaints') }}">Keluhan Saya</a></li>
                                <li class="breadcrumb-item active">Detail Keluhan</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('tenant.complaints') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        @if($complaint->status === 'new')
                            <button class="btn btn-warning" onclick="editComplaint({{ $complaint->id }})">
                                <i class="fas fa-edit me-2"></i>Edit Keluhan
                            </button>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Complaint Information -->
                    <div class="col-lg-8">
                        <!-- Basic Info Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Keluhan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Judul Keluhan:</strong>
                                        <p class="text-muted mb-0">{{ $complaint->title }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Kategori:</strong>
                                        <p class="text-muted mb-0">
                                            <span class="badge bg-secondary">{{ ucfirst($complaint->category) }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Prioritas:</strong>
                                        <p class="text-muted mb-0">
                                            @if($complaint->priority === 'urgent')
                                                <span class="badge bg-danger">Mendesak</span>
                                            @elseif($complaint->priority === 'high')
                                                <span class="badge bg-warning">Tinggi</span>
                                            @elseif($complaint->priority === 'medium')
                                                <span class="badge bg-info">Sedang</span>
                                            @else
                                                <span class="badge bg-success">Rendah</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Status:</strong>
                                        <p class="text-muted mb-0">
                                            @if($complaint->status === 'new')
                                                <span class="badge bg-primary">Baru</span>
                                            @elseif($complaint->status === 'in_progress')
                                                <span class="badge bg-warning">Sedang Diproses</span>
                                            @elseif($complaint->status === 'resolved')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">Ditutup</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Tanggal Dibuat:</strong>
                                        <p class="text-muted mb-0">{{ $complaint->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    @if($complaint->resolved_at)
                                        <div class="col-md-6 mb-3">
                                            <strong>Tanggal Selesai:</strong>
                                            <p class="text-muted mb-0">{{ $complaint->resolved_at->format('d M Y H:i') }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($complaint->description)
                                    <div class="mt-3">
                                        <strong>Deskripsi Keluhan:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $complaint->description }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Images Card -->
                        @if($complaint->images && count($complaint->images) > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-images me-2"></i>Foto Bukti
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($complaint->images as $image)
                                        <div class="col-md-4 mb-3">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="Foto Bukti Keluhan"
                                                 style="height: 200px; width: 100%; object-fit: cover; cursor: pointer;"
                                                 onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Admin Response Card -->
                        @if($complaint->admin_response)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-comment-dots me-2"></i>Tanggapan Admin
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-primary text-white rounded">
                                    {{ $complaint->admin_response }}
                                </div>
                                @if($complaint->updated_at)
                                    <small class="text-muted mt-2 d-block">
                                        Diperbarui: {{ $complaint->updated_at->format('d M Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-comment-dots me-2"></i>Tanggapan Admin
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-4">
                                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada tanggapan</h5>
                                    <p class="text-muted mb-0">Admin akan memberikan tanggapan segera setelah keluhan diproses.</p>
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
                                    @if($complaint->status === 'new')
                                        <button class="btn btn-warning" onclick="editComplaint({{ $complaint->id }})">
                                            <i class="fas fa-edit me-2"></i>Edit Keluhan
                                        </button>
                                    @endif
                                    <a href="{{ route('tenant.complaints.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Keluhan Baru
                                    </a>
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
                                        <strong>Nomor Kamar:</strong> {{ $complaint->room->room_number }}
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Harga:</strong> Rp {{ number_format($complaint->room->price, 0, ',', '.') }}/bulan
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Kapasitas:</strong> {{ $complaint->room->capacity }} orang
                                    </div>
                                    <div class="col-12">
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ $complaint->room->status === 'available' ? 'success' : ($complaint->room->status === 'occupied' ? 'warning' : 'danger') }}">
                                            {{ $complaint->room->status === 'available' ? 'Tersedia' : ($complaint->room->status === 'occupied' ? 'Terisi' : 'Maintenance') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Timeline -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i>Timeline Status
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Keluhan Dibuat</h6>
                                            <small class="text-muted">{{ $complaint->created_at->format('d M Y H:i') }}</small>
                                        </div>
                                    </div>
                                    
                                    @if($complaint->status !== 'new')
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-warning"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Status Diperbarui</h6>
                                                <small class="text-muted">{{ $complaint->updated_at->format('d M Y H:i') }}</small>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($complaint->resolved_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Keluhan Selesai</h6>
                                                <small class="text-muted">{{ $complaint->resolved_at->format('d M Y H:i') }}</small>
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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto Bukti Keluhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Foto Bukti">
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
function editComplaint(complaintId) {
    // Implementasi edit complaint
    alert('Fitur edit keluhan akan segera tersedia!');
}

function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
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
