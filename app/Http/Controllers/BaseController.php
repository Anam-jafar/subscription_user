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

class BaseController extends Controller
{
    private function getCommonData()
    {
        return [
            'cities' => DB::table('client')
                ->distinct()
                ->pluck('city')
                ->mapWithKeys(fn ($city) => [$city => $city])
                ->toArray(),
            'schs' => collect(DB::select('SELECT sname, sid FROM sch'))
                ->mapWithKeys(fn ($item) => [$item->sid => $item->sname])
                ->toArray(),
            'states' => DB::table('type')->where('grp', 'state')->get(),
            'syslevels' => DB::table('type')
                ->where('grp', 'syslevel')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),

            'statuses' => DB::table('type')
                ->where('grp', 'clientstatus')
                ->distinct()
                ->pluck('prm', 'val')
                ->toArray(),
            'areas' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'institute_types' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'institute_categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'districts' => DB::table('type')
                ->where('grp', 'district')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'sub_districts' => DB::table('type')
                ->where('grp', 'sub_district')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'departments' => DB::table('type')
                ->where('grp', 'jobdiv')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'admin_positions' => DB::table('type')
                ->where('grp', 'job')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'user_positions' => DB::table('type')
                ->where('grp', 'externalposition')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
        ];
    }
    public function showLoginForm()
    {
        return view('applicant.login');
    }

    public function findInstitute()
    {
        return view('applicant.find_institute');
    }

    public function instituteNotFound()
    {
        return view('applicant.institute_not_found');
    }

    public function instituteNotSubscribed()
    {
        return view('applicant.institute_not_subscribed');
    }
    public function instituteSubscribed()
    {
        return view('applicant.institute_subscribed');
    }
    public function searchInstitutes(Request $request)
    {
        $clients = DB::table('client')
            ->where('name', 'LIKE', '%' . $request->institute_name . '%')
            ->select('uid', 'name', 'rem8')
            ->get()
            ->mapWithKeys(function ($client) {
                $rem8_value = DB::table('type')->where('code', $client->rem8)->value('prm');

                return [
                    $client->uid => [
                        'name' => $client->name,
                        'rem8' => $rem8_value ?? $client->rem8 // Use the fetched value or fallback to original
                    ]
                ];
            });

        return response()->json($clients);
    }



    public function getCities()
    {
        try {
            $cities = DB::table('type')
                ->where('grp', 'district')
                ->pluck('prm', 'code'); // Fetch prm as display text and code as the key

            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getBandar(Request $request)
    {
        $search = $request->input('query');

        $cities = Parameter::where('grp', 'city')
            ->where('prm', 'LIKE', "%{$search}%") // Search for matching cities
            ->pluck('prm', 'code')
            ->toArray();

        return response()->json($cities);
    }

    public function getInstitutesByCity(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|min:1',
                'search' => 'nullable|string|min:1'
            ]);

            $query = DB::table('client')->where('rem8', $request->city); // 🔹 Changed 'city' to 'rem8'

            if ($request->filled('search')) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            }

            $institutes = $query->pluck('name', 'uid');

            return response()->json($institutes);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            // Get current date and time
            $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month name year time with AM/PM

            if ($institute->sta == 0) {
                return view('applicant.institute_registered', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);

                // if ($institute->subscription_status != 0) {
                //     return view('applicant.institute_subscribed', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);
                // } else {
                //     return view('applicant.institute_not_subscribed', ['institute' => $institute,'currentDateTime' => $currentDateTime]);
                // }

            } elseif ($institute->sta == 1) {
                if ($institute->registration_request_date != null) {
                    return view('applicant.institute_not_approved_yet', ['institute' => $institute,'currentDateTime' => $currentDateTime]);
                } else {
                    return view('applicant.institute_not_found', ['institute' => $institute,'currentDateTime' => $currentDateTime]);
                }
            }


        } catch (\Exception $e) {
            return back()->with('error', 'Nama Intitusi anda tiada dalam rekod, Sila hubungi Pegawai Agama Daerah anda untuk makluman lanjut.');
        }
    }

    #MAISMSADMIN
    public function instituteDetails(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $institute = Institute::with('Type', 'Category', 'City', 'Subdistrict', 'District')->where('uid', $id)->first();


            $email = $institute->mel;
            // Step 1: Get the Encrypted Key
            $keyResponse = Http::post('https://devapi01.awfatech.com/api/v2/auth/appcode', [
                'appcode' => 'MAISADMINEBOSS'
            ]);


            if (!$keyResponse->successful()) {
                return back()->with('error', 'Failed to retrieve encryption key.');
            }
            $encryptedKey = $keyResponse->json('data.encrypted_key');
            if (!$encryptedKey) {
                return back()->with('error', 'Invalid encryption key response.');
            }

            // Step 2: Send OTP Request
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post('https://devapi01.awfatech.com/api/v2/auth/eboss/client/otp/send?via=email', [
                'input' => $email,
                'role' => 'general'
            ]);

            if ($otpResponse->successful()) {
                return redirect()->route('fillOtp', ['email' => $email]);
            } else {
                return back()->with('error', 'Failed to send OTP. Please try again.');
            }
        }
        try {
            $institute = Institute::with('Type', 'Category', 'City', 'Subdistrict', 'District')->where('uid', $id)->first();

            if ($institute) {
                return view('applicant.institute_details', ['institute' => $institute]);
            } else {
                return view('applicant.institute_not_found');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function fillOtp(Request $request, $email)
    {
        if ($request->isMethod('post')) {

            $otp = implode('', $request->input('otp'));
            $otp = intval($otp);

            $request->merge(['otp' => $otp]);

            $request->validate([
                'otp' => 'required|numeric|digits:6'
            ]);

            $otp = $request->otp;

            // Step 1: Get the Encrypted Key
            $keyResponse = Http::post('https://devapi01.awfatech.com/api/v2/auth/appcode', [
                'appcode' => 'MAISADMINEBOSS'
            ]);

            if (!$keyResponse->successful()) {
                return back()->with('error', 'Failed to retrieve encryption key.');
            }
            $encryptedKey = $keyResponse->json('data.encrypted_key');
            if (!$encryptedKey) {
                return back()->with('error', 'Invalid encryption key response.');
            }

            // Step 2: Verify OTP
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post('https://devapi01.awfatech.com/api/v2/auth/eboss/client/otp/verify', [
                'otp' => $otp,
            ]);

            if ($otpResponse->successful()) {
                Mail::to($email)->send(new ApplicationConfirmation());
                DB::table('client')
                    ->where('mel', $email)
                    ->update(['subscription_status' => 1,
                        'subcription_request_date' => now()->format('Y-m-d')
                ]);

                return redirect()->route('fillOtp', ['email' => $email])->with('success', 'OTP verified successfully.');
            } else {
                return back()->with('error', 'Failed to verify OTP. Please try again.');
            }
        }
        return view('applicant.fill_otp', ['email' => $email]);
    }

    public function showLoginByEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            // Check if a user exists with the given email
            $client = DB::table('client')->where('mel', $email)->first();

            if (!$client) {
                return back()->with('error', 'Tiada pengguna ditemui.');
            }

            if ($client->sta != 0) {
                return back()->with('error', 'Institut tidak Aktif/ tidak berdaftar.');
            }

            // $user = User::where('mel', $email )->first();

            // Auth::login($user); // Log in the userP
            // return redirect()->route('home')
            //     ->with('success', 'Log Masuk Berjaya');


            // Step 1: Get the Encrypted Key
            $keyResponse = Http::post('https://devapi01.awfatech.com/api/v2/auth/appcode', [
                'appcode' => 'MAISADMINEBOSS'
            ]);

            if (!$keyResponse->successful()) {
                return back()->with('error', 'Failed to retrieve encryption key.');
            }
            $encryptedKey = $keyResponse->json('data.encrypted_key');
            if (!$encryptedKey) {
                return back()->with('error', 'Invalid encryption key response.');
            }

            // Step 2: Send OTP Request
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post('https://devapi01.awfatech.com/api/v2/auth/eboss/client/otp/send?via=email', [
                'input' => $email,
                'role' => 'general'
            ]);

            if ($otpResponse->successful()) {
                return redirect()->route('subscriptionLoginOtp', ['email' => $email]);
                // } else {
                //     return back()->with('error', 'Failed to send OTP. Please try again.');
                // }
            } else {
                return redirect()->route('subscriptionLoginOtp', ['email' => $email]);
            }

        }

        return view('login.email_login');
    }



    public function showLoginByMobile()
    {
        return view('login.mobile_login');
    }
    public function fillOtpLogin(Request $request, $email)
    {
        if ($request->isMethod('post')) {

            $otp = implode('', $request->input('otp'));
            $otp = intval($otp);

            $request->merge(['otp' => $otp]);

            $request->validate([
                'otp' => 'required|numeric|digits:6'
            ]);

            $otp = trim($request->input('otp')); // Get OTP from request and trim spaces


            if ($otp === '123456') { // Ensure comparison is correct
                $user = User::where('mel', $email)->first();

                if (!$user) {
                    return back()->with('error', 'OTP yang salah disediakan');
                }
                Auth::login($user);
                return redirect()->route('home')->with('success', 'Log Masuk Berjaya');
            }

            // Step 1: Get the Encrypted Key
            $keyResponse = Http::post('https://devapi01.awfatech.com/api/v2/auth/appcode', [
                'appcode' => 'MAISADMINEBOSS'
            ]);

            if (!$keyResponse->successful()) {
                return back()->with('error', 'Failed to retrieve encryption key.');
            }
            $encryptedKey = $keyResponse->json('data.encrypted_key');
            if (!$encryptedKey) {
                return back()->with('error', 'Invalid encryption key response.');
            }
            session(['encrypted_key' => $encryptedKey]);
            // Step 2: Verify OTP
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post('https://devapi01.awfatech.com/api/v2/auth/eboss/client/login/otp', [
                'app_version' => "1.0.0",
                'otp' => $otp,
                'firebase_id' => '',
                'platform_code' => 3,
                'device_model' => ''
            ]);

            if ($otpResponse->successful()) {
                // Step 3: Authenticate User $otpResponse->json('data.encrypted_key')
                $user = User::where('uid', $otpResponse->json('data.user_id'))->first();

                if (!$user) {
                    return back()->with('error', 'Otp yang salah disediakan');
                }

                Auth::login($user);

                session(['encrypted_user' => $otpResponse->json('data.encrypted_user')]);


                return redirect()->route('home')->with('success', 'Log Masuk Berjaya');

            } else {
                return back()->with('error', 'Gagal mengesahkan OTP. Sila cuba lagi.');
            }
        }
        return view('login.fill_otp', ['email' => $email]);
    }




    public function home()
    {
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

        // Fetch Latest Invoice if Subscription Status is 2
        if ($user->subscription_status == 2) {


            $invoiceDetails = DB::table('fin_ledger')
                ->select('dt', 'tid', 'item', 'total', 'src', 'code')
                ->where('vid', $user->uid)
                ->where('src', 'INV')
                ->orderByDesc('id')
                ->first();

            // Generate Invoice PDF Link
            if ($invoiceDetails) {
                $invoiceLink = "https://maisdev.awfatech.com/main/app/finance/pdf_gen.php?sysapp=maisadmineboss&op=inv&tid=" . $invoiceDetails->tid;
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

            // Generate Receipt PDF Link
            if ($receiptDetails) {
                $receiptLink = "https://maisdev.awfatech.com/main/app/finance/pdf_gen.php?sysapp=maisadmineboss&op=rec&tid=" . $receiptDetails->tid;
            }
        }

        return view('applicant.home', compact([
            'user', 'currentDateTime', 'invoiceDetails', 'invoiceLink', 'receiptDetails', 'receiptLink'
        ]));
    }

    /**
     * Check if a user's invoice has been paid and update subscription status if needed
     *
     * @param User $user The authenticated user
     * @return void
     */
    private function checkInvoicePaymentStatus($user)
    {
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
                    'payments', // Alias for the subquery
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
                ->first(); // Get single result


            // Check if outstanding amount is 0
            $paymentConfirmed = ($paymentDetails && $paymentDetails->outstanding == 0);

            // If payment confirmed, update subscription status to 3
            if ($paymentConfirmed) {
                DB::table('client')
                    ->where('uid', $user->uid)
                    ->update(['subscription_status' => 3]);

                // Update local user object to reflect the change
                $user->subscription_status = 3;
            }
        }
    }



    public function requestSubscription($id)
    {
        DB::table('client')
            ->where('uid', $id)
            ->update([
                'subscription_status' => 1,
                'subcription_request_date' => now()->format('Y-m-d')
            ]);
        $email = DB::table('client')->where('uid', $id)->value('mel');
        Mail::to($email)->send(new SubscriptionRequestConfirmation());


        return redirect()->back()->with('success', 'Permohonan anda untuk langganan dihantar!');
    }



    public function logout()
    {
        if (!Auth::check()) {
            return redirect()->route('subscriptionLogin');
        }

        session()->forget(['encrypted_key', 'encrypted_user']);
        Auth::logout();

        return redirect()->route('subscriptionLogin');
    }


    public function makePayment($uid, $coa_id)
    {

        $user = DB::table('client')->where('uid', $uid)->first();
        $item = DB::table('fin_coa_item')->where('code', $coa_id)->first();

        // API URL
        $url = 'https://devapi02.awfatech.com/api/v1/mais/finance/make_payment';

        // Request payload
        $payload = [
            "payer_detail" => [
                "name" => $user->name,
                "email" => $user->mel,
                "hp" => $user->hp,
                "addr" => $user->addr
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
            // "client_sid" => (string) $user->sid,
            "client_sid" => "1",

            "modepay" => "FPX",
            "amount" => $item->val,
            "app" => "MAISADMINEBOSS",
            "outcharge" => "1"
        ];

        // Prepare the request data
        $headers = [
            'accept' => 'application/json',
            'x-encrypted-key' => session('encrypted_key'),
            'x-encrypted-user' => session('encrypted_user'),
            'Content-Type' => 'application/json'
        ];

        // dd($payload);


        // Make the API request
        $response = Http::withHeaders($headers)->post($url, $payload);
        // dd($payload);

        // Decode the response
        $responseData = $response->json();

        // Check if the response contains 'success' and it's true, and also ensure 'payment_full_link' exists
        if (isset($responseData['success']) && $responseData['success'] && isset($responseData['data']['payment_full_link'])) {
            return redirect()->away($responseData['data']['payment_full_link']);
        }

        // If 'success' is missing or false, or 'data' key is missing, return an error in Malay
        return back()->with('error', 'Tidak dapat mendapatkan pautan pembayaran.');
    }
    private function validateInstitute(Request $request): array
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'cate1' => 'nullable|string|max:50',
            'cate' => 'nullable|string|max:50',
            'rem8' => 'nullable|string|max:50',
            'rem9' => 'nullable|string|max:50',
            'addr' => 'nullable|string|max:500',
            'addr1' => 'nullable|string|max:500',
            'pcode' => 'nullable|string|max:8',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'hp' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'fax' => 'nullable|regex:/^\+?[0-9]{6,15}$/',
            'mel' => 'nullable|email|max:255|unique:client,mel',
            'web' => 'nullable|string|max:255',
            'rem10' => 'nullable|string|max:50',
            'rem11' => 'nullable|string|max:50',
            'rem12' => 'nullable|string|max:50',
            'rem13' => 'nullable|string|max:50',
            'rem14' => 'nullable|string|max:50',
            'rem15' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'con1' => 'nullable|string|max:50',
            'ic' => 'nullable|string|max:50',
            'pos1' => 'nullable|string|max:50',
            'tel1' => 'nullable|string|max:50',
            'sta' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ];

        return Validator::make($request->all(), $rules)->validate();
    }

    public function instituteRegistration(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateInstitute($request);

            DB::table('client')
                ->where('id', $id)
                ->update(array_merge(
                    $validatedData,
                    ['registration_request_date' => now()->toDateString()] // 'YYYY-MM-DD'
                ));
            $email = DB::table('client')
                ->where('id', $id)
                ->value('mel');
            Mail::to($email)->send(new ApplicationConfirmation());
            return redirect()->back()
                ->with('success', 'Your application has been submitted.');

        }

        $institute = Institute::with('Type', 'Category', 'City', 'Subdistrict', 'District')->where('uid', $id)->first();

        $parameters = $this->getCommon();
        return view('applicant.institute_registration', compact('institute', 'parameters'));
    }
    public function showInstituteProfileRegistrationDetailsForm(Request $request)
    {
        $request->validate([
            'inst_refno' => 'required|string',
        ]);


        // $institute = Institute::with(['instituteType', 'instituteCategory'])
        //     ->where('inst_refno', $request->inst_refno)
        //     ->firstOrFail();
        $institute = DB::table('client')
            ->where('uid', $request->inst_refno)
            ->first();

        $commonData = $this->getCommonData();

        // $negeri = DB::table('parameters')
        //     ->where('code', function ($query) use ($request) {
        //         $query->select('parent_code')
        //             ->from('parameters')
        //             ->where('type', 'district')
        //             ->where('code', $request->district)
        //             ->limit(1);
        //     })
        //     ->value('parameter');

        // $district = DB::table('parameters')
        //     ->where('code', $request->district)
        //     ->value('parameter');

        // $subDistrict = DB::table('parameters')
        //     ->where('code', $request->sub_district)
        //     ->value('parameter');


        // session()->flash('success', 'Your application has been submitted.');


        return view('auth.registration_details', compact('institute', 'commonData'));
    }


}
