<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Institution;
use App\Models\ImportRequestNote;
use App\Models\ExportRequestNote;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeRoom()
    {
        if (auth()->user()->profile->employee_department != 'الإدارة' 
        && auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $devices= Device::all();
        $exportRequestNotes= ExportRequestNote::orderBy('created_at')->get();
        $importRequestNotes= ImportRequestNote::orderBy('created_at')->get();
        return view('mangament.storeRoomMangment.storeRoom',compact('devices','exportRequestNotes','importRequestNotes'));
    }




    public function stockingDevices(Request $request)
    {
        if ( auth()->user()->profile->employee_department != 'المستودع') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $devices=[];
        $kind= '';
        if ($request->all == 'all') {
            $devices=device::orderBy('created_at')->get();
            $kind= 'جرد جميع الأجهزة';
            $exportType='all';
            $date=null;
        }
        elseif ($request->currentYear == 'currentYear') {
            $devices=device::whereYear('created_at',date('Y'))->orderBy('created_at')->get();
            $kind= 'جرد السنة الحالية';
            $exportType='currentYear';
            $date= date('Y');
        }
        elseif ($request->year) {
            $date=$request->year;
            $devices=device::whereYear('created_at',$date)->orderBy('created_at')->get();
            
            $kind= 'جرد الأجهزة سنة '.$date.' م';
            $exportType='year';
        }
        elseif ($request->month) {
            $date=Carbon::parse($request->month);
            
            $devices=device::whereMonth('created_at',$date->format('m'))->whereYear('created_at',$date->format('Y'))->orderBy('created_at')->get();
            
            $kind= 'جرد الأجهزة لشهر '.$date->format('m').' لسنة '.$date->format('Y').' م';
            $exportType='month';
        }else {
          return  redirect()->back();
        }
        return view('mangament.storeRoomMangment.stockingDevices',compact('devices','kind','exportType','date'));
    }



    public function showDevice($device_slug)
    {
        $device=device::where('device_slug',$device_slug)->first();

        return view('mangament.storeRoomMangment.deviceMangment.showDevice',compact('device'));
    }
    public function showAllDevices($device_model) /////
    {
        $devices=device::where('device_model',$device_model)->get();

        return view('mangament.storeRoomMangment.deviceMangment.showAllDevice',compact('devices'));
    }

    public function edit(Device $device)
    {
        //
    }


    public function updateDevice(Request $request, $device_slug)
    {
        $validator =  Validator::make($request->all(), [
            'device_details'              => ['nullable'],
            'device_notes'                 => ['nullable', ],
            'device_status'              => ['nullable'],
            'device_report'              => ['nullable'],
            'device_belongings'           => ['nullable'],
            'device_belongings_count'     => ['nullable', ],


        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $device=Device::where('device_slug',$device_slug)->first();

        if ($request->device_details) {
            $device->device_details = $request->device_details;
        }

        if ($request->device_notes) {
            $device->device_notes = $request->device_notes;
        }

        if ($request->device_status) {
            $device->device_status = $request->device_status;
        }

        if ($request->device_report) {
            $device->device_report = $request->device_report;
        }

        if ($request->device_belongings) {
            $device->device_belongings = $request->device_belongings;
        }

        if ($request->device_belongings_count) {
            $device->device_belongings_count = $request->device_belongings_count;
        }



        $device->save();



        // ---------------- حلقة فور بعدد المواد -------------------------
        
        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث معلومات المادة بنجاح .',
            'alert_type_A'         =>    'success'
        ]);


    }



    public function destroy(Device $device)
    {
        //
    }
}
