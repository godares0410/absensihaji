<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $guarded = 'id_scan'; // Menjaga kolom id_scan dari mass assignment
    protected $table = 'scan'; // Nama tabel di database
    protected $primaryKey = 'id_scan'; // Menentukan primary key
}
