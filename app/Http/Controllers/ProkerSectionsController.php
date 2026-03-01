<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ProkerSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProkerSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.content-settings.proker.index', [
            'title' => 'Program Kerja',
            'proker' => ProkerSections::all(),
            'events' => Event::where('status', 'completed')->orderBy('judul')->get()
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
            'title' => 'required',
            'subtitle' => 'required',
            'background_image' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        $formInput = $request->except('background_image');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('background_image')) {
            $background_imagePath = $request->file('background_image')->store('temp');
            $formInput['background_image_temp_path'] = $background_imagePath;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('background_image')) {
            $validatedData['background_image'] = $request->file('background_image')->store('content-image');
        }

        ProkerSections::create($validatedData);
        return redirect('/dashboard/prokerSections')->with('success', 'ProkerSections Has Been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProkerSections $prokerSection)
    {
        return view('dashboard.super-admin.content-settings.proker.show', [
            'title' => 'Show Content',
            'proker' => $prokerSection,
            'events' => Event::with(['divisi', 'ketuaPelaksana'])->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProkerSections $prokerSection)
    {
        return response()->json($prokerSection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProkerSections $prokerSection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'required',
            'background_image' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        $formInput = $request->except('background_image');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('background_image')) {
            $background_imagePath = $request->file('background_image')->store('temp');
            $formInput['background_image_temp_path'] = $background_imagePath;
        } elseif ($prokerSection->background_image) {
            $formInput['background_image_temp_path'] = $prokerSection->background_image;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan, periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validateData = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'status' => $request->status,
        ];

        // Jika ada upload gambar baru
        if ($request->file('background_image')) {
            // Hapus gambar lama jika ada
            if ($prokerSection->background_image) {
                Storage::delete($prokerSection->background_image);
            }
            $validateData['background_image'] = $request->file('background_image')->store('content-image');
        }

        // Update data
        $prokerSection->update($validateData);

        return redirect()->back()->with('success', 'Content berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProkerSections $prokerSection)
    {
        if (!empty($prokerSection->background_image) && Storage::disk('public')->exists($prokerSection->background_image)) {
            Storage::disk('public')->delete($prokerSection->background_image);
        }
        $prokerSection->delete();
        return redirect('/dashboard/prokerSections')->with('success', 'Content successfully deleted!');
    }
}
