<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::when(request()->q, function ($campaigns) {
            $campaigns = $campaigns->where('title', 'LIKE', '%' . request()->q . '%');
        })->with('category')->latest()->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.campaign.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'title' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'target_donation' => 'required|numeric',
            'max_date' => 'required|date_format:Y-m-d',
            'description' => 'required|string'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashName());

        $validate['slug'] = \Illuminate\Support\Str::slug($request->title, '-');
        $validate['user_id'] = auth()->user()->id;
        $validate['image'] = $image->hashName();

        $campaign = Campaign::create($validate);

        if ($campaign) {
            return redirect()->route('admin.campaign.index')->with([
                'success' => 'Data berhasil disimpan!'
            ]);
        }

        return redirect()->route('admin.campaign.index')->with([
            'error' => 'Data gagal disimpan!'
        ]);
    }
}
