<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';
        public $timestamps = false; // Disable created_at and updated_at

             
    protected $fillable = ['fin_id', 'fin_statement', 'bank_statement', 'ccc', 'bank_reconciliation', 'clean_cert', 'qualified_audit_cert', 'unauditable_statement', 'audited_fin_report', 'reviewed_fin_report', 'unaudited_fin_report'];

    public function financialStatement()
    {
        return $this->belongsTo(FinancialStatement::class, 'fin_id', 'id');
    }

}
