<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'required|string'
        ]);

        $image = $request->file('image');
        $image->storeAs("public/sliders", $image->hashName());

        Slider::create([
            'image' => $image->hashName(),
            'link' => $request->link
        ]);

        return redirect()->route('admin.slider.index')->with([
            'success' => 'Data berhasil disimpan.'
        ]);
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        if ($slider) {
            Storage::disk('local')->delete('public/sliders/' .  basename($slider->image));
            return response()->json([
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
