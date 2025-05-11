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
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // tanpa Hash::make
        ]);


        return redirect()->back()->with('success', 'Admin User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $adminUser = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $adminUser->name = $request->name;
        $adminUser->email = $request->email;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $adminUser->password = Hash::make($request->password);
        }

        $adminUser->save();
        return redirect()->back()->with('success', 'Admin User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'Admin User berhasil dihapus');
    }
}
