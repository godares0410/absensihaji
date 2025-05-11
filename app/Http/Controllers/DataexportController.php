<?php
// /Users/admin/Documents/absensinew/app/Http/Controllers/DataexportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicScanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class DataexportController extends Controller
{
    public function index()
    {
        $scans = Scan::all()->groupBy('nama');
        return view('data_export.index', ['dataGrouped' => $scans]);
    }

    public function destroy($nama)
    {
        Scan::where('nama', $nama)->delete();
        return redirect()->route('dataexport.index')->with('success', 'Data berhasil dihapus');
    }

    public function export($nama, $format)
    {
        // Sudah Scan (join scan + peserta)
        $sudahScan = DB::table('scan')
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
            ->where('scan.nama', $nama)
            ->where('scan.scan', 1)
            ->orderBy('scan.updated_at', 'desc')
            ->get()
            ->map(function ($scan) {
                $scan->waktu_scan = date('d-m-Y H:i', strtotime($scan->created_at));
                return $scan;
            });

        // Hitung jumlah sudah scan
        $countSudahScan = $sudahScan->count();

        // Belum Scan (peserta tanpa entri scan)
        $belumScan = DB::table('scan')
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
            ->where('scan.nama', $nama)
            ->where('scan.scan', 0)
            ->orderBy('scan.updated_at', 'desc')
            ->get()
            ->map(function ($scan) {
                $scan->waktu_scan = date('d-m-Y H:i', strtotime($scan->created_at));
                return $scan;
            });

        // Hitung jumlah belum scan
        $countBelumScan = $belumScan->count();

        if ($format === 'pdf') {
            $pdf = PDF::loadView('scan.export_pdf', [
                'nama' => $nama,
                'sudahScan' => $sudahScan,
                'belumScan' => $belumScan,
                'countSudahScan' => $countSudahScan,
                'countBelumScan' => $countBelumScan
            ]);
            return $pdf->download("scan_$nama.pdf");
        }

        if ($format === 'excel') {
            return Excel::download(new DynamicScanExport($nama, $sudahScan, $belumScan, $countSudahScan, $countBelumScan), "scan_$nama.xlsx");
        }

        return redirect()->back()->with('error', 'Format tidak dikenali');
    }
}
