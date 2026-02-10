<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktifitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktifitas';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'aksi_admin',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
