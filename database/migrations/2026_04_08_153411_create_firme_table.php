<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('firme', function (Blueprint $table) {
            $table->id();
            $table->string('nume');
            $table->string('cui')->unique();
            $table->string('adresa')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firme');
    }
};