<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function edit(Campaign $campaign)
    {
        $data = [
            'campaign' => $campaign,
            'categories' => Category::latest()->get()
        ];

        return view('admin.campaign.edit', $data);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validate = $this->validate($request, [
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'title' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'target_donation' => 'required|numeric',
            'max_date' => 'required|date_format:Y-m-d',
            'description' => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('local')->delete('public/campaigns/' . basename($campaign->image));

            $image = $request->file('image');
            $image->storeAs('public/campaigns', $image->hashName());
            $validate['image'] = $image->hashName();
        }

        $validate['slug'] = \Illuminate\Support\Str::slug($request->title);
        $update = $campaign->update($validate);

        if ($update) {
            return redirect()->route('admin.campaign.index')->with([
                'success' => 'Data berhasil diupdate!'
            ]);
        }

        return redirect()->route('admin.campaign.index')->with([
            'error' => 'Data gagal diupdate!'
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        if ($campaign) {
            Storage::disk('local')->delete('public/campaigns/' . basename($campaign->image));
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
