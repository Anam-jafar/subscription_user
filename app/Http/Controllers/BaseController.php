<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApplicationConfirmation;
use App\Mail\SubscriptionRequestConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\Institute;
use Illuminate\Support\Facades\Validator;
use App\Models\Parameter;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    public function findInstitute()
    {
        return view('applicant.find_institute');
    }

    public function searchInstitutes(Request $request)
    {
        try {
            $clients = DB::table('client')
                ->where('name', 'LIKE', '%' . $request->institute_name . '%')
                ->select('uid', 'name', 'rem8')
                ->get()
                ->mapWithKeys(function ($client) {
                    $rem8_value = DB::table('type')->where('code', $client->rem8)->value('prm');

                    return [
                        $client->uid => [
                            'name' => $client->name,
                            'rem8' => $rem8_value ?? $client->rem8
                        ]
                    ];
                });

            return response()->json($clients);

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error during institute search.', [
                'institute_name' => $request->institute_name,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'An error occurred while searching for institutes.'], 500);
        }
    }


    public function getCities()
    {
        try {
            $cities = DB::table('type')
                ->where('grp', 'district')
                ->pluck('prm', 'code');

            return response()->json($cities);
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error fetching cities.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Failed to fetch cities.'], 500);
        }
    }

    public function getBandar(Request $request)
    {
        try {
            $search = $request->input('query');

            $cities = Parameter::where('grp', 'city')
                ->where('prm', 'LIKE', "%{$search}%")
                ->pluck('prm', 'code')
                ->toArray();

            return response()->json($cities);

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error fetching bandar.', [
                'query' => $request->input('query'),
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Failed to fetch bandar.'], 500);
        }
    }


    public function getInstitutesByCity(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|min:1',
                'search' => 'nullable|string|min:1'
            ]);

            $query = DB::table('client')->where('rem8', $request->city);

            if ($request->filled('search')) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            }

            $institutes = $query->pluck('name', 'uid');

            return response()->json($institutes);

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error fetching institutes by city.', [
                'city' => $request->city,
                'search' => $request->search,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Failed to fetch institutes.'], 500);
        }
    }


    public function instituteCheck(Request $request)
    {
        try {
            $request->validate([
                'institute_name' => 'required|string|min:1',
                'institute_refno' => 'required|string|min:1',
            ]);

            $institute = Institute::with(['city', 'state'])
                ->where('name', $request->institute_name)
                ->where('uid', $request->institute_refno)
                ->first();

            $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month name year time with AM/PM

            if ($institute->sta == 0) {
                return view('applicant.institute_registered', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);

            } elseif ($institute->sta == 1) {
                if ($institute->registration_request_date != null) {
                    return view('applicant.institute_not_approved_yet', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);
                } else {
                    return view('applicant.institute_not_found', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);
                }
            }

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error in institute check.', [
                'institute_name' => $request->institute_name,
                'institute_refno' => $request->institute_refno,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Nama Intitusi anda tiada dalam rekod, Sila hubungi Pegawai Agama Daerah anda untuk makluman lanjut.');
        }
    }

    public function home()
    {
        try {
            $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month Year Time with AM/PM
            $user = Auth::user();

            // Fetch City and State Names
            $user->CITY = DB::table('type')
                ->where('code', $user->city)
                ->value('prm');

            $user->STATE = DB::table('type')
                ->where('code', $user->state)
                ->value('prm');

            $invoiceDetails = null; // Default null
            $invoiceLink = null;    // Default null
            $receiptDetails = null; // Default null
            $receiptLink = null;    // Default null

            // Check and update subscription status if needed
            $this->checkInvoicePaymentStatus($user);

            $pdfBaseUrl = config('services.awfatech.pdf_base_url');
            $appName = strtolower(config('services.awfatech.appcode'));

            // Fetch Latest Invoice if Subscription Status is 2
            if ($user->subscription_status == 2) {
                $invoiceDetails = DB::table('fin_ledger')
                    ->select('dt', 'tid', 'item', 'total', 'src', 'code')
                    ->where('vid', $user->uid)
                    ->where('src', 'INV')
                    ->orderByDesc('id')
                    ->first();

                if ($invoiceDetails) {
                    $invoiceLink = "{$pdfBaseUrl}?sysapp={$appName}&op=inv&tid={$invoiceDetails->tid}";
                }
            }

            // Fetch Latest Receipt if Subscription Status is 3
            if ($user->subscription_status == 3) {
                $receiptDetails = DB::table('fin_ledger')
                    ->select('dt', 'tid', 'item', 'total', 'src', 'code', 'ref')
                    ->where('vid', $user->uid)
                    ->where('src', 'CSL')
                    ->orderByDesc('id')
                    ->first();

                if ($receiptDetails) {
                    $receiptLink = "{$pdfBaseUrl}?sysapp={$appName}&op=rec&tid={$receiptDetails->tid}";
                }
            }

            return view('applicant.home', compact([
                'user', 'currentDateTime', 'invoiceDetails', 'invoiceLink', 'receiptDetails', 'receiptLink'
            ]));

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Internal error in home method.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'An unexpected error occurred. Please contact support.');
        }
    }

    private function checkInvoicePaymentStatus($user)
    {
        try {
            // Only proceed if user has pending invoices (status 2)
            if ($user->subscription_status == 2) {

                $user_id = $user->uid;

                // Fetch total invoice amount (INV) and total received payment (CSL)
                $paymentDetails = DB::table('fin_ledger as inv')
                    ->leftJoinSub(
                        DB::table('fin_ledger')
                            ->select('vid', DB::raw('SUM(val) AS total_received'))
                            ->where('src', 'CSL')
                            ->groupBy('vid'),
                        'payments',
                        'inv.vid',
                        '=',
                        'payments.vid'
                    )
                    ->select(
                        DB::raw('SUM(inv.val) AS total_invoice'),
                        DB::raw('COALESCE(payments.total_received, 0) AS total_received'),
                        DB::raw('SUM(inv.val) - COALESCE(payments.total_received, 0) AS outstanding')
                    )
                    ->where('inv.vid', $user_id)
                    ->where('inv.src', 'INV')
                    ->groupBy('inv.vid', 'payments.total_received')
                    ->first();

                // Check if outstanding amount is 0
                $paymentConfirmed = ($paymentDetails && $paymentDetails->outstanding == 0);

                // If payment confirmed, update subscription status to 3
                if ($paymentConfirmed) {
                    DB::table('client')
                        ->where('uid', $user->uid)
                        ->update(['subscription_status' => 3]);

                    $user->subscription_status = 3;
                }
            }
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error checking invoice payment status.', [
                'user_id' => $user->uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }


    public function requestSubscription($id)
    {
        try {
            DB::table('client')
                ->where('uid', $id)
                ->update([
                    'subscription_status' => 1,
                    'subcription_request_date' => now()->format('Y-m-d')
                ]);

            $email = DB::table('client')->where('uid', $id)->value('mel');

            Mail::to($email)->send(new SubscriptionRequestConfirmation());

            return redirect()->back()->with('success', 'Permohonan anda untuk langganan dihantar!');
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Error during subscription request.', [
                'uid' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Ralat berlaku semasa permohonan langganan. Sila cuba lagi.');
        }
    }


    public function makePayment($uid, $coa_id)
    {
        try {
            $user = DB::table('client')->where('uid', $uid)->first();
            $item = DB::table('fin_coa_item')->where('code', $coa_id)->first();

            // Individually validate payer_detail fields
            if (!$user) {
                return back()->with('error', 'Pengguna tidak dijumpai.');
            }

            if (!$user->name) {
                return back()->with('error', "Maklumat 'name' tidak dijumpai.");
            }

            if (!$user->mel) {
                return back()->with('error', "Maklumat 'email' tidak dijumpai.");
            }

            if (!$user->hp) {
                return back()->with('error', "Maklumat 'hp' tidak dijumpai.");
            }

            if (!$user->addr) {
                return back()->with('error', "Maklumat 'addr' tidak dijumpai.");
            }

            // Validate cart item fields
            if (!$item || !$item->id || !$item->code || !$item->item || !$item->val || !$item->sid) {
                Log::channel('internal_error')->error('Cart validation failed in makePayment()', [
                    'uid' => $uid,
                    'coa_id' => $coa_id,
                    'user' => $user,
                    'item' => $item,
                ]);
                return back()->with('error', 'Terjadi ralat semasa proses pembayaran. Sila hubungi pihak berwajib.');
            }

            $url = config('services.awfatech.make_payment_url');
            $app = config('services.awfatech.appcode');

            $payload = [
                "payer_detail" => [
                    "name" => $user->name,
                    "email" => $user->mel,
                    "hp" => $user->hp,
                    "addr" => $user->addr,
                    "ic" => $user->ic
                ],
                "cart" => [
                    [
                        "item_id" => (string) $item->id,
                        "tid" => $item->code,
                        "uid" => $user->uid,
                        "item" => $item->item,
                        "code" => $item->code,
                        "qtt" => "1",
                        "price" => $item->val,
                        "total" => $item->val,
                        "sid" => (string) $item->sid
                    ]
                ],
                "type_payment" => "multi",
                "client_id" => $uid,
                "client_sid" => "1",
                "modepay" => "FPX",
                "amount" => $item->val,
                "app" => $app,
                "outcharge" => "1"
            ];

            $headers = [
                'accept' => 'application/json',
                'x-encrypted-key' => session('encrypted_key'),
                'x-encrypted-user' => session('encrypted_user'),
                'Content-Type' => 'application/json'
            ];

            $response = Http::withHeaders($headers)->post($url, $payload);
            $responseData = $response->json();

            if (isset($responseData['success']) && $responseData['success'] && isset($responseData['data']['payment_full_link'])) {
                return redirect()->away($responseData['data']['payment_full_link']);
            }

            // Log API failure to external_api_error channel
            Log::channel('external_api_error')->error('makePayment API failed', [
                'endpoint' => $url,
                'uid' => $uid,
                'email' => $user->mel,
                'response_status' => $response->status(),
                'response_body' => $responseData,
            ]);

            return back()->with('error', 'Tidak dapat mendapatkan pautan pembayaran.');

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Exception during makePayment()', [
                'uid' => $uid,
                'coa_id' => $coa_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi ralat semasa proses pembayaran. Sila hubungi pihak berwajib.');
        }
    }
}
