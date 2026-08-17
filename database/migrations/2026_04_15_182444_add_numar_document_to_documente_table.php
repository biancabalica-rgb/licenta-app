<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documente', function (Blueprint $table) {
            $table->string('numar_document')->nullable()->after('data_document');
        });
    }

    public function down(): void
    {
        Schema::table('documente', function (Blueprint $table) {
            $table->dropColumn('numar_document');
        });
    }
};