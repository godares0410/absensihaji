<?php
// app/Http/Controllers/AdminUserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminUserController extends Controller
{
    public function index()
    {
        $adminUsers = User::all();
        return view('admin_user.index', compact('adminUsers'))->with('title', 'Admin User');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $data['foto'] = $fileName;
        }

        User::create($data);

        return redirect()->back()->with('success', 'Admin User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $adminUser = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminUser->name = $request->name;
        $adminUser->email = $request->email;

        if ($request->filled('password')) {
            $adminUser->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($adminUser->foto) {
                $oldFilePath = public_path('image/' . $adminUser->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // atau File::delete($oldFilePath)
                }
            }

            // Upload foto baru
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $adminUser->foto = $fileName;
        }

        $adminUser->save();
        return redirect()->back()->with('success', 'Admin User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto jika ada
        if ($user->foto) {
            $filePath = public_path('image/' . $user->foto); // Tambahkan 'image/' di sini
            if (file_exists($filePath)) {
                unlink($filePath); // atau File::delete($filePath)
            }
        }

        $user->delete();

        return redirect()->back()->with('success', 'Admin User berhasil dihapus');
    }
}
