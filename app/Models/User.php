<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable; 
    protected $table = 'client';

    // protected $fillable = ['uid', 'fullname', 'nric_number', 'mobile_number', 'email', 'position', 'department', 'district_access', 'user_group', 'status', 'profie_img', 'isdelete', 'password', 'password_set', 'created_by', 'updated_by', 'reset_token'];
    // protected $hidden = ['pass'];

    // public function userDepartment()
    // {
    //     return $this->belongsTo(Parameter::class, 'department', 'code');
    // }
    // public function userPosition()
    // {
    //     return $this->belongsTo(Parameter::class, 'position', 'code');
    // }
    // public function userDistrictAccess()
    // {
    //     return $this->belongsTo(Parameter::class, 'district_access', 'code');
    // }
    // public function userStatus()
    // {
    //     return $this->belongsTo(Parameter::class, 'status', 'code');
    // }
    // public function userGroup()
    // {
    //     return $this->belongsTo(Parameter::class, 'user_group', 'code');
    // }
    // public function userCreatedBy()
    // {
    //     return $this->belongsTo(Parameter::class, 'created_at', 'code');
    // }
    // public function instituteProfile()
    // {
    //     return $this->hasOne(InstituteProfile::class, 'person_incharge', 'uid');
    // }

    // public function financialStatements()
    // {
    //     return $this->hasMany(FinancialStatement::class, 'created_by', 'uid');
    // }

}