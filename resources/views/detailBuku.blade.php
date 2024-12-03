@extends('components.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3>Detail Buku</h3>
        </div>
        <div class="card-body">
            <!-- Informasi Buku -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <img 
                        src="{{ $book->image ? asset('storage/img/'.$book->image) : 'https://via.placeholder.com/300' }}" 
                        class="img-fluid rounded shadow" 
                        alt="{{ $book->title }}">
                </div>
                <div class="col-md-8">
                    <h4 class="mb-3">{{ $book->title }}</h4>
                    <p><strong>Penulis:</strong> {{ $book->author }}</p>
                    <p><strong>Harga:</strong> Rp{{ number_format($book->harga, 2, ',', '.') }}</p>
                    <p><strong>Tanggal Terbit:</strong> {{ \Carbon\Carbon::parse($book->tanggal_terbit)->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <hr>

            <!-- Galeri Gambar Buku -->
            <h5 class="mb-3">Galeri Gambar Buku</h5>
            <div class="row">
                @if($book->galleries->isNotEmpty())
                    @foreach($book->galleries as $gallery)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <img 
                            src="{{ asset('storage/galleries/'.$gallery->image) }}" 
                            class="img-fluid rounded shadow-sm" 
                            alt="Gallery Image">
                        <!-- Menampilkan deskripsi gambar jika ada -->
                        @if($gallery->deskripsi_gambar)
                        <p class="mt-2 text-muted">{{ $gallery->deskripsi_gambar }}</p>
                        @endif
                            
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-muted">Tidak ada gambar tambahan untuk buku ini.</p>
                    </div>
                @endif
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-3">
                <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
