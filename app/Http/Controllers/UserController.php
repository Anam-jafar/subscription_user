<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendUserOtp;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
        public function instituteList(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $query = Institute::query()
                      ->orderBy('created_at', 'desc'); // Orders by created_at in descending order
;

        if ($request->has('inst_category') && $request->inst_category != '') {
            $query->where('inst_category', $request->inst_category);
        }
        if ($request->has('inst_type') && $request->inst_type != '') {
            $query->where('inst_type', $request->inst_type);
        }
        if ($request->has('inst_district') && $request->inst_district != '') {
            $query->where('inst_district', $request->inst_district);
        }
        if ($request->has('inst_sub_district') && $request->inst_sub_district != '') {
            $query->where('inst_sub_district', $request->inst_sub_district);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('inst_name', 'like', '%' . $request->search . '%');
        }

        $institutes = $query->paginate($perPage);

        $fieldsToMap = ['inst_category', 'inst_type', 'inst_district', 'inst_sub_district'];
        $institutes = $this->mapInstituteFields($institutes, $fieldsToMap);

        $commonData = $this->getCommonData();

        return view('admin.institute.institute_list', compact('institutes', 'commonData'));
    }

    public function list(Request $request)
    {
        $perPage = $request->get('perpage', 10);

        $query = User::with(['userGroup', 'userStatus']) // Eager load relationships
                    ->orderBy('created_at', 'desc');

        // if ($request->has('inst_category') && $request->inst_category != '') {
        //     $query->where('inst_category', $request->inst_category);
        // }
        // if ($request->has('inst_type') && $request->inst_type != '') {
        //     $query->where('inst_type', $request->inst_type);
        // }
        // if ($request->has('inst_district') && $request->inst_district != '') {
        //     $query->where('inst_district', $request->inst_district);
        // }
        // if ($request->has('inst_sub_district') && $request->inst_sub_district != '') {
        //     $query->where('inst_sub_district', $request->inst_sub_district);
        // }

        if ($request->has('search') && $request->search != '') {
            $query->where('fullname', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate($perPage);

        $users->setCollection(
            $users->getCollection()->transform(function ($user) {
                $user->user_position = $user->userGroup->parameter ?? 'N/A';
                $user->user_status = $user->userStatus->parameter ?? 'N/A';
                return $user;
            })
        );

        return view('user.list', compact('users'));
    }

        public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $departments = DB::table('parameters')->where('type', 'department')->pluck('parameter', 'code');
            $positions = DB::table('parameters')->where('type', 'position')->pluck('parameter', 'code');
            $districts = DB::table('parameters')->where('type', 'district')->pluck('parameter', 'code');
            $userGroups = DB::table('parameters')->where('type', 'usergroup')->pluck('parameter', 'code');
            $statuses = DB::table('parameters')->where('type', 'status')->pluck('parameter', 'code');

            return view('user.create', compact('departments', 'positions', 'districts', 'userGroups', 'statuses'));
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

        $password = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $data = $request->all();
        $data['password'] = bcrypt($password);
        $data['uid'] = uniqid();
        $data['created_by'] = Auth::user()->uid;
        $data['updated_by'] = Auth::user()->uid;

        $user = User::create($data);

        Mail::to($user->email)->send(new SendUserOtp($user->email, $password));

        return redirect()->route('userList')->with('success', 'Dicipta Pengguna. Mel dihantar kepada pengguna dengan OTP.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);


        if ($request->isMethod('post')) {
            $request->validate([
            'nric_number' => 'required|string',
            'fullname' => 'required|string',
            'mobile_number' => 'required|string',
            // 'email' => 'required|string|email|unique:users,email',
            'position' => 'required|string',
            'department' => 'required|string',
            'district_access' => 'required|string',
            'user_group' => 'required|string',
            'status' => 'nullable|string',
            'profile_img' => 'nullable|string',
            ]);

            $data = $request->all();
        
            $data['updated_by'] = Auth::user()->uid;

            $user->update($data);


            return redirect()->route('userList')->with('success', 'Pengguna Berjaya dikemas kini');

        }

        $departments = DB::table('parameters')->where('type', 'department')->pluck('parameter', 'code');
        $positions = DB::table('parameters')->where('type', 'position')->pluck('parameter', 'code');
        $districts = DB::table('parameters')->where('type', 'district')->pluck('parameter', 'code');
        $userGroups = DB::table('parameters')->where('type', 'usergroup')->pluck('parameter', 'code');
        $statuses = DB::table('parameters')->where('type', 'status')->pluck('parameter', 'code');

        return view('user.update', compact('departments', 'positions', 'districts', 'userGroups', 'statuses', 'user'));

    }

}
