<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['title', 'author', 'harga', 'tanggal_terbit', 'image'];
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'book_id', 'id');
    }
}
