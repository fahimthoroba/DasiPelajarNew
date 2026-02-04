<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PacManagementController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('role', 'pac')
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.pac.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.admin.pac.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'zona_wilayah' => 'required|string|max:255', // Korwas
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'pac',
            'zona_wilayah' => $request->zona_wilayah,
            'departemen_id' => 'PAC', // Tagging as PAC explicitly if needed, or null
        ]);

        return redirect()->route('dashboard.admin.pac.index')->with('success', 'Akun PAC berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $user = \App\Models\User::where('role', 'pac')->findOrFail($id);
        return view('dashboard.admin.pac.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::where('role', 'pac')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'zona_wilayah' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'zona_wilayah' => $request->zona_wilayah,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('dashboard.admin.pac.index')->with('success', 'Akun PAC berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->role !== 'pac') {
            return back()->with('error', 'Hanya akun PAC yang boleh dihapus dari sini.');
        }
        $user->delete();
        return back()->with('success', 'Akun PAC berhasil dihapus.');
    }
}
