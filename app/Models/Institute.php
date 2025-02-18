<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Institute extends Model
{
    use HasFactory;
    
    protected $table = 'institutes';

    protected $fillable = ['inst_refno', 'inst_category', 'inst_type', 'inst_name', 'inst_district', 'inst_sub_district', 'isdelete', 'created_by', 'updated_by'];
    

    public function instituteType()
    {
        return $this->belongsTo(Parameter::class, 'inst_type', 'code');
    }

    public function instituteCategory()
    {
        return $this->belongsTo(Parameter::class, 'inst_category', 'code');
    }
    public function district()
    {
        return $this->belongsTo(Parameter::class, 'inst_district', 'code');
    }
    public function subDistrict()
    {
        return $this->belongsTo(Parameter::class, 'inst_sub_district', 'code');
    }

    public function instituteProfile()
    {
        return $this->hasOne(InstituteProfile::class, 'inst_refno', 'inst_refno');
    }
}
