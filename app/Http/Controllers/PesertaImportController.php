<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Peserta;

class PesertaImportController extends Controller
{
    public function index()
    {
        return view('peserta.index');
    }

    public function import(Request $request)
    {
        // Validasi file yang di-upload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Ambil file yang di-upload
        $file = $request->file('file');
        
        // Load file Excel menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil data mulai dari baris ke-2 dan kolom ke-2 (skip baris pertama dan kolom pertama)
        $data = [];
        foreach ($sheet->getRowIterator(2) as $row) { // Mulai dari baris ke-2
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Skip kolom pertama (index 0) dan masukkan data ke dalam array
            if (!empty($rowData[1])) {
                $data[] = [
                    'nomor_peserta' => $rowData[1],  // Kolom ke-2
                    'nama_peserta'  => $rowData[2],  // Kolom ke-3
                    'alamat'        => $rowData[3],  // Kolom ke-4
                    'kecamatan'     => $rowData[4],  // Kolom ke-5
                    'rombongan'     => $rowData[5],  // Kolom ke-6
                    'regu'          => $rowData[6],  // Kolom ke-7
                    'keterangan'    => $rowData[7],  // Kolom ke-8
                    'kloter'        => $rowData[8],  // Kolom ke-9
                ];
            }
        }

        // Insert data ke dalam database
        foreach ($data as $row) {
            Peserta::create($row);
        }

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diimport!');
    }
}
