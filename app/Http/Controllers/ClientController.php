<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialStatement;

class ClientController extends Controller
{
public function index()
{   
    $draftStatements = auth()->user()->financialStatements()->where('submission_status', 'SS05')->get();
    $instituteType = auth()->user()->instituteProfile->institute->inst_type;


$latestSubmission = auth()->user()->financialStatements()
    ->where('submission_status', '!=', 'SS05')
    ->latest('created_at')
    ->first();

    return view('client.index', compact('draftStatements', 'latestSubmission', 'instituteType'));
}


    public function adminIndex()
    {
        if (Auth::user()->user_group !== 'ADMIN') {
            return abort(403, 'Unauthorized Access'); // Deny access
        }
        return view('client.admin_index');
    }

    public function instituteProfile()
    {
        
        return view('client.institute_profile');
    }

    public function reportCreate(){
        return view('client.report.create');
    
    }
        public function reportCreate_(){
        return view('client.report.create_');
    
    }

        public function reportView(){
        return view('client.report.view');
    
    }
        public function reportView_(){
        return view('client.report.view_');
    
    }
            public function _reportView_(){
        return view('client.report._view_');
    
    }
}
