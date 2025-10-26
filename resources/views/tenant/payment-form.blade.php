@extends('layouts.app')

@section('title', 'Bayar Tagihan - Dashboard Penghuni')

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
                    <a class="nav-link active" href="{{ route('tenant.bills') }}">
                        <i class="fas fa-file-invoice me-2"></i>Tagihan Saya
                    </a>
                    <a class="nav-link" href="{{ route('tenant.complaints') }}">
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
                            <i class="fas fa-credit-card me-2"></i>Bayar Tagihan #{{ $bill->id }}
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.bills') }}">Tagihan Saya</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.bills.detail', $bill) }}">Detail Tagihan</a></li>
                                <li class="breadcrumb-item active">Bayar Tagihan</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('tenant.bills.detail', $bill) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Payment Form -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Form Pembayaran
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tenant.bills.payment.store', $bill) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Amount -->
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Jumlah Pembayaran <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                                   id="amount" name="amount" value="{{ $bill->total_amount }}" 
                                                   min="1" step="1" required readonly>
                                        </div>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Total tagihan: Rp {{ number_format($bill->total_amount, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" name="payment_method" required>
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                            <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Payment Proof -->
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                               id="payment_proof" name="payment_proof" accept="image/*,.pdf" required>
                                        <div class="form-text">
                                            Upload bukti pembayaran (format: JPG, PNG, PDF, maksimal 2MB)
                                        </div>
                                        @error('payment_proof')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Payment Proof Preview -->
                                    <div id="proofPreview" class="mb-3" style="display: none;">
                                        <label class="form-label">Preview Bukti:</label>
                                        <div id="previewContainer" class="text-center">
                                            <img id="previewImage" src="" class="img-fluid rounded" style="max-height: 300px;" alt="Preview Bukti Pembayaran">
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Catatan</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="3" 
                                                  placeholder="Tambahkan catatan terkait pembayaran (opsional)...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Bill Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-invoice me-2"></i>Ringkasan Tagihan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <strong>Nomor Tagihan:</strong> #{{ $bill->id }}
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Kamar:</strong> {{ $bill->room->room_number }}
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Periode:</strong> {{ $bill->period_start ? \Carbon\Carbon::parse($bill->period_start)->format('M Y') : \Carbon\Carbon::create($bill->year, $bill->month, 1)->format('M Y') }}
                                    </div>
                                    <div class="col-12 mb-2">
                                        <strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}
                                    </div>
                                    <div class="col-12 mb-3">
                                        <strong>Total Tagihan:</strong>
                                        <h4 class="text-primary mb-0">Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                                
                                @if($bill->status === 'overdue')
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Tagihan Terlambat!</strong><br>
                                        Terlambat {{ \Carbon\Carbon::parse($bill->due_date)->diffInDays(now()) }} hari
                                        @if(isset($bill->late_fee) && $bill->late_fee > 0)
                                            <br>Denda: Rp {{ number_format($bill->late_fee, 0, ',', '.') }}
                                        @endif
                                    </div>
                                @elseif($bill->status === 'pending')
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>Jatuh Tempo:</strong><br>
                                        @php
                                            $daysLeft = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($bill->due_date)->startOfDay(), false);
                                        @endphp
                                        {{ max(0, (int) $daysLeft) }} hari lagi
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Instructions -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Instruksi Pembayaran
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>Transfer Bank:</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>BCA:</strong> 1234567890</li>
                                        <li><strong>Mandiri:</strong> 0987654321</li>
                                        <li><strong>BNI:</strong> 1122334455</li>
                                    </ul>
                                    <small class="text-muted">A/N: Admin Kosku</small>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>E-Wallet:</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>DANA:</strong> 081234567890</li>
                                        <li><strong>OVO:</strong> 081234567890</li>
                                        <li><strong>GoPay:</strong> 081234567890</li>
                                    </ul>
                                </div>
                                
                                <div class="alert alert-info">
                                    <small>
                                        <i class="fas fa-lightbulb me-1"></i>
                                        <strong>Tips:</strong> Pastikan nominal transfer sesuai dengan tagihan dan sertakan nomor tagihan di keterangan transfer.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>Butuh Bantuan?
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>Hubungi Admin:</strong><br>
                                    📞 081234567890<br>
                                    📧 admin@kosku.com
                                </p>
                                <p class="mb-0">
                                    <strong>Jam Operasional:</strong><br>
                                    Senin - Jumat: 08:00 - 17:00<br>
                                    Sabtu: 08:00 - 12:00
                                </p>
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
// Payment proof preview functionality
document.getElementById('payment_proof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('previewContainer');
    const proofPreview = document.getElementById('proofPreview');
    const previewImage = document.getElementById('previewImage');
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            proofPreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else if (file && file.type === 'application/pdf') {
        previewContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-file-pdf fa-2x"></i><br>File PDF terpilih</div>';
        proofPreview.style.display = 'block';
    } else {
        proofPreview.style.display = 'none';
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('amount').value);
    const totalAmount = {{ $bill->total_amount }};
    const paymentMethod = document.getElementById('payment_method').value;
    const paymentProof = document.getElementById('payment_proof').files[0];
    
    if (!paymentMethod) {
        e.preventDefault();
        alert('Mohon pilih metode pembayaran!');
        return false;
    }
    
    if (!paymentProof) {
        e.preventDefault();
        alert('Mohon upload bukti pembayaran!');
        return false;
    }
    
    if (amount < 1) {
        e.preventDefault();
        alert('Jumlah pembayaran minimal Rp 1!');
        return false;
    }
    
    if (amount > totalAmount * 2) {
        e.preventDefault();
        alert('Jumlah pembayaran terlalu besar!');
        return false;
    }
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
