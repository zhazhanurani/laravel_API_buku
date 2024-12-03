<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';

    protected $fillable = [
        'id_buku',
        'review',
        'tag'
    ];

    protected $casts = [
        'tag' => 'array'
    ];

    public function book()
    {
        return $this->belongsTo(Books::class,'id_buku','id');
    }
}
