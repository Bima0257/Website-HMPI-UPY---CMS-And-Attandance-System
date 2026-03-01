<?php

namespace App\Http\Controllers;

use App\Models\DataMember;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DataMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user =  Auth::user();
        if ($user->level_pengguna === 'Super Admin') {
            // Super Admin -> semua data member
            $data = DataMember::with('division')->get();
        } else {
            // Admin -> hanya data member sesuai division_id miliknya
            $data = DataMember::with('division')
                ->where('division_id', $user->divisi_id)
                ->get();
        }

        return view('dashboard.super-admin.member-data.index', [
            'title' => 'Member Data',
            'divisions' => Division::all(),
            'data' => $data
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
        $user = Auth::user();

        $rules = [
            'nama' => 'required|max:255|unique:data_members,nama',
            'npm' => 'required|unique:data_members,npm',
            'link_ig' => 'nullable|url',
            'jabatan' => 'required',
            'foto' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ];

        if ($user->level_pengguna === 'Super Admin') {
            $rules['division_id'] = 'required|exists:divisions,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true);
        }

        $validatedData = $validator->validated();

        // Jika Admin → paksa division_id
        if ($user->level_pengguna === 'Admin') {
            $validatedData['division_id'] = $user->divisi_id;
        }

        // Upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $validatedData['foto'] = $file->storeAs(
                'member-image',
                time() . '.' . $file->extension()
            );
        }

        DataMember::create($validatedData);

        return redirect('/dashboard/dataMemberSections')
            ->with('success', 'New Member Has Been Added!');
    }


    /**
     * Display the specified resource.
     */

    public function show(DataMember $dataMember)
    {
        return view('dashboard.super-admin.member-data.show', [
            'title' => 'Detail Data Member',
            'teams' => $dataMember->load('division'),
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataMember $dataMember)
    {
        return response()->json($dataMember);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataMember $dataMember)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
            'npm' => 'required|max:100',
            'link_ig' => 'nullable|url',
            'division_id' => 'required|exists:divisions,id',
            'jabatan' => 'required',
            'foto' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan, periksa kembali input Anda!')
                ->with('form_error', true);
        }

        $validatedData = $validator->validated();

        // === LOGIC LEVEL PENGGUNA ===
        if ($user->level_pengguna === 'Admin') {
            // admin → paksa division_id sendiri
            $validatedData['division_id'] = $user->divisi_id;
        }
        // Super Admin otomatis pakai division_id dari request

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($dataMember->foto) {
                Storage::delete($dataMember->foto);
            }
            $validatedData['foto'] = $request->file('foto')
                ->store('member-image');
        }

        $dataMember->update($validatedData);

        return back()->with('success', 'Member data berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataMember $dataMember)
    {
        if (!empty($dataMember->foto) && Storage::disk('public')->exists($dataMember->foto)) {
            Storage::disk('public')->delete($dataMember->foto);
        }
        $dataMember->delete();
        return redirect('/dashboard/dataMemberSections')->with('success', 'About content successfully deleted!');
    }


    public function chartData()
    {
        $data = DataMember::join('divisions', 'data_members.division_id', '=', 'divisions.id')
            ->selectRaw('divisions.nama_divisi as divisi, COUNT(*) as total')
            ->groupBy('divisions.nama_divisi')
            ->get();

        return response()->json($data);
    }
}
