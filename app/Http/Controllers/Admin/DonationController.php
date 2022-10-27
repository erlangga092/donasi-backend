<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $start_date = request()->start_date;
        $end_date = request()->end_date;

        $data = [];
        if ($start_date && $end_date) {
            $data = [
                'donations' => Donation::where('status', 'success')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->get(),
                'total' => Donation::where('status', 'success')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->sum('amount')
            ];
        }

        return view('admin.donation.index', $data);
    }
}
