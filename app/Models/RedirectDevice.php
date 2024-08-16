<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectDevice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function from_person()
    {
        return $this->belongsTo(Employee::class, 'from_employee_id'); // id => Employee -- from_employee_id => RedirectDevice
    }
    public function from_institution()
    {
        return $this->belongsTo(Institution::class, 'from_institution_id');// id => Institution -- from_institution_id => RedirectDevice
    }
    public function to_person()
    {
        return $this->belongsTo(Employee::class, 'to_employee_id');// id => Employee -- to_employee_id => RedirectDevice
    }
    public function to_institution()
    {
        return $this->belongsTo(Institution::class, 'to_institution_id');// id => Institution -- to_institution_id => RedirectDevice
    }




    public function redirectNote_Devices() // الوصول إلى الأجهزة العائدة للمناقلة الواحدة
    {
        return $this->belongsToMany(Device::class, 'device_logs', 'redirect_devices_note_id', 'device_id');
    }

    public function redirectNote_logs() 
    {
        return $this->hasMany(DeviceLog::class , 'redirect_devices_note_id');// id -- RedirectDevice => RedirectDevice_id -- DeviceLog
    }


}
