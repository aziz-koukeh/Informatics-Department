<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportStockingDevices implements FromCollection ,WithMapping , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Device::all();
        $devices = Device::with(['device_importNotes'])->orderBy('created_at')->get();
        return $devices;
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
