@extends('components.layout')
@section('content')
<div class="row justify-content-center">
    <h3 class="text-center">Kirim Email</h3>
    <div class="col-md-12 p-12">
        {{-- Display status message --}}
        @if (session('status'))
        <div class="alert alert-primary" role="alert">
            {{ session('status') }}
        </div>
        @endif

        {{-- Email form --}}
        <form action="{{ route('post-email') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama">
            </div>
            <div class="form-group my-3">
                <label for="email">Email Tujuan</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Tujuan">
            </div>
            <div class="form-group my-3">
                <label for="subject">Subjek</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek">
            </div>
            <div class="form-group my-3">
                <label for="body">Body Deskripsi</label>
                <textarea name="body" class="form-control" id="body" cols="30" rows="10" placeholder="Isi pesan"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Kirim Email</button>
            </div>
        </form>
    </div>
</div>
@endsection