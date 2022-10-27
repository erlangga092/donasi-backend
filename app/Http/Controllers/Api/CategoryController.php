<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(12);

        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories
        ], 200);
    }

    public function show($slug)
    {
        $category = Category::with('campaigns.user', 'campaigns.sumDonation')
            ->where('slug', $slug)
            ->first();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Campaign Berdasarkan Category : ' . $category->name,
                'data' => $category
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Category Tidak Ditemukan!',
        ], 404);
    }

    public function categoryHome()
    {
        $categories = Category::latest()->take(3)->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories
        ], 200);
    }
}
