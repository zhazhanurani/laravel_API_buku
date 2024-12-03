<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['title', 'author', 'harga', 'tanggal_terbit', 'image', 'editorial_picks', 'deskripsi_gambar', 'discount_percentage'];

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->harga - ($this->harga * $this->discount_percentage / 100);
        }
        return $this->harga;
    }

    
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'book_id', 'id', 'deskripsi_gambar');
    }
}
