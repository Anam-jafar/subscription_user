<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Institute;
use App\Models\InstituteProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;



class AuthController extends Controller
{

    private function getCommonData()
    {
        return [
            'institutes' => DB::table('parameters')
                ->where('type', 'institute')
                ->pluck('parameter', 'code')
                ->toArray(),
            'institute_types' => DB::table('parameters')
                ->where('type', 'institute_type')
                ->pluck('parameter', 'code')
                ->toArray(),
            'districts' => DB::table('parameters')
                ->where('type', 'district')
                ->pluck('parameter', 'code')
                ->toArray(),
            'sub_districts' => DB::table('parameters')
                ->where('type', 'sub_district')
                ->pluck('parameter', 'code')
                ->toArray(),
            'cities' => DB::table('parameters')
                ->where('type', 'city')
                ->pluck('parameter', 'code')
                ->toArray(),
            'states' => DB::table('parameters')
                ->where('type', 'state')
                ->pluck('parameter', 'code')
                ->toArray(),
            'positions' => DB::table('parameters')
                ->where('type', 'externalposition')
                ->pluck('parameter', 'code')
                ->toArray(),
            'statuses' => DB::table('parameters')
                ->where('type', 'status')
                ->pluck('parameter', 'code')
                ->toArray(),

        ];
    }

    public function showLoginForm()
    {
    // Set the timezone to Kuala Lumpur
    $currentDateTime = Carbon::now('Asia/Kuala_Lumpur');

    // Set Arabic locale and format the date in Arabic numerals
    $arabicDateTime = $currentDateTime->locale('ar')->isoFormat('D MMMM YYYY / HH:mm:ss');

    // Set English locale
    $englishDateTime = $currentDateTime->locale('en')->isoFormat('D MMMM YYYY / HH:mm:ss');

            return view('auth.login', compact('arabicDateTime', 'englishDateTime'));
    }

    public function showLoginFormAdmin()
    {
            // Set the timezone to Kuala Lumpur
    $currentDateTime = Carbon::now('Asia/Kuala_Lumpur');

    // Set Arabic locale and format the date in Arabic numerals
    $arabicDateTime = $currentDateTime->locale('ar')->isoFormat('D MMMM YYYY / HH:mm:ss');

    // Set English locale
    $englishDateTime = $currentDateTime->locale('en')->isoFormat('D MMMM YYYY / HH:mm:ss');
        return view('auth.login_admin', compact('arabicDateTime', 'englishDateTime'));
    }

    public function showInstituteProfileRegisterForm()
    {
        $commonData = $this->getCommonData();

        $institutesWithoutProfile = DB::table('institutes')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('profile_inst')
                    ->whereColumn('profile_inst.inst_refno', 'institutes.inst_refno');
            })
            ->pluck('inst_name', 'inst_refno'); 

        $commonData['unregistered_institutes'] = $institutesWithoutProfile;

        return view('auth.register', compact('commonData'));
    }

    public function showInstituteProfileRegistrationDetailsForm(Request $request)
    {
        $request->validate([
            'inst_refno' => 'required|string',
        ]);


        $institute = Institute::with(['instituteType', 'instituteCategory'])
            ->where('inst_refno', $request->inst_refno)
            ->firstOrFail(); 

        $commonData = $this->getCommonData();

        $negeri = DB::table('parameters')
            ->where('code', function ($query) use ($request) {
                $query->select('parent_code')
                    ->from('parameters')
                    ->where('type', 'district')
                    ->where('code', $request->district)
                    ->limit(1);
            })
            ->value('parameter');

        $district = DB::table('parameters')
            ->where('code', $request->district)
            ->value('parameter');

        $subDistrict = DB::table('parameters')
            ->where('code', $request->sub_district)
            ->value('parameter');


        // session()->flash('success', 'Your application has been submitted.');


        return view('auth.registration_details', compact('institute', 'commonData', 'negeri', 'district', 'subDistrict'));
    }

    public function instituteProfileRegister(Request $request)
    {
        $request->validate([
            'inst_refno' => 'required|string',
            'email' => 'required|string',
            'incharge_name' => 'required|string',
            'incharge_nric' => 'required|string',
            'incharge_position' => 'required|string',
            'incharge_mobile_no' => 'required|string',
        ]);

        $user = User::create([
            'uid' => uniqid(),
            'nric_number' => $request->incharge_nric,
            'fullname' => $request->incharge_name,
            'mobile_number' => $request->incharge_mobile_no,
            'email' => $request->email,
            'position' => $request->incharge_position,
            'status' => 1,
            'user_group' => 'USER',
        ]);

        $instituteProfile = InstituteProfile::create([
            'inst_refno' => $request->inst_refno, // Required field
            'address_line_1' => $request->address_line_1 ?? null,
            'address_line_2' => $request->address_line_2 ?? null,
            'postcode' => $request->postcode ?? null,
            'city' => $request->city ?? null,
            'state' => $request->state ?? null,
            'telephone_no' => $request->telephone_no ?? null,
            'fax_no' => $request->fax_no ?? null,
            'email' => $request->email,
            'web_url' => $request->web_url ?? null,
            'media_social' => $request->media_social ?? null,
            'dun' => $request->dun ?? null,
            'parliament' => $request->parliament ?? null,
            'institutional_area' => $request->institutional_area ?? null,
            'total_capacity' => $request->total_capacity ?? null,
            'inst_coordinate' => $request->inst_coordinate ?? null,
            'jatums_date' => $request->jatums_date ?? null,
            'person_incharge' => $user->uid, // Required field
            'created_by' => $user->uid ?? null,
            'updated_by' => $user->uid ?? null,
            'status' => 1,
        ]);


        return redirect()->route('showInstituteProfileRegistrationDetailsForm', ['inst_refno' => $instituteProfile->inst_refno])
        ->with('success', 'Your application has been submitted.');
    }



    public function resetPassword(Request $request)
    {
        if($request->method() == 'POST') {
            $request->validate([
                'password' => 'required|string',
                'confirm_password' => 'required|string|same:password',
            ]);

            $user = Auth::user();
            $user->update([
                'password' => bcrypt($request->password),
                'password_set' => 1,
            ]);
            
            if($user->user_group == "ADMIN"){
            return redirect()->route('loginAdmin')->with('success', 'Kata Laluan Dikemaskini. Log masuk semula dengan kata laluan baharu.');
            }else{
            return redirect()->route('login')->with('success', 'Kata Laluan Dikemaskini. Log masuk semula dengan kata laluan baharu.');

            }

        }
        return view('auth.reset_password');
    }

public function forgetPassword(Request $request)
{
    if ($request->isMethod('POST')) {
        // Validate email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'No user exists with this email.');
        }

        // Generate a 6-digit random reset token
        $resetToken = mt_rand(100000, 999999);

        // Store the reset token in the database
        $user->reset_token = $resetToken;
        $user->save();

        // Send reset token via email
        Mail::to($user->email)->send(new ResetPasswordMail($resetToken));

        return redirect()->back()->with('success', 'Reset token sent to your email.');
    }

    return view('auth.forget_password');
}




    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            if (Auth::user()->password_set == 0) {
                return redirect()->route('resetPassword');
            }

            if (Auth::user()->user_group == 'ADMIN'){
                return redirect()->route('adminIndex');
            }
        return redirect()->route('index');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function registerUser(Request $request)
    {
        if ($request->method() == 'GET') {
            $departments = DB::table('parameters')->where('type', 'department')->pluck('parameter', 'code');
            $positions = DB::table('parameters')->where('type', 'position')->pluck('parameter', 'code');
            $districts = DB::table('parameters')->where('type', 'district')->pluck('parameter', 'code');
            $userGroups = DB::table('parameters')->where('type', 'usergroup')->pluck('parameter', 'code');
            $statuses = DB::table('parameters')->where('type', 'status')->pluck('parameter', 'code');

            return view('admin.user_registeration', compact('departments', 'positions', 'districts', 'userGroups', 'statuses'));
        }

        $request->validate([
            'nric_number' => 'required|string',
            'fullname' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'position' => 'required|string',
            'department' => 'required|string',
            'district_access' => 'required|string',
            'user_group' => 'required|string',
            'status' => 'nullable|string',
            'profile_img' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt('12345');
        $data['uid'] = uniqid();
        $data['created_by'] = Auth::user()->uid;
        $data['updated_by'] = Auth::user()->uid;


        $user = User::create($data);

        return redirect()->route('userList')->with('success', 'User registered successfully!');
    }


    public function profile()
    {

        $user = Auth::user(); 


        return view('auth.profile', compact('user'));
    }

    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $user->update($request->all());

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();


        if (md5($request->current_password) !== $user->pass) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'pass' => md5($request->new_password),  
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    public function activityLogs()
    {
        $perPage = request()->get('per_page', 10); 


        $logs = DB::table('sys_log as s')
            ->rightJoin('usr as u', 's.uid', '=', 'u.uid')
            ->select('s.*', 'u.uid', 'u.name', 'u.ic')
            ->paginate($perPage);

        return view('auth.activity_logs', ['logs' => $logs, 'perPage' => $perPage]);
    }


}
