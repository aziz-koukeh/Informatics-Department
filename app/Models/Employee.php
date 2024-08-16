<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Employee extends Model
{
    use HasFactory,SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'employees.employee_full_name' => 10,
            'employees.employee_national_number' => 10,
            'employees.employee_self_number' => 10,
            'employees.employee_job' => 10,
        ],
    ];

    public function account()
    {
        return $this->hasOne(User::class);
    }
    public function employee_devices()
    {
        return $this->hasMany(Device::class);// id -- employee => employee_id -- Device
    }


    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');// id => Institution -- Institution_id => Employee
    }
}
