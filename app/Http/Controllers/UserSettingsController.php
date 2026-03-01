<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.user-settings.index', [
            'title' => 'User Setting',
            'divisions' => Division::all(),
            'users' => User::with('divisi')->where('level_pengguna', '!=', 'Super Admin')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255|unique:users',
            'password' => 'required|string|min:8',
            'divisi_id' => 'required',
            'confirm_password' => 'required|string|min:8|same:password',
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'level_pengguna' => ['required', Rule::in(['Admin', 'Super Admin'])],
        ], [
            'confirm_password.same' => 'Konfirmasi password tidak cocok!',
        ]);

        // Simpan input yang gagal validasi untuk dikirim ke frontend
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true) // Tambahkan penanda error form
                ->with('form_input', $request->all()); // Simpan data input
        }


        // Hash password sebelum disimpan
        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        unset($validatedData['confirm_password']);

        // Simpan user
        User::create($validatedData);

        return redirect('/dashboard/userSettings')->with('success', 'new User Has Been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, User $user)
    {
        // Validasi dasar
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'divisi_id' => 'required',
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'level_pengguna' => ['required', Rule::in(['Admin', 'Super Admin'])],
        ];

        $input = $request->all();

        // Jika user ingin mengganti password, mulai dari validasi old_password
        if ($request->filled('old_password') || $request->filled('password') || $request->filled('confirm_password')) {
            // Pastikan old_password diisi
            if (!$request->filled('old_password')) {
                return redirect()->back()
                    ->withErrors(['old_password' => 'Password lama wajib diisi!'])
                    ->withInput()
                    ->with('error', 'Password lama harus diisi terlebih dahulu.')
                    ->with('form_error', true) // Tambahkan penanda error form
                    ->with('form_input', $request->all()); // Simpan data input
            }

            // Cek old_password benar atau tidak
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['old_password' => 'Password lama salah!'])
                    ->with('error', 'Password lama yang Anda masukkan tidak sesuai.')
                    ->with('form_error', true) // Tambahkan penanda error form
                    ->with('form_input', $request->all()); // Simpan data input
            }

            // Jika old password benar, lanjut validasi password baru
            $rules['password'] = 'required|string|min:8';
            $rules['confirm_password'] = 'required|string|min:8|same:password';
        }

        $validator = Validator::make($input, $rules, [
            'confirm_password.same' => 'Konfirmasi password tidak cocok!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true) // Tambahkan penanda error form
                ->with('form_input', $request->all()); // Simpan data input
        }

        // Jika password baru diisi dan valid, simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update data user
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'divisi_id' => $request->divisi_id,
            'status' => $request->status,
            'level_pengguna' => $request->level_pengguna,
            'password' => $user->password,
        ]);

        return redirect()->back()->with([
            'success' => 'User updated successfully!',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/dashboard/userSettings')->with([
            'success' => 'User deleted successfully!',
        ]);
    }

    // Halaman edit
    public function editProfile()
    {
        return view('dashboard.profile-setting.index', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        // Rules dasar
        $rules = [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'old_password'  => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $request->all());
        }

        $validated = $validator->validated();

        // Data dasar
        $data = [
            'name'     => $validated['name'],
            'username' => $validated['username'],
        ];


        // Jika user ingin ganti password
        if (!empty($validated['password'])) {
            // Cek password lama dulu
            if (empty($validated['old_password']) || !Hash::check($validated['old_password'], $user->password)) {
                return redirect()->back()
                    ->withErrors(['old_password' => 'Password lama tidak sesuai!'])
                    ->withInput()
                    ->with('error', 'Password lama yang Anda masukkan tidak sesuai.')
                    ->with('form_error', true)
                    ->with('form_input', $request->all());
            }

            $data['password'] = Hash::make($validated['password']);
        }

        // Upload foto profil jika ada
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru ke folder storage/app/public/profile-image
            $path = $request->file('avatar')->store('profile-image', 'public');
            $data['avatar'] = $path;
        }

        // Update ke database
        $user->update($data);

        return redirect()->route('profile.edit')->with([
            'success' => 'Profil berhasil diperbarui!',
        ]);
    }
}
