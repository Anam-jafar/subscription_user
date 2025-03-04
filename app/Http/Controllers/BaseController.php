<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApplicationConfirmation;
use Illuminate\Support\Facades\Mail;



class BaseController extends Controller
{
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
            ->pluck('name', 'uid'); 

        return response()->json($clients);
    }
    public function getCities()
    {
        try {
            $cities = DB::table('client')
                ->distinct()
                ->pluck('city');

            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getInstitutesByCity(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|min:1',
                'search' => 'nullable|string|min:1'
            ]);

            $query = DB::table('client')->where('city', $request->city);

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
            $institute = DB::table('client')
                ->where('name', $request->institute_name)
                ->where('uid', $request->institute_refno)
                ->first();
            // Get current date and time
            $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month name year time with AM/PM

            if ($institute->subscription_status != 0) {
                return view('applicant.institute_subscribed', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);
            } else {
                return view('applicant.institute_not_subscribed', ['institute' => $institute,'currentDateTime' => $currentDateTime]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Untuk meneruskan anda mesti memilih institut');
        }
    }

    #MAISMSADMIN
    public function instituteDetails(Request $request, $id)
    {
        if($request->isMethod('post')){

            $institute = DB::table('client')->where('uid', $id)->first();

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
            $institute = DB::table('client')->where('uid', $id)->first();

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
        if($request->isMethod('post')) {

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
                    ->update(['subscription_status' => 1]);  

                return redirect()->route('fillOtp', ['email' => $email])->with('success', 'OTP verified successfully.');
            } else {
                return back()->with('error', 'Failed to verify OTP. Please try again.');
            }
        }
        return view('applicant.fill_otp');
    }

    public function showLoginByEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            $client = DB::table('client')->where('mel', $email)->first();
            if (in_array($client->subscription_status, [0, 1])) {
                return back()->with('error', 'Institut belum melanggan perkhidmatan kami.');
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

            // Step 2: Send OTP Request
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post('https://devapi01.awfatech.com/api/v2/auth/eboss/client/otp/send?via=email', [
                'input' => $email,
                'role' => 'general'
            ]);

            if ($otpResponse->successful()) {
                return redirect()->route('subscriptionLoginOtp');
            } else {
                return back()->with('error', 'Failed to send OTP. Please try again.');
            }
        }

        return view('login.email_login');
    }


    public function showLoginByMobile()
    {
        return view('login.mobile_login');
    }

    public function fillOtpLogin(Request $request)
    {
        if($request->isMethod('post')) {

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
                    return back()->with('error', 'User not found.');
                }

                Auth::login($user); // Log in the user

                session(['encrypted_user' => $otpResponse->json('data.encrypted_user')]);


                if ($user->subscription_status == 2) {
                    return redirect()->route('activateSubscription', ['id' => $user->uid])->with('success', 'Log Masuk Berjaya');
                } elseif ($user->subscription_status == 3) {
                    return redirect()->route('activatedSubscription', ['id' => $user->uid])->with('success', 'Log Masuk Berjaya');
                }
            } else {
                return back()->with('error', 'Failed to verify OTP. Please try again.');
            }
        }
        return view('login.fill_otp');
    }

    public function activateSubscription($id) 
    {
        $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month name year time with AM/PM


        $invoiceDetails = DB::table('fin_ledger')
            ->select('dt', 'tid', 'item', 'total', 'src', 'code')
            ->where('vid', $id)
            ->where('src', 'INV')
            ->first();


        $user = Auth::user();

        $user_id = $user->uid;
        $coa_id = $invoiceDetails->code;
        return view('applicant.activate_subscription', compact(['user', 'currentDateTime', 'invoiceDetails']));
    }

    public function activatedSubscription($id) 
    {
        $currentDateTime = now('Asia/Kuala_Lumpur')->format('d F Y h:i A'); // Format: Date Month name year time with AM/PM


        $invoiceDetails = DB::table('fin_ledger')
            ->select('dt', 'tid', 'item', 'total', 'src', 'code')
            ->where('vid', $id)
            ->where('src', 'REC')
            ->first();


        $user = Auth::user();
        return view('applicant.activated_subscription', compact(['user', 'currentDateTime', 'invoiceDetails']));
    }

    public function logout()
    {
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
            "app" => "EBOSS",
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


        // Decode the response
        $responseData = $response->json();
        
        // Check if request was successful
        if ($responseData['success'] && isset($responseData['data']['payment_full_link'])) {
            return redirect()->away($responseData['data']['payment_full_link']);
        } else {
            return back()->with('error', 'Payment failed. Please try again.');
        }
    }


}
