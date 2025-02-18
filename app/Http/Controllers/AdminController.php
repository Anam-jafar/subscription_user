<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;

class AdminController extends Controller
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
        $query = Institute::query();

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

            return redirect()->route('instituteList');
        }

        $commonData = $this->getCommonData();

        return view('admin.institute.institute_create', compact('commonData'));
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

            return redirect()->route('instituteList');
        }

        $commonData = $this->getCommonData();

        return view('admin.institute.institute_update', compact('institute', 'commonData'));
    }

}
