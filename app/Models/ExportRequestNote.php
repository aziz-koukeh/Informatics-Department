<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportRequestNote extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function exportNote_Devices() // الوصول إلى الأجهزة العائدة لمذكرة التسليم الواحدة
    {
        return $this->belongsToMany(Device::class, 'device_logs', 'export_request_note_id', 'device_id');
    }

    public function exported_to() // المنشأة العائدة لمذكرة التسليم
    {
        return $this->belongsTo(Institution::class, 'institution_id');// id => Institution -- Institution_id => ExportRequestNote
    }
    public function exported_to_employee() // المنشأة العائدة لمذكرة التسليم
    {
        return $this->belongsTo(Employee::class, 'employee_id');// id => Institution -- Institution_id => ExportRequestNote
    }

    public function exportNote_logs() // السجل التابعة للمذكرة لمعرفة ( تسليم إلى ) والموظف  في المذكرة
    {
        return $this->hasMany(DeviceLog::class);// id -- export_request_note => export_request_note_id -- DeviceLog
    }


    //----------------------------------------------

    // public function exported_Devices()
    // {
    //     return $this->hasMany(Device::class );
    // }

    // public function devices_Export_log()
    // {
    //     return $this->belongsTo(DeviceLog::class, 'export_request_notes_id');
    // }
    // public function devices() /// ???????????????????!!!!!!!!!!!!!!!! in SelectDevicesBack {view} لماذا لا أعود للأجهزة التابعة للمنشأة عوضا عن الاستعلام من مذكرة التسليم ؟
    // {
    //     return $this->belongsToMany(Device::class, 'device_logs', 'export_request_note_id', 'device_id')->whereNotNull('institution_id');
    // }
    // public function export_Devices_logs()
    // {
    //     return $this->hasMany(DeviceLog::class);
    // }

    //----------------------------------------
    // public function exportNote_Devices()
    // {
    //     return $this->belongsToMany(Device::class, 'device_logs', 'export_request_note_id', 'device_id');
    // }
}
