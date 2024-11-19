<?php

namespace Database\Seeders;
use App\Models\Books;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) {    
        Books::create([
            'title' => fake()->sentence(3),
            'author'=> fake()->name(),
            'harga'=> fake()->numberBetween(10000, 100000),
            'tanggal_terbit'=> fake()->date(),
        ]);
    }
    }
}
