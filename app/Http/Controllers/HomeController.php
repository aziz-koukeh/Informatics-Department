<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Employee;
use App\Models\Institution;

use App\Exports\ExportImportRequestNotes;
use App\Exports\ExportImportRequestNotesByMonth;
use App\Exports\ExportImportRequestNotesByYear;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function exportImportRequestNotes(Request $request)
    {
        if (auth()->user()->level != 'مدير' && auth()->user()->profile->employee_department != 'المستودع') {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل',
                'SlowAlertMessage'     =>    'لا يمكنك تنفيذ هذه الإجراء '  ,
                'alert_type_A'         =>    'danger'
            ]);
        }
        return Excel::download(new ExportImportRequestNotes, 'جميع مذكرات الإدخال.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportImportRequestNotesByDate(Request $request)
    {
        $this->validate($request,[
            'month' => 'nullable',
            'year' => 'nullable',
            'currentYear' => 'nullable',
        ]);

        if ($request->month) {
            $formatted=Carbon::parse($request->month);
            $date=Carbon::parse($formatted)->format('Y-m');
            $formattedMonth = $formatted->format('m');
            $formattedYear = $formatted->format('Y');
            

            return (new ExportImportRequestNotesByMonth())->forDate( $date  )->download('مذكرات الإدخال لشهر '. $formattedMonth .' لسنة '. $formattedYear .'.xlsx');
        }else{

            if ($request->year) {
                $date=$request->year;
            }
            elseif ($request->currentYear) {
                $date=Carbon::today()->format('Y');
            }

            return (new ExportImportRequestNotesByYear())->forDate( $date )->download('مذكرات الإدخال لسنة '. $date .'.xlsx');
        }




        // if ($request->month) {
            // $date =$request->month;
        //     $type = 'month';

        // } elseif($request->year) {
        //     $date =$request->year;
            $type = 'year';


        // }
        $date = Carbon::parse($request->month);
        $formattedMonth = $date->format('m');
        $formattedYear = $date->format('Y');
        dd($formattedMonth);
        // return (new DevicesExportByDate())->forDate( $date ,$type )->download('سجل جرد لشهر '. $formattedMonth .' لسنة '. $formattedYear .'.xlsx');
        return (new DevicesExportByDate())->forDate( $date )->download(' لسنة '. $formattedYear .'.xlsx');
    }

    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null ;
        $devices=[];
        $employees=[];
        $institutions=[];

        if ($keyword != null ){
            $devices= Device::search($keyword, null , true ,true )->get();
            $employees = Employee::search($keyword, null , true ,true )->get();
            $institutions = Institution::search($keyword, null , true ,true )->get();
            
        }
        return view('mangament.searchPage',compact('devices','employees','institutions'));
    }
}
