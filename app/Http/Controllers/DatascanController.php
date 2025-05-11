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
            // Sudah Scan
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
                ->orderBy('scan.updated_at', 'desc')
                ->get()
                ->map(function ($scan) {
                    $scan->waktu_scan = date('d-m-Y H:i', strtotime($scan->created_at));
                    return $scan;
                });
        } else {
            // Belum Scan
            $scans = DB::table('peserta')
                ->whereNotIn('id_peserta', function ($query) {
                    $query->select('id_peserta')->from('scan');
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
}
