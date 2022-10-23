<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donatur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = [
            'donaturs' => Donatur::count(),
            'campaigns' => Campaign::count(),
            'donations' => Donation::where('status', 'success')->sum('amount')
        ];

        return view('admin.dashboard.index', $data);
    }
}
