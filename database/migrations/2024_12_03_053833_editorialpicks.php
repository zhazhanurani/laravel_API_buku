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
        // Schema::create('editorial_picks',function(Blueprint $table){
        //     $table->id();
        //     $table->unsignedBigInteger('id_buku');
        //     $table->string('');
        //     $table->timestamps();


        //     $table->foreign('id_buku')->references('id')->on('books');
        // });

        Schema::table('books', function (Blueprint $table) {
            $table->boolean('editorial_picks')->default(false);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('editorial_picks');
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
