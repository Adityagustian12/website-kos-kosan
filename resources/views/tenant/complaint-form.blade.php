@extends('layouts.app')

@section('title', 'Ajukan Keluhan - Dashboard Penghuni')

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
                            <i class="fas fa-plus me-2"></i>Ajukan Keluhan Baru
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.complaints') }}">Keluhan Saya</a></li>
                                <li class="breadcrumb-item active">Ajukan Keluhan Baru</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('tenant.complaints') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Complaint Form -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Form Keluhan
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tenant.complaints.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Keluhan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}" 
                                               placeholder="Masukkan judul keluhan yang singkat dan jelas..." required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                            <option value="">Pilih kategori keluhan</option>
                                            <option value="facility" {{ old('category') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                                            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                            <option value="noise" {{ old('category') == 'noise' ? 'selected' : '' }}>Kebisingan</option>
                                            <option value="security" {{ old('category') == 'security' ? 'selected' : '' }}>Keamanan</option>
                                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Priority -->
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                        <select class="form-select @error('priority') is-invalid @enderror" 
                                                id="priority" name="priority" required>
                                            <option value="">Pilih prioritas keluhan</option>
                                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Room -->
                                    <div class="mb-3">
                                        <label for="room_id" class="form-label">Kamar</label>
                                        <select class="form-select @error('room_id') is-invalid @enderror" 
                                                id="room_id" name="room_id">
                                            <option value="">Pilih kamar (opsional)</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->room_number }} - Rp {{ number_format($room->price, 0, ',', '.') }}/bulan
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('room_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                               id="location" name="location" value="{{ old('location') }}" 
                                               placeholder="Masukkan lokasi spesifik keluhan (opsional)...">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi Keluhan <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="5" 
                                                  placeholder="Jelaskan keluhan Anda secara detail. Sertakan informasi seperti waktu kejadian, lokasi yang tepat, dan dampak yang dirasakan..." required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Images -->
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Foto Bukti</label>
                                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                               id="images" name="images[]" multiple accept="image/*">
                                        <div class="form-text">
                                            Upload foto bukti keluhan (maksimal 5 foto, format: JPG, PNG, maksimal 2MB per foto)
                                        </div>
                                        @error('images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mb-3" style="display: none;">
                                        <label class="form-label">Preview Foto:</label>
                                        <div id="previewContainer" class="row"></div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Keluhan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Tips Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-lightbulb me-2"></i>Tips Mengajukan Keluhan
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <strong>Judul yang Jelas:</strong> Gunakan judul yang singkat dan menggambarkan masalah utama
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <strong>Deskripsi Detail:</strong> Jelaskan masalah secara lengkap dengan waktu dan lokasi
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <strong>Foto Bukti:</strong> Sertakan foto untuk membantu admin memahami masalah
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <strong>Prioritas Tepat:</strong> Pilih prioritas sesuai tingkat urgensi masalah
                                    </li>
                                    <li class="mb-0">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <strong>Kategori Benar:</strong> Pilih kategori yang sesuai dengan jenis masalah
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Priority Guide -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Panduan Prioritas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="badge bg-danger me-2">Mendesak</span>
                                    <small>Masalah keamanan, kebocoran air, listrik mati</small>
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-warning me-2">Tinggi</span>
                                    <small>AC rusak, WiFi tidak berfungsi, kebisingan</small>
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-info me-2">Sedang</span>
                                    <small>Keran bocor, lampu mati, pintu rusak</small>
                                </div>
                                <div class="mb-0">
                                    <span class="badge bg-success me-2">Rendah</span>
                                    <small>Saran perbaikan, keluhan umum</small>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>Kontak Darurat
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>Untuk masalah mendesak:</strong><br>
                                    Hubungi admin langsung melalui WhatsApp atau telepon
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

#previewContainer img {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 8px;
    margin: 5px;
}
</style>

<script>
// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    
    // Clear previous previews
    previewContainer.innerHTML = '';
    
    if (files.length > 0) {
        imagePreview.style.display = 'block';
        
        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Preview ${index + 1}`;
                    img.className = 'img-thumbnail';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        imagePreview.style.display = 'none';
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const category = document.getElementById('category').value;
    const priority = document.getElementById('priority').value;
    const description = document.getElementById('description').value.trim();
    
    if (!title || !category || !priority || !description) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi!');
        return false;
    }
    
    if (description.length < 20) {
        e.preventDefault();
        alert('Deskripsi keluhan minimal 20 karakter!');
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
