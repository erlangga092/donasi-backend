<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'LIKE', '%' . request()->q . '%');
        })->latest()->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2000'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // save to DB
        $category = Category::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name, '-')
        ]);

        if ($category) {
            return redirect()->route('admin.category.index')
                ->with(['success' => 'Data berhasil disimpan!']);
        }

        return redirect()->route('admin.category.index')->with([
            'error' => 'Data gagal disimpan!'
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2000'
        ]);

        if ($request->file('image') == "") {
            $category->update([
                'name' => $request->name,
                'slug' => \Illuminate\Support\Str::slug($request->name, '-')
            ]);
        } else {
            // delete current image
            Storage::disk('local')->delete('public/categories/' . basename($category->image));

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'slug' => \Illuminate\Support\Str::slug($request->name, '-')
            ]);
        }

        if ($category) {
            return redirect()->route('admin.category.index')->with([
                'success' => 'Data berhasil diupdate!'
            ]);
        }

        return redirect()->route('admin.category.index')->with([
            'error' => 'Data gagal diupdate!'
        ]);
    }

    public function destroy(Category $category)
    {
        Storage::disk('local')->delete('public/categories/' . basename($category->image));
        $category->delete();

        if ($category) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
