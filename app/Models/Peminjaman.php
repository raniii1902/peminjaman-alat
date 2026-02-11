<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // Nama tabel di database
    protected $primaryKey = 'id_peminjaman'; // Primary key tabel

    /**
     * Kolom yang dapat diisi secara massal.
     * Ini memastikan field 'status' dan 'denda' tidak terblokir saat proses create.
     */
    protected $fillable = [
        'id_user', 
        'id_laptop', 
        'tgl_pinjam', 
        'tgl_kembali', 
        'status', 
        'denda'
    ];

    /**
     * Relasi ke Model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke Model Laptop
     */
    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'id_laptop');
    }
}