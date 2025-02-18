<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\InstituteProfile;
use App\Models\Institute;
use App\Models\User;
use App\Models\FinancialStatement;
use App\Models\Attachment;


class FinancialStatementReviewController extends Controller
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
            'statements' => DB::table('parameters')
                ->where('type', 'statement')
                ->pluck('parameter', 'code')
                ->toArray(),
            'submission_statuses' => DB::table('parameters')
                ->where('type', 'submission_status')
                ->whereNotIn('code', ['SS05', 'SS06'])
                ->pluck('parameter', 'code')
                ->toArray(),

            'audit_statuses' => DB::table('parameters')
                ->where('type', 'audit_status')
                ->pluck('parameter', 'code')
                ->toArray(),
            

        ];
    }

    public function list(Request $request)
    {
        $currentYear = date('Y');

        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));
        $statements = $this->getCommonData()['statements'];

        $perPage = $request->get('per_page', 10);

        $query = FinancialStatement::whereNotIn('submission_status', ['SS05', 'SS06', 'SS04']);

        // Filter by fin_year if provided
        if ($request->filled('fin_year')) {
            $query->where('fin_year', $request->fin_year);
        }

        // Filter by fin_category if provided
        if ($request->filled('fin_category')) {
            $query->where('fin_category', $request->fin_category);
        }

        // Search by institute name
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';

            $query->whereHas('instituteProfile.institute', function ($q) use ($searchTerm) {
                $q->where('inst_name', 'like', $searchTerm);
            });
        }

        // Load related models
        $query->with(['finCategory', 'submissionStatus', 'auditStatus', 'instituteProfile.institute'])
            ->orderBy('created_at', 'desc');

        $financialStatements = $query->paginate($perPage);

        // Transform the collection
        $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
            $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
            $financialStatement->audit_status = $financialStatement->auditStatus->parameter ?? null;
            $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
            $financialStatement->in_charge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
            return $financialStatement;
        });

        return view('financial_statement_review.list', compact('financialStatements', 'years', 'statements'));
    }

        public function reviewedList(Request $request)
    {
        $currentYear = date('Y');

        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));
        $statements = $this->getCommonData()['statements'];

        $perPage = $request->get('per_page', 10);

$query = FinancialStatement::whereNotIn('submission_status', ['SS01'])
    ->whereNotIn('audit_status', ['AS01']);

        // Filter by fin_year if provided
        if ($request->filled('fin_year')) {
            $query->where('fin_year', $request->fin_year);
        }

        // Filter by fin_category if provided
        if ($request->filled('fin_category')) {
            $query->where('fin_category', $request->fin_category);
        }

        // Search by institute name
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';

            $query->whereHas('instituteProfile.institute', function ($q) use ($searchTerm) {
                $q->where('inst_name', 'like', $searchTerm);
            });
        }

        // Load related models
        $query->with(['finCategory', 'submissionStatus', 'auditStatus', 'instituteProfile.institute'])
            ->orderBy('created_at', 'desc');

        $financialStatements = $query->paginate($perPage);

        // Transform the collection
        $financialStatements->getCollection()->transform(function ($financialStatement) {
            $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
            $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
            $financialStatement->audit_status = $financialStatement->auditStatus->parameter ?? null;
            $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
            $financialStatement->in_charge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
            return $financialStatement;
        });

        return view('financial_statement_review.reviewed_list', compact('financialStatements', 'years', 'statements'));
    }
    

public function cancelRequestList(Request $request)
{
    $currentYear = date('Y');

    $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));
    $statements = $this->getCommonData()['statements'];

    $perPage = $request->get('per_page', 10);

    $query = FinancialStatement::query();

    // Apply default filter based on canceled_statements
    if ($request->filled('canceled_statements')) {
        $query->where('submission_status', 'SS04');
    } else {
        $query->where('submission_status', 'SS06');
    }

    // Filter by fin_year if provided
    if ($request->filled('fin_year')) {
        $query->where('fin_year', $request->fin_year);
    }

    // Filter by fin_category if provided
    if ($request->filled('fin_category')) {
        $query->where('fin_category', $request->fin_category);
    }

    // Search by institute name
    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->whereHas('instituteProfile.institute', function ($q) use ($searchTerm) {
            $q->where('inst_name', 'like', $searchTerm);
        });
    }

    // Load related models
    $query->with(['finCategory', 'submissionStatus', 'auditStatus', 'instituteProfile.institute'])
        ->orderBy('created_at', 'desc');

    $financialStatements = $query->paginate($perPage);

    // Transform the collection
    $financialStatements->getCollection()->transform(function ($financialStatement) {
        $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
        $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
        $financialStatement->audit_status = $financialStatement->auditStatus->parameter ?? null;
        $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
        $financialStatement->in_charge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
        return $financialStatement;
    });

    return view('financial_statement_review.cancel_req_list', compact('financialStatements', 'years', 'statements'));
}





    public function create(Request $request)
    {
        $instituteType = Auth::user()->instituteProfile->institute->inst_type;
        if($request->isMethod('post')){
            $validatedData = $request->validate([
                // 'inst_refno' => 'required',
                'fin_year' => 'required',
                'fin_category' => 'required',
                'latest_construction_progress' => 'nullable',
                'ori_construction_cost' => 'nullable',
                'variation_order' => 'nullable',
                'current_collection' => 'nullable',
                'total_collection' => 'nullable',
                'total_statement' => 'nullable',
                'transfer_pws' => 'nullable',
                'construction_expenses' => 'nullable',
                'inst_surplus' => 'nullable',
                'pws_surplus' => 'nullable',
                'pws_expenses' => 'nullable',
                'balance_forward' => 'nullable',
                'total_expenses' => 'nullable',
                'total_income' => 'nullable',
                'total_surplus' => 'nullable',
                'bank_cash_balance' => 'nullable',
                'ccc'                 => 'nullable|file|mimes:pdf',
                'bank_statement'      => 'nullable|file|mimes:pdf',
                'bank_reconciliation' => 'nullable|file|mimes:pdf',
                'fin_statement'       => 'nullable|file|mimes:pdf',
                // 'submission_status' => 'required',
                // 'audit_status' => 'required',
                // 'submission_date' => 'required',
                // 'submission_refno' => 'required',
                // 'cancellation_date' => 'required',
                // 'cancel_reason_byuser' => 'required',
                // 'cancel_reason_byadmin' => 'required',
                // 'correction_proposal_byadmin' => 'required',
                // 'created_by' => 'required',
                // 'updated_by' => 'required',
                // 'reviewed_by' => 'required',
                // 'reviewed_at' => 'required',
                // 'audited_by' => 'required',
                // 'audited_at' => 'required',
            ]);



            $financialStatement = new FinancialStatement($validatedData);
            $financialStatement->inst_refno = Auth::user()->instituteProfile->inst_refno;
            $financialStatement->fin_year = $request->fin_year;
            $financialStatement->fin_category = $request->fin_category;

            $financialStatement->submission_status = $request->input('draft') === 'true' ? 'SS05' : 'SS01';
            $financialStatement->audit_status = $request->input('draft') === 'true' ? null : 'AS01';
            $financialStatement->submission_date = $request->input('draft') === 'true' ? null : date('Y-m-d');
            $financialStatement->submission_refno = uniqid();
            // $financialStatement->cancellation_date = $request->cancellation_date;

            // $financialStatement->cancel_reason_byuser = $request->cancel_reason_byuser;
            // $financialStatement->cancel_reason_byadmin = $request->cancel_reason_byadmin;

            // $financialStatement->correction_proposal_byadmin = $request->correction_proposal_byadmin;

            $financialStatement->created_by = Auth::user()->uid;
            // $financialStatement->reviewed_by = $request->reviewed_by;
            // $financialStatement->reviewed_at = $request->reviewed_at;
            // $financialStatement->audited_by = $request->audited_by;
            // $financialStatement->audited_at = $request->audited_at;
            $financialStatement->save();        



                // Initialize attachment data
            $attachmentData = [
                'fin_id' => $financialStatement->id,
            ];

            // Handle each file upload
            $fileFields = ['ccc', 'bank_statement', 'bank_reconciliation', 'fin_statement'];
            
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    
                    // Create unique filename using field name and timestamp
                    $filename = $field . '_' . time() . '_' . uniqid() . '.pdf';
                    
                    // Store the file in the public folder
                    $path = $file->storeAs(
                        'fin_statement_attachments', 
                        $filename, 
                        'public'
                    );

                    // Add the path to attachment data
                    $attachmentData[$field] = 'storage/' . $path;
                }
            }

            // Create single attachment record with all files
            Attachment::create($attachmentData);

            return redirect()->route('financialStatementList');
        }

        $commonData = $this->getCommonData();
        $currentYear = date('Y');


        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.create', compact('commonData', 'years', 'instituteType'));

    }

        public function edit(Request $request, $id)
    {
    $financialStatement = FinancialStatement::with(['finCategory', 'submissionStatus', 'auditStatus'])->findOrFail($id);
            $instituteType = Auth::user()->instituteProfile->institute->inst_type;


    if ($request->isMethod('post')) {
        $validatedData = $request->validate([
            'fin_year' => 'required',
            'fin_category' => 'required',
            'latest_construction_progress' => 'nullable',
            'ori_construction_cost' => 'nullable',
            'variation_order' => 'nullable',
            'current_collection' => 'nullable',
            'total_collection' => 'nullable',
            'total_statement' => 'nullable',
            'transfer_pws' => 'nullable',
            'construction_expenses' => 'nullable',
            'inst_surplus' => 'nullable',
            'pws_surplus' => 'nullable',
            'pws_expenses' => 'nullable',
            'balance_forward' => 'nullable',
            'total_expenses' => 'nullable',
            'total_income' => 'nullable',
            'total_surplus' => 'nullable',
            'bank_cash_balance' => 'nullable',
        ]);

        // Determine the submission status based on draft value
        $validatedData['submission_status'] = $request->input('draft') === 'true' ? 'SS05' : 'SS01';
        $validatedData['audit_status'] = $request->input('draft') === 'true' ? null : 'AS01';
        $validatedData['submission_date'] = $request->input('draft') === 'true' ? null : now();

        // Update the existing record
        $financialStatement->update($validatedData);

        return redirect()->route('financialStatementList')->with('success', 'Financial Statement updated successfully!');
    }


        $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
        $financialStatement->submission_status = $financialStatement->submissionStatus->parameter ?? null;
        $financialStatement->audit_status = $financialStatement->auditStatus->parameter ?? null;
        $financialStatement->institute_category = $financialStatement->instituteProfile->institute->instituteCategory->parameter ?? null;
        $financialStatement->institute_type = $financialStatement->instituteProfile->institute->instituteType->parameter ?? null;
        $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
        $financialStatement->institute_district = $financialStatement->instituteProfile->institute->district->parameter ?? null;
        $financialStatement->institute_city = $financialStatement->instituteProfile->instituteCity->parameter ?? null;
        $financialStatement->institute_telephone_no = $financialStatement->instituteProfile->telephone_no ?? null;
        $financialStatement->institute_email = $financialStatement->instituteProfile->email ?? null;

        $financialStatement->institute_person_incharge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
        $financialStatement->institute_person_incharge_position = $financialStatement->instituteProfile->personIncharge->userPosition->parameter ?? null;
        $financialStatement->institute_person_incharge_mobile_number = $financialStatement->instituteProfile->personIncharge->mobile_number ?? null;



        $commonData = $this->getCommonData();
        $currentYear = date('Y');

        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.edit', compact('commonData', 'years', 'financialStatement', 'instituteType'));
    }

    public function view(Request $request, $id)
    {
        $financialStatement = FinancialStatement::with(['finCategory', 'submissionStatus', 'auditStatus'])->find($id);
        $submission_statuses = $this->getCommonData()['submission_statuses'];
        $audit_statuses = $this->getCommonData()['audit_statuses'];

        // $instituteType = Auth::user()->instituteProfile->institute->inst_type;
        $instituteType = $financialStatement->instituteProfile->institute->inst_type;    

        $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
        $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
        $financialStatement->audit_status_ = $financialStatement->auditStatus->parameter ?? null;
        $financialStatement->institute_category = $financialStatement->instituteProfile->institute->instituteCategory->parameter ?? null;
        $financialStatement->institute_type = $financialStatement->instituteProfile->institute->instituteType->parameter ?? null;
        $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
        $financialStatement->institute_district = $financialStatement->instituteProfile->institute->district->parameter ?? null;
        $financialStatement->institute_city = $financialStatement->instituteProfile->instituteCity->parameter ?? null;
        $financialStatement->institute_telephone_no = $financialStatement->instituteProfile->telephone_no ?? null;
        $financialStatement->institute_email = $financialStatement->instituteProfile->email ?? null;

        $financialStatement->institute_person_incharge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
        $financialStatement->institute_person_incharge_position = $financialStatement->instituteProfile->personIncharge->userPosition->parameter ?? null;
        $financialStatement->institute_person_incharge_mobile_number = $financialStatement->instituteProfile->personIncharge->mobile_number ?? null;
        $attachment = $financialStatement->attachment;


        return view('financial_statement_review.approve_statement', compact('financialStatement', 'instituteType', 'attachment', 'submission_statuses', 'audit_statuses'));
    }

        public function reviewedView(Request $request, $id)
    {
        $financialStatement = FinancialStatement::with(['finCategory', 'submissionStatus', 'auditStatus'])->find($id);
        $submission_statuses = $this->getCommonData()['submission_statuses'];
        $audit_statuses = $this->getCommonData()['audit_statuses'];

        // $instituteType = Auth::user()->instituteProfile->institute->inst_type;
        $instituteType = $financialStatement->instituteProfile->institute->inst_type;    

        $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
        $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
        $financialStatement->audit_status_ = $financialStatement->auditStatus->parameter ?? null;
        $financialStatement->institute_category = $financialStatement->instituteProfile->institute->instituteCategory->parameter ?? null;
        $financialStatement->institute_type = $financialStatement->instituteProfile->institute->instituteType->parameter ?? null;
        $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
        $financialStatement->institute_district = $financialStatement->instituteProfile->institute->district->parameter ?? null;
        $financialStatement->institute_city = $financialStatement->instituteProfile->instituteCity->parameter ?? null;
        $financialStatement->institute_telephone_no = $financialStatement->instituteProfile->telephone_no ?? null;
        $financialStatement->institute_email = $financialStatement->instituteProfile->email ?? null;
        $financialStatement->audited_by_ = $financialStatement->auditedBy->fullname ?? null;
        $financialStatement->reviewed_by_ = $financialStatement->reviewedBy->fullname ?? null;
        $financialStatement->reviewed_at_ = $financialStatement->reviewed_at 
            ? \Carbon\Carbon::parse($financialStatement->reviewed_at)->format('Y-m-d') 
            : null;

        $financialStatement->institute_person_incharge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
        $financialStatement->institute_person_incharge_position = $financialStatement->instituteProfile->personIncharge->userPosition->parameter ?? null;
        $financialStatement->institute_person_incharge_mobile_number = $financialStatement->instituteProfile->personIncharge->mobile_number ?? null;
        $attachment = $financialStatement->attachment;


        return view('financial_statement_review.view_reviewed_statement ', compact('financialStatement', 'instituteType', 'attachment', 'submission_statuses', 'audit_statuses'));
    }

        public function cancelRequestView(Request $request, $id)
    {
        $financialStatement = FinancialStatement::with(['finCategory', 'submissionStatus', 'auditStatus'])->find($id);
        $submission_statuses = $this->getCommonData()['submission_statuses'];
        $audit_statuses = $this->getCommonData()['audit_statuses'];

        // $instituteType = Auth::user()->instituteProfile->institute->inst_type;
        $instituteType = $financialStatement->instituteProfile->institute->inst_type;    

        $financialStatement->fin_category = $financialStatement->finCategory->parameter ?? null;
        $financialStatement->submission_status_ = $financialStatement->submissionStatus->parameter ?? null;
        $financialStatement->audit_status_ = $financialStatement->auditStatus->parameter ?? null;
        $financialStatement->institute_category = $financialStatement->instituteProfile->institute->instituteCategory->parameter ?? null;
        $financialStatement->institute_type = $financialStatement->instituteProfile->institute->instituteType->parameter ?? null;
        $financialStatement->institute_name = $financialStatement->instituteProfile->institute->inst_name ?? null;
        $financialStatement->institute_district = $financialStatement->instituteProfile->institute->district->parameter ?? null;
        $financialStatement->institute_city = $financialStatement->instituteProfile->instituteCity->parameter ?? null;
        $financialStatement->institute_telephone_no = $financialStatement->instituteProfile->telephone_no ?? null;
        $financialStatement->institute_email = $financialStatement->instituteProfile->email ?? null;

        $financialStatement->institute_person_incharge = $financialStatement->instituteProfile->personIncharge->fullname ?? null;
        $financialStatement->institute_person_incharge_position = $financialStatement->instituteProfile->personIncharge->userPosition->parameter ?? null;
        $financialStatement->institute_person_incharge_mobile_number = $financialStatement->instituteProfile->personIncharge->mobile_number ?? null;
        $attachment = $financialStatement->attachment;


        return view('financial_statement_review.cancel_request_view', compact('financialStatement', 'instituteType', 'attachment', 'submission_statuses', 'audit_statuses'));
    }

        public function adminReview(Request $request, $id)
    {
    $financialStatement = FinancialStatement::with(['finCategory', 'submissionStatus', 'auditStatus'])->findOrFail($id);
        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'audited_fin_report'                 => 'nullable|file|mimes:pdf',
                'reviewed_fin_report'      => 'nullable|file|mimes:pdf',
                'unaudited_fin_report' => 'nullable|file|mimes:pdf',
                'clean_cert'       => 'nullable|file|mimes:pdf',
                'qualified_audit_cert' => 'nullable|file|mimes:pdf',
                'unauditable_statement'       => 'nullable|file|mimes:pdf',
                'submission_status' => 'required',
                'audit_status' => 'required',
            ]);


            // dd($request->all());
            $financialStatement->submission_status = $request->submission_status;
            $financialStatement->audit_status = $request->audit_status;
            $financialStatement->audited_by = Auth::user()->uid;
            $financialStatement->audited_at = now(); // Current date & time
            $financialStatement->reviewed_by = Auth::user()->uid;
            $financialStatement->reviewed_at = now(); // Current date & time

            $financialStatement->save();        


// Find the existing attachment record
$attachment = Attachment::where('fin_id', $financialStatement->id)->first();

if ($attachment) {
    // Define file fields
    $fileFields = [
        'bank_reconciliation', 'clean_cert', 'qualified_audit_cert', 
        'unauditable_statement', 'audited_fin_report', 
        'reviewed_fin_report', 'unaudited_fin_report'
    ];

    $updateData = [];

    // Loop through each file field and store the file if provided
    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);

            // Generate unique filename
            $filename = "{$field}_" . time() . "_" . uniqid() . ".pdf";

            // Store the file in the 'public/fin_statement_attachments' folder
            $path = $file->storeAs('fin_statement_attachments', $filename, 'public');

            // Add file path to update data
            $updateData[$field] = 'storage/' . $path;
        }
    }

    // Update the existing attachment record
    if (!empty($updateData)) {
        $attachment->update($updateData);
    }
}


            return redirect()->route('financialStatementReviewlist');
        }

        $commonData = $this->getCommonData();
        $currentYear = date('Y');


        $years = array_combine(range($currentYear - 3, $currentYear + 3), range($currentYear - 3, $currentYear + 3));

        return view('financial_statement.create', compact('commonData', 'years', 'instituteType'));

    }

    public function cancelationByUser(Request $request, $id)
    {
        $request->validate([
            'cancel_reason_byuser' => 'required'
        ]);
        $financialStatement = FinancialStatement::find($id);
        $financialStatement->submission_status = 'SS04';
        $financialStatement->audit_status = null;
        $financialStatement->cancellation_date = date('Y-m-d');
        $financialStatement->cancel_reason_byuser = $request->cancel_reason_byuser;
        
        $financialStatement->save();

        return redirect()->route('financialStatementList');
    }

        public function statementCancellation(Request $request, $id)
    {
        $financialStatement = FinancialStatement::find($id);
        $financialStatement->submission_status = 'SS04';
        $financialStatement->audit_status = null;
        // $financialStatement->cancellation_date = date('Y-m-d');
        $financialStatement->reviewed_by = Auth::user()->uid;
        $financialStatement->reviewed_at = now();
        
        $financialStatement->save();

        return redirect()->route('cancelRequestList');
    }
   


}
