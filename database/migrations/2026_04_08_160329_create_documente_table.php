<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained('firme')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tip'); // factura, chitanta, receptie, extras_banca, extras_casa
            $table->string('nume_fisier');
            $table->string('cale_fisier');
            $table->text('observatii')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documente');
    }
};