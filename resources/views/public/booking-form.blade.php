@extends('layouts.app')

@section('title', 'Form Booking - Kos-Kosan Management')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.room.detail', $room) }}">Detail Kamar</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Form Booking</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>Form Booking Kamar
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Room Info -->
                    <div class="alert alert-info">
                        <h5 class="alert-heading">{{ $room->room_number }}</h5>
                        <p class="mb-0">
                            <strong>Harga:</strong> Rp {{ number_format($room->price, 0, ',', '.') }}/bulan
                            <br>
                            <strong>Kapasitas:</strong> {{ $room->capacity }} Orang
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="booking_fee" value="{{ $room->price * 0.1 }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="check_in_date" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" 
                                       id="check_in_date" name="check_in_date" 
                                       value="{{ old('check_in_date') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="check_out_date" class="form-label">Tanggal Keluar (Opsional)</label>
                                <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" 
                                       id="check_out_date" name="check_out_date" 
                                       value="{{ old('check_out_date') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">Dokumen Pendukung</label>
                            <input type="file" class="form-control @error('documents.*') is-invalid @enderror" 
                                   id="documents" name="documents[]" multiple 
                                   accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">
                                Upload dokumen seperti KTP, KK, atau dokumen pendukung lainnya (JPG, PNG, PDF)
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Catatan tambahan untuk admin...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Informasi Penting
                            </h6>
                            <ul class="mb-0">
                                <li>Booking fee: <strong>Rp {{ number_format($room->price * 0.1, 0, ',', '.') }}</strong></li>
                                <li>Setelah submit form, Anda akan diminta untuk upload bukti pembayaran booking fee</li>
                                <li>Admin akan memproses booking dalam 1-2 hari kerja</li>
                                <li>Status booking akan dikirim melalui email</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('public.room.detail', $room) }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-plus me-2"></i>Submit Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Set minimum date to tomorrow
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const checkInDate = document.getElementById('check_in_date');
        const checkOutDate = document.getElementById('check_out_date');
        
        checkInDate.min = tomorrow.toISOString().split('T')[0];
        
        checkInDate.addEventListener('change', function() {
            if (this.value) {
                const selectedDate = new Date(this.value);
                const nextDay = new Date(selectedDate);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutDate.min = nextDay.toISOString().split('T')[0];
            }
        });
    });
</script>
@endsection
