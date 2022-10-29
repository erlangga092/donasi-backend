<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$clientKey = config('services.midtrans.clientKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $donations = Donation::with('campaign')->where('donatur_id', auth('api')->user()->id)
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List data donasi : ' . auth('api')->user()->name,
            'data' => $donations
        ], 200);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $length = 10;
            $random = "";

            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = "TRX-" . \Illuminate\Support\Str::upper($random);

            $campaign = Campaign::where('slug', $request->campaign)->first();
            $donation = Donation::create([
                'invoice' => $no_invoice,
                'campaign_id' => $campaign->id,
                'donatur_id' => auth('api')->user()->id,
                'amount' => $request->amount,
                'pray' => $request->pray,
                'status' => 'pending'
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $no_invoice,
                    'gross_amount' => $request->amount
                ],
                'customer_details' => [
                    'first_name' => auth('api')->user()->name,
                    'email' => auth('api')->user()->email
                ]
            ];

            $snap_token = Snap::getSnapToken($payload);
            $donation->snap_token = $snap_token;
            $donation->save();

            $this->response['snap_token'] = $snap_token;
        });

        return response()->json([
            'success' => true,
            'message' => 'Donasi berhasil dibuat',
            $this->response
        ]);
    }

    public function notification_handler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload, true);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));
        if ($notification->signature_key != $validSignatureKey) {
            return response([
                'message' => 'Invalid signature'
            ], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;

        $data_donation = Donation::where('invoice', $order_id)->first();

        switch ($transaction) {
            case 'capture':
                if ($type == "credit_card") {
                    if ($fraud == "challenge") {
                        $data_donation->update([
                            'status' => 'pending'
                        ]);
                    } else {
                        $data_donation->update([
                            'status' => 'success'
                        ]);
                    }
                }
                break;
            case 'settlement':
                $data_donation->update([
                    'status' => 'success'
                ]);
                break;
            case 'pending':
                $data_donation->update([
                    'status' => 'pending'
                ]);
                break;
            case 'deny':
                $data_donation->update([
                    'status' => 'failed'
                ]);
                break;
            case 'expire':
                $data_donation->update([
                    'status' => 'expired'
                ]);
                break;
            case 'cancel':
                $data_donation->update([
                    'status' => 'failed'
                ]);
                break;
        }
    }
}
