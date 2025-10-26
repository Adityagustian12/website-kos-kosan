@extends('layouts.app')

@section('title', 'Data Diri - Kos-Kosan Management')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Data Diri Calon Penguni
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="occupation" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                   id="occupation" name="occupation" value="{{ old('occupation', $user->occupation) }}" required>
                        </div>

                        <!-- Profile Picture -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-camera me-2"></i>Foto Profil
                                </h5>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" name="profile_picture" accept="image/*">
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB</div>
                            
                            @if($user->profile_picture)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                         alt="Profile Picture" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                    <small class="text-muted d-block">Foto saat ini</small>
                                </div>
                            @endif
                        </div>

                        <!-- ID Card Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-id-card me-2"></i>Informasi KTP
                                </h5>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_card_number" class="form-label">Nomor KTP</label>
                            <input type="text" class="form-control @error('id_card_number') is-invalid @enderror" 
                                   id="id_card_number" name="id_card_number" value="{{ old('id_card_number', $user->id_card_number) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_card_file" class="form-label">File KTP</label>
                            <input type="file" class="form-control @error('id_card_file') is-invalid @enderror" 
                                   id="id_card_file" name="id_card_file" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">Format: JPG, PNG, PDF. Maksimal 2MB</div>
                            
                            @if($user->id_card_file)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $user->id_card_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Lihat KTP
                                    </a>
                                    <small class="text-muted d-block">File KTP saat ini</small>
                                </div>
                            @endif
                        </div>

                        <!-- Emergency Contact -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-phone-alt me-2"></i>Kontak Darurat
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_name" class="form-label">Nama Kontak Darurat</label>
                                <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                       id="emergency_contact_name" name="emergency_contact_name" 
                                       value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_phone" class="form-label">Nomor Telepon Kontak Darurat</label>
                                <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                       id="emergency_contact_phone" name="emergency_contact_phone" 
                                       value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('public.home') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data Diri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
