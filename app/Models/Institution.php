<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Institution extends Model
{
    use HasFactory,SearchableTrait;

    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'institutions.institution_name' => 10,
            'institutions.institution_phone' => 10,
        ],
    ];


    //------------------------------------------------------------------
    public function main_institution()
    {
        return $this->belongsTo(Institution::class ,'parent_institution_id' );// id -- institution => parent_institution_id -- institution
    }
    public function sub_institutions()
    {
        return $this->hasMany(Institution::class ,'parent_institution_id' );// id -- institution => parent_institution_id -- Device
    }


    public function employees()
    {
        return $this->hasMany(Employee::class); // id -- institution => institution_id -- Employee
    }
    public function manager()
    {
        return $this->hasOne(Employee::class)->where('employee_job','مدير'); // id -- institution => institution_id -- Employee
    }
    public function storekeeper()
    {
        return $this->hasOne(Employee::class)->where('employee_job','أمين المستودع'); // id -- institution => institution_id -- Employee
    }
    // public function amanuensis()
    // {
    //     return $this->hasOne(Employee::class)->where('employee_job','أمين السر'); // id -- institution => institution_id -- Employee
    // }


    public function manager_first()
    {
        return $this->hasOne(Employee::class)->where('employee_job','مدير ف1'); // id -- institution => institution_id -- Employee
    }
    
    public function manager_second()
    {
        return $this->hasOne(Employee::class)->where('employee_job','مدير ف2'); // id -- institution => institution_id -- Employee
    }


    public function amanuensis_first()
    {
        return $this->hasOne(Employee::class)->where('employee_job','أمين السر ف1'); // id -- institution => institution_id -- Employee
    }

    public function amanuensis_second()
    {
        return $this->hasOne(Employee::class)->where('employee_job','أمين السر ف2'); // id -- institution => institution_id -- Employee
    }
    public function computer_saver()
    {
        return $this->hasMany(Employee::class)->where('employee_job','أمين سر الحاسوب'); // id -- institution => institution_id -- Employee
    }
    public function computer_teacher()
    {
        return $this->hasMany(Employee::class)->where('employee_job','مدرس معلوماتية'); // id -- institution => institution_id -- Employee
    }


    
    public function exported_notes()
    {
        return $this->hasMany(ExportRequestNote::class);
    }
    public function imported_notes()
    {
        return $this->hasMany(ImportRequestNote::class);
    }


    
    public function institution_devices()
    {
        return $this->hasMany(Device::class);// id -- institution => institution_id -- Device
    }
    public function sub_institution_devices()
    {
        return $this->hasMany(Device::class , 'sub_institution_id');// id -- institution => institution_id -- Device
    }

}
