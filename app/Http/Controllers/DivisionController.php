<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.division-settings.index', [
            'title' => 'Divisi HMPI',
            'divisions' => Division::all()
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
            'nama_divisi' => 'required|unique:divisions',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true) // Tambahkan penanda error form
                ->with('form_input', $request->all()); // Simpan data input
        }

        $validatedData = $validator->validated();

        Division::create($validatedData);

        return redirect('/dashboard/divisions')->with('success', 'Division Has Been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        return response()->json($division);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required|unique:divisions',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true) // Tambahkan penanda error form
                ->with('form_input', $request->all()); // Simpan data input
        }

        $validateData = [
            'nama_divisi' => $request->nama_divisi,
        ];

        $division->update($validateData);
        return redirect()->back()->with('success', 'Data Division berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect('/dashboard/divisions')->with('success', 'Division successfully deleted!');
    }
}
