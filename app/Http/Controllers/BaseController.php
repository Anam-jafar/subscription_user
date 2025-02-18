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
                'institute_refno' => 'nullable|string|min:1',
            ]);

            $institute = DB::table('client')
                ->where('name', $request->institute_name)
                ->where('uid', $request->institute_refno)
                ->first();

            if ($institute) {
                return view('applicant.institute_subscribed', ['institute' => $institute]);
            } else {
                return view('applicant.institute_not_found');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


}
