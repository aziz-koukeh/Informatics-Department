<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceLog;
use App\Models\Institution;
use App\Models\Employee;
use App\Models\ImportRequestNote;
use App\Models\ExportRequestNote;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ExportRequestNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function selectExportRequestNote($institution_slug)
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $current_institution = Institution::where('institution_slug',$institution_slug)->first();
        if ($current_institution->institution_kind == 'third_pro' || $current_institution->institution_kind == 'college' || $current_institution->institution_kind == 'compound' || $current_institution->institution_kind == 'circle_sec') {
            if (!$current_institution->storekeeper) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'خطأ !! ',
                    'SlowAlertMessage'     =>    'لا يمكنك تسليم المنشأة بدون تحديد الموظف المسؤول عن المستودع  .',
                    'alert_type_A'         =>    'warning'
                ]);
            }
        }
        $allowed_devices=Device::whereNull('institution_id')->get();
        return view('mangament.storeRoomMangment.exportNotes.selectExportRequestNote',compact('allowed_devices','current_institution'));
    }

    public function selectExportRequestNoteForPerson($employee_slug)
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $employee = Employee::where('employee_slug',$employee_slug)->first();
        $allowed_devices=Device::whereNull('institution_id')->get();
        return view('mangament.storeRoomMangment.exportNotes.selectExportRequestNoteForPerson',compact('allowed_devices','employee'));
    }

    public function storeExportRequestNote(Request $request , $institution_slug )
    {
        
        $validator =  Validator::make($request->all(), [
            'export_request_note_by_person'       => ['required'],
            'export_request_note_folder'          => ['required'],
            'export_request_note_SN'              => ['required'],
            'created_at'                          => ['required'],
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //   عهدة أم جهة -------------------
        if ($request->employee_slug) {
            $employee= Employee::where('employee_slug',$request->employee_slug)->first();
            $institution = $employee->institution;
        } else {
            $institution = Institution::where('institution_slug',$institution_slug)->first();
        }
        //   عهدة أم جهة -------------------
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

        $by_person='';
        if ($request->export_request_note_by_person == 'else' && $request->export_request_note_by_person_else != null) {
            $by_person = $request->export_request_note_by_person_else ;
        }elseif ($request->export_request_note_by_person == 'else' && $request->export_request_note_by_person_else == null) {
            
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'إملأ حقل الموظف المفوض أو اختر موظف من الخيارات  .',
                'alert_type_A'         =>    'warning'
            ]);
            
            dd('إملأ الحقل أو أختر شخص ما');
        }else {
            $by_person = $request->export_request_note_by_person ;
        }
        if ($request->employee_slug) {
            $export_request_note=ExportRequestNote::create([
                'export_request_note_slug'            => Str::uuid()->toString(),
                'export_request_note_SN'              => $request->export_request_note_SN,
                'export_request_note_folder'          => $request->export_request_note_folder,
                'export_request_note_status'          => 'تسليم إلى عهدة موظف ' ,
                'export_request_note_by_person'       => $by_person,
                'created_at'                          => $request->created_at,
                'institution_id'                      => $institution->id,
                'employee_id'                         => $employee->id,
                'export_update_by_employee'           => auth()->user()->id,
            ]);
        }else{
            $export_request_note=ExportRequestNote::create([
                'export_request_note_slug'            => Str::uuid()->toString(),
                'export_request_note_SN'              => $request->export_request_note_SN,
                'export_request_note_folder'          => $request->export_request_note_folder,
                'export_request_note_status'          => 'تسليم إلى '.$kind. $institution->institution_name ,
                'export_request_note_by_person'       => $by_person,
                'created_at'                          => $request->created_at,
                'institution_id'                      => $institution->id,
                'export_update_by_employee'           => auth()->user()->id,
            ]);
        }
        if ($request->has('export_request_image')) {
            $photo= $request->export_request_image;
            $newPhoto ='IMG_320_export_request_note_number_'.$export_request_note->export_request_note_SN.'.jpg';
            $photo->move('uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/', $newPhoto);
            $export_request_note->export_request_image='uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'.$newPhoto;
            $export_request_note->save();
        }


        foreach ($request->device_slug as $device_slug) {
            $device=Device::where('device_slug',$device_slug)->first();
                    
            if ($request->employee_slug) {
                DeviceLog::create([
                    'device_log_status'                   => 'تسليم إلى عهدة موظف ' ,
                    'device_by_person'                    => $export_request_note->export_request_note_by_person,
                    'export_request_note_id'              => $export_request_note->id,
                    'created_at'                          => $request->created_at,
                    'device_id'                           => $device->id,
                ]);
                $device->employee_id = $employee->id;

            }else{
                DeviceLog::create([
                    'device_log_status'                   => 'تسليم إلى '.$kind. $institution->institution_name ,
                    'device_by_person'                    => $export_request_note->export_request_note_by_person,
                    'export_request_note_id'              => $export_request_note->id,
                    'created_at'                          => $request->created_at,
                    'device_id'                           => $device->id,
                ]);
            }
            $device->institution_id = $institution->id;
            $device->save();

        }

        if ($request->employee_slug) {
            return redirect()->route('showEmployee', $request->employee_slug)->with([
                'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
                'FastAlertMessage'     =>    'تم إنشاء مذكرة التسليم بنجاح .',
                'alert_type_A'         =>    'success'
            ]);
        } else {
            return redirect()->route('showInstitution', $institution->institution_slug)->with([
                'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
                'FastAlertMessage'     =>    'تم إنشاء مذكرة التسليم بنجاح .',
                'alert_type_A'         =>    'success'
            ]);
        }
        


    }
    public function showExportRequestNote($export_request_note_slug)
    {
        if ( auth()->user()->level != 'مدير'
        && auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $export_request_note=ExportRequestNote::where('export_request_note_slug',$export_request_note_slug)->first();
        $allowed_devices=Device::whereNull('institution_id')->get();
        return view('mangament.storeRoomMangment.exportNotes.show_export_request_note',compact('export_request_note','allowed_devices'));
    }



    public function updateExportRequestNote(Request $request , $export_request_note_slug )
    {
        $validator =  Validator::make($request->all(), [
            'export_request_note_by_person'       => ['required'],
            'export_request_note_folder'          => ['required'],
            'export_request_note_SN'              => ['required'],
            'created_at'                          => ['required'],
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $export_request_note=ExportRequestNote::where('export_request_note_slug',$export_request_note_slug)->first();

       //   عهدة أم جهة -------------------
       if ($request->employee_slug) {
            $employee= Employee::where('employee_slug',$request->employee_slug)->first();
            $institution = $employee->institution;
        } else {
            $institution = $export_request_note->exported_to;
        }
        //   عهدة أم جهة -------------------
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

        if ($request->employee_slug) {
            $employee= Employee::where('employee_slug',$request->employee_slug)->first();
            $export_request_note->export_request_note_status = 'تسليم إلى عهدة موظف ' ;
            $export_request_note->employee_id= $employee->id;
        } else {
            $export_request_note->export_request_note_status = 'تسليم إلى '.$kind. $institution->institution_name ;
        }
        
        if ($request->export_request_note_by_person_else && $request->export_request_note_by_person =='else' ) {
            $export_request_note->export_request_note_by_person = $request->export_request_note_by_person_else;

        } elseif ($request->export_request_note_by_person_else == null && $request->export_request_note_by_person =='else' ) {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'إملأ حقل الموظف المفوض أو اختر موظف من الخيارات  .',
                'alert_type_A'         =>    'warning'
            ]);
            dd('إملأ الحقل الخاص بالموظف أو أختر جهة ما');

        }else{
            $export_request_note->export_request_note_by_person =$request->export_request_note_by_person;
        }


        if ($request->export_request_note_folder) {
            $export_request_note->export_request_note_folder =$request->export_request_note_folder;
        }
        if ($request->export_request_note_SN) {
            $export_request_note->export_request_note_SN =$request->export_request_note_SN;
        }
        if ($request->created_at ) {
            
            // //  تعديل الصورة إلى تاريخ جديد وحذف القديمة  -------
            // $media_file_name ='IMG_320_export_request_note_number_'.$export_request_note->export_request_note_SN.'.jpg';
            // $file =File::exists('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'. $media_file_name);
            // if ($file) {
            //     $contents =File::copy('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'. $media_file_name);
            //     dd($contents);

            //     $contents = File::copy('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/',$media_file_name);
            //     // $contents->move('uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/', $newPhoto);
            //     // $path = 'uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'. $media_file_name;
            //     $newPath ='uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'. $media_file_name;
            //     File::move($contents , $newPath);
            //     // // // dd($file,$path , $newPath );
            //     // File::copy($path , move($newPath));
                
            //     $export_request_note->export_request_image='uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'.$media_file_name;

            //     // unlink('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/' . $media_file_name);
            // }

            
            // //  تعديل الصورة إلى تاريخ جديد وحذف القديمة  -------
            $export_request_note->created_at =$request->created_at;
        }

        if ($request->has('export_request_image')) {
            $photo= $request->export_request_image;
            $newPhoto ='IMG_320_export_request_note_number_'.$export_request_note->export_request_note_SN.'.jpg';
            $photo->move('uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/', $newPhoto);
            $export_request_note->export_request_image='uploads/export_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'.$newPhoto;
        }
        $export_request_note->export_update_by_employee = auth()->user()->id ;
        $export_request_note->save();
        // dd($export_request_note);

        foreach ($export_request_note->exportNote_logs as $log) {
            $log->device_by_person = $export_request_note->export_request_note_by_person ;
            $log->created_at = $request->created_at ;
            $log->save() ;
        }

        
        // حلقة فور كمية المواد في كل صنف ----------
        foreach ($request->device_model as $key => $value) {
            $countDevices = (integer)$request->device_count[$key];
            $allDevices= 0 ;
            foreach ($request->device_count as $i) {
                $allDevices = $allDevices+(integer)$i;
            }
           
            // dd($allDevices);
            if ($allDevices == 0){
                return redirect()->back()->with([
                    'MainFastAlertMessage' =>    'فشل !!',
                    'FastAlertMessage'     =>    'لا يمكن ترك المذكرة بدون أجهزة .',
                    'alert_type_A'         =>    'warning'
                ]);
            }
            if ($allDevices > 0) {
                # عدد الأجهزة في هذه المذكرة من نفس رقم البطاقة للجهاز
                $this_Note_Devices_Same_device_model =$export_request_note->exportNote_Devices->where('device_model',$value);
                // dd( $this_Note_Devices_Same_device_model);
                # إذا كان عدد الأجهزة أكبر من المجتوى الأصلي

                if ($countDevices >  $this_Note_Devices_Same_device_model->count() ) {
                    # عدد الفرق للأجهزة
                    $addDevices = $countDevices - count($this_Note_Devices_Same_device_model) ;
                    $id_array= [];
                    foreach ($this_Note_Devices_Same_device_model as $key => $device) {
                        $id_array[$key]=  $device->id;
                    }

                    $devices=Device::where('device_model',$value)->whereNull('institution_id')->whereNotIn('id',$id_array)->limit($addDevices)->get();
                    // dd($devices, $this_Note_Devices_Same_device_model);

                    if ($devices) {
                        foreach ($devices as $device) {
                            //    ---------عهدة أم جهة --------  تعديل على الأجهزة والسجل -----------
                            if ($request->employee_slug) {
                                DeviceLog::create([
                                    'device_log_status'                   => 'تسليم إلى عهدة موظف ' ,
                                    'device_by_person'                    => $export_request_note->export_request_note_by_person,
                                    'export_request_note_id'              => $export_request_note->id,
                                    'created_at'                          => $request->created_at,
                                    'device_id'                           => $device->id,
                                ]);
                                $device->employee_id = $employee->id;
    
                            }else{
                                DeviceLog::create([
                                    'device_log_status'                   => 'تسليم إلى '.$kind. $institution->institution_name ,
                                    'device_by_person'                    => $export_request_note->export_request_note_by_person,
                                    'export_request_note_id'              => $export_request_note->id,
                                    'created_at'                          => $request->created_at,
                                    'device_id'                           => $device->id,
                                ]);
                            }
                            $device->institution_id = $institution->id;
                            $device->save();
                            //    ---------عهدة أم جهة --------  تعديل على الأجهزة والسجل -----------
                        }

                    }

                } elseif ($countDevices <  $this_Note_Devices_Same_device_model->count() ) {
                    $subDevices = count($this_Note_Devices_Same_device_model) - $countDevices ;
                    $cancelDevices = $this_Note_Devices_Same_device_model->reverse()->take($subDevices);

                    foreach ($cancelDevices as $cancelDevice) {
                        $cancelDevice->employee_id = null ;
                        $cancelDevice->institution_id = null ;
                        $cancelDevice->save();
                        $log_device= $export_request_note->exportNote_logs->where('device_id',$cancelDevice->id)->first();
                        $log_device->delete();
                    }
                }


            }
        }


        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث معلومات مذكرة التسليم بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
         


    }




    public function exportRequestNotesLog(Request $request)
    {
        if (auth()->user()->level != 'مدير'
        && auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }

        $exportRequestNotes=[];
        $kind= '';
        if ($request->all == 'all') {
            $exportRequestNotes=ExportRequestNote::orderBy('created_at')->get();
            $kind= 'جميع مذكرات التسليم';
        }
        elseif ($request->currentYear == 'currentYear') {
            $exportRequestNotes=ExportRequestNote::whereYear('created_at',date('Y'))->orderBy('created_at')->get();
            $kind= 'مذكرات تسليم السنة الحالية';
        }
        elseif ($request->year) {
            $date=$request->year;
            $exportRequestNotes=ExportRequestNote::whereYear('created_at',$date)->orderBy('created_at')->get();
            
            $kind= 'مذكرات تسليم سنة '.$date.' م';
        }
        elseif ($request->month) {
            $date=Carbon::parse($request->month);
            
            $exportRequestNotes=ExportRequestNote::whereMonth('created_at',$date->format('m'))->whereYear('created_at',$date->format('Y'))->orderBy('created_at')->get();
            
            $kind= 'مذكرات تسليم لشهر '.$date->format('m').' لسنة '.$date->format('Y').' م';
        }else {
          return  redirect()->back();
        }
        return view('mangament.storeRoomMangment.exportNotes.exportRequestNotesLog',compact('exportRequestNotes','kind'));
    }



    public function destroyExportRequestNote($export_request_note_slug)
    {
        if (auth()->user()->level != 'مشرف'
        || auth()->user()->profile->employee_department != 'المستودع') {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك القيام بهذا الإجراء .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $export_request_note= ExportRequestNote::where('export_request_note_slug',$export_request_note_slug)->first();

        // التحقق من عدد الأجهزة وعدم الحذف في حال التسليم لجهة ما ---------
            $this_Note_Devices = $export_request_note->exportNote_Devices->count();
            $check_Count = $export_request_note->exportNote_Devices->where('institution_id',$export_request_note->exported_to->id )->count() ;
            if ($this_Note_Devices != $check_Count) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'لا يمكن حذف مذكرة التسليم .... هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن حذفها .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd(' لا يمكن حذف مذكرة التسليم .... هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن حذفها');
            }
        // التحقق من عدد الأجهزة وعدم الحذف في حال التسليم لجهة ما ---------
            
        foreach ($export_request_note->exportNote_Devices as $device) {
            $device->employee_id = null ;
            $device->institution_id= null ;
            $device->save();
            $log_device= $export_request_note->exportNote_logs->where('device_id',$device->id)->first();
            $log_device->delete();
        }
        if ( $export_request_note->export_request_image) {
            $media_file_name ='IMG_320_export_request_note_number_'.$export_request_note->export_request_note_SN.'.jpg';
            if (File::exists('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/'. $media_file_name)) {
                unlink('uploads/export_request_notes_image/'.Carbon::parse($export_request_note->created_at)->format('Y').'/'.Carbon::parse($export_request_note->created_at)->format('m').'/'.Carbon::parse($export_request_note->created_at)->format('d').'/'.$export_request_note->export_request_note_SN.'/' . $media_file_name);
            }
        }
        $export_request_note->delete();

      
        return redirect()->back()->with([
            'MainSlowAlertMessage' =>    'تم الحذف بنجاح',
            'SlowAlertMessage'     =>    'تم حذف مذكرة التسليم بنجاح وإعادة المواد إلى المستودع   .',
            'alert_type_A'         =>    'danger'
        ]);
 
    }
}
