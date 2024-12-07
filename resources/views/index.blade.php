@extends('components.layout')
@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<div class="container mt-5">

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                </div>
    <!-- Tombol Create -->
    
    @if (Auth::user()->level == 'admin')
    <div class="mb-3">
        <a href="{{ route('create') }}" class="btn btn-primary">
            Create
        </a>
    </div>    
    
    <div class="mb-3">
        <a href="{{ route('review') }}" class="btn btn-primary">
            Review Buku
        </a>
    </div>
    @endif

    @if (Auth::user()->level == 'internal_reviewer')
    <div class="mb-3">
        <a href="{{ route('review') }}" class="btn btn-primary">
            Review Buku
        </a>
    </div>
    @endif
    
    @if (@session('status'))
        <script>
            alert('{{ session('status') }}');
        </script>
    @endif

    <div>
        <div class="editorial-picks">
            <h2>Editorial Picks</h2>
            <div class="books">
                @foreach($editorialPicks as $book)
                    <div class="book">
                        <img src="{{ asset('storage/img/' . $book->image) }}" alt="{{ $book->title }}">
                        <h3>{{ $book->title }}</h3>
                        <p>{{ $book->author }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        
        
        
    </div>

</div>

    <table  class="datatable align-middle table table-light table-striped text-center">
        <thead class="thead-light">
            <tr class="table-primary">
                <th scope="col">NO</th>
                <th scope="col">ID</th>
                <th scope="col">Gambar</th>
                <th scope="col">Judul</th>
                <th scope="col">Penulis</th>
                <th scope="col">Harga</th>
                <th scope="col">Tanggal Terbit</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Looping data -->
            @foreach ($books as $index => $book)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $book->id }}</td>
                <td>
                    <img src="{{ asset('storage/img/'.$book->image) }}" class="rounded"
                    style="width: 150px">
                </td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>
                    @if($book->discount_percentage > 0)
                        <del>Rp. {{ number_format($book->harga, 0, ',', '.') }}</del>
                        <span class="badge bg-success">{{ $book->discount_percentage }}% off</span>
                        <br>
                        Rp. {{ number_format($book->discounted_price, 0, ',', '.') }}
                    @else
                        Rp. {{ number_format($book->harga, 0, ',', '.') }}
                    @endif
                </td>
                <td>{{ $book->tanggal_terbit }}</td>

                
                <td>
                    @if (Auth::User()->level == 'admin')
                        <!-- Form untuk Delete -->
                        <form action="{{ route('destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <!-- Tombol Edit -->
                        <a href="{{ route('edit', $book->id) }}" class="btn btn-info btn-sm">Edit</a>

                        <!-- Review Buku Admin  -->
                        <form action="{{ route('editorial', $book->id) }}" method="POST">
                            @csrf
                            <label for="editorial_picks">Editorial Pick:</label>
                            <input type="checkbox" id="editorial_picks" name="editorial_picks" value="1" {{ $book->editorial_picks ? 'checked' : '' }}>
                            <button type="submit" class="btn btn-secondary btn-sm">Simpan Editorial Picks</button>
                        </form>
                        



                    @endif
                    <!-- Tombol Detail yang sama untuk Admin dan User -->
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm">Detail</a>
                </td>   
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Bagian untuk menampilkan total buku dan total harga -->
    <div class="mt-3 p-3 bg-light">
        <p class="h5">Total Buku: {{ $totalBooks }}</p>
        <p class="h5">Total Harga Buku: Rp{{ number_format($totalHarga, 2, ',', '.') }}</p>
    </div>
</div>

<!-- JQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    new DataTable('.datatable');
</script>
@endsection
