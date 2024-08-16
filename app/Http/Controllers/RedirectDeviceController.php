<?php

namespace App\Http\Controllers;

use App\Models\RedirectDevice;
use App\Models\Institution;
use App\Models\Device;
use App\Models\DeviceLog;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;



class RedirectDeviceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectDevicesNotesLog()
    {
        if (auth()->user()->profile->employee_department != 'الإدارة' 
        && auth()->user()->profile->employee_department != 'شعبة المناقلات'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة'  ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $redirectDevicesNotes= RedirectDevice::orderBy('redirect_note_number')->get();
        return view('mangament.redirectDeviceMangment.redirectDevicesNotesLog',compact('redirectDevicesNotes'));
    }

    public function selectNextSide($institution_slug)
    {
        if (auth()->user()->profile->employee_department != 'شعبة الأتمتة' 
        && auth()->user()->profile->employee_department != 'شعبة المناقلات' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $current_institution = Institution::where('institution_slug',$institution_slug)->first();
        $devices= Device::where('institution_id',$current_institution->id)->get();
        if (!$devices) {
            return redirect()->route('showInstitution', $institution_slug)->with([
                'MainSlowAlertMessage'=>'فشل',
                'SlowAlertMessage'=>'لا يوجد أجهزة للمناقلة  .',
                'alert_type_A'   =>'warning'
            ]);
        }
        $institutions=Institution::where('institution_slug','<>',$institution_slug)
        ->where('institution_kind','first')
        ->orWhere('institution_kind','second')
        ->orWhere('institution_kind','third_pub')
        ->orWhere('institution_kind','circle_pri')
        ->get();
        if (!$institutions) {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يوجد مدارس .',
                'alert_type_A'         =>    'warning'
            ]);

            dd('لا يوجد مدارس أنت وحيد على هذا الكوكب');
        }

        return view('mangament.redirectDeviceMangment.selectNextSide',compact('institutions','devices','current_institution'));
    }
    public function selectNextSideFromPerson($employee_slug)
    {
        if (auth()->user()->profile->employee_department != 'شعبة الأتمتة' 
        && auth()->user()->profile->employee_department != 'شعبة المناقلات' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $current_employee = Employee::where('employee_slug',$employee_slug)->first();

        $devices= Device::where('employee_id',$current_employee->id)->get();
        if (!$devices) {
            return redirect()->route('showEmployee', $employee_slug)->with([
                'MainFastAlertMessage'=>'فشل',
                'FastAlertMessage'=>'لا يوجد أجهزة للمناقلة  .',
                'alert_type_A'   =>'warning'
            ]);
        }
        $institutions=Institution::where('institution_kind','first')
        ->orWhere('institution_kind','second')
        ->orWhere('institution_kind','third_pub')
        ->orWhere('institution_kind','circle_pri')
        ->get();
        if (!$institutions) {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يوجد مدارس .',
                'alert_type_A'         =>    'warning'
            ]);
            dd('لا يوجد مدارس أنت وحيد على هذا الكوكب');
        }

        return view('mangament.redirectDeviceMangment.selectNextSideFromPerson',compact('institutions','devices','current_employee'));
    }


    public function storeRedirectDevice(Request $request)
    {
        // dd($request->all());
        // تحقق من الأخطاء في الإدخال ------------------------------------------------
            $validator =  Validator::make($request->all(), [
                'redirect_note_number'            => ['required'],
                'created_at'                      => ['required'],
            ]);
            if ( $validator->fails() ) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if (!$request->device_slug) {
                return redirect()->back()->with([
                    'MainFastAlertMessage'=>'عذراً',
                    'FastAlertMessage'=>'حدد المواد للمناقلة  .',
                    'alert_type_A'   =>'warning'
                ]);
            }
            if (!$request->redirect_to_employee_side && !$request->redirect_to_institution_side ) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'حدد جهة التسليم .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd('حدد جهة التسليم');
            }
            // متغيرات خاصة بمستقر مواد المناقلة  -------------------------------
            
                $device_to_side_by_employee  = null ;
                $device_to_side_institution = null ;
                $to_institution_id = null ;
                $to_employee_id = null ;

            // متغيرات خاصة بمستقر مواد المناقلة  -------------------------------
            // متغير لمعرفة عدد العهد المحددة ---------------------------------------
            $selectedSides1=0;

            foreach ($request->redirect_to_employee_side as $key1 => $value1) {
                if ($value1 != null) {
                    ++$selectedSides1;
                    $employee= Employee:: where('employee_slug',$value1)->first();
                    $device_to_side_by_employee =$employee->employee_full_name;
                    $to_employee_id = $employee->id;
                    $to_institution_id = $employee->institution->id;
                }
            }
            if ($selectedSides1 == 0) {
                $request->redirect_to_employee_side = null; # تصفير المصفوفة الخاصة بالعهد
            }
            // متغير لمعرفة عدد العهد المحددة ---------------------------------------

            // متغير لمعرفة عدد الجهات المحددة ----------------------------------------
            $selectedSides2=0;

            foreach ($request->redirect_to_institution_side as $key2 => $value2) {
                if ($value2 != null || $request->redirect_to_institution_side_else_person[$key2] != null) {
                    ++$selectedSides2;

                    if (($value2 == 'else_person'|| $value2 == null) && $request->redirect_to_institution_side_else_person[$key2] != null) {
                        $device_to_side_by_employee = $request->redirect_to_institution_side_else_person[$key2];
                    }else{
                        $device_to_side_by_employee = $value2;
                    }
                    $to_institution=Institution::where('institution_slug',$request->redirect_to_side_institution_slug[$key2])->first();
                    $kind=null;
                    if ($to_institution->institution_kind == 'first'){
                        $kind = 'المدرسة الإبتدائية ';
                    }elseif ($to_institution->institution_kind == 'second') {
                        $kind = 'المدرسة الإعدادية ';
                    }elseif ($to_institution->institution_kind == 'third_pub') {
                        $kind = 'الثانوية العامة ';
                    }
                    $device_to_side_institution = $kind.$to_institution->institution_name;
                    $to_institution_id = $to_institution->id;
                }
            }
            if ($selectedSides2 == 0) {
                $request->redirect_to_institution_side = null;# تصفير المصفوفة الخاصة بالعهد
            }
            if ($selectedSides1 + $selectedSides2 > 1) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'إختيار جهة واحدة ... وموظف واحد من الجهة الواحدة .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd('إختيار جهة واحدة ... وموظف واحد من الجهة الواحدة ');
            }elseif ($selectedSides1 + $selectedSides2 == 0) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'إختيار جهة التسليم .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd(' إختيار جهة التسليم ');
            }

            // متغير لمعرفة عدد الجهات المحددة ----------------------------------------

        
        // تحقق من الأخطاء في الإدخال ------------------------------------------------

        // المصدر جهة أم عهدة ---------------------
        $from_institution= null;
        $from_employee= null;
            if ($request->device_from_side_institution_slug) {
                
                $from_institution=Institution::where('institution_slug',$request->device_from_side_institution_slug)->first();    # إحضار المنشأة المصدر 
                $kind=null;
                    if ($from_institution->institution_kind == 'first'){
                        $kind = 'المدرسة الإبتدائية ';
                    }elseif ($from_institution->institution_kind == 'second') {
                        $kind = 'المدرسة الإعدادية ';
                    }elseif ($from_institution->institution_kind == 'third_pub') {
                        $kind = 'الثانوية العامة ';
                    }
                $device_from_side_institution =  $kind . $from_institution->institution_name;                                             # تجهيز اسم المصدر للإنشاء
                if ($request->device_from_side_by_employee =='else' &&  $request->device_from_side_by_employee_else !=null) {     # تحديد اسم الموظف المسلم 
                $device_from_side_by_employee = $request->device_from_side_by_employee_else ;
                }elseif ($request->device_from_side_by_employee  =='else' &&  $request->device_from_side_by_employee_else ==null) {
                    return redirect()->back()->with([
                        'MainSlowAlertMessage' =>    'فشل !!',
                        'SlowAlertMessage'     =>    'حدد الموظف المسلم .',
                        'alert_type_A'         =>    'warning'
                    ]);
                    dd('حدد الموظف المسلم ');
                }else{
                    $device_from_side_by_employee = $request->device_from_side_by_employee ;
                }
                $from_institution_id =  $from_institution->id;                                                                    # وضع أيدي المنشأة المصدر من أجل المناقلة 
                $from_employee_id = null;
                
            }


            elseif ($request->device_from_side_employee_slug) {
                $from_employee=Employee::where('employee_slug',$request->device_from_side_employee_slug)->first();
                $device_from_side_by_employee = $from_employee->employee_full_name ;
                $device_from_side_institution = null ;
                
                $from_institution_id = $from_employee->institution->id ;
                $from_employee_id = $from_employee->id ;
            }
            

        // المصدر جهة أم عهدة --------------------- 

        // حالة المناقلة من عهدة إلى جهة أو العكس أو من عهدة لعهدة أو من جهة لجهة ------------------------------

            if ($selectedSides1 == 1 && $request->device_from_side_employee_slug) {
                $redirect_note_status = ' مناقلة من عهدة إلى عهدة ';
                $from_to = ' مناقلة إلى عهدة ' . $device_to_side_by_employee ;
                
            } elseif ($selectedSides1 == 1 && $request->device_from_side_institution_slug) {
                $redirect_note_status = ' مناقلة من جهة إلى عهدة ';
                $from_to = ' مناقلة إلى عهدة ' . $device_to_side_by_employee ;

            } elseif ($selectedSides2 == 1 && $request->device_from_side_employee_slug) {
                $redirect_note_status = ' مناقلة من عهدة إلى جهة ';
                $from_to = ' مناقلة إلى ' . $device_to_side_institution ;

            } elseif ($selectedSides2 == 1 && $request->device_from_side_institution_slug) {
                $redirect_note_status = ' مناقلة من جهة إلى جهة ';
                $from_to = ' مناقلة إلى ' . $device_to_side_institution ;
            }
            
        // حالة المناقلة من عهدة إلى جهة أو العكس أو من عهدة لعهدة أو من جهة لجهة ------------------------------


        $redirectDeviceNote = RedirectDevice::create([

            'redirect_note_slug'                 => Str::uuid()->toString(),
            'redirect_note_number'               => $request->redirect_note_number,
            'created_at'                         => $request->created_at,
            'redirect_note_status'               => $redirect_note_status,

            'device_from_side_institution'       => $device_from_side_institution,
            'device_from_side_by_employee'       => $device_from_side_by_employee,
            'from_employee_id'                   => $from_employee_id,
            'from_institution_id'                => $from_institution_id,

            'device_to_side_institution'         => $device_to_side_institution,
            'device_to_side_by_employee'         => $device_to_side_by_employee,
            'to_employee_id'                     => $to_employee_id,
            'to_institution_id'                  => $to_institution_id,
            'redirect_update_by_employee'        => auth()->user()->id,
        ]);

        if ($request->has('redirect_note_image')) {
            $photo= $request->redirect_note_image;
            $newPhoto ='IMG_320_redirectDevicesNote_number_'.$redirectDeviceNote->redirect_note_number.'.jpg';
            $photo->move('uploads/redirect_Device_Notes_Image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$redirectDeviceNote->redirect_note_number .'/', $newPhoto);
            $redirectDeviceNote->redirect_note_image='uploads/redirect_Device_Notes_Image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$redirectDeviceNote->redirect_note_number.'/'.$newPhoto;
            $redirectDeviceNote->save();
        }


        foreach ($request->device_slug as $device_slug ) {
            $device=Device::where('device_slug',$device_slug)->first();
            $device->device_infos ='مستعمل';
            $device->institution_id =$to_institution_id;
            $device->sub_institution_id =null;
            $device->employee_id =$to_employee_id;
            $device->save();

            DeviceLog::create([
                'device_log_status'                   => $redirect_note_status ,
                'device_by_person'                    => $from_to,
                'redirect_devices_note_id'            => $redirectDeviceNote->id,
                'created_at'                          => $request->created_at,
                'device_id'                           => $device->id,
            ]);

        }

        if ($device_from_side_institution) {
            $message ='تمت المناقلة من ' .$device_from_side_institution ;
        }else{
            $message ='تمت المناقلة من عهدة ' . $device_from_side_by_employee ;
        }
        if ($device_to_side_institution) {
            $message .=' إلى ' .$device_to_side_institution ;
        }else{
            $message .=' إلى عهدة ' . $device_to_side_by_employee ;
        }




        if ($request->device_from_side_institution_slug) {
                
            return redirect()->route('showInstitution', $from_institution->institution_slug)->with([
                'MainSlowAlertMessage'=>'نجحت المناقلة',
                'SlowAlertMessage'=>$message ,
                'alert_type_A'   =>'success'
            ]);
        }elseif ($request->device_from_side_employee_slug) {
            return redirect()->route('showEmployee', $from_employee->employee_slug)->with([
                'MainSlowAlertMessage'=>'نجحت المناقلة',
                'SlowAlertMessage'=>$message ,
                'alert_type_A'   =>'success'
            ]);
        }



    }

    public function showRedirectDeviceNote($redirect_note_slug)
    {
        if (auth()->user()->profile->employee_department != 'الإدارة' 
        && auth()->user()->profile->employee_department != 'شعبة المناقلات' 
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة' ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $redirectDevicesNote= RedirectDevice::where('redirect_note_slug',$redirect_note_slug)->first();
        $devices =   $redirectDevicesNote->redirectNote_Devices;

        return view('mangament.redirectDeviceMangment.showRedirectDeviceNote',compact('devices','redirectDevicesNote'));
    }

    


    public function destroyRedirectDeviceNote($redirect_note_slug)
    {
        if (auth()->user()->level != 'مشرف'
        || auth()->user()->profile->employee_department != 'شعبة المناقلات') {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك القيام بهذا الإجراء .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $redirectDevicesNote= RedirectDevice::where('redirect_note_slug',$redirect_note_slug)->first();

        // التحقق من عدد الأجهزة وعدم الحذف في حال التسليم لجهة ما ---------
            $this_Note_Devices = $redirectDevicesNote->redirectNote_Devices;
            $check_Count = $redirectDevicesNote->redirectNote_Devices->where('employee_id',$redirectDevicesNote->to_employee_id )->where('institution_id',$redirectDevicesNote->to_institution_id ) ;
            if ($this_Note_Devices != $check_Count) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'لا يمكن حذف مذكرة المناقلة .... هناك أجهزة تابعة لهذه المناقلة تم تسليمهم لمنشأة ما .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd( ' لا يمكن حذف مذكرة المناقلة .... هناك أجهزة تابعة لهذه المناقلة تم تسليمهم لمنشأة ما ولا يمكن حذفها');
            }
        // التحقق من عدد الأجهزة وعدم الحذف في حال التسليم لجهة ما ---------

        foreach ($redirectDevicesNote->redirectNote_Devices as $device) {
            // dd($device->device_import_export_logs->reverse()->take(3)->last()->device_by_person);
            if($device->device_import_export_logs->reverse()->take(3)->last()->device_by_person == 'أمين المستودع'){ # الرجوع ثلاث خطوات والتحقق من المذكرة إذا كان الجهااز من مستودع الدائرة
                $device->device_infos= 'جديد';
            }
            $device->institution_id =$redirectDevicesNote->from_institution_id;
            $device->employee_id =$redirectDevicesNote->from_employee_id;
            $device->save();

            $log_device= $redirectDevicesNote->redirectNote_logs->where('device_id',$device->id)->first();
            $log_device->delete();
        }
        $redirectDevicesNote->delete();



        return redirect()->back()->with([
            'MainSlowAlertMessage'=>'تم حذف المناقلة',
            'SlowAlertMessage'=>'تم حذف المناقلة وإعادة المواد للمصدر  .',
            'alert_type_A'   =>'danger'
        ]);

    }
}
