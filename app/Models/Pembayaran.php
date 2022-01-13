<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;
use App\Models\Siswa;
use Carbon\Carbon;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $guarded = [];

    public function getTanggalBayarAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getJumlahBayarAttribute($value)
    {
        return "Rp " . number_format($value, 0, 2, '.');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
