@extends('layouts.app')

@section('title', 'Kelola Keluhan - Admin Dashboard')

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
                    <a class="nav-link active" href="{{ route('admin.complaints') }}">
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
                        <i class="fas fa-exclamation-triangle me-2"></i>Kelola Keluhan
                    </h2>
                </div>

                <!-- Complaints Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Keluhan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($complaints->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Keluhan</th>
                                            <th>Penghuni</th>
                                            <th>Kamar</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Prioritas</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($complaints as $complaint)
                                            <tr>
                                                <td>
                                                    <strong>#{{ $complaint->id }}</strong>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $complaint->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $complaint->user->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $complaint->room->room_number }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ Str::limit($complaint->title, 30) }}</strong>
                                                        @if($complaint->description)
                                                            <br>
                                                            <small class="text-muted">{{ Str::limit($complaint->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ ucfirst($complaint->category) }}</span>
                                                </td>
                                                <td>
                                                    @if($complaint->priority === 'urgent')
                                                        <span class="badge bg-danger">Mendesak</span>
                                                    @elseif($complaint->priority === 'high')
                                                        <span class="badge bg-warning">Tinggi</span>
                                                    @elseif($complaint->priority === 'medium')
                                                        <span class="badge bg-info">Sedang</span>
                                                    @else
                                                        <span class="badge bg-success">Rendah</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($complaint->status === 'new')
                                                        <span class="badge bg-primary">Baru</span>
                                                    @elseif($complaint->status === 'in_progress')
                                                        <span class="badge bg-warning">Sedang Diproses</span>
                                                    @elseif($complaint->status === 'resolved')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-secondary">Ditutup</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $complaint->created_at->format('d M Y') }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $complaint->created_at->format('H:i') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-sm btn-outline-info" onclick="viewComplaint({{ $complaint->id }})" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning" onclick="updateComplaintStatus({{ $complaint->id }})" title="Update Status">
                                                            <i class="fas fa-edit"></i>
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
                                {{ $complaints->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada keluhan</h4>
                                <p class="text-muted">Belum ada keluhan yang perlu ditangani.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Summary Cards -->
                @if($complaints->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $complaints->where('status', 'new')->count() }}</h4>
                                        <p class="mb-0">Keluhan Baru</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-circle fa-2x"></i>
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
                                        <h4 class="mb-0">{{ $complaints->where('status', 'in_progress')->count() }}</h4>
                                        <p class="mb-0">Sedang Diproses</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
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
                                        <h4 class="mb-0">{{ $complaints->where('status', 'resolved')->count() }}</h4>
                                        <p class="mb-0">Selesai</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ $complaints->where('priority', 'urgent')->count() }}</h4>
                                        <p class="mb-0">Mendesak</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-fire fa-2x"></i>
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

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">
                    <i class="fas fa-edit me-2"></i>Update Status Keluhan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="new">Baru</option>
                                <option value="in_progress">Sedang Diproses</option>
                                <option value="resolved">Selesai</option>
                                <option value="closed">Ditutup</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Prioritas</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                                <option value="urgent">Mendesak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_response" class="form-label">Tanggapan Admin</label>
                        <textarea class="form-control" id="admin_response" name="admin_response" rows="4" placeholder="Berikan tanggapan atau update terkait keluhan ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Status
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
function viewComplaint(complaintId) {
    // Redirect to complaint detail page
    window.location.href = `/admin/complaints/${complaintId}`;
}

function updateComplaintStatus(complaintId) {
    // Set form action
    document.getElementById('updateStatusForm').action = `/admin/complaints/${complaintId}/status`;
    
    // Show modal
    const statusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    statusModal.show();
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
