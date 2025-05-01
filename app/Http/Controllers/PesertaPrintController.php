<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PesertaPrintController extends Controller
{
    public function print($id)
    {
        // Ambil data peserta berdasarkan ID
        $peserta = Peserta::findOrFail($id);

        // Buat QR code dari nomor_peserta
        $qrCode = QrCode::size(100)->generate($peserta->nomor_peserta);

        // Data yang akan dikirim ke view
        $data = [
            'peserta' => $peserta,
            'qrCode' => $qrCode,
        ];

        // Render PDF
        $pdf = Pdf::loadView('peserta.print', $data);
        return $pdf->download('peserta_' . $peserta->nomor_peserta . '.pdf');
    }
}
