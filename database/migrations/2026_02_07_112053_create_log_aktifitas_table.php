<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       if (Schema::hasTable('log_aktifitas')) {
           return;
       }

       Schema::create('log_aktifitas', function (Blueprint $table) {
    $table->id('id_log');

    $table->foreignId('id_user')
          ->constrained('users', 'id_user')
          ->onDelete('cascade');

    $table->string('aksi_admin');
    $table->timestamp('waktu');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktifitas');
    }
};
