<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tytuł filmu
            $table->string('poster_url')->nullable(); // URL plakatu
            $table->text('note')->nullable(); // Notatki użytkownika
            $table->unsignedBigInteger('user_id'); // ID użytkownika
            $table->timestamps();

            // Klucz obcy
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
