<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;

class DonaturController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $donaturs = Donatur::when(request()->q, function ($donaturs) {
            $donaturs = $donaturs->where('name', 'LIKE', '%' . request()->q . '%');
        })->latest()->paginate(10);

        return view('admin.donatur.index', compact('donaturs'));
    }
}
