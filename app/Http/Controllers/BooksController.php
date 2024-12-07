<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::all();
        $totalBooks = Books::count();
        $totalHarga = Books::sum('harga');
        $editorialPicks = Books::get()->where('editorial_picks',true);

        return view('index', compact('books',  'totalBooks', 'totalHarga','editorialPicks'));
    }

    public function create()
    {
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
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tanggal_terbit' => 'required|date',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000',
            'gallery_images.*' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000', // Validation for multiple images]
            'deskripsi_gambar' => 'nullable|string|max:255'
        ]);

        // Store the image
        $imagePath = $request->file('image')->store('public/img');


        // Create the book record
        $book = Books::create([
            'title' => $request->title,
            'author' => $request->author,
            'harga' => $request->harga,
            'discount_percentage' => $request->discount_percentage,
            'tanggal_terbit' => $request->tanggal_terbit,
            'image' => basename($imagePath),
            'deskripsi_gambar' => $request->deskripsi_gambar

        ]);

        // Store gallery images if any
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPath = $image->store('public/galleries');
                $book->galleries()->create([
                    'image' => basename($galleryPath),
                    'deskripsi_gambar' => $request->deskripsi_gambar
                ]);
            }
        }

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
    public function edit($id)
    {
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
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'tanggal_terbit' => 'required|date',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:10000',
            'deskripsi_gambar' => 'nullable|string|max:255'
        ]);

        // Update the book data
        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'harga' => $request->harga,
            'tanggal_terbit' => $request->tanggal_terbit,
            'discount_percentage' => $request->discount_percentage,
            'deskripsi_gambar' => $request->deskripsi_gambar

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
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('galleries', 'public');
            }
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
                    'deskripsi_gambar' => $book->deskripsi_gambar
                ]);
            }
        }

        return redirect('/buku')->with('status', 'Data Buku Berhasil Diubah');
    }
    public function review()
    {
        $books = Books::all();
        return view('reviewbuku', compact('books'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'review' => 'nullable|string|max:1000',
            'tags' => 'required|array|min:1',
            'tags.*' => 'required|string|max:255'
        ]);

        // dd($request->tags);

        Review::create([
            'id_buku' => $request->title,
            'review' => $request->review,
            'tag' => $request->tags,
            'id_user' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Review Added');
    }


    public function getReview(Request $request)
    {
        // Start a query for reviews
        $query = Review::with('user', 'book');  // Eager load user (reviewer) and book for performance

        // Apply filter by tag if provided
        if ($request->has('tag') && $request->tag) {
            $query->whereJsonContains('tag', $request->tag);  // Filter by tag
        }

        // Apply filter by reviewer's name if provided
        if ($request->has('reviewer') && $request->reviewer) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->reviewer . '%');  // Filter by reviewer name
            });
        }

        // Get the filtered reviews
        $list_review = $query->get();

        // Return the view with filtered reviews
        return view('listReviewBuku', compact('list_review'));
    }
    public function setEditorial($id)
    {
        $book = Books::findOrFail($id);
    
        // Check if the editorial_picks checkbox is checked (value will be 1 if checked)
        $book->editorial_picks = request()->has('editorial_picks') ? true : false;
    
        $book->save();
    
        return redirect()->back();
    }
}
