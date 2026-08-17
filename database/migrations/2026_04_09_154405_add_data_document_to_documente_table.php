<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documente', function (Blueprint $table) {
            $table->date('data_document')->nullable()->after('tip');
        });
    }

    public function down(): void
    {
        Schema::table('documente', function (Blueprint $table) {
            $table->dropColumn('data_document');
        });
    }
};