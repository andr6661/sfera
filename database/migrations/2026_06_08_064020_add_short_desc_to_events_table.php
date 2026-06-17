<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Проверяем, существует ли колонка
            if (!Schema::hasColumn('events', 'short_desc')) {
                $table->text('short_desc')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'short_desc')) {
                $table->dropColumn('short_desc');
            }
        });
    }
};
