<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'kondisi_pengembalian')) {
                $table->enum('kondisi_pengembalian', ['baik', 'buruk'])
                    ->nullable()
                    ->after('denda');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (Schema::hasColumn('peminjaman', 'kondisi_pengembalian')) {
                $table->dropColumn('kondisi_pengembalian');
            }
        });
    }
};
