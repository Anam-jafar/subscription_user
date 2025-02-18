<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialStatement extends Model
{
    use HasFactory;
    
    protected $table = 'financial_statements';

    protected $fillable = ['inst_refno', 'fin_year', 'fin_category', 'latest_construction_progress', 'ori_construction_cost',
                            'variation_order', 'current_collection', 'total_collection', 'transfer_pws', 'construction_expenses',
                            'inst_surplus', 'pws_surplus', 'pws_expenses', 'balance_forward', 'total_expenses', 'total_income', 
                            'total_surplus', 'bank_cash_balance', 'submission_status', 'audit_status', 'submission_date', 'submission_refno',
                            'cancellation_date', 'cancel_reason_byuser', 'cancel_reason_byadmin', 'correction_proposal_byadmin', 
                            'created_by', 'updated_by', 'reviewed_by', 'reviewed_at', 'audited_by', 'audited_at'
                    ];

    public function finCategory()
    {
        return $this->belongsTo(Parameter::class, 'fin_category', 'code');
    }
    public function instituteProfile()
    {
        return $this->belongsTo(InstituteProfile::class, 'inst_refno', 'inst_refno');
    }
    public function submissionStatus()
    {
        return $this->belongsTo(Parameter::class, 'submission_status', 'code');
    }
    public function auditStatus()
    {
        return $this->belongsTo(Parameter::class, 'audit_status', 'code');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'created_by', 'uid');
    }

    public function reviewedBy()
    {
        return $this->hasOne(User::class, 'uid', 'reviewed_by');
    }
    public function auditedBy()
    {
        return $this->hasOne(User::class, 'uid', 'audited_by');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'fin_id', 'id');
    }
}
