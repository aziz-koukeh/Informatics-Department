<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;


class ExportStockingDevicesByYear implements FromQuery , WithMapping , WithHeadings
{
    use Exportable;


    public function forDate($date)
    {    
        $this->date = $date;
        return $this;
    }

    public function query()
    {
       return Device::orderBy('created_at')->whereYear('created_at', $this->date) ;
       
    }


     public function map($devices): array
    {
        return [
            $devices->device_name,
            $devices->device_importNotes->first()->import_request_note_SN,
            $devices->device_importNotes->first()->created_at->toDateString(),
            $devices->device_importNotes->first()->import_device_source,
            $devices->device_importNotes->first()->import_device_source_from_employee,
        ];
    }

    public function headings(): array
    {
        return [
            'اسم المادة',
            'رقم المذكرة',
            'تاريخ الإدخال',
            'الجهةالمسلمة',
            'اسم الموظف',
        ];
    }
}
