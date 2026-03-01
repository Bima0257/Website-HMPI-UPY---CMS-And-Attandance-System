<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.post-settings.categories.index', [
            'title' => 'Category Settings',
            'categories' => Categories::all()
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
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories|max:255',
            'image' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        $formInput = $request->except('image');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp');
            $formInput['image_temp_path'] = $imagePath;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validateData = [
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
        ];

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('post-image');
        }


        Categories::create($validateData);
        return redirect('/dashboard/categories')->with('success', 'New Category Has Been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $category)
    {
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'image' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ];

        if ($request->slug != $category->slug) {
            $rules['slug'] = 'required|unique:categories';
        }

        $validator = Validator::make($request->all(), $rules);

        $formInput = $request->except('image');

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp');
            $formInput['image_temp_path'] = $imagePath;
        } elseif ($category->image) {
            $formInput['image_temp_path'] = $category->image;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan, periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validateData = $validator->validated();

        if ($request->file('image')) {
            if ($category->image != null) {
                Storage::delete($category->image);
            }
            $validateData['image'] = $request->file('image')->store('category-image');
        }

        Categories::where('id', $category->id)->update($validateData);

        return redirect()->back()->with('success', 'Category Has Been Edited!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        if ($category->image) {
            Storage::delete($category->image);
        }

        Categories::destroy($category->id);

        return redirect('/dashboard/categories')->with('success', 'Post Has Been Deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Categories::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
