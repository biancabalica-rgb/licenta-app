<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificari', function (Blueprint $table) {
            $table->id();
            $table->string('tip'); // 'document' sau 'contact'
            $table->string('titlu');
            $table->text('mesaj');
            $table->boolean('citita')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificari');
    }
};