<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books',function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('harga');
            $table->string('tanggal_terbit');
            $table->string('image')->nullable();
            $table->string('deskripsi_gambar')->nullable();
            $table->boolean('editorial_picks')->default(false);
            $table->unsignedTinyInteger('discount_percentage')->nullable()->default(0); // Diskon dalam %]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
