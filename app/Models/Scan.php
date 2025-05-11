<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $guarded = 'id_scan';
    protected $table = 'scan';
    protected $primaryKey = 'id_scan';
    
    // Definisikan relasi ke model Peserta
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }
}