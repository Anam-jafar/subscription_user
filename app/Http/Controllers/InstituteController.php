<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Institute;
use Illuminate\Support\Facades\Validator;



class InstituteController extends Controller
{
    private function validateInstitute(Request $request): array
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'cate1' => 'nullable|string|max:50',
            'cate' => 'nullable|string|max:50',
            'rem8' => 'nullable|string|max:50',
            'rem9' => 'nullable|string|max:50',
            'addr' => 'nullable|string|max:500',
            'addr1' => 'nullable|string|max:500',
            'pcode' => 'nullable|string|max:8',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'hp' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'mel' => 'nullable|string|max:255',
            'web' => 'nullable|string|max:255',
            'rem10' => 'nullable|string|max:50',
            'rem11' => 'nullable|string|max:50',
            'rem12' => 'nullable|string|max:50',
            'rem13' => 'nullable|string|max:50',
            'rem14' => 'nullable|string|max:50',
            'rem15' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'con1' => 'nullable|string|max:50',
            'ic' => 'nullable|string|max:50',
            'pos1' => 'nullable|string|max:50',
            'tel1' => 'nullable|string|max:50',
            'sta' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ];

        return Validator::make($request->all(), $rules)->validate();
    }

    public function edit(Request $request)
    {
        $id = Auth::user()->id;
        $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->find($id);

        if ($request->isMethod('post')) {
            
            $validatedData = $this->validateInstitute($request);
            $institute->update($validatedData);

            return redirect()->route('home')
                ->with('success', 'Institusi berjaya dikemaskini!');
        }


        return view('institute.update', ['institute' => $institute, 'parameters' => $this->getCommon()]);        
    }
}
