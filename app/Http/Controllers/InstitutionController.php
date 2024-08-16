<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\InstitutionEmployee;
use App\Models\ExportRequestNote;
use App\Models\Employee;
use App\Models\Device;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function allInstitutions()
    {
        if ( auth()->user()->profile->employee_department == 'شعبة الديوان') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $institutions=Institution::whereNull('parent_institution_id')->get();

        return view('mangament.institutionsMangment.allInstitutions',compact('institutions'));
    }


    public function showInstitution($institution_slug) // $employee_slug
    {
        $institution=Institution::with(['institution_devices'])->where('institution_slug',$institution_slug)->first();
        if ( auth()->user()->profile->employee_department == 'شعبة الديوان' && $institution->institution_name != 'دائرة المعلوماتية' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        // $exportRequestNotes= ExportRequestNote::with(['exportNote_Devices'])->where('institution_id',$institution->id)->get();

        return view('mangament.institutionsMangment.showInstitution',compact('institution'));
    }


    public function institutionMap($institution_slug) // $employee_slug
    {
 
        $institution=Institution::where('institution_slug',$institution_slug)->first();
        if ( auth()->user()->profile->employee_department == 'شعبة الديوان' && $institution->institution_name != 'دائرة المعلوماتية' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        return view('mangament.institutionsMangment.institutionMap',compact('institution'));
    }



    public function storeInstitution(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'institution_name'                 => ['required',  'max:100'],
            'institution_kind'                 => ['required',  'max:50'],
            'institution_phone'                => ['nullable'],
            'institution_map'                  => ['nullable'],
            'institution_address'              => ['required'],
            'institution_image'                => ['nullable', ],
            'institution_bio'                  => ['nullable', ],

        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $institution= Institution:: create([


            'institution_name'             => $request->institution_name,
            'institution_slug'             => Str::uuid()->toString(),
            'institution_phone'            => $request->institution_phone,
            'institution_kind'             => $request->institution_kind,
            'institution_map'              => $request->institution_map,
            'institution_address'          => $request->institution_address,
            'institution_bio'              => $request->institution_bio,
            'parent_institution_id'        => $request->parent_institution_id,
        ]);

        $kind = '';
        if ($institution->institution_kind == 'first'){
            $kind = ' مدرسة ';
        }elseif ($institution->institution_kind == 'second') {
            $kind = ' إعدادية ';
        }elseif ($institution->institution_kind == 'third_pub') {
            $kind = ' الثانوية العامة ';
        }elseif ($institution->institution_kind == 'third_pro') {
            $kind = ' الثانوية المهنية ';
        }elseif ($institution->institution_kind == 'college') {
            $kind = ' معهد ';
        }elseif ($institution->institution_kind == 'compound') {
            $kind = ' مجمع ';
        }elseif ($institution->institution_kind == 'circle_pri') {
            $kind = ' الدائرة العامة ';
        }elseif ($institution->institution_kind == 'circle_sec') {
            $kind = ' الدائرة الفرعية';
        }
        
        if ($request->hasFile('institution_image')) {
            $photo= $request->institution_image;
            $newPhoto ='IMG_320_'.$kind.$institution->institution_name.'.jpg';
            $photo->move('uploads/institutions_image/', $newPhoto);
            $institution->institution_image='uploads/institutions_image/'.$newPhoto;
        }
        $institution->save();



        return redirect()->route('showInstitution', $institution->institution_slug)->with([
            'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
            'FastAlertMessage'     =>    'تم إنشاء بيانات '.$kind . ' ' . $institution->institution_name . '  بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
         


    }


    public function updateInstitution(Request $request, $institution_slug)
    {
        $validator =  Validator::make($request->all(), [
            'institution_name'                 => ['required',  'max:100'],
            'institution_kind'                 => ['nullable',  'max:50'],
            'institution_phone'                => ['nullable'],
            'institution_map'                  => ['nullable'],
            'institution_address'              => ['required'],
            'institution_image'                => ['nullable', ],
            'institution_bio'                  => ['nullable', ],

        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $institution= Institution:: where('institution_slug',$institution_slug)->first();


        if ($request->institution_name) {
            $institution->institution_name       = $request->institution_name;
        }
        if ($request->institution_kind) {
            $institution->institution_kind    = $request->institution_kind;
        }
        if ($request->institution_phone) {
            $institution->institution_phone      = $request->institution_phone;
        }
        if ($request->institution_map) {
            $institution->institution_map        = $request->institution_map;
        }

        if ($request->institution_address) {
            $institution->institution_address    = $request->institution_address;
        }
        if ($request->institution_bio) {
            $institution->institution_bio        = $request->institution_bio;
        }
        // dd($institution->institution_kind);
        
        if ($institution->institution_kind == 'first'){
            $kind = ' مدرسة ';
        }elseif ($institution->institution_kind == 'second') {
            $kind = ' إعدادية ';
        }elseif ($institution->institution_kind == 'third_pub') {
            $kind = ' الثانوية العامة ';
        }elseif ($institution->institution_kind == 'third_pro') {
            $kind = ' الثانوية المهنية ';
        }elseif ($institution->institution_kind == 'college') {
            $kind = ' معهد ';
        }elseif ($institution->institution_kind == 'compound') {
            $kind = ' مجمع ';
        }elseif ($institution->institution_kind == 'circle_pri') {
            $kind = ' الدائرة العامة ';
        }elseif ($institution->institution_kind == 'circle_sec') {
            $kind = ' الدائرة الفرعية';
        }
        if ($request->hasFile('institution_image')) {
            $photo= $request->institution_image;
            $newPhoto ='IMG_320_'.$kind.$institution->institution_name.'.jpg';
            $photo->move('uploads/institutions_image/', $newPhoto);
            $institution->institution_image='uploads/institutions_image/'.$newPhoto;
        }

        $institution->save();



        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث بيانات '.$kind . ' ' . $institution->institution_name . '  بنجاح .',
            'alert_type_A'         =>    'success'
        ]);


    }
    public function devices_main_sub_institution($institution_slug)
    {
        if (auth()->user()->profile->employee_department != 'شعبة الحاسب التعليمي' 
        && auth()->user()->profile->employee_department != 'المستودع' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $sub_institution=Institution::where('institution_slug',$institution_slug)->first();
        $main_institution=$sub_institution->main_institution;
        $devices= Device::where('institution_id',$main_institution->id)->whereNull('sub_institution_id')->get();
        return view('mangament.storeRoomMangment.deviceMangment.devices_main_sub_institution',compact('devices','sub_institution','main_institution'));
    }
    public function store_devices_to_sub_institution(Request $request , $institution_slug)
    {
        $sub_institution=Institution::where('institution_slug',$institution_slug)->first();
        foreach ($request->device_slug as $device_slug) {
            $device=Device::where('device_slug',$device_slug)->first();
            if ($device) {
                $device->sub_institution_id= $sub_institution->id;
                $device->save();
            }
        }
        return redirect()->route('showInstitution',$institution_slug)->with([
            'MainFastAlertMessage' =>    'نجاح',
            'FastAlertMessage'     =>    'تم تحديد الأجهزة التابعة  .',
            'alert_type_A'         =>    'success'
        ]);
    }
    public function devices_sub_main_institution($institution_slug)
    {
        if (auth()->user()->profile->employee_department != 'شعبة الحاسب التعليمي' 
        && auth()->user()->profile->employee_department != 'المستودع' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $main_institution=Institution::where('institution_slug',$institution_slug)->first();
        $devices= Device::where('institution_id',$main_institution->id)->whereNotNull('sub_institution_id')->get();
        if (count($devices) == 0) {
            return redirect()->route('showInstitution',$institution_slug)->with([
                'MainFastAlertMessage' =>    'تنبيه',
                'FastAlertMessage'     =>    'كل الأجهزة غير مسلمة '.$main_institution->institution_name,
                'alert_type_A'         =>    'success'
            ]);
        }
        return view('mangament.storeRoomMangment.deviceMangment.devices_sub_main_institution',compact('devices','main_institution'));
    }
    public function store_devices_to_main_institution(Request $request , $institution_slug)
    {
        $main_institution=Institution::where('institution_slug',$institution_slug)->first();
        foreach ($request->device_slug as $device_slug) {
            $device=Device::where('device_slug',$device_slug)->first();
            if ($device) {
                $device->sub_institution_id= null;
                $device->save();
            }
        }
        return redirect()->route('showInstitution',$institution_slug)->with([
            'MainFastAlertMessage' =>    'نجاح',
            'FastAlertMessage'     =>    'تم إعادة نقل الأجهزة التابعة إلى '.$main_institution->institution_name,
            'alert_type_A'         =>    'success'
        ]);
    }

}
