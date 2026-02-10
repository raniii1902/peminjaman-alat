<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;
    
    protected $table = 'laptop';
    protected $primaryKey = 'id_laptop';
    public $timestamps = true;

    protected $fillable = ['nama_laptop', 'id_kategori', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}