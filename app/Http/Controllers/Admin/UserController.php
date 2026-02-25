<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        
        $usersQuery = \App\Models\User::with('organisasi')->latest();
        
        if ($role) {
            $usersQuery->where('role', $role);
        }

        $users = $usersQuery->paginate(10);

        return view('dashboard.admin.users.index', compact('users', 'role'));
    }

    public function create()
    {
        $organisasis = \App\Models\Organisasi::orderBy('nama')->get();
        return view('dashboard.admin.users.create', compact('organisasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,pc,pac,pr,pk,departemen', // Added standard roles
            'organisasi_id' => 'nullable|exists:organisasis,id', 
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'organisasi_id' => $request->organisasi_id,
        ]);

        return redirect()->route('dashboard.admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $organisasis = \App\Models\Organisasi::orderBy('nama')->get();
        return view('dashboard.admin.users.edit', compact('user', 'organisasis'));
    }

    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,pc,pac,pr,pk,departemen',
            'organisasi_id' => 'nullable|exists:organisasis,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'organisasi_id' => $request->organisasi_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('dashboard.admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
