<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function cetakKartu()
    {
        $pesertas = Peserta::all(); // Adjust this query as needed
        return view('peserta.cetak', compact('pesertas'));
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);

        // Hapus foto jika ada
        if ($peserta->foto) {
            $filePath = public_path('image/' . $peserta->foto);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data scan yang terkait
        DB::table('scan')->where('id_peserta', $peserta->id_peserta)->delete();

        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data berhasil dihapus.');
    }



    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            // Hapus data scan terkait
            DB::table('scan')->whereIn('id_peserta', $ids)->delete();

            // Ambil dan hapus foto peserta bila ada
            $pesertas = Peserta::whereIn('id_peserta', $ids)->get();
            foreach ($pesertas as $peserta) {
                if ($peserta->foto) {
                    $filePath = public_path('image/' . $peserta->foto);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Hapus peserta
            DB::table('peserta')->whereIn('id_peserta', $ids)->delete();

           return response()->json(['success' => true, 'message' => 'Data peserta berhasil dihapus.']);
        }

        return response()->json(['success' => true, 'message' => 'Data peserta berhasil dihapus.']);
    }
}
