@extends('components.layout')
@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Create Data</h4>

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" required>
        </div>
        
        <!-- Author -->
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" name="author" id="author" class="form-control" placeholder="Enter author's name" required>
        </div>
        
        <!-- Harga -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" placeholder="Enter book price" required>
        </div>
        
        <!-- Tanggal Terbit -->
        <div class="mb-3">
            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control" placeholder="yyyy/mm/dd">
        </div>
        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <div id="gallery-images" class="form-group">
            <label for="gallery_images">Tambah Gambar Galeri:</label>
            <input type="file" name="gallery_images[]" class="form-control mb-2">
        </div>
        <button type="button" id="add-gallery" class="btn btn-secondary">Tambah Gambar Galeri</button>
        
        <!-- Submit and Back Buttons -->
        <div class="mt-4 d-flex justify-content-between">
            <!-- Tombol Back -->
            <a href="{{'/buku'}}" class="btn btn-secondary">
                Back
            </a>
            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">
                Create
            </button>
        </div>
        
    </form>
    <script>
        // Menambahkan input file galeri gambar dinamis
        document.getElementById('add-gallery').addEventListener('click', function() {
            const galleryImagesDiv = document.getElementById('gallery-images');
            const newInput = document.createElement('input');
            newInput.setAttribute('type', 'file');
            newInput.setAttribute('name', 'gallery_images[]');
            newInput.classList.add('form-control', 'mb-2');
            galleryImagesDiv.appendChild(newInput);
        });
    </script>
</div>
@if ($errors->any())
    <ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
@endif
@endsection
