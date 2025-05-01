<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    // Menentukan primary key
    protected $primaryKey = 'id_peserta';
    protected $table = 'peserta'; // Nama tabel di database
    protected $fillable = [
        'nomor_peserta',
        'nama_peserta',
        'alamat',
        'kecamatan',
        'rombongan',
        'regu',
        'keterangan',
        'kloter',
    ];
}
