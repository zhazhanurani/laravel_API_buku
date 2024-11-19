<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['book_id', 'image'];

    // Relasi banyak ke satu ke Book
    public function book()
    {
        return $this->belongsTo(Books::class);
    }
}
