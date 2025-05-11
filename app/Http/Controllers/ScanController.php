<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
public function index()
{
    // Total peserta
    $totalPeserta = DB::table('peserta')->count();

    // Peserta yang sudah scan (status = 0)
    $sudahScan = DB::table('scan')
        ->join('peserta', 'scan.id_peserta', '=', 'peserta.id_peserta')
        ->where('scan.status', 0)
        ->select('peserta.id_peserta', 'peserta.nama_peserta', 'scan.created_at', 'peserta.foto', 'peserta.nomor_peserta', 'peserta.rombongan', 'peserta.regu')
        ->orderBy('scan.updated_at', 'desc')
        ->get()
        ->map(function ($scan) {
            $scan->waktu_scan = date('H:i:s', strtotime($scan->created_at));
            return $scan;
        });

    // Ambil ID peserta yang sudah scan
    $idSudahScan = $sudahScan->pluck('id_peserta')->toArray();

    // Peserta yang belum scan
    $belumScan = DB::table('peserta')
        ->whereNotIn('id_peserta', $idSudahScan)
        ->select('nama_peserta', 'foto', 'nomor_peserta', 'rombongan', 'regu')
        ->get();

    // Statistik berdasarkan rombongan
    $rombonganStats = DB::table('peserta')
        ->whereNotIn('id_peserta', $idSudahScan)
        ->select('rombongan', DB::raw('count(*) as total'))
        ->groupBy('rombongan')
        ->get();

    // Statistik berdasarkan regu
    $reguStats = DB::table('peserta')
        ->whereNotIn('id_peserta', $idSudahScan)
        ->select('regu', DB::raw('count(*) as total'))
        ->groupBy('regu')
        ->get();

    // Hitung jumlah scan
    $totalSudahScan = count($idSudahScan);
    $totalBelumScan = $totalPeserta - $totalSudahScan;

    return view('scan.index', compact(
        'totalPeserta',
        'sudahScan',
        'belumScan',
        'totalSudahScan',
        'totalBelumScan',
        'rombonganStats',
        'reguStats'
    ));
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
        $alreadyScanned = Scan::where('id_peserta', $id)->where('status', 0)->exists();
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
    public function getBelumScan(Request $request)
    {
        try {
            Log::info('GetBelumScan Request:', ['data' => $request->all()]);

            $query = DB::table('peserta')
                ->whereNotIn('id_peserta', function ($q) {
                    $q->select('id_peserta')->from('scan');
                });

            if ($request->filled('rombongan')) {
                $query->where('rombongan', $request->rombongan);
            }

            if ($request->filled('regu')) {
                $query->where('regu', $request->regu);
            }

            $pesertas = $query->select([
                'id_peserta',
                'nama_peserta',
                'nomor_peserta',
                'foto',
                'rombongan',
                'regu'
            ])->get();

            return response()->json([
                'success' => true,
                'data' => $pesertas
            ]);
        } catch (\Throwable $e) {
            Log::error('getBelumScan error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(Request $request)
    { {
            try {

                $query = DB::table('peserta')
                    ->whereNotIn('id_peserta', function ($q) {
                        $q->select('id_peserta')->from('scan');
                    });

                if ($request->filled('rombongan')) {
                    $query->where('rombongan', $request->rombongan);
                }

                if ($request->filled('regu')) {
                    $query->where('regu', $request->regu);
                }

                $pesertas = $query->select([
                    'id_peserta',
                    'nama_peserta',
                    'nomor_peserta',
                    'foto',
                    'rombongan',
                    'regu'
                ])->get();

                return response()->json([
                    'success' => true,
                    'data' => $pesertas
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Server error',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }
}
