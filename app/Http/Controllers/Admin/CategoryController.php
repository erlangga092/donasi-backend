<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'LIKE', '%' . request()->q . '%');
        })->latest()->paginate();

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

    public function edit()
    {
    }
    public function show()
    {
    }
    public function update()
    {
    }
    public function desroy()
    {
    }
}
