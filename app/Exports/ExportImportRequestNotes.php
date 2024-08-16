<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportImportRequestNotes implements FromCollection ,WithMapping , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Device::all();
        $devices = Device::orderBy('created_at')->get();
        
        // dd($devices);

        return $devices;
    }

    public function map($devices): array
    {
        $sdd= collect($devices)->unique('device_file_card');
        dd($devices);
        return [
            $sdd->devices->device_name,
            $sdd->device_importNotes->first()->import_request_note_SN,
            $sdd->device_importNotes->first()->import_request_note_folder,
            count($devices->device_importNotes->first()->importNote_Devices),
            $sdd->device_importNotes->first()->import_request_note_status,
            $sdd->device_importNotes->first()->import_device_source,
            $sdd->device_importNotes->first()->import_device_source_from_employee,
            $sdd->device_importNotes->first()->created_at->toDateString(),
        ];
    }

    public function headings(): array
    {
        return [
            'اسم المادة',
            'رقم المذكرة',
            'رقم الجلد',
            'عدد المواد',
            'حالة الإدخال',
            'المصدر',
            'الموظف',
            'تاريخ المذكرة',
        ];
    }
}
