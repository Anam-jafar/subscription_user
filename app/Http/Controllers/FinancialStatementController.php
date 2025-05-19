<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialStatement;
use App\Models\Parameter;
use App\Models\Institute;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FinancialStatementController extends Controller
{
    private function validateFinancialStatement(Request $request): array
    {
        $rules = [
            'inst_refno' => 'nullable',
            'fin_year' => 'nullable',
            'fin_category' => 'nullable',
            'latest_contruction_progress' => 'nullable',
            'ori_contruction_cost' => 'nullable',
            'variation_order' => 'nullable',
            'current_collection' => 'nullable',
            'total_collection' => 'nullable',
            'total_statement' => 'nullable',
            'transfer_pws' => 'nullable',
            'contruction_expenses' => 'nullable',
            'inst_surplus' => 'nullable',
            'pws_surplus' => 'nullable',
            'pws_expenses' => 'nullable',
            'balance_forward' => 'nullable',
            'total_expenses' => 'nullable',
            'total_income' => 'nullable',
            'total_surplus' => 'nullable',
            'bank_cash_balance' => 'nullable',
            'attachment1_info' => 'nullable',
            'attachment1' => 'nullable|file|mimes:pdf|max:10240',
            'attachment2' => 'nullable|file|mimes:pdf|max:10240',
            'attachment3' => 'nullable|file|mimes:pdf|max:10240',
    ];


        return Validator::make($request->all(), $rules)->validate();
    }

    private function generateUniqueSubmissionRefno($year, $instituteType, $instituteID)
    {
        $instituteType = strtoupper($instituteType);
        $count = DB::table('splk_submission')->count() + 1;
        $uniqueNumber = str_pad($count, 6, '0', STR_PAD_LEFT);
        $newRefNo = "STM-{$year}-{$instituteType}-{$instituteID}-{$uniqueNumber}";

        return $newRefNo;
    }


    private function applyFilters($query, Request $request)
    {
        foreach ($request->all() as $field => $value) {
            if (!empty($value) && \Schema::hasColumn('splk_submission', $field)) {
                $query->where($field, $value);
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }


    public function create(Request $request, $inst_refno)
    {
        if ($request->isMethod('post')) {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'inst_refno' => 'nullable',
                'fin_year' => 'nullable',
                'fin_category' => 'nullable',
                'latest_contruction_progress' => 'nullable|numeric|min:1|max:100',
                'ori_contruction_cost' => 'nullable|numeric',
                'variation_order' => 'nullable|numeric',
                'current_collection' => 'nullable|numeric',
                'total_collection' => 'nullable|numeric',
                'total_statement' => 'nullable|numeric',
                'transfer_pws' => 'nullable|numeric',
                'contruction_expenses' => 'nullable|numeric',
                'inst_surplus' => 'nullable|numeric',
                'pws_surplus' => 'nullable|numeric',
                'pws_expenses' => 'nullable|numeric',
                'balance_forward' => 'nullable|numeric',
                'total_expenses' => 'nullable|numeric',
                'total_income' => 'nullable',
                'total_surplus' => 'nullable',
                'bank_cash_balance' => 'nullable|numeric',
                'attachment1_info' => 'nullable',
                'attachment1' => 'nullable|file|mimes:pdf|max:10240',
                'attachment2' => 'nullable|file|mimes:pdf|max:10240',
                'attachment3' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            // If validation fails, return back with input and errors
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            // Retrieve validated data
            $validatedData = $validator->validated();

            // Determine submission status
            $validatedData['status'] = ($request->input('draft') == "true") ? 0 : 1;

            $institute = Institute::with('Type')->where('uid', $validatedData['inst_refno'])->first();

            $institutionType = $request->input('institute_type');
            $institution = DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->where('code', $institutionType)
                ->value('etc');

            $validatedData['institute'] = $institution ?? null;
            $validatedData['institute_type'] = $institutionType ?? null;

            $fin_category = DB::table('type')
                ->where('grp', 'statement')
                ->where('code', $validatedData['fin_category'])
                ->value('val');

            // Set submission reference if not a draft
            if ($validatedData['status'] == 1) {
                $validatedData['submission_date'] = now();
                $validatedData['submission_refno'] = $this->generateUniqueSubmissionRefno(
                    date('Y'),
                    $fin_category,
                    $institute->uid
                );
            } else {
                $validatedData['submission_date'] = null;
            }

            // Handle file uploads

            $fileFields = ['attachment1', 'attachment2', 'attachment3'];
            $attachmentData = [];

            $year = $request->input('fin_year');
            $year = preg_replace('/[^0-9]/', '', $year); // Sanitize year input to digits only

            $storagePath = "/var/www/static_files/fin_statement_attachments/$year";

            // Create directory if it doesn't exist
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $year.'_'.$fin_category . '_' . $institute->uid .'_'. $field . '_' . rand(1, 99) . '.pdf';
                    $file->move($storagePath, $filename);

                    // Save the relative path for DB or other uses
                    $attachmentData[$field] = "fin_statement_attachments/$year/$filename";
                }
            }


            try {
                // Create financial statement
                $financialStatement = FinancialStatement::create(array_merge($validatedData, $attachmentData));

                if ($financialStatement) {
                    return redirect()->route('statementList')->with('success', 'Laporan kewangan berjaya dihantar');
                } else {
                    return back()->withInput()->with('error', 'Laporan kewangan tidak berjaya dihantar');
                }
            } catch (\Exception $e) {
                Log::error('Ralat Penyerahan Laporan Kewangan: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Penghantaran tidak berjaya. Sila cuba sebentar lagi!');
            }

        }

        // Fetch institute data
        $institute = Institute::where('uid', $inst_refno)->first();

        $code = $request->input('institute_type') ?? Auth::user()->cate;

        $instituteType = (int) DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->where('code', $code)
            ->value('lvl');



        // Generate years array
        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

        // Fetch common parameters
        $parameters = $this->getCommon();

        return view('financial_statement.create', compact(['institute', 'instituteType', 'years', 'parameters']));
    }


    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // Validate input data
            $validatedData = Validator::make($request->all(), [
                'inst_refno' => 'nullable',
                'fin_year' => 'nullable',
                'fin_category' => 'nullable',
                'latest_contruction_progress' => 'nullable|numeric|min:1|max:100',
                'ori_contruction_cost' => 'nullable|numeric',
                'variation_order' => 'nullable|numeric',
                'current_collection' => 'nullable|numeric',
                'total_collection' => 'nullable|numeric',
                'total_statement' => 'nullable|numeric',
                'transfer_pws' => 'nullable|numeric',
                'contruction_expenses' => 'nullable|numeric',
                'inst_surplus' => 'nullable|numeric',
                'pws_surplus' => 'nullable|numeric',
                'pws_expenses' => 'nullable|numeric',
                'balance_forward' => 'nullable|numeric',
                'total_expenses' => 'nullable|numeric',
                'total_income' => 'nullable',
                'total_surplus' => 'nullable',
                'bank_cash_balance' => 'nullable|numeric',
                'attachment1_info' => 'nullable',
                'attachment1' => 'nullable|file|mimes:pdf|max:10240',
                'attachment2' => 'nullable|file|mimes:pdf|max:10240',
                'attachment3' => 'nullable|file|mimes:pdf|max:10240',
            ])->validate();

            // Retrieve existing financial statement
            $financialStatement = FinancialStatement::find($id);
            if (!$financialStatement) {
                return redirect()->route('statementList')->with('error', 'Tiada rekod ditemui');
            }

            // Determine submission status
            $validatedData['status'] = ($request->input('draft') == "true") ? 0 : 1;
            if ($validatedData['status'] == 1) {
                $validatedData['submission_date'] = now();
            } else {
                $validatedData['submission_date'] = null;
            }

            // Handle file uploads
            $fileFields = ['attachment1', 'attachment2', 'attachment3'];
            $storagePath = '/var/www/static_files/fin_statement_attachments';

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $field . '_' . time() . '_' . uniqid() . '.pdf';
                    $file->move($storagePath, $filename);
                    $validatedData[$field] = 'fin_statement_attachments/' . $filename; // Save relative path
                } else {
                    $validatedData[$field] = $financialStatement->$field; // Keep existing file
                }
            }


            try {
                // Update financial statement
                $financialStatement->update($validatedData);
                return redirect()->route('statementList')->with('success', 'Laporan kewangan berjaya dikemaskini');
            } catch (\Exception $e) {
                Log::error('Ralat Penyerahan Laporan Kewangan: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Penghantaran tidak berjaya. Sila cuba sebentar lagi!');
            }
        }

        // Fetch existing data
        $financialStatement = FinancialStatement::find($id);
        $institute = Institute::where('uid', $financialStatement->inst_refno)->first();

        $instituteType = (int) DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->where('code', $request->input('institute_type'))
            ->value('lvl');


        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));
        $parameters = $this->getCommon();

        return view('financial_statement.edit', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));
    }


    public function view(Request $request, $id)
    {
        // if ($request->isMethod('post')) {
        //     $validatedData = $this->validateFinancialStatement($request);

        //     $financialStatement = FinancialStatement::find($id);

        //     if (!$financialStatement) {
        //         return redirect()->route('statementList')->with('error', 'Financial Statement not found');
        //     }

        //     if ($request['draft'] == "true") {
        //         $validatedData['status'] = 0;
        //     } else {
        //         $validatedData['status'] = 1;
        //         $validatedData['submission_date'] = now();
        //     }

        //     $financialStatement->update($validatedData);

        //     return redirect()->route('statementList')->with('success', 'Financial Statement updated successfully');
        // }

        $financialStatement = FinancialStatement::find($id);
        $financialStatement->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $financialStatement->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
        $verifiedBy = DB::table('usr')->where('uid', $financialStatement->verified_by)->first();
        $verifiedBy = $verifiedBy->name ?? null;
        $institute = Institute::with('UserPosition')->where('uid', $financialStatement->inst_refno)->first();
        // $instituteType = isset($institute->Category->lvl) ? intval($institute->Category->lvl) : null;


        $instituteType = (int) DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->where('code', $request->input('institute_type'))
            ->value('lvl');


        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));


        $parameters = $this->getCommon();
        return view('financial_statement.view', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement', 'verifiedBy']));
    }

    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $distinctInstitutes = DB::table('institute_history')
            ->where('inst_refno', Auth::user()->uid)
            ->distinct()
            ->pluck('institute_type')
            ->toArray();

        $currentInstitute = Auth::user()->cate;
        if (!in_array($currentInstitute, $distinctInstitutes)) {
            $distinctInstitutes[] = $currentInstitute;
        }

        $institutionHistory = DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->whereIn('code', $distinctInstitutes)
            ->pluck('prm', 'code');


        if (!$request->filled('institute_type')) {
            $request->merge([
                'institute_type' => $currentInstitute,
            ]);
        }

        $query = FinancialStatement::where('inst_refno', Auth::user()->uid);

        $query = $this->applyFilters($query, $request);

        $financialStatements = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();


        $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->CATEGORY = $financialStatement->Category->prm ?? null;
            $financialStatement->INSTITUTE = $financialStatement->Institute->name ?? null;
            $financialStatement->SUBMISSION_DATE = date('d-m-Y', strtotime($financialStatement->submission_date));
            $financialStatement->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $financialStatement->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
            return $financialStatement;
        });

        $currentYear = date('Y');
        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.list', [
            'parameters' => $this->getCommon(),
            'financialStatements' => $financialStatements,
            'years' => $years,
            'institutionHistory' => $institutionHistory,
            'currentInstitute' => $currentInstitute,
        ]);
    }

    public function editRequest(Request $request, $id)
    {

        if (strlen($request->request_edit_reason) < 1) {
            return redirect()->back()->with('error', 'Sebab permintaan mesti diisi.');
        }

        $request_edit_reason = $request->input('request_edit_reason');

        // Find the financial statement with its AuditType relation
        $financialStatement = FinancialStatement::with('AuditType')->find($id);

        if (!$financialStatement) {
            return redirect()->route('statementList')->with('error', 'Tiada rekod ditemui');
        }

        // Update the financial statement
        $financialStatement->update([
            'request_edit_reason' => $request_edit_reason,
            'request_edit_date' => Carbon::now('Asia/Kuala_Lumpur'),
            'status' => 4,
        ]);

        return redirect()->route('statementList')->with('success', 'Permohonan Berjaya Dihantar');
    }


}
