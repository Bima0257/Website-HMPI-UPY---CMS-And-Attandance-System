<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\BreadCrumbBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.about.index', [
            'title' => 'About Content Setting',
            'abouts' => About::all()
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
            'video_url' => 'required|url',
            'instagram_url' => 'required|url',
            'youtube_url' => 'required|url',
            'tiktok_url' => 'required|url',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'alamat' => 'required',
            'body' => 'required',
            'background_image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'small_logo' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'large_logo' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required|in:draft,published'
        ]);
        $formInput = $request->except('background_image', 'small_logo', 'large_logo');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        foreach (['background_image', 'small_logo', 'large_logo'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('temp');
                $formInput[$field . '_temp_path'] = $path;
            } elseif (isset($about) && $about->$field) {
                // Kalau di update, ambil dari data lama
                $formInput[$field . '_temp_path'] = $about->$field;
            }
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

        $validatedData['background_image'] = $this->handleFileUpload($request, 'background_image');
        $validatedData['small_logo'] = $this->handleFileUpload($request, 'small_logo');
        $validatedData['large_logo'] = $this->handleFileUpload($request, 'large_logo');


        About::create($validatedData);

        return redirect('/dashboard/about')->with('success', 'New About Content Has Been Added!');
    }


    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        return view('dashboard.super-admin.about.show', [
            'title' => 'Show Content',
            'about' => $about,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        return response()->json($about);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, About $about)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'video_url' => 'required|url',
            'instagram_url' => 'required|url',
            'youtube_url' => 'required|url',
            'tiktok_url' => 'required|url',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|max:20',
            'alamat' => 'required',
            'body' => 'required',
            'status' => 'required|in:draft,published',
            'small_logo' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'large_logo' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'background_image' => 'image|file|max:1000'
        ]);

        $formInput = $request->except('background_image', 'small_logo', 'large_logo');
        
        // Simpan sementara file gambar untuk preview jika validasi gagal
        foreach (['background_image', 'small_logo', 'large_logo'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('temp');
                $formInput[$field . '_temp_path'] = $path;
            } elseif (isset($about) && $about->$field) {
                // Kalau di update, ambil dari data lama
                $formInput[$field . '_temp_path'] = $about->$field;
            }
        }


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan, periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validateData = $request->only(['title', 'video_url', 'instagram_url', 'youtube_url', 'tiktok_url', 'email', 'contact_phone', 'alamat', 'body', 'status']);

        $validateData['background_image'] = $this->handleFileUpload($request, 'background_image', $about->background_image);
        $validateData['small_logo'] = $this->handleFileUpload($request, 'small_logo', $about->small_logo);
        $validateData['large_logo'] = $this->handleFileUpload($request, 'large_logo', $about->large_logo);


        $about->update($validateData);

        return redirect()->back()->with('success', 'About content berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {

        if (!empty($about->background_image) && Storage::disk('public')->exists($about->background_image)) {
            Storage::disk('public')->delete($about->background_image);
        }
        $about->delete();
        return redirect('/dashboard/about')->with('success', 'About content successfully deleted!');
    }

    private function handleFileUpload($request, $field, $oldFile = null)
    {
        if ($request->hasFile($field)) {
            if ($oldFile) {
                Storage::delete($oldFile);
            }
            return $request->file($field)->store('content-image');
        }
        return $oldFile;
    }
}
