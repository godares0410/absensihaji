<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakkartuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get total counts
        $totalPeserta = DB::table('peserta')->count();
        $totalScan = DB::table('scan')->where('status', 0)->count();
        $totalRombongan = DB::table('peserta')->distinct('rombongan')->count('rombongan');
        $totalRegu = DB::table('peserta')->distinct('regu')->count('regu');

        // Get distinct rombongan and regu
        $rombonganList = DB::table('peserta')->distinct('rombongan')->pluck('rombongan');
        $reguList = DB::table('peserta')->distinct('regu')->pluck('regu');

        return view('data_kartu.index', [
            'user' => $user,
            'userName' => $user->name ?? 'Admin',
            'totalPeserta' => $totalPeserta,
            'totalScan' => $totalScan,
            'totalRombongan' => $totalRombongan,
            'totalRegu' => $totalRegu,
            'rombonganList' => $rombonganList,
            'reguList' => $reguList,
        ]);
    }
    public function show(Request $request)
    {
        $rombongan = $request->get('rombongan', 'semua');
        $regu = $request->get('regu', 'semua');

        $query = Peserta::query();

        // Filter based on rombongan if not 'semua'
        if ($rombongan !== 'semua') {
            $query->where('rombongan', $rombongan);
        }

        // Filter based on regu if not 'semua'
        if ($regu !== 'semua') {
            $query->where('regu', $regu);
        }

        $pesertas = $query->get();

        return view('peserta.cetak', compact('pesertas'));
    }
    public function getRegu($rombongan)
    {
        $regus = DB::table('peserta')
            ->where('rombongan', $rombongan)
            ->distinct()
            ->pluck('regu');

        return response()->json($regus);
    }
}
