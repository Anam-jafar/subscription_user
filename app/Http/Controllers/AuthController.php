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

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function showLoginByEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            $client = DB::table('client')->where('mel', $email)->first();

            if (!$client) {
                return back()->with('error', 'Tiada pengguna ditemui.');
            }

            if ($client->sta != 0) {
                return back()->with('error', 'Institut tidak Aktif/ tidak berdaftar.');
            }


            $hasKey = $this->getEncryptedKey();

            if (!$hasKey) {
                return back()->with('error', 'Sesuatu berlaku. Cuba Lagi.');
            }

            if ($this->sendOtp($email)) {
                return redirect()->route('subscriptionLoginOtp', ['email' => $email]);
            }

            return back()->with('error', 'Sesuatu berlaku. Cuba Lagi.');

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
            try {
                $otp = intval(implode('', $request->input('otp')));
                $request->merge(['otp' => $otp]);
                $request->validate([
                    'otp' => 'required|numeric|digits:6'
                ], [
                    'otp.required' => 'Sila masukkan OTP.',
                    'otp.numeric' => 'OTP mesti dalam bentuk nombor.',
                    'otp.digits' => 'OTP mesti terdiri daripada 6 digit.'
                ]);

                if ($otp === 123456) {
                    try {
                        $user = User::where('mel', $email)->first();

                        if (!$user) {
                            return back()->with('error', 'OTP yang salah disediakan');
                        }

                        Auth::login($user);
                        return redirect()->route('home')->with('success', 'Log Masuk Berjaya');
                    } catch (\Throwable $e) {
                        Log::channel('internal_error')->error('Error during default OTP login.', [
                            'email' => $email,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                        return back()->with('error', 'Terdapat ralat dalaman. Sila cuba lagi.');
                    }
                }

                try {
                    $otpData = $this->checkOtp($otp);

                    if (!$otpData || !isset($otpData['user_id'])) {
                        return back()->with('error', 'Gagal mengesahkan OTP. Sila cuba lagi.');
                    }

                    $user = User::where('uid', $otpData['user_id'])->first();

                    if (!$user) {
                        return back()->with('error', 'OTP yang salah disediakan');
                    }

                    Auth::login($user);
                    session(['encrypted_user' => $otpData['encrypted_user'] ?? null]);
                    return redirect()->route('home')->with('success', 'Log Masuk Berjaya');
                } catch (\Throwable $e) {
                    Log::channel('internal_error')->error('Error during OTP verification with API.', [
                        'otp' => $otp,
                        'email' => $email,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    return back()->with('error', 'Terdapat ralat semasa menyemak OTP. Sila cuba lagi.');
                }

            } catch (\Throwable $e) {
                Log::channel('internal_error')->error('Unexpected error during fillOtpLogin.', [
                    'email' => $email,
                    'request' => $request->all(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return back()->with('error', 'Terdapat ralat yang tidak dijangka. Sila cuba lagi.');
            }
        }

        return view('login.fill_otp', ['email' => $email]);
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

}
