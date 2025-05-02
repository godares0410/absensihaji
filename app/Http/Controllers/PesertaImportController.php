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

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        $validData = [];
        $invalidData = [];
        $rowNumber = 1;

        foreach ($sheet->getRowIterator(2) as $row) {
            $rowNumber++;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Skip jika seluruh kolom kosong
            if (empty(array_filter($rowData))) {
                continue;
            }

            // Mapping data
            $data = [
                'nomor_peserta' => $rowData[1] ?? null,
                'nama_peserta'  => $rowData[2] ?? null,
                'alamat'        => $rowData[3] ?? null,
                'kecamatan'     => $rowData[4] ?? null,
                'rombongan'     => $rowData[5] ?? null,
                'regu'          => $rowData[6] ?? null,
                'keterangan'    => $rowData[7] ?? null,
                'kloter'        => $rowData[8] ?? null,
            ];

            // Validasi sederhana
            if (!empty($data['nomor_peserta']) && !empty($data['nama_peserta'])) {
                $validData[] = $data;
            } else {
                $data['error'] = 'Nomor peserta atau nama peserta kosong';
                $invalidData[] = $data;
            }
        }

        // Simpan sementara ke session
        session([
            'valid_import_data' => $validData,
        ]);

        return view('peserta.preview', compact('validData', 'invalidData'));
    }


    public function processImport()
    {
        $data = session('valid_import_data', []);
    
        $inserted = [];
        $duplicateData = [];
    
        foreach ($data as $row) {
            // Cek apakah nomor_peserta sudah ada di database
            if (Peserta::where('nomor_peserta', $row['nomor_peserta'])->exists()) {
                $duplicateData[] = $row;
            } else {
                Peserta::create($row);
                $inserted[] = $row;
            }
        }
    
        // Bersihkan session
        session()->forget('valid_import_data');
    
        // Tampilkan halaman hasil import (baik berhasil maupun duplikat)
        return view('peserta.duplicate', [
            'insertedData'   => $inserted,
            'duplicateData'  => $duplicateData,
        ]);
    }
    

    public function cancelImport()
    {
        session()->forget('valid_import_data');
        return redirect()->route('peserta.index');
    }
}
