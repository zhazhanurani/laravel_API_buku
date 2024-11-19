<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

//import
use App\Http\Resources\BookResource;

//import buku, yaitu books
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    public function index()
    {
        $books = Books::all();

        return new BookResource(true, 'List Data Buku', $books);
    }

    public function store(Request $request)
    {
        $validatedData = Validator( $request->all(), [
            'title' => 'required|string',
            'author' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tanggal_terbit' => 'required|date',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        // Simpan data ke database
        $book = Books::create([
            'title' => $request->title,
            'author' => $request->author,
            'harga' => $request->harga,
            'tanggal_terbit' => $request->tanggal_terbit,
            'image' => $request->image
        ]);

        // Response
        return new BookResource(true, 'List Data Buku', $book);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Buku berhasil ditambahkan!',
        //     'data' => new BookResource(true, 'Buku berhasil ditambahkan', $book)
        // ], 201);
    }
}
