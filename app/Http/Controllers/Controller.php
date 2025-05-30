<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Parameter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected function getCommon()
    {
        return [
            'types' => Parameter::where('grp', 'clientcate1')
                ->pluck('prm', 'code')
                ->toArray(),
            'categories' => Parameter::where('grp', 'type_CLIENT')
                ->pluck('prm', 'code')
                ->toArray(),
            'districts' => Parameter::where('grp', 'district')
                ->pluck('prm', 'code')
                ->toArray(),
            'subdistricts' => Parameter::where('grp', 'subdistrict')
                ->pluck('prm', 'code')
                ->toArray(),
            'cities' => Parameter::where('grp', 'city')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_positions' => Parameter::where('grp', 'user_position')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_statuses' => Parameter::where('grp', 'clientstatus')
                ->pluck('prm', 'val')
                ->toArray(),
            'statements' => Parameter::where('grp', 'statement')
                ->pluck('prm', 'code')
                ->toArray(),
            'audit_types' => Parameter::where('grp', 'audit_type')
                ->pluck('prm', 'code')
                ->toArray(),

        ];
    }


    protected function getEncryptedKey(): bool
    {
        if (session()->has('encrypted_key')) {
            return true;
        }

        $appcode = config('services.awfatech.appcode');
        $url = config('services.awfatech.appcode_url');

        $keyResponse = Http::post($url, [
            'appcode' => $appcode,
        ]);

        if (!$keyResponse->successful()) {
            Log::channel('external_api_error')->error('Appcode Fetch Failed', [
                'endpoint' => $url,
                'appcode' => $appcode,
                'response_status' => $keyResponse->status(),
                'response_body' => $keyResponse->json(),
            ]);

            return false;
        }

        $encryptedKey = $keyResponse->json('data.encrypted_key');

        if (!$encryptedKey) {
            Log::channel('external_api_error')->error('Appcode Fetch Failed: No encrypted_key in response', [
                'endpoint' => $url,
                'appcode' => $appcode,
                'response_body' => $keyResponse->json(),
            ]);

            return false;
        }

        session(['encrypted_key' => $encryptedKey]);

        return true;
    }


    protected function sendOtp(string $email): bool
    {
        $encryptedKey = session('encrypted_key');

        if (!$encryptedKey) {
            Log::channel('external_api_error')->warning('Send OTP skipped: No encrypted key in session.');
            return false;
        }

        $url = config('services.awfatech.send_otp_url');

        $response = Http::withHeaders([
            'x-encrypted-key' => $encryptedKey
        ])->post($url, [
            'input' => $email,
            'role' => 'general'
        ]);

        if (!$response->successful()) {
            Log::channel('external_api_error')->error('Send OTP API failed', [
                'endpoint' => $url,
                'email' => $email,
                'response_status' => $response->status(),
                'response_body' => $response->json(),
            ]);

            return false;
        }

        return true;
    }


    protected function checkOtp(string $otp): ?array
    {
        $encryptedKey = session('encrypted_key');

        if (!$encryptedKey) {
            Log::channel('external_api_error')->warning('Check OTP skipped: No encrypted key in session.');
            return null;
        }

        $url = config('services.awfatech.check_otp_url');

        $response = Http::withHeaders([
            'x-encrypted-key' => $encryptedKey
        ])->post($url, [
            'app_version' => '1.0.0',
            'otp' => $otp,
            'firebase_id' => '',
            'platform_code' => 3,
            'device_model' => ''
        ]);

        if (!$response->successful()) {
            Log::channel('external_api_error')->error('Check OTP API failed', [
                'endpoint' => $url,
                'otp' => $otp,
                'response_status' => $response->status(),
                'response_body' => $response->json(),
            ]);

            return null;
        }

        return $response->json('data');
    }

}
