<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteProfile extends Model
{
    use HasFactory;

    protected $table = 'profile_inst';

    protected $fillable = [
        'inst_refno', 'address_line_1', 'address_line_2', 'state', 'city', 
        'postcode', 'telephone_no', 'fax_no', 'email', 'web_url', 'media_social', 
        'dun', 'parliament', 'institutional_area', 'total_capacity', 
        'inst_coordinate', 'person_incharge', 'jatums_date', 'status', 
        'approved_by', 'created_by', 'updated_by'
    ];
    
    public function institute()
    {
        return $this->belongsTo(Institute::class, 'inst_refno', 'inst_refno');
    }

    public function personIncharge()
    {
        return $this->belongsTo(User::class, 'person_incharge', 'uid');
    }

    public function instituteState()
    {
        return $this->belongsTo(Parameter::class, 'state', 'code');
    }

    public function instituteCity()
    {
        return $this->belongsTo(Parameter::class, 'city', 'code');
    }

}
