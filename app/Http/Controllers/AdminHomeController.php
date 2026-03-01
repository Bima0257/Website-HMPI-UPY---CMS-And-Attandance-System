<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.content-settings.home.index', [
            'title' => 'Home Carousel',
            'carousels' => HomeSection::all()
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
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'body' => 'required',
            'background_image' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required|in:draft,published'
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

        HomeSection::create($validatedData);
        return redirect('/dashboard/homeSections')->with('success', 'New Content Has Been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSection $homeSection)
    {
        return view('dashboard.super-admin.content-settings.home.show', [
            'title' => 'Show Content',
            'carousel' => $homeSection
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSection $homeSection)
    {
        return response()->json($homeSection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subtitle' => 'required',
            'body' => 'required',
            'status' => 'required|in:draft,published',
            'background_image' => 'image|file|max:1000'
        ]);

        $formInput = $request->except('background_image');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('background_image')) {
            $background_imagePath = $request->file('background_image')->store('temp');
            $formInput['background_image_temp_path'] = $background_imagePath;
        } elseif ($homeSection->background_image) {
            $formInput['background_image_temp_path'] = $homeSection->background_image;
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
            'body' => $request->body,
            'status' => $request->status,
        ];

        // Jika ada upload gambar baru
        if ($request->file('background_image')) {
            // Hapus gambar lama jika ada
            if ($homeSection->background_image) {
                Storage::delete($homeSection->background_image);
            }
            $validateData['background_image'] = $request->file('background_image')->store('content-image');
        }

        // Update data
        $homeSection->update($validateData);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSection $homeSection)
    {

        if (!empty($homeSection->background_image) && Storage::disk('public')->exists($homeSection->background_image)) {
            Storage::disk('public')->delete($homeSection->background_image);
        }
        $homeSection->delete();
        return redirect('/dashboard/homeSections')->with('success', 'Content successfully deleted!');
    }
}
