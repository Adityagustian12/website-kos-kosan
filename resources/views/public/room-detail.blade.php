@extends('layouts.app')

@section('title', 'Detail Kamar - Kos-Kosan Management')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Kamar</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $room->room_number }}</h2>
                    
                    @if($room->images && count($room->images) > 0)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $room->images[0]) }}" class="img-fluid rounded" alt="Room {{ $room->room_number }}">
                        </div>
                    @else
                        <div class="mb-4 bg-light p-5 text-center rounded">
                            <i class="fas fa-image fa-4x text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada gambar tersedia</p>
                        </div>
                    @endif

                    <h4>Deskripsi</h4>
                    <p class="text-muted">{{ $room->description ?: 'Tidak ada deskripsi tersedia.' }}</p>

                    <h4>Fasilitas</h4>
                    @if($room->facilities && count($room->facilities) > 0)
                        <div class="row">
                            @foreach($room->facilities as $facility)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-check text-success me-2"></i>{{ $facility }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada fasilitas yang tercantum.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Kamar</h4>
                    
                    <div class="mb-3">
                        <strong>Nomor Kamar:</strong>
                        <span class="text-muted">{{ $room->room_number }}</span>
                    </div>
                    
                    
                    <div class="mb-3">
                        <strong>Kapasitas:</strong>
                        <span class="text-muted">{{ $room->capacity }} Orang</span>
                    </div>
                    
                    
                    @if($room->area)
                        <div class="mb-3">
                            <strong>Luas:</strong>
                            <span class="text-muted">{{ $room->area }}</span>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <strong>Status:</strong>
                        <span class="badge bg-success ms-2">Tersedia</span>
                    </div>

                    <hr>

                    <div class="text-center mb-4">
                        <h3 class="text-primary">Rp {{ number_format($room->price, 0, ',', '.') }}</h3>
                        <small class="text-muted">per bulan</small>
                    </div>

                    <div class="d-grid gap-2">
                        @auth
                            @if(auth()->user()->isSeeker() || auth()->user()->isTenant())
                                <a href="{{ route('booking.form', $room) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
                            </a>
                        @endauth
                        
                        <a href="{{ route('public.home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
