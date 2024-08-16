<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function log_ImportNote()
    {
        return $this->belongsTo(ImportRequestNote::class , 'import_request_note_id');// id => ImportRequestNote -- ImportRequestNote_id => DeviceLog
    }
    public function log_ExportNote()
    {
        return $this->belongsTo(ExportRequestNote::class , 'export_request_note_id');// id => ExportRequestNote -- ExportRequestNote_id => DeviceLog
    }
    public function log_RedirectNote()
    {
        return $this->belongsTo(RedirectDevice::class , 'redirect_devices_note_id');// id => RedirectDevice -- RedirectDeviceNote_id => DeviceLog
    }

//-------------------------------------------------------------
    public function log_device() 
    {
        return $this->belongsTo(Device::class , 'device_id'); // id => Device -- device_id => DeviceLog
    }
//-------------------------------------------------------------
}
