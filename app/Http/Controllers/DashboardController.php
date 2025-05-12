<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalPeserta = DB::table('peserta')->count();
        $totalScan = DB::table('scan')->where('status', 0)->count();
        $totalRombongan = DB::table('peserta')->distinct('rombongan')->count('rombongan');
        $totalRegu = DB::table('peserta')->distinct('regu')->count('regu');

        return view('admin.dashboard', [
            'user' => $user,
            'userName' => $user->name ?? 'Admin',
            'totalPeserta' => $totalPeserta,
            'totalScan' => $totalScan,
            'totalRombongan' => $totalRombongan,
            'totalRegu' => $totalRegu,
        ]);
    }
}
