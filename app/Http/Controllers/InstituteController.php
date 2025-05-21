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
            'name' => 'nullable|string|max:255',
            'cate1' => 'nullable|string|max:50',
            'cate' => 'nullable|string|max:50',
            'rem8' => 'nullable|string|max:50',
            'rem9' => 'nullable|string|max:50',
            'addr' => 'nullable|string|max:128',
            'addr1' => 'nullable|string|max:128',
            'pcode' => 'nullable|numeric|digits_between:1,8',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'hp' => 'nullable|regex:/^\d+$/',
            'fax' => 'nullable|numeric|digits_between:1,10',
            'mel' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('client', 'mel')->ignore($id),
            ],
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
            'tel1' => 'nullable|regex:/^\d+$/',
            'sta' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ];

        return Validator::make($request->all(), $rules)->validate();
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
                    'trace' => $e->getTraceAsString(),
                ]);

                return back()->withInput()->with('error', 'Pendaftaran gagal dikemas kini. Sila cuba lagi.');
            }

            try {
                $email = DB::table('client')
                    ->where('id', $id)
                    ->value('mel');

                if ($email) {
                    Mail::to($email)->send(new ApplicationConfirmation());
                }
            } catch (\Exception $e) {
                Log::channel('external_api_error')->error('Failed to Send Email for New Institute Registration', [
                    'user_id' => Auth::id(),
                    'client_id' => $id,
                    'email' => $email ?? null,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            return redirect()->back()->with('success', 'Permohonan anda telah dihantar.');
        }

        try {
            $institute = Institute::with('Type', 'Category', 'City', 'Subdistrict', 'District')->where('uid', $id)->first();

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
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to fetch Institute Data', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
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
