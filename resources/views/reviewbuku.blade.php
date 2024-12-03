@extends('components.layout')
@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Review Buku</h4>

    <form action="{{ route('review-store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <select name="title" id="title" class="form-control" required>
                <option value="" disabled selected>Pilih Buku</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        
        
        <!-- Review -->
        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea type="textarea" name="review" id="review" class="form-control" placeholder="enter descriptions" required></textarea>
        </div>

        {{-- Tag Select --}}
        <div class="mb-3">
            <label class="form-label">Tags</label>
            <div>
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="tags[]" 
                        value="Petualangan" 
                        class="form-check-input" 
                        id="tag-petualangan"
                    >
                    <label class="form-check-label" for="tag-petualangan">Petualangan</label>
                </div>
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="tags[]" 
                        value="Epik" 
                        class="form-check-input" 
                        id="tag-epik"
                    >
                    <label class="form-check-label" for="tag-epik">Epik</label>
                </div>
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="tags[]" 
                        value="Karya klasik" 
                        class="form-check-input" 
                        id="tag-karya-klasik"
                    >
                    <label class="form-check-label" for="tag-karya-klasik">Karya klasik</label>
                </div>
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="tags[]" 
                        value="Literatur fantasi ikonik" 
                        class="form-check-input" 
                        id="tag-literatur-fantasi"
                    >
                    <label class="form-check-label" for="tag-literatur-fantasi">Literatur fantasi ikonik</label>
                </div>
            </div>
        </div>
        
        
        
       
        
        <!-- Submit and Back Buttons -->
        <div class="mt-4 d-flex justify-content-between">
            <!-- Tombol Back -->
            <a href="{{'/buku'}}" class="btn btn-secondary">
                Back
            </a>
            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">
                Kirim Review
            </button>
        </div>
    </form>
</div>
@if ($errors->any())
    <ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
@endif
@endsection
