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

    protected function validateFinancialStatement(Request $request)
    {
        return Validator::make($request->all(), [
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
    }

    protected function handleAttachments(Request $request, $finYear, $finCategory, $instUid)
    {
        $fileFields = ['attachment1', 'attachment2', 'attachment3'];
        $attachments = [];

        $year = preg_replace('/[^0-9]/', '', $finYear);
        $storagePath = "/var/www/static_files/fin_statement_attachments/$year";

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = "{$year}_{$finCategory}_{$instUid}_{$field}_" . rand(1, 99) . '.pdf';
                $file->move($storagePath, $filename);
                $attachments[$field] = "fin_statement_attachments/$year/$filename";
            }
        }

        return $attachments;
    }

    public function create(Request $request, $inst_refno)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateFinancialStatement($request);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            $validatedData = $validator->validated();
            $validatedData['status'] = $request->input('draft') == "true" ? 0 : 1;

            try {
                $institute = Institute::with('Type')->where('uid', $validatedData['inst_refno'])->first();

                $institutionType = $request->input('institute_type') ?? Auth::user()->cate;

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

                $attachmentData = $this->handleAttachments(
                    $request,
                    $validatedData['fin_year'],
                    $validatedData['fin_category'],
                    $institute->uid
                );

                $financialStatement = FinancialStatement::create(array_merge($validatedData, $attachmentData));

                if ($financialStatement) {
                    return redirect()->route('statementList')->with('success', 'Laporan kewangan berjaya dihantar');
                } else {
                    Log::channel('internal_error')->error('FinancialStatement::create returned false', [
                        'validated_data' => $validatedData,
                        'attachment_data' => $attachmentData
                    ]);
                    return back()->withInput()->with('error', 'Laporan kewangan tidak berjaya dihantar');
                }

            } catch (\Exception $e) {
                Log::channel('internal_error')->error('Exception during FinancialStatement submission', [
                    'error' => $e->getMessage(),
                    'request_data' => $request->all(),
                ]);

                return back()->withInput()->with('error', 'Penghantaran tidak berjaya. Sila cuba sebentar lagi!');
            }
        }

        try {
            $institute = Institute::where('uid', $inst_refno)->first();
            $code = $request->input('institute_type') ?? Auth::user()->cate;

            $instituteType = (int) DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->where('code', $code)
                ->value('lvl');

            $currentYear = date('Y');
            $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));
            $parameters = $this->getCommon();

            return view('financial_statement.create', compact(['institute', 'instituteType', 'years', 'parameters']));

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Exception during loading financial statement create view', [
                'inst_refno' => $inst_refno,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Ralat semasa memuatkan halaman. Sila cuba sebentar lagi.');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $financialStatement = FinancialStatement::findOrFail($id);
            $institute = Institute::where('uid', $financialStatement->inst_refno)->firstOrFail();
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to fetch financial statement or institute', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Ralat semasa memuatkan data. Sila cuba sebentar lagi.');
        }

        if ($request->isMethod('post')) {
            $validator = $this->validateFinancialStatement($request);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            $validatedData = $validator->validated();
            $validatedData['status'] = $request->input('draft') == "true" ? 0 : 1;

            $validatedData['submission_date'] = $validatedData['status'] == 1 ? now() : null;

            try {
                $attachmentData = $this->handleAttachments(
                    $request,
                    $validatedData['fin_year'],
                    $validatedData['fin_category'],
                    $institute->uid
                );

                $financialStatement->update(array_merge($validatedData, $attachmentData));

                return redirect()->route('statementList')->with('success', 'Laporan kewangan berjaya dikemaskini');

            } catch (\Exception $e) {
                Log::channel('internal_error')->error('Failed to update financial statement', [
                    'id' => $id,
                    'error' => $e->getMessage(),
                    'validated_data' => $validatedData,
                ]);

                return back()->withInput()->with('error', 'Kemaskini tidak berjaya. Sila cuba sebentar lagi!');
            }
        }

        try {
            $code = $request->input('institute_type') ?? $institute->cate ?? Auth::user()->cate;

            $instituteType = (int) DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->where('code', $code)
                ->value('lvl');

            $currentYear = date('Y');
            $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));
            $parameters = $this->getCommon();

            return view('financial_statement.edit', compact(['institute', 'instituteType', 'years', 'parameters', 'financialStatement']));

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to load edit view for financial statement', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Ralat semasa memuatkan halaman kemaskini.');
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $financialStatement = FinancialStatement::findOrFail($id);

            $financialStatement->FIN_STATUS = Parameter::where('grp', 'splkstatus')
                ->where('val', $financialStatement->status)
                ->pluck('prm', 'val')
                ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();

            $verifiedByUser = DB::table('usr')->where('uid', $financialStatement->verified_by)->first();
            $verifiedBy = $verifiedByUser->name ?? null;

            $institute = Institute::with('UserPosition')->where('uid', $financialStatement->inst_refno)->firstOrFail();

            $code = $request->input('institute_type') ?? $institute->cate ?? Auth::user()->cate;
            $instituteType = (int) DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->where('code', $code)
                ->value('lvl');

            $currentYear = date('Y');
            $years = array_combine(range($currentYear - 3, $currentYear + 1), range($currentYear - 3, $currentYear + 1));

            $parameters = $this->getCommon();

            return view('financial_statement.view', compact([
                'institute',
                'instituteType',
                'years',
                'parameters',
                'financialStatement',
                'verifiedBy'
            ]));

        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Failed to load financial statement view', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Ralat semasa memuatkan halaman laporan kewangan.');
        }
    }


    public function list(Request $request)
    {
        try {
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
                ->paginate($perPage)
                ->withQueryString();

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
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Ralat ketika memuatkan senarai laporan kewangan', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Ralat semasa memuatkan senarai laporan kewangan. Sila cuba sebentar lagi.');
        }
    }


    public function editRequest(Request $request, $id)
    {

        if (strlen($request->request_edit_reason) < 1) {
            return redirect()->back()->with('error', 'Sebab permintaan mesti diisi.');
        }

        $request_edit_reason = $request->input('request_edit_reason');
        $financialStatement = FinancialStatement::with('AuditType')->find($id);

        if (!$financialStatement) {
            return redirect()->route('statementList')->with('error', 'Tiada rekod ditemui');
        }

        try {
            $financialStatement->update([
                'request_edit_reason' => $request_edit_reason,
                'request_edit_date' => Carbon::now('Asia/Kuala_Lumpur'),
                'status' => 4,
            ]);

            return redirect()->route('statementList')->with('success', 'Permohonan Berjaya Dihantar');
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Ralat ketika menghantar permohonan suntingan laporan kewangan', [
                'user_id' => Auth::id(),
                'statement_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Ralat semasa menghantar permohonan. Sila cuba sebentar lagi.');
        }
    }



}
