<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;

class Institutecontroller extends Controller
{
    private $parameterDictionary;

    public function __construct()
    {
        $this->initializeParameters();
    }

    private function initializeParameters()
    {
        $parameterTypes = ['institute', 'institute_type', 'district', 'sub_district'];
        $parameters = DB::table('parameters')
            ->whereIn('type', $parameterTypes)
            ->get();

        $this->parameterDictionary = [];
        foreach ($parameters as $parameter) {
            $this->parameterDictionary[$parameter->code] = $parameter->parameter;
        }
    }

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
        ];
    }


    private function mapInstituteFields($institutes, $fields)
    {
        $institutes->getCollection()->transform(function ($institute) use ($fields) {
            foreach ($fields as $field) {
                if (isset($this->parameterDictionary[$institute->$field])) {
                    $institute->$field = $this->parameterDictionary[$institute->$field];
                }
            }
            return $institute;
        });

        return $institutes;
    }

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

        return view('institute.list', compact('institutes', 'commonData'));
    }


    public function instituteCreate(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'inst_category' => 'required|string',
                'inst_type' => 'required|string',
                'inst_name' => 'required|string',
                'inst_district' => 'required|string',
                'inst_sub_district' => 'required|string',
            ]);
            $institute = new Institute();
            $institute->inst_refno = uniqid();
            $institute->inst_category = $request->inst_category;
            $institute->inst_type = $request->inst_type;
            $institute->inst_name = $request->inst_name;
            $institute->inst_district = $request->inst_district;
            $institute->inst_sub_district = $request->inst_sub_district;
            $institute->isdelete = 0;
            $institute->created_by = auth()->user()->uid;
            $institute->updated_by = auth()->user()->uid;
            $institute->save();

            return redirect()->route('instituteList')->with('success', 'Institusi Dicipta dengan jayanya');
        }

        $commonData = $this->getCommonData();

        return view('institute.create', compact('commonData'));
    }

    public function instituteUpdate(Request $request, $id)
    {
        $institute = Institute::find($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'inst_category' => 'required|string',
                'inst_type' => 'required|string',
                'inst_name' => 'required|string',
                'inst_district' => 'required|string',
                'inst_sub_district' => 'required|string',
            ]);

            $institute->inst_category = $request->inst_category;
            $institute->inst_type = $request->inst_type;
            $institute->inst_name = $request->inst_name;
            $institute->inst_district = $request->inst_district;
            $institute->inst_sub_district = $request->inst_sub_district;
            $institute->updated_by = auth()->user()->uid;
            $institute->save();

            return redirect()->route('instituteList')->with('success', 'Institusi berjaya dikemas kini');

        }

        $commonData = $this->getCommonData();

        return view('institute.update', compact('institute', 'commonData'));
    }

    // app/Http/Controllers/InstituteController.php
public function getInstituteTypes($instituteCode)
{
    $instituteTypes = DB::table('parameters')
        ->where('type', 'institute_type')
        ->where('parent_code', $instituteCode)
        ->pluck('parameter', 'code');
    
    return response()->json($instituteTypes);
}

public function getSubDistricts($districtCode)
{
    $subDistricts = DB::table('parameters')
        ->where('type', 'sub_district')
        ->where('parent_code', $districtCode)
        ->pluck('parameter', 'code');
    
    return response()->json($subDistricts);
}

public function searchInstitutes(Request $request)
{
    $query = DB::table('institutes')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('profile_inst')
                ->whereColumn('profile_inst.inst_refno', 'institutes.inst_refno');
        });

    if ($request->institute_type) {
        $query->where('inst_type', $request->institute_type);
    }
    
    if ($request->sub_district) {
        $query->where('inst_sub_district', $request->sub_district);
    }

    if ($request->search) {
        $query->where('inst_name', 'LIKE', '%' . $request->search . '%');
    }

    $institutes = $query->pluck('inst_name', 'inst_refno');
    return response()->json($institutes);
}

}
