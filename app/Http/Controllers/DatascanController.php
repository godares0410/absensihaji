<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatascanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 1); // default 1: Sudah Scan

        if ($status == 1) {
            // Sudah Scan (status scan = 0)
            $scans = DB::table('scan')
                ->join('peserta', 'scan.id_peserta', '=', 'peserta.id_peserta')
                ->select(
                    'scan.id_scan',
                    'peserta.nama_peserta',
                    'scan.created_at',
                    'peserta.foto',
                    'peserta.nomor_peserta',
                    'peserta.rombongan',
                    'peserta.regu',
                    'peserta.kecamatan',
                    'peserta.kloter'
                )
                ->where('scan.status', 0)
                ->orderBy('scan.updated_at', 'desc')
                ->get()
                ->map(function ($scan) {
                    $scan->waktu_scan = date('d-m-Y H:i', strtotime($scan->created_at));
                    return $scan;
                });
        } else {
            // Belum Scan (tidak ada record di tabel scan dengan status 0)
            $scans = DB::table('peserta')
                ->whereNotIn('id_peserta', function ($query) {
                    $query->select('id_peserta')
                        ->from('scan')
                        ->where('status', 0);
                })
                ->select(
                    DB::raw('NULL as id_scan'),
                    'nama_peserta',
                    DB::raw('NULL as created_at'),
                    'foto',
                    'nomor_peserta',
                    'rombongan',
                    'regu',
                    'kecamatan',
                    'kloter'
                )
                ->get()
                ->map(function ($scan) {
                    $scan->waktu_scan = '-';
                    return $scan;
                });
        }

        // Filter jika data kosong
        $scans = $scans->filter(function ($item) {
            return !empty($item->nama_peserta);
        });

        return view('data_scan.index', compact('scans', 'status'));
    }


    public function destroy($id_scan)
    {
        try {
            $scan = Scan::findOrFail($id_scan);
            $scan->delete();

            return redirect()->route('datascan.index')
                ->with('success', 'Data scan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('datascan.index')
                ->with('error', 'Gagal menghapus data scan');
        }
    }

    public function rekap(Request $request)
{
    $request->validate([
        'nama_absensi' => 'required|string|max:255',
    ]);

    DB::beginTransaction();
    try {
        // 1. Get all participants who have status=0 scans (active scans)
        $activeScannedParticipants = DB::table('scan')
            ->where('status', 0)
            ->pluck('id_peserta')
            ->toArray();

        // 2. Update these active scans to status=1 (mark as rekap)
        DB::table('scan')
            ->where('status', 0)
            ->update([
                'status' => 1,
                'nama' => $request->nama_absensi,
                'updated_at' => now()
            ]);

        // 3. Find participants who are not in the activeScannedParticipants array
        $missingParticipants = DB::table('peserta')
            ->whereNotIn('id_peserta', $activeScannedParticipants)
            ->select('id_peserta')
            ->get();

        // 4. Insert records for these participants with scan=0
        $insertData = [];
        $now = now();
        foreach ($missingParticipants as $participant) {
            $insertData[] = [
                'id_peserta' => $participant->id_peserta,
                'nama' => $request->nama_absensi,
                'status' => 1, // Marked as rekap
                'scan' => 0, // Indicates they didn't scan
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($insertData)) {
            DB::table('scan')->insert($insertData);
        }

        DB::commit();

        return redirect()->route('datascan.index')->with('success', 'Rekap absensi berhasil disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('datascan.index')->with('error', 'Gagal menyimpan rekap absensi: '.$e->getMessage());
    }
}
}
