<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Institute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\ApplicationConfirmation;
use App\Mail\SubscriptionRequestConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InstituteController extends Controller
{
    private function validateInstitute(Request $request, $id = null): array
    {
        $rules = [
            'addr' => 'required|string|max:255',
            'addr1' => 'nullable|string|max:255',
            'pcode' => 'required|digits:5',
            'city' => 'nullable|string|max:50',
            'hp' => 'required|regex:/^\d+$/|max:16',
            'fax' => 'nullable|numeric|digits_between:1,15',
            'mel' => [
                'required',
                'email',
                'max:48',
                Rule::unique('client', 'mel')->ignore($id),
            ],
            'web' => 'nullable|string|max:255',
            'rem10' => 'nullable|string|max:255',
            'rem11' => 'nullable|string|max:255',
            'rem12' => 'nullable|string|max:255',
            'rem13' => 'nullable|numeric',
            'rem14' => 'nullable|numeric',
            'rem15' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'con1' => 'required|string|max:255',
            'ic' => 'required|regex:/^\d+$/|max:128',
            'pos1' => 'required|string|max:32',
            'tel1' => 'required|regex:/^\d{10,11}$/',
            'sta' => 'nullable',
            'country' => 'nullable|string|max:48',
        ];

        $messages = [
            'addr.required' => 'Alamat diperlukan.',
            'addr.max' => 'Alamat tidak boleh melebihi 255 aksara.',

            'addr1.max' => 'Alamat tambahan tidak boleh melebihi 255 aksara.',

            'pcode.required' => 'Poskod diperlukan.',
            'pcode.digits' => 'Poskod mesti terdiri daripada 5 angka.',

            'city.max' => 'Bandar tidak boleh melebihi 48 aksara.',

            'hp.required' => 'Nombor telefon bimbit diperlukan.',
            'hp.regex' => 'Nombor telefon bimbit mestilah terdiri daripada digit sahaja.',
            'hp.max' => 'Nombor telefon tidak boleh melebihi 16 angka',

            'fax.numeric' => 'Nombor faks mesti dalam format nombor.',
            'fax.digits_between' => 'Nombor faks mesti antara 1 hingga 15 angka.',

            'mel.required' => 'Alamat emel diperlukan.',
            'mel.email' => 'Alamat emel tidak sah.',
            'mel.max' => 'Alamat emel tidak boleh melebihi 48 aksara.',
            'mel.unique' => 'Alamat emel telah digunakan.',

            'web.max' => 'Laman web tidak boleh melebihi 255 aksara.',

            'rem10.max' => 'Medan tambahan tidak boleh melebihi 255 aksara.',
            'rem11.max' => 'Medan tambahan tidak boleh melebihi 255 aksara.',
            'rem12.max' => 'Medan tambahan tidak boleh melebihi 255 aksara.',
            'rem13.numeric' => 'Medan tambahan mesti dalam format nombor.',
            'rem14.numeric' => 'Medan tambahan mesti dalam format nombor.',
            'rem15.required' => 'Maklumat tambahan diperlukan.',
            'rem15.max' => 'Maklumat tambahan tidak boleh melebihi 255 aksara.',

            'location.required' => 'Lokasi diperlukan.',
            'location.max' => 'Lokasi tidak boleh melebihi 255 aksara.',

            'con1.required' => 'Nama pegawai diperlukan.',
            'con1.max' => 'Nama pegawai tidak boleh melebihi 255 aksara.',

            'ic.required' => 'No. kad pengenalan diperlukan.',
            'ic.regex' => 'No. kad pengenalan bimbit mestilah terdiri daripada digit sahaja.',
            'ic.max' => 'No. kad pengenalan tidak boleh melebihi 128 angka',


            'pos1.required' => 'Jawatan pegawai diperlukan.',
            'pos1.max' => 'Jawatan tidak boleh melebihi 32 aksara.',

            'tel1.required' => 'Nombor telefon diperlukan.',
            'tel1.regex' => 'Nombor telefon mesti terdiri daripada 10 atau 11 angka.',

            'country.max' => 'Negara tidak boleh melebihi 48 aksara.',
        ];


        return Validator::make($request->all(), $rules, $messages)->validate();
    }


    public function instituteRegistration(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateInstitute($request, $id);
            try {
                DB::table('client')
                    ->where('id', $id)
                    ->update(array_merge(
                        $validatedData,
                        ['registration_request_date' => now()->toDateString()] // 'YYYY-MM-DD'
                    ));
            } catch (\Exception $e) {
                Log::channel('internal_error')->error('Failed to Update Institute', [
                    'user_id' => Auth::id(),
                    'client_id' => $id,
                    'error' => $e->getMessage(),
                ]);

                return back()->withInput()->with('error', 'Pendaftaran gagal dikemas kini. Sila cuba lagi.');
            }

            $email = DB::table('client')
                ->where('id', $id)
                ->value('mel');

            if ($email) {
                $to = [
                    [
                        'email' => $email,
                        'name' => ''
                    ]
                ];

                $dynamicTemplateData = [
                ];

                $templateType = 'mais-application-confirmation';

                // Just call the function - it handles success/failure internally
                $this->sendEmail($to, $dynamicTemplateData, $templateType);
            }


            return redirect()->back()->with('success', 'Permohonan anda telah dihantar.');
        }

        try {
            $institute = Institute::with('Type', 'Category', 'City', 'Subdistrict', 'District')->where('uid', $id)->first();
            // if institute hp exits then pass to the view by filtering, like if there is any space remove it and if there is - remove it.

            if ($institute && $institute->hp) {
                // Remove spaces and dashes from 'hp'
                $institute->hp = str_replace([' ', '-'], '', $institute->hp);
            }

            if ($institute && $institute->tel1) {
                // Remove spaces and dashes from 'tel1'
                $institute->hp = str_replace([' ', '-'], '', $institute->tel1);
            }



            $parameters = $this->getCommon();
            return view('institute.registration', compact('institute', 'parameters'));
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to fetch institute', [
                'user_id' => Auth::id(),
                'client_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Tidak dapat memuatkan maklumat institusi. Sila cuba lagi.');
        }
    }

    public function edit(Request $request)
    {
        $id = Auth::user()->id;

        try {
            $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->find($id);

            if ($institute && $institute->hp) {
                // Remove spaces and dashes from 'hp'
                $institute->hp = str_replace([' ', '-'], '', $institute->hp);
            }

            if ($institute && $institute->tel1) {
                // Remove spaces and dashes from 'tel1'
                $institute->hp = str_replace([' ', '-'], '', $institute->tel1);
            }

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to fetch Institute Data', [
                'user_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal memuatkan data institusi. Sila cuba lagi.');
        }

        if ($request->isMethod('post')) {

            $validatedData = $this->validateInstitute($request, $id);
            try {
                $institute->update($validatedData);
                return redirect()->route('home')
                    ->with('success', 'Institusi berjaya dikemaskini!');
            } catch (\Exception $e) {
                Log::channel('internal_error')->error('Failed to update institute data', [
                    'user_id' => $id,
                    'input' => $request->all(),
                    'error' => $e->getMessage(),
                ]);

                return back()->withInput()->with('error', 'Kemaskini institusi gagal. Sila cuba lagi.');
            }
        }

        return view('institute.update', ['institute' => $institute, 'parameters' => $this->getCommon()]);
    }

}
