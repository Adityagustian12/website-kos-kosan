@extends('layouts.app')

@section('title', 'Keluhan Saya - Dashboard Penghuni')

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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Keluhan Saya
                    </h2>
                    <div>
                        <a href="{{ route('tenant.complaints.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajukan Keluhan Baru
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('tenant.complaints') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status Keluhan</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Baru</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="priority" class="form-label">Prioritas</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="">Semua Prioritas</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <option value="facility" {{ request('category') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                                    <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="noise" {{ request('category') == 'noise' ? 'selected' : '' }}>Kebisingan</option>
                                    <option value="security" {{ request('category') == 'security' ? 'selected' : '' }}>Keamanan</option>
                                    <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('tenant.complaints') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Complaints Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Keluhan Saya
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($complaints->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Keluhan</th>
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
                                                        <strong>{{ Str::limit($complaint->title, 40) }}</strong>
                                                        @if($complaint->description)
                                                            <br>
                                                            <small class="text-muted">{{ Str::limit($complaint->description, 60) }}</small>
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
                                                        @if($complaint->status === 'new')
                                                            <button class="btn btn-sm btn-outline-warning" onclick="editComplaint({{ $complaint->id }})" title="Edit Keluhan">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
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
                                {{ $complaints->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada keluhan</h4>
                                <p class="text-muted">Anda belum mengajukan keluhan apapun.</p>
                                <a href="{{ route('tenant.complaints.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Ajukan Keluhan Pertama
                                </a>
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
    // Implementasi view complaint detail
    alert('Fitur lihat detail keluhan akan segera tersedia!');
}

function editComplaint(complaintId) {
    // Implementasi edit complaint
    alert('Fitur edit keluhan akan segera tersedia!');
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
