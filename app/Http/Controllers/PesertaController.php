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
    public function store(Request $request)
    {
        $request->validate([
            'nomor_peserta' => 'required|unique:peserta',
            'nama_peserta' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add other validation rules
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $data['foto'] = $fileName;
        }

        Peserta::create($data);

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);

        $request->validate([
            'nomor_peserta' => 'required|unique:peserta,nomor_peserta,' . $id . ',id_peserta',
            'nama_peserta' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add other validation rules
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($peserta->foto) {
                $oldFilePath = public_path('image/' . $peserta->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // atau File::delete($oldFilePath)
                }
            }

            // Upload new photo
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $data['foto'] = $fileName;
        }

        $peserta->update($data);

        return redirect()->route('peserta.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);

        // Delete photo if exists
        if ($peserta->foto) {
            $filePath = public_path('image/' . $peserta->foto); // Tambahkan 'image/' di sini
            if (file_exists($filePath)) {
                unlink($filePath); // atau File::delete($filePath)
            }
        }

        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data berhasil dihapus.');
    }

    public function cetakKartu()
    {
        $pesertas = Peserta::all(); // Adjust this query as needed
        return view('peserta.cetak', compact('pesertas'));
    }
}
