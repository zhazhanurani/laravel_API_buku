<?php

namespace App\Http\Controllers;
use App\Models\Books;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index(){
        $books = Books::all();
        $totalBooks = Books::count();
        $totalHarga = Books::sum('harga');
        return view('index', compact('books',  'totalBooks', 'totalHarga'));
    }

    public function create(){
        return view('create');
    }
    public function show($id)
{
    // Ambil buku berdasarkan id
    $book = Books::with('galleries')->findOrFail($id);

    return view('detailBuku', compact('book'));
}

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'author' => 'required|string|max:30',
        'harga' => 'required|numeric',
        'tanggal_terbit' => 'required|date',
        'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000',
        'gallery_images.*' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000', // Validation for multiple images
    ]);

    // Store the image
    $imagePath = $request->file('image')->store('public/img');
    
    
    // Create the book record
    $book = Books::create([
        'title' => $request->title,
        'author' => $request->author,
        'harga' => $request->harga,
        'tanggal_terbit' => $request->tanggal_terbit,
        'image' => basename($imagePath)
    ]);

    // Store gallery images if any
    if ($request->hasFile('gallery_images')) {
        foreach ($request->file('gallery_images') as $image) {
            $galleryPath = $image->store('public/galleries');
            $book->galleries()->create([
                'image' => basename($galleryPath),
            ]);
        }
    }

    // Response
    return response()->json([
        'success' => true,
        'message' => 'Buku berhasil ditambahkan!',
        'data' => $book
    ], 201);

    return redirect('/buku')->with('status', 'Data Buku Berhasil Ditambahkan');
}
    
    
public function destroy($id)
{
    $book = Books::find($id);
    
    // Delete the book's image if it exists
    if ($book->image) {
        Storage::delete('public/img/' . $book->image);
    }

    // Delete associated galleries images
    foreach ($book->galleries as $gallery) {
        Storage::delete('public/galleries/' . $gallery->image);
    }

    // Delete the book
    $book->delete();

    return redirect('/buku')->with('status', 'Data Buku Berhasil Dihapus');
}
    public function edit($id){
        $books = Books::find($id);
        return view('edit', compact('books'));
    }

    public function update(Request $request, $id)
    {
        $book = Books::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tanggal_terbit' => 'required|date',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:10000',
        ]);
    
        // Update the book data
        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'harga' => $request->harga,
            'tanggal_terbit' => $request->tanggal_terbit
        ];
    
        // Handle the image update if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($book->image) {
                Storage::delete('public/img/' . $book->image);
            }
    
            // Store the new image
            $imagePath = $request->file('image')->store('public/img');
            $data['image'] = basename($imagePath);
        }
    
        // Update the book data
        $book->update($data);
    
        // Handle gallery image update
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPath = $image->store('public/galleries');
                $book->galleries()->create([
                    'image' => basename($galleryPath),
                    'book_id' => $book->id,
                ]);
            }
        }
    
        return redirect('/buku')->with('status', 'Data Buku Berhasil Diubah');
    }
}

// public function search(Request $request){
//     $batas = 5;
//     $search = $request->search;
//     $books = Books::where('title', 'like', "%" . $search . "%")->orwhere('author','like','%'.
//     $search.'%')->paginate($batas);
//     $totalBooks = $books->count();
//     $totalHarga = Books::sum('harga');
//     $no = $batas * ($books->currentPage() - 1);
//     return view('search', compact('books', 'no', 'search', 'totalBooks', 'totalHarga'));
// }