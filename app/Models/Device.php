<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Device extends Model
{
    use HasFactory ,SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'devices.device_name' => 10,
            'devices.device_number' => 10,
            'devices.device_file_card' => 10,
            'devices.device_model' => 10,
        ],
    ];


    public function device_import_export_logs() // سجل الجهاز كامل تنقلات من ------->إلى
    {
        return $this->hasMany(DeviceLog::class); // id -- Device => device_id -- DeviceLog
    }

    public function institution() // الجهاز عائد لمنشأة  بحسب 'institution_id'
    {
        return $this->belongsTo(Institution::class); // institution_id -- Device  => id -- institution
    }
    public function sub_institution() // الجهاز عائد لمنشأة  بحسب 'institution_id'
    {
        return $this->belongsTo(Institution::class ,'sub_institution_id'); // institution_id -- Device  => id -- institution
    }
    public function employee() // الجهاز عائد لمنشأة  بحسب 'institution_id'
    {
        return $this->belongsTo(Employee::class, 'employee_id'); // Employee_id -- Device  => id -- Employee
    }
    public function device_importNotes() // مجموعة مذكرات إدخال تابعة للجهاز الواحد
    {
        return $this->belongsToMany(ImportRequestNote::class, 'device_logs', 'device_id', 'import_request_note_id');
    }

    public function device_exportNotes() // مجموعة مذكرات تسليم التابعة للجهاز الواحد
    {
        return $this->belongsToMany(ExportRequestNote::class, 'device_logs', 'device_id', 'export_request_note_id');
    }


//----------------------------------------------------------------

    // public function device_Logs() // showDevice
    // {
    //     return $this->hasMany(DeviceLog::class);
    // }

    // public function devices_ImportRequestNote()
    // {
    //     return $this->belongsToMany(ImportRequestNote::class, 'device_logs', 'device_id', 'import_request_note_id');
    // }

    // public function devices_ExportRequestNote() // مجموعة مذكرات تسليم التابعة للجهاز
    // {
    //     return $this->belongsToMany(ExportRequestNote::class, 'device_logs', 'device_id', 'export_request_note_id');
    // }

    // public function institution_devices()
    // {
    //     return $this->belongsTo(Institution::class , 'institution_id');
    // }


//-------------------------------------------------
    // public function devices_ImportRequestNote()
    // {
    //     return $this->belongsTo(ImportRequestNote::class, 'import_request_notes_id');
    // }
    // public function devices_ExportRequestNote()
    // {
    //     return $this->belongsTo(ExportRequestNote::class, 'export_request_notes_id');
    // }

}
