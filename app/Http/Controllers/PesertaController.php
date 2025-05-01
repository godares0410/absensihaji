<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function cetakKartu()
    {
        $pesertas = Peserta::all(); // Adjust this query as needed
        return view('peserta.cetak', compact('pesertas'));
    }
}
