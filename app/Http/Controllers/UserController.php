<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        $title = 'Manajemen Pengguna';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Manajemen Pengguna', 'active' => true],
        ];

        return $dataTable->render('users.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Manajemen Pengguna', 'url' => route('users.index')],
            ['name' => 'Tambah Pengguna', 'active' => true],
        ];
        $roles = Role::all();

        // Get NIPs of existing users
        $existingUserNips = User::whereNotNull('username')->pluck('username')->toArray();

        // Get Pegawai who do not have a user account yet (NIP not in existingUserNips)
        $availablePegawai = Pegawai::whereNotIn('nip', $existingUserNips)->get();

        return view('users.create', compact('title', 'breadcrumbs', 'roles', 'availablePegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
        ];

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->user_type === 'new') {
            $availableRoles = Role::pluck('name')->toArray();
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['role'] = ['required', 'string', Rule::in($availableRoles)];
            $userData['password'] = Hash::make($request->password);
            $userData['role'] = $request->role;
        } elseif ($request->user_type === 'pegawai') {
            $rules['pegawai_id'] = 'required|exists:pegawai,id';
            // For pegawai, password will be generated, and role will be 'pegawai'
            // We don't need password or role from request for validation here
            // The name, username (nip), email will come from the selected pegawai
            $pegawai = Pegawai::findOrFail($request->pegawai_id);
            $userData['name'] = $pegawai->nama_lengkap;
            $userData['username'] = $pegawai->nip;
            $userData['email'] = $pegawai->email; // Use pegawai's email
            $userData['password'] = Hash::make(Str::random(10)); // Generate random password
            $userData['role'] = 'pegawai'; // Default role for pegawai
        }

        $request->validate($rules);

        User::create($userData);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not explicitly requested, but good practice for resource controllers
        // For now, we can redirect to edit or index if not needed.
        return redirect()->route('users.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit Pengguna';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Manajemen Pengguna', 'url' => route('users.index')],
            ['name' => 'Edit Pengguna', 'active'],
        ];
        $roles = Role::all();

        return view('users.edit', compact('user', 'title', 'breadcrumbs', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $availableRoles = Role::pluck('name')->toArray();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in($availableRoles)],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Activate the specified user.
     */
    public function activate(User $user)
    {
        $user->is_active = true;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diaktifkan.');
    }

    /**
     * Deactivate the specified user.
     */
    public function deactivate(User $user)
    {
        $user->is_active = false;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dinonaktifkan.');
    }

    /**
     * Generate a user account for a selected Pegawai.
     */
    public function generatePegawaiAccount(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
        ]);

        $pegawai = Pegawai::findOrFail($request->pegawai_id);

        // Check if user already exists for this NIP
        if (User::where('username', $pegawai->nip)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun untuk NIP ini sudah ada.',
            ], 409); // Conflict
        }

        $password = Str::random(10);

        User::create([
            'name' => $pegawai->nama_lengkap,
            'username' => $pegawai->nip,
            'email' => $pegawai->email,
            'password' => Hash::make($password),
            'role' => 'pegawai',
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat.',
            'username' => $pegawai->nip,
            'password' => $password,
        ]);
    }
}
