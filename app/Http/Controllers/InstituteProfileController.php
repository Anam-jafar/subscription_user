<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\InstituteProfile;
use App\Models\Institute;
use App\Models\User;
use App\Mail\SendUserOtp;
use Illuminate\Support\Facades\Mail;

class InstituteProfileController extends Controller
{
    private $parameterDictionary;

    public function __construct()
    {
        $this->initializeParameters();
    }

    private function initializeParameters()
    {
        $parameterTypes = ['institute', 'institute_type', 'district', 'sub_district', 'city', 'state'];
        $parameters = DB::table('parameters')
            ->whereIn('type', $parameterTypes)
            ->get();

        $this->parameterDictionary = [];
        foreach ($parameters as $parameter) {
            $this->parameterDictionary[$parameter->code] = $parameter->parameter;
        }
    }

    public function instituteProfileList(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = InstituteProfile::where('status', 0);

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('institute', function ($q) use ($request) {
                $q->where('inst_name', 'like', '%' . $request->search . '%');
            });
        }

        $query->with(['institute', 'personIncharge'])
              ->orderBy('created_at', 'desc'); // Orders by created_at in descending order
;

        $institutes = $query->paginate($perPage);

        $institutes->getCollection()->transform(function ($institute) {
            $institute->name = $institute->institute->inst_name ?? null;
            $institute->incharge = $institute->personIncharge->fullname ?? null;
            $institute->type = $institute->institute->instituteType->parameter ?? null;
            $institute->number = $institute->personIncharge->mobile_number ?? null;
            $institute->email = $institute->email ;
            $institute->daerah = $institute->institute->district->parameter ?? null;
            $institute->mukim = $institute->institute->subDistrict->parameter ?? null;
            $institute->profile_status = $institute->status == 0 ? 'Aktif' : 'tadak aktif';
            return $institute;
        });

        return view('institute_profile.list', compact('institutes'));
    }

        public function instituteProfileRequestList(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = InstituteProfile::where('status', 1); // Inactive

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('institute', function ($q) use ($request) {
                $q->where('inst_name', 'like', '%' . $request->search . '%');
            });
        }

        $query->with(['institute', 'personIncharge'])
              ->orderBy('created_at', 'desc'); // Orders by created_at in descending order
;

        $institutes = $query->paginate($perPage);


        $institutes->getCollection()->transform(function ($institute) {
            $institute->name = $institute->institute->inst_name ?? null;
            $institute->incharge = $institute->personIncharge->fullname ?? null;
            $institute->type = $institute->institute->instituteType->parameter ?? null;
            $institute->created = $institute->created_at->format('d-m-Y');
            return $institute;
        });

        return view('institute_profile.req_list', compact('institutes'));
    }


    public function update(Request $request, $id)
    {
        $institute = InstituteProfile::with(['institute', 'personIncharge', 'instituteState', 'instituteCity'])->find($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|string',
            ]);

            $institute->email = $request->email;
            $institute->updated_by = Auth::user()->uid;
            $institute->created_by = Auth::user()->uid;
            $institute->status = 0;
            $institute->save();

            $user = User::where('uid', $institute->person_incharge)->first();

            $password = "";

            if ($user) {
                $user->status = 0;
                $password = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $user->password = bcrypt($password);
                $user->save();

            }

            Mail::to($user->email)->send(new SendUserOtp($user->email, $password));


            return redirect()->route('instituteProfileList')
                ->with('success', 'Profil Institusi Diluluskan. Mel dihantar kepada pengguna dengan OTP.');
        }

        return view('institute_profile.edit', compact('institute'));
    }

        public function updateByUser(Request $request)
    {
        $institute = Auth::user()->instituteProfile;

    if ($request->isMethod('post')) {

        $institute->fill($request->all()); // Isi data dari request
        $institute->updated_by = Auth::user()->uid;
        $institute->created_by = Auth::user()->uid;
        $institute->status = 0;
        $institute->save(); // Simpan ke dalam database

        return redirect()->route('index')->with('success', 'Maklumat institusi berjaya dikemas kini.');
    }

        return view('client.institute_profile', compact('institute'));
    }
}
