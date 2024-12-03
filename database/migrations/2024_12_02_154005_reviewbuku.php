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
        Schema::create('review',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_buku');
            $table->string('review');
            // $table->string('tag');
            $table->json('tag');
            $table->timestamps();


            $table->foreign('id_buku')->references('id')->on('books');
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
