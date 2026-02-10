<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_laptop',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'denda',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'id_laptop');
    }
}
