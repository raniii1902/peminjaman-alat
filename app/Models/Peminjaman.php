<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public const BATAS_PINJAM_HARI = 7;
    public const DENDA_PER_HARI = 5000;

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
        'denda',
        'verified_at',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali' => 'datetime',
        'verified_at' => 'datetime',
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

    public function dueDate(): Carbon
    {
        return Carbon::parse($this->tgl_pinjam)->addDays(self::BATAS_PINJAM_HARI);
    }

    public function lateDays(?Carbon $returnedAt = null): int
    {
        $returnedAt ??= $this->tgl_kembali
            ? Carbon::parse($this->tgl_kembali)
            : now();

        $dueDate = $this->dueDate();

        if ($returnedAt->lessThanOrEqualTo($dueDate)) {
            return 0;
        }

        return $dueDate->diffInDays($returnedAt);
    }

    public function calculateDenda(?Carbon $returnedAt = null): int
    {
        return $this->lateDays($returnedAt) * self::DENDA_PER_HARI;
    }

    public static function syncOverdueStatuses(): void
    {
        static::query()
            ->where('status', 'dipinjam')
            ->whereDate('tgl_pinjam', '<', now()->subDays(self::BATAS_PINJAM_HARI)->toDateString())
            ->update(['status' => 'terlambat']);
    }
}
