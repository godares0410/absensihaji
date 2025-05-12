<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $primaryKey = 'id_peserta';
    public $timestamps = true;

    protected $fillable = [
        'nomor_peserta',
        'nama_peserta',
        'alamat',
        'kecamatan',
        'rombongan',
        'regu',
        'keterangan',
        'embarkasi',
        'kloter',
        'foto'
    ];

    public function scans()
    {
        return $this->hasMany(Scan::class, 'id_peserta', 'id_peserta');
    }
}