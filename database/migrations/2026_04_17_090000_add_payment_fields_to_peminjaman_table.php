<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'status_pembayaran_denda')) {
                $table->enum('status_pembayaran_denda', ['belum_bayar', 'lunas'])
                    ->nullable()
                    ->after('denda');
            }

            if (!Schema::hasColumn('peminjaman', 'tgl_bayar_denda')) {
                $table->timestamp('tgl_bayar_denda')
                    ->nullable()
                    ->after('status_pembayaran_denda');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (Schema::hasColumn('peminjaman', 'tgl_bayar_denda')) {
                $table->dropColumn('tgl_bayar_denda');
            }

            if (Schema::hasColumn('peminjaman', 'status_pembayaran_denda')) {
                $table->dropColumn('status_pembayaran_denda');
            }
        });
    }
};
