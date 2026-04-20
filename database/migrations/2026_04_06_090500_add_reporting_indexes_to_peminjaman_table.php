<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->index(['status', 'tgl_pinjam'], 'peminjaman_status_tgl_pinjam_idx');
            $table->index(['status', 'tgl_kembali'], 'peminjaman_status_tgl_kembali_idx');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropIndex('peminjaman_status_tgl_pinjam_idx');
            $table->dropIndex('peminjaman_status_tgl_kembali_idx');
        });
    }
};
