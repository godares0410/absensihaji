<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function index()
    {
        // Ambil semua peserta
        $totalPeserta = DB::table('peserta')->count();

        // Ambil peserta yang sudah scan
        $sudahScan = DB::table('scan')
            ->join('peserta', 'scan.id_peserta', '=', 'peserta.id_peserta')
            ->select('peserta.nama_peserta', 'scan.created_at', 'peserta.foto')
            ->get()
            ->map(function ($scan) {
                $scan->waktu_scan = date('H:i:s', strtotime($scan->created_at));
                return $scan;
            });

        // Ambil daftar ID peserta yang sudah scan
        $idSudahScan = $sudahScan->pluck('id_peserta')->toArray();

        // Ambil peserta yang belum scan
        $belumScan = DB::table('peserta')
            ->whereNotIn('id_peserta', function ($query) {
                $query->select('id_peserta')->from('scan');
            })
            ->select('nama_peserta', 'foto')
            ->get();

        // Hitung jumlah
        $totalSudahScan = $sudahScan->count();
        $totalBelumScan = $totalPeserta - $totalSudahScan;

        return view('scan.index', compact('totalPeserta', 'sudahScan', 'belumScan', 'totalSudahScan', 'totalBelumScan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20',
        ]);
    
        $id = Peserta::where('nomor_peserta', $request->kode)
            ->value('id_peserta');
    
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan!'
            ], 404);
        }
    
        // Check if already scanned
        $alreadyScanned = Scan::where('id_peserta', $id)->exists();
        if ($alreadyScanned) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah melakukan scan sebelumnya!'
            ], 400);
        }
    
        $scan = new Scan;
        $scan->id_peserta = $id;
        $scan->save();
    
        $peserta = Peserta::find($id);
    
        return response()->json([
            'success' => true,
            'message' => 'Scan berhasil!',
            'data' => [
                'nama_peserta' => $peserta->nama_peserta,
                'waktu_scan' => $scan->created_at->format('H:i:s')
            ]
        ]);
    }

}
