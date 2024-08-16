<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportRequestNote extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function importNote_Devices() // الوصول إلى الأجهزة العائدة لمذكرة الإدخال الواحدة
    {
        return $this->belongsToMany(Device::class, 'device_logs', 'import_request_note_id', 'device_id');
    }
    
    public function importNote_logs() // السجل التابعة للمذكرة لمعرفة ( استلام من ) والموظف  في المذكرة
    {
        return $this->hasMany(DeviceLog::class);// id -- import_request_note => import_request_note_id -- DeviceLog
    }



    public function imported_from() // المنشأة العائدة لمذكرة التسليم
    {
        return $this->belongsTo(Institution::class, 'institution_id');// id => Institution -- Institution_id => ImportRequestNote
    }
    public function imported_from_employee() // المنشأة العائدة لمذكرة التسليم
    {
        return $this->belongsTo(Employee::class, 'employee_id');// id => Institution -- Institution_id => ImportRequestNote
    }

    //-----------------------------------------------------------------------
    // public function imported_Devices()
    // {
    //     return $this->hasMany(Device::class ,'device_id');
    // }
    // public function import_Devices_logs()
    // {
    //     return $this->hasMany(DeviceLog::class);
    // }
    // public function import_Devices_logs()
    // {
    //     return $this->belongsTo(Device::class, 'device_id', 'import_request_note_id');
    // }

}
