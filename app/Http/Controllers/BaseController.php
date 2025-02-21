<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

            if ($institute->isActivated == 1) {
                return view('applicant.institute_subscribed', ['institute' => $institute, 'currentDateTime' => $currentDateTime]);
            } else {
                return view('applicant.institute_not_subscribed', ['currentDateTime' => $currentDateTime]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Untuk meneruskan anda mesti memilih institut');
        }
    }


    public function instituteDetails($id)
    {
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

    public function fillOtp()
    {
        return view('applicant.fill_otp');
    }

    public function showLoginByEmail()
    {
        return view('login.email_login');
    }

    public function showLoginByMobile()
    {
        return view('login.mobile_login');
    }

    public function fillOtpLogin()
    {
        return view('login.fill_otp');
    }

    public function activateSubscription() 
    {
        return view('applicant.activate_subscription');
    }


}
