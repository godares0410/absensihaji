<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = Peserta::all(); // ambil data peserta
        return view('data_umum.peserta.index', [
            'peserta' => $peserta,
            'title' => 'Data Peserta'
        ]);
    }
    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);

        $peserta->nomor_peserta = $request->nomor_peserta;
        $peserta->nama_peserta = $request->nama_peserta;
        $peserta->kecamatan = $request->kecamatan;
        $peserta->rombongan = $request->rombongan;
        $peserta->regu = $request->regu;
        $peserta->kloter = $request->kloter;
        $peserta->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('peserta', 'public');
            $peserta->foto = $path;
        }

        $peserta->save();

        return redirect()->route('peserta.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'Data berhasil dihapus.');
    }

    public function cetakKartu()
    {
        $pesertas = Peserta::all(); // Adjust this query as needed
        return view('peserta.cetak', compact('pesertas'));
    }
}
