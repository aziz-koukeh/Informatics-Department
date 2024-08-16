<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceLog;
use App\Models\ImportRequestNote;
use App\Models\ExportRequestNote;
use App\Models\Institution;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

class ImportRequestNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createImportRequestNote()
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة'
        ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $institutions=Institution::where('institution_kind', 'third_pro')->orWhere('institution_kind', 'college')->orWhere('institution_kind', 'compound')->orWhere('institution_kind', 'circle_sec')->get();
        return view('mangament.storeRoomMangment.importNotes.create_import_request_notes',compact('institutions'));
    }

    public function storeImportRequestNote(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'device_name'                 => ['required',  'max:100'],
            'device_number'               => ['required',  'max:50'],
            'device_details'              => ['nullable'],
            'device_weight'               => ['nullable',  'max:100'],
            'device_belongings'           => ['nullable'],
            'device_belongings_count'     => ['nullable', ],
            'device_file_card'            => ['required', ],
            'device_notes'                => ['nullable', ],

            'device_count'                => ['required', ],

            'import_request_note_SN'      => ['required', ],
            'import_request_note_folder'  => ['required', ],
            'import_device_source_from_employee'        => ['required',  ],
            'created_at'                  => ['required',  ],

        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        if ($request->import_device_source && $request->import_device_source_from_employee =='else' ) {
            $source = $request->import_device_source;
            $import_request_note = ImportRequestNote::create([

                'import_request_note_slug'           => Str::uuid()->toString(),
                'import_request_note_SN'             => $request->import_request_note_SN,
                'import_request_note_folder'         => $request->import_request_note_folder,
                'import_request_note_status'         => 'استلام من '.$source ,
                'import_device_source'               => $source ,
                'import_device_source_from_employee' => 'أمين المستودع',
                'import_type'                        => 'store',
                'created_at'                         => $request->created_at,
                'import_update_by_employee'          => auth()->user()->id,
            ]);
        } elseif ($request->import_device_source == null && $request->import_device_source_from_employee =='else' ) {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'إملأ الحقل الخاص بالمصدر أو اختر جهة ما .',
                'alert_type_A'         =>    'warning'
            ]);
           dd('إملأ الحقل الخاص بالمصدر أو اختر جهة ما');
        } else {
            $institution =Institution::where('institution_slug',$request->import_device_source_from_employee)->first();
            $source = $institution->institution_name;
            $import_request_note = ImportRequestNote::create([

                'import_request_note_slug'           => Str::uuid()->toString(),
                'import_request_note_SN'             => $request->import_request_note_SN,
                'import_request_note_folder'         => $request->import_request_note_folder,
                'import_request_note_status'         => 'استلام من '.$source ,
                'import_device_source'               => $source ,
                'import_device_source_from_employee' => 'أمين المستودع ' .$institution->storekeeper->employee_full_name,
                'import_type'                        => 'store',
                'institution_id'                     => $institution->id,
                'created_at'                         => $request->created_at,
                'import_update_by_employee'          => auth()->user()->id,
            ]);
        }
        

        // import_request_image ---------------------
            if ($request->has('import_request_image')) {
                $photo= $request->import_request_image;
                $newPhoto ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
                $photo->move('uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/', $newPhoto);
                $import_request_note->import_request_image='uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'.$newPhoto;
                $import_request_note->save();
            }
        // import_request_image ---------------------
        // device_image ---------------------
            $imageFileds=[];
            foreach ($request->device_file_card as $key=> $device_file_card) {
                $imageFileds[$key] = null;
            }

            if ($request->has('device_image')) {
                foreach ($request->device_image as $key => $device_image) {
                    $imageFileds[$key] = $device_image ;
                }
            }
        // device_image ---------------------

        // ---------------- حلقة فور بكميات كل صنف -------------------------

            foreach ($request->device_count as  $key => $value) {
                if ($request->has('device_image')) {
                    $photo= $imageFileds[$key];
                    if ($photo) {
                        $newPhoto ='IMG_320_device_image_'.$request->device_file_card[$key].'_Model_'.Carbon::parse($request->created_at)->format('Y').'.jpg';
                        $photo->move('uploads/devices_images/'.$request->device_number[$key].'/', $newPhoto);
                        $photoPath ='uploads/devices_images/'.$request->device_number[$key].'/'.$newPhoto ;
                    }else {
                        $photoPath = null;
                    }
                }
                $countDevices=(integer)$value ;
                for ($i=0; $i < $countDevices ; $i++) {
                    $device= Device::create([
                        'device_name'                         => $request->device_name[$key],
                        'device_slug'                         => Str::uuid()->toString(),
                        'device_number'                       => $request->device_number[$key],
                        'device_details'                      => $request->device_details[$key],
                        'device_model'                        => $request->device_file_card[$key].'-'.Carbon::parse($request->created_at)->format('Y'),

                        'device_weight'                       => $request->device_weight[$key],

                        'device_belongings'                   => $request->device_belongings[$key],
                        'device_belongings_count'             => $request->device_belongings_count[$key],

                        'device_file_card'                    => $request->device_file_card[$key],
                        'device_notes'                        => $request->device_notes[$key],
                        'device_infos'                        => 'جديد',

                        'created_at'                          => $request->created_at,
                    ]);
                    if ($request->has('device_image')) {
                        $device->device_image= $photoPath;
                        $device->save();
                    }
                    DeviceLog::create([
                        'device_log_status'                   => 'استلام من '.$source ,
                        'device_by_person'                    => 'أمين المستودع',
                        'import_request_note_id'              => $import_request_note->id,
                        'created_at'                          => $request->created_at,
                        'device_id'                           => $device->id,
                    ]);
                }
            }
        // ---------------- حلقة فور بعدد المواد -------------------------
        
        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
            'FastAlertMessage'     =>    'تم إنشاء مذكرة الإدخال بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
 


    }

    public function showImportRequestNote($import_request_note_slug)
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'الإدارة' 
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة'
        ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $institutions=Institution::where('institution_kind', 'third_pro')->orWhere('institution_kind', 'college')->orWhere('institution_kind', 'compound')->orWhere('institution_kind', 'circle_sec')->get();
        $import_request_note= ImportRequestNote::where('import_request_note_slug',$import_request_note_slug)->first();
        return view('mangament.storeRoomMangment.importNotes.show_import_request_note',compact('import_request_note','institutions'));
    }

    public function updateImportRequestNote(Request $request, $import_request_note_slug)
    {
        // تحقق من الأخطاء في الإدخال ------------------------------------------------
            $validator =  Validator::make($request->all(), [
                'device_name'                 => ['required',  'max:100'],
                'device_number'               => ['required',  'max:50'],
                'device_details'              => ['nullable'],
                'device_weight'               => ['nullable',  'max:100'],
                'device_image'                 => ['nullable'],
                'device_belongings'           => ['nullable'],
                'device_belongings_count'     => ['nullable'],
                'device_file_card'            => ['required'],
                'device_notes'                 => ['nullable'],

                'device_count'                => ['required'],

                'import_request_note_SN'     => ['required'],
                'import_request_note_folder' => ['required'],
                'import_device_source_from_employee'        => ['required' ],

            ]);
            if ( $validator->fails() ) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        // تحقق من الأخطاء في الإدخال ------------------------------------------------
            // dd($request->all());

        // التعديل على معلومات المذكرة --------------------------------------------
            $import_request_note= ImportRequestNote::where('import_request_note_slug',$import_request_note_slug)->first();

            if ($request->import_request_note_SN) {
                $import_request_note->import_request_note_SN = $request->import_request_note_SN;
            }
            if ($request->import_request_note_folder) {
                $import_request_note->import_request_note_folder = $request->import_request_note_folder;
            }
            if ($request->import_device_source && $request->import_device_source_from_employee =='else' ) {
                $import_request_note->import_device_source = $request->import_device_source;
                $import_request_note->import_device_source_from_employee = 'أمين المستودع';
                $import_request_note->import_request_note_status ='استلام من '.$request->import_device_source; ;
                $import_request_note->institution_id = null ;

            }elseif ($request->import_device_source == null && $request->import_device_source_from_employee =='else' ) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'إملأ الحقل الخاص بالمصدر أو اختر جهة ما .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd('إملأ الحقل الخاص بالمصدر أو اختر جهة ما');

            }else{
                $institution = Institution::where('institution_slug',$request->import_device_source_from_employee)->first();
                if ($institution) {
                    $import_request_note->import_device_source_from_employee = 'أمين المستودع '.$institution->storekeeper->employee_full_name;
                    $import_request_note->import_device_source = $institution->institution_name;
                    $import_request_note->import_request_note_status ='استلام من '.$institution->institution_name ;
                    $import_request_note->institution_id = $institution->id;
                } else {
                    return redirect()->back()->with([
                        'MainSlowAlertMessage' =>    'فشل !!',
                        'SlowAlertMessage'     =>    'لا يوجد مدرسة بهذا المعرف .',
                        'alert_type_A'         =>    'warning'
                    ]);
                    dd('لا يوجد مدرسة بهذا المعرف');
                }
                
               
            }
            if ($request->created_at) {
                $import_request_note->created_at = $request->created_at;
            }
            if ($request->has('import_request_image')) {
                $photo= $request->import_request_image;
                $newPhoto ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
                $photo->move('uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/', $newPhoto);
                $import_request_note->import_request_image='uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'.$newPhoto;
            }
            $import_request_note->import_update_by_employee  = auth()->user()->id ;
            $import_request_note->save();
            foreach ($import_request_note->importNote_logs as $log) {
                $log->device_log_status = 'استلام من '.$import_request_note->import_device_source ;
                $log->device_by_person = 'أمين المستودع';
                $log->save();
            }
        // التعديل على معلومات المذكرة --------------------------------------------

        // التعديل على الأجهزة التابعة لهذه المذكرة -------------------------------
            // إنشاء فائمة فارغة من أجل إرسالية الصور في الفورم في حال كانت فارغة ---
                $imageFileds=[];
                foreach ($request->device_file_card as $key=> $device_file_card) {
                    $imageFileds[$key] = null;
                }
            // إنشاء فائمة فارغة من أجل إرسالية الصور في الفورم في حال كانت فارغة ---
            //l ملأ الصور المرسلة من الفورم  في المصفوفة    -------
                if ($request->has('device_image')) { # تحقق من وجود صور في الإرسالية
                    foreach ($request->device_image as $key => $device_image) {
                        $imageFileds[$key] = $device_image ;
                    }
                }
            //l ملأ الصور المرسلة من الفورم  في المصفوفة    -------

            // التعديل بحسب الأصناف الموجودة في فورم التعديل --------
                foreach ($request->device_file_card as $key=> $device_file_card) {
                    // dd($request->device_file_card);
                    // الفروقات إضافة أو حذف --------------------------------------------------
                        $countDevice = (integer)$request->device_count[$key];
                        $all_device_same_card_number  =  $import_request_note->importNote_Devices->where('device_file_card',$device_file_card);
                        
                        if ($countDevice > count($all_device_same_card_number) ) {
                            # إضافة المزيد بحسب الفرق
                            $add = $countDevice - count($all_device_same_card_number) ;

                            for ($i=0; $i < $add ; $i++) {
                                # إضافة أجهزة الفرق
                                $device= Device::create([
                                    'device_name'                         => $request->device_name[$key],
                                    'device_slug'                         => Str::uuid()->toString(),
                                    'device_number'                       => $request->device_number[$key],
                                    'device_details'                      => $request->device_details[$key],
                                    'device_model'                        => $request->device_file_card[$key].'-'.Carbon::parse($request->created_at)->format('Y'),
                                    'device_weight'                       => $request->device_weight[$key],
                                    'device_belongings'                   => $request->device_belongings[$key],
                                    'device_belongings_count'             => $request->device_belongings_count[$key],
                                    'device_file_card'                    => $request->device_file_card[$key],
                                    'device_notes'                        => $request->device_notes[$key],
                                    'device_infos'                        => 'جديد',

                                    'created_at'                          => $request->created_at,
                                ]);
                                DeviceLog::create([
                                    'device_log_status'                   => 'استلام من '.$import_request_note->import_device_source ,
                                    'device_by_person'                    => 'أمين المستودع',
                                    'import_request_note_id'              => $import_request_note->id,
                                    'created_at'                          => $request->created_at,
                                    'device_id'                           => $device->id,
                                ]);
                            }
                        } elseif ($countDevice < count($all_device_same_card_number) ) {

                            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
                                // أيديات تجنب الطلب ------------
                                    $id_array= [];
                                    foreach ($all_device_same_card_number as $num => $device) {
                                        $id_array[$num]=  $device->id;
                                    }
                                // أيديات تجنب الطلب ------------
                                $all_device_same_card_number_Count = $all_device_same_card_number->count() ;
                                $check_Count = $all_device_same_card_number->whereNull('institution_id')->whereIn('id',$id_array)->count() ;
                                if ($all_device_same_card_number_Count != $check_Count ) {
                                    return redirect()->back()->with([
                                        'MainSlowAlertMessage' =>    'فشل !!',
                                        'SlowAlertMessage'     =>    'هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن الإنقاص من المذكرة .',
                                        'alert_type_A'         =>    'warning'
                                    ]);
                                    dd('هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن الإنقاص من المذكرة');
                                }
                            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------

                            #حذف الزيادة من الأخير
                            $subCount = count($all_device_same_card_number) - $countDevice ;

                            $cancelDevices= $import_request_note->importNote_Devices->where('device_file_card',$device_file_card)->whereNull('institution_id')->reverse()->take($subCount);
                            
                            foreach ($cancelDevices as $cancelDevice) {
                                $log_device= $import_request_note->importNote_logs->where('device_id',$cancelDevice->id)->first();
                                $log_device->delete();
                                $cancelDevice->delete();
                            }
                        }

                    // الفروقات إضافة أو حذف --------------------------------------------------

                    // إستعلام جديد لتنفيذ التعديل على الأجهزة ---------------------------------

                        $photoPath = null;
                        if ($request->has('device_image')) {
                            $photo= $imageFileds[$key];
                            if ($photo) {
                                $newPhoto ='IMG_320_device_image_'.$request->device_file_card[$key].'_Model_'.Carbon::parse($request->created_at)->format('Y').'.jpg';
                                $photo->move('uploads/devices_images/'.$request->device_number[$key].'/', $newPhoto);
                                $photoPath ='uploads/devices_images/'.$request->device_number[$key].'/'.$newPhoto ;
                            }
                        }
                        # حلقة من أجل التعديل على كل جهاز في الزمرة التابع للمذكرة

                        foreach ($all_device_same_card_number as $device) {
                            
                            # تعديل معلومات كل جهاز من نفس البطاقة
                            if ($request->device_name[$key]) {
                                $device->device_name=  $request->device_name[$key];
                            }
                            if ($request->device_number[$key]) {
                                $device->device_number=  $request->device_number[$key];
                            }
                            if ($request->device_details[$key]) {
                                $device->device_details=  $request->device_details[$key];
                            }
                            if ($request->device_weight[$key]) {
                                $device->device_weight=  $request->device_weight[$key];
                            }
                            if ($request->device_belongings[$key]) {
                                $device->device_belongings=  $request->device_belongings[$key];
                            }
                            if ($request->device_belongings_count[$key]) {
                                $device->device_belongings_count=  $request->device_belongings_count[$key];
                            }
                            if ($request->device_file_card[$key]) {
                                $device->device_file_card=  $request->device_file_card[$key];
                            }
                            if ($request->device_notes[$key]) {
                                $device->device_notes=  $request->device_notes[$key];
                            }
                            if ($request->created_at) {
                                $device->created_at=  $request->created_at;
                                $device->device_model=  $request->device_file_card[$key].'-'.Carbon::parse($request->created_at)->format('Y');
                            }
                            if ($photoPath) {
                                $device->device_image= $photoPath;
                            }
                            $device->save();
                        }

                    // إستعلام جديد لتنفيذ التعديل على الأجهزة ---------------------------------

                }
            // التعديل بحسب الأصناف الموجودة في فورم التعديل --------
        // التعديل على الأجهزة التابعة لهذه المذكرة -------------------------------


        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث معلومات مذكرة الإدخال بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
         
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //--------------------------------------------
    public function selectDevicesToRestoreBack($institution_slug)
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة'
        ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $current_institution = Institution::where('institution_slug',$institution_slug)->first();
        $devices= Device::where('institution_id',$current_institution->id)->get();
        return view('mangament.storeRoomMangment.importNotes.selectDevicesToRestoreBack',compact('devices','current_institution'));
    }
    public function selectDevicesToRestoreBackFromPerson($employee_slug)
    {
        if (auth()->user()->profile->employee_department != 'المستودع'
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة'
        ) {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $employee = Employee::where('employee_slug',$employee_slug)->first();
        $devices= $employee->employee_devices;
        return view('mangament.storeRoomMangment.importNotes.selectDevicesToRestoreBackFromPerson',compact('devices','employee'));
    }


    public function storeDevicesBack(Request $request , $institution_slug)
    {
        // تحقق من الأخطاء في الإدخال ------------------------------------------------
            $validator =  Validator::make($request->all(), [
                'import_request_note_SN'             => ['required'],
                'import_request_note_folder'         => ['required'],
                'import_device_source_from_employee' => ['required' ],
                'created_at'                         => ['required' ],

            ]);

            if ( $validator->fails() ) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        // تحقق من الأخطاء في الإدخال ------------------------------------------------

        // إحضار معلومات الموظف الذي قام بالتسليم ---------------------------------------------------------------
            if ($request->import_device_source_from_employee_else && $request->import_device_source_from_employee =='else' ) {
                $by_employee = $request->import_device_source_from_employee_else;

            } elseif ($request->import_device_source_from_employee_else == null && $request->import_device_source_from_employee =='else' ) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'إملأ الحقل الخاص بالموظف المفوض أو اختر موظف من الخيارات .',
                    'alert_type_A'         =>    'warning'
                ]);
            dd('إملأ الحقل الخاص بالمصدر أو اختر جهة ما');
            } else {
                $by_employee = $request->import_device_source_from_employee;
                
            }
        // إحضار معلومات الموظف الذي قام بالتسليم ---------------------------------------------------------------

        // إحضار المنشأة ---------------------------------------------------------------
            if ($request->employee_slug) { // في حال كانت عهدة
                $employee= Employee::where('employee_slug',$request->employee_slug)->first();
                $institution = $employee->institution;
                $source =$employee->employee_full_name ;
                $import_request_note = ImportRequestNote::create([

                    'import_request_note_slug'           => Str::uuid()->toString(),
                    'import_request_note_SN'             => $request->import_request_note_SN,
                    'import_request_note_folder'         => $request->import_request_note_folder,
                    'import_device_source_from_employee' => $source ,
                    'import_device_source'               => $source ,
                    'import_request_note_status'         => 'استعادة من عهدة موظف ' ,
                    'import_type'                        => 'restore',
                    'institution_id'                     => $institution->id,
                    'employee_id'                        => $employee->id,
                    'created_at'                         => $request->created_at,
                    'import_update_by_employee'          => auth()->user()->id,
                ]);
            } else {
                $institution = Institution::where('institution_slug',$institution_slug)->first();
                $source=$institution->institution_name;
                    // إحضار معلومات المنشأة ---------------------------------------------------------------
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

                    // إحضار معلومات المنشأة ---------------------------------------------------------------
    
                $import_request_note = ImportRequestNote::create([

                    'import_request_note_slug'           => Str::uuid()->toString(),
                    'import_request_note_SN'             => $request->import_request_note_SN,
                    'import_request_note_folder'         => $request->import_request_note_folder,
                    'import_device_source_from_employee' => $by_employee ,
                    'import_device_source'               => $source ,
                    'import_request_note_status'         => 'استعادة من '.$kind. $source ,
                    'import_type'                        => 'restore',
                    'institution_id'                     => $institution->id,
                    'created_at'                         => $request->created_at,
                    'import_update_by_employee'          => auth()->user()->id,
                ]);
            }
           
        // إحضار المنشأة ---------------------------------------------------------------


       
        // إنشاء مذكرة إدخال للمستودع كمستعمل أجهزة فرادا ------------------
        // dd($request->all());
       


        if ($request->has('import_request_image')) {
            $photo= $request->import_request_image;
            $newPhoto ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
            $photo->move('uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN .'/', $newPhoto);
            $import_request_note->import_request_image='uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'.$newPhoto;
            $import_request_note->save();
        }
        // إنشاء مذكرة إدخال للمستودع كمستعمل أجهزة فرادا ------------------

        // حلقة فور بالأجهزة المرسلة في الفورم ----------------------------
        foreach ($request->device_slug as $device_slug ) {
            $device=Device::where('device_slug',$device_slug)->first();
            if ($device) {
                if ($request->employee_slug) { // في حال كانت عهدة
                    DeviceLog::create([
                    'device_log_status'                   => 'استعادة من عهدة موظف ' ,
                    'device_by_person'                    => $source,
                    'import_request_note_id'              => $import_request_note->id,
                    'created_at'                          => $request->created_at,
                    'device_id'                           => $device->id,
                    ]);
                    $device->employee_id = null;

                }else{
                    DeviceLog::create([
                    'device_log_status'                   => 'استعادة من '.$kind. $source ,
                    'device_by_person'                    => $by_employee,
                    'import_request_note_id'              => $import_request_note->id,
                    'created_at'                          => $request->created_at,
                    'device_id'                           => $device->id,
                    ]);
                }
                $device->institution_id= null;
                $device->sub_institution_id= null;
                $device->device_infos= 'مستعمل';
                $device->save();
            }
        }
        // حلقة فور بالأجهزة المرسلة في الفورم ----------------------------

        if ($request->employee_slug) {
            return redirect()->route('showEmployee', $request->employee_slug)->with([
                'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
                'FastAlertMessage'     =>    'تم إنشاء مذكرة الإستعادة بنجاح  .',
                'alert_type_A'         =>    'success'
            ]);
        } else {
            return redirect()->route('showInstitution', $institution->institution_slug)->with([
                'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
                'FastAlertMessage'     =>    'تم إنشاء مذكرة الإستعادة بنجاح  .',
                'alert_type_A'         =>    'success'
            ]);
        }
        

         


    }

    public function updateDevicesBack(Request $request , $import_request_note_slug)
    {

        // تحقق من الأخطاء في الإدخال ------------------------------------------------
            $validator =  Validator::make($request->all(), [
                'device_model'            => ['required'],
                'device_count'                => ['nullable'],

                'import_request_note_SN'      => ['required'],
                'import_request_note_folder'  => ['required'],
                'import_device_source_from_employee'        => ['required' ],
                'created_at'                  => ['required',  ],

            ]);
            if ( $validator->fails() ) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        // تحقق من الأخطاء في الإدخال ------------------------------------------------

        // إحضار المنشأة ---------------------------------------------------------------
        $import_request_note= ImportRequestNote::where('import_request_note_slug',$import_request_note_slug)->first();
        
        if ($request->employee_slug) { // في حال كانت عهدة
            $employee= Employee::where('employee_slug',$request->employee_slug)->first();
            $institution = $employee->institution;
        } else {
            $institution = $import_request_note->imported_from;
        }
       
        // إحضار المنشأة ---------------------------------------------------------------

        // إحضار معلومات المنشأة ---------------------------------------------------------------
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
                $kind = ' عهدة شخصية ';
            }elseif ($institution->institution_kind == 'circle_sec') {
                $kind = ' الدائرة الفرعية';
            }

        // إحضار معلومات المنشأة ---------------------------------------------------------------

        // التعديل على معلومات المذكرة --------------------------------------------
            $import_request_note= ImportRequestNote::where('import_request_note_slug',$import_request_note_slug)->first();

            if ($request->employee_slug) { // في حال كانت عهدة
                $import_request_note->import_request_note_status = 'استعادة من عهدة موظف ' ;
                $import_request_note->employee_id= $employee->id;
            } else {
                $import_request_note->import_request_note_status = 'استعادة من '.$kind. $institution->institution_name ;
            }
            
            if ($request->import_request_note_SN) {
                $import_request_note->import_request_note_SN = $request->import_request_note_SN;
            }
            if ($request->import_request_note_folder) {
                $import_request_note->import_request_note_folder = $request->import_request_note_folder;
            }


            if ($request->import_device_source_from_employee_else && $request->import_device_source_from_employee =='else' ) {
                $import_request_note->import_device_source_from_employee = $request->import_device_source_from_employee_else;
                
            } elseif ($request->import_device_source_from_employee_else == null && $request->import_device_source_from_employee =='else' ) {
                return redirect()->back()->with([
                    'MainSlowAlertMessage' =>    'فشل !!',
                    'SlowAlertMessage'     =>    'إملأ الحقل الخاص بالمصدر أو اختر جهة ما .',
                    'alert_type_A'         =>    'warning'
                ]);
                dd('إملأ الحقل الخاص بالمصدر أو اختر جهة ما');
            } else {
                $import_request_note->import_device_source_from_employee = $request->import_device_source_from_employee;
                
            }


            // if ($request->created_at) {
            //     $import_request_note->created_at = $request->created_at;
            // }
            if ($request->has('import_request_image')) {
                $photo= $request->import_request_image;
                $newPhoto ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
                $photo->move('uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/', $newPhoto);
                $import_request_note->import_request_image='uploads/import_request_notes_image/'.Carbon::parse($request->created_at)->format('Y').'/'.Carbon::parse($request->created_at)->format('m').'/'.Carbon::parse($request->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'.$newPhoto;
            }
            $import_request_note->import_update_by_employee  = auth()->user()->id ;
            $import_request_note->save();

            # التعديل على سجل المذكرة
            foreach ($import_request_note->importNote_logs as $log) {
                $log->device_by_person = $import_request_note->import_device_source_from_employee ;
                $log->save() ;
            }

        // التعديل على معلومات المذكرة --------------------------------------------


        // التعديل على الأجهزة التابعة لهذه المذكرة -------------------------------

            // التعديل بحسب الأصناف الموجودة في فورم التعديل --------
                foreach ($request->device_model as $key=> $value) {
                    // الفروقات إضافة أو حذف --------------------------------------------------
                        $countDevices = (integer)$request->device_count[$key];
                        $allDevices= 0 ;
                        foreach ($request->device_count as $i) {
                            $allDevices = $allDevices+(integer)$i;
                        }
                    
                        // dd($allDevices);
                        if ($allDevices == 0){
                            return redirect()->back()->with([
                                'MainSlowAlertMessage' =>    'فشل !!',
                                'SlowAlertMessage'     =>    ' لا يمكن ترك المذكرة بدون أجهزة .',
                                'alert_type_A'         =>    'warning'
                            ]);
                            dd(' لا يمكن ترك المذكرة بدون أجهزة ');
                        }
                        if ($allDevices > 0){

                            $this_Note_Devices_Same_device_model  =  $import_request_note->importNote_Devices->where('device_model',$value);

                            if ($countDevices > count($this_Note_Devices_Same_device_model) ) {
                                # عدد الفرق للأجهزة
                                $addDevices = $countDevices - count($this_Note_Devices_Same_device_model) ;
                                // أيديات تجنب الطلب ------------
                                    $id_array= [];
                                    foreach ($this_Note_Devices_Same_device_model as $key => $device) {
                                        $id_array[$key]=  $device->id;
                                    }
                                // أيديات تجنب الطلب ------------
                                $institution_all_devices_same_card_number = $import_request_note->imported_from->institution_devices->where('device_model',$value)->whereNotIn('id',$id_array)->take($addDevices);

                                if ($institution_all_devices_same_card_number) {
                                    foreach ($institution_all_devices_same_card_number as $device) {

                                        if ($request->employee_slug) { // في حال كانت عهدة
                                            DeviceLog::create([
                                            'device_log_status'                   => 'استعادة من عهدة موظف ' ,
                                            'device_by_person'                    => $import_request_note->import_device_source_from_employee,
                                            'import_request_note_id'              => $import_request_note->id,
                                            'created_at'                          => $request->created_at,
                                            'device_id'                           => $device->id,
                                            ]);
                                            $device->employee_id = null;
                        
                                        }else{
                                            DeviceLog::create([
                                            'device_log_status'                   => 'استعادة من '.$kind. $institution->institution_name ,
                                            'device_by_person'                    => $import_request_note->import_device_source_from_employee,
                                            'import_request_note_id'              => $import_request_note->id,
                                            'created_at'                          => $request->created_at,
                                            'device_id'                           => $device->id,
                                            ]);
                                        }
                                        $device->institution_id= null;
                                        $device->sub_institution_id= null;
                                        $device->device_infos= 'مستعمل';
                                        $device->save();


                                    }

                                }

                            } elseif ($countDevices < count($this_Note_Devices_Same_device_model) ) {
                                #حذف الزيادة من الأخير
                                $id_array= [];
                                foreach ($this_Note_Devices_Same_device_model as $key => $device) {
                                    $id_array[$key]=  $device->id;
                                }
                                $subDevices = count($this_Note_Devices_Same_device_model) - $countDevices ;
                                $cancelDevices = $this_Note_Devices_Same_device_model->reverse()->take($subDevices);
                                // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
                                    $this_Note_Devices_Same_device_model_Count = $this_Note_Devices_Same_device_model->count() ;
                                    $check_Count = $this_Note_Devices_Same_device_model->whereNull('institution_id')->whereIn('id',$id_array)->count() ;
                                    if ($this_Note_Devices_Same_device_model_Count != $check_Count ) {
                                        
                                        return redirect()->back()->with([
                                            'MainSlowAlertMessage'=>'عذراً',
                                            'SlowAlertMessage'=>'هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن الإنقاص من المذكرة .',
                                            'alert_type_A'   =>'warning'
                                        ]);

                                        dd('هناك أجهزة تابعة لهذه المذكرة تم تسليمهم لمنشأة ما ولا يمكن الإنقاص من المذكرة');
                                    }
                                // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
                                
                                foreach ($cancelDevices as $cancelDevice) {
                                    if ($request->employee_slug) { // في حال كانت عهدة
                                        $cancelDevice->employee_id = $import_request_note->employee_id ;
                                    }
                                    $cancelDevice->institution_id = $institution->id ;
                                    if($cancelDevice->device_import_export_logs->reverse()->take(3)->last()->device_by_person == 'أمين المستودع'){ # الرجوع ثلاث خطوات والتحقق من المذكرة إذا كان الجهااز من مستودع الدائرة
                                        $cancelDevice->device_infos= 'جديد';
                                    }
                                    $cancelDevice->save();
                                    $log_device= $import_request_note->importNote_logs->where('device_id',$cancelDevice->id)->first(); # first function FOR delete function in the next code line
                                    $log_device->delete();
                                }

                            }
                        }

                    // الفروقات إضافة أو حذف --------------------------------------------------


                }
            // التعديل بحسب الأصناف الموجودة في فورم التعديل --------
        // التعديل على الأجهزة التابعة لهذه المذكرة -------------------------------

        
        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث معلومات مذكرة الإستعادة بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
 

    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







    //--------------------------------------------
    public function importRequestNotesLog( Request $request)
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


        
        $importRequestNotes=[];
        $kind= '';
        if ($request->all == 'all') {
            $importRequestNotes=ImportRequestNote::orderBy('created_at')->get();
            $kind= 'جميع مذكرات الإدخال';
            $exportType='all';
            $date=null;
        }
        elseif ($request->currentYear == 'currentYear') {
            $importRequestNotes=ImportRequestNote::whereYear('created_at',date('Y'))->orderBy('created_at')->get();
            $kind= 'مذكرات إدخال السنة الحالية';
            $exportType='currentYear';
            $date= date('Y');
        }
        elseif ($request->year) {
            $date=$request->year;
            $importRequestNotes=ImportRequestNote::whereYear('created_at',$date)->orderBy('created_at')->get();
            
            $kind= 'مذكرات إدخال سنة '.$date.' م';
            $exportType='year';
        }
        elseif ($request->month) {
            $date=Carbon::parse($request->month);
            
            $importRequestNotes=ImportRequestNote::whereMonth('created_at',$date->format('m'))->whereYear('created_at',$date->format('Y'))->orderBy('created_at')->get();
            
            $kind= 'مذكرات إدخال لشهر '.$date->format('m').' لسنة '.$date->format('Y').' م';
            $exportType='month';
        }else {
          return  redirect()->back();
        }

        return view('mangament.storeRoomMangment.importNotes.importRequestNotesLog',compact('importRequestNotes','kind','exportType','date'));
    }

    // multiDelete store &restore ------------------------
    public function destroyImportRequestNote($import_request_note_slug)
    {
        if (auth()->user()->level != 'مشرف'
        || auth()->user()->profile->employee_department != 'المستودع') {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك القيام بهذا الإجراء .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $import_request_note= ImportRequestNote::where('import_request_note_slug',$import_request_note_slug)->first();
        if ($import_request_note->import_type == 'store') {
            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
                $this_Note_Devices_Count = $import_request_note->importNote_Devices->count() ;
                $check_Count = $import_request_note->importNote_Devices->whereNull('institution_id')->count() ;
                if ($this_Note_Devices_Count != $check_Count ) {
                    return redirect()->back()->with([
                        'MainSlowAlertMessage' =>    'فشل !!',
                        'SlowAlertMessage'     =>    ' لا يمكن حذف المذكرة الأساسية .. هناك أجهزة قد تم تسليمها لجهة ما .',
                        'alert_type_A'         =>    'warning'
                    ]);
                    dd(' لا يمكن حذف مذكرة الأساس .. هناك أجهزة قد تم تسليمها لجهة ما ');
                }
               
            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
            foreach ($import_request_note->importNote_Devices as $device) {
                $log_device= $import_request_note->importNote_logs->where('device_id',$device->id)->first();
                $log_device->delete();
                $device->delete();
            }
            if ( $import_request_note->import_request_image) {
                $media_file_name ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
                if (File::exists('uploads/import_request_notes_image/'.Carbon::parse($import_request_note->created_at)->format('Y').'/'.Carbon::parse($import_request_note->created_at)->format('m').'/'.Carbon::parse($import_request_note->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'. $media_file_name)) {
                    unlink('uploads/import_request_notes_image/'.Carbon::parse($import_request_note->created_at)->format('Y').'/'.Carbon::parse($import_request_note->created_at)->format('m').'/'.Carbon::parse($import_request_note->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/' . $media_file_name);
                }
            }
            $import_request_note->delete();
            
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'تم الحذف بنجاح',
                'SlowAlertMessage'     =>    'تم حذف مذكرة الإدخال بنجاح وحذف المواد التي تم إضافتها للمستودع .',
                'alert_type_A'         =>    'danger'
            ]);


        } elseif ($import_request_note->import_type == 'restore') {
            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
                $this_Note_Devices = $import_request_note->importNote_Devices ;
                $this_Note_Devices_Count = $this_Note_Devices->count() ;
                $check_Count = $import_request_note->importNote_Devices->whereNull('institution_id')->count() ;
                if ($this_Note_Devices_Count != $check_Count ) {
                    return redirect()->back()->with([
                        'MainSlowAlertMessage' =>    'فشل !!',
                        'SlowAlertMessage'     =>    'لا يمكن حذف مذكرة الإستعادة .... هناك أجهزة تم تسليمهم لمنشأة ما ولا يمكن حذف المذكرة .',
                        'alert_type_A'         =>    'warning'
                    ]);

                    dd(' لا يمكن حذف مذكرة الإستعادة .... هناك أجهزة تم تسليمهم لمنشأة ما ولا يمكن حذف المذكرة');
                }
            // التحقق من عدم إستخدام أجهزة المذكرة في مكان آخر --------
            foreach ( $this_Note_Devices as $device) {

                $device->institution_id= $import_request_note->institution_id;
                $device->employee_id= $import_request_note->employee_id;
                if($device->device_import_export_logs->reverse()->take(3)->last()->device_by_person == 'أمين المستودع'){ # الرجوع ثلاث خطوات والتحقق من المذكرة إذا كان الجهااز من مستودع الدائرة
                    $device->device_infos= 'جديد';
                }
                $device->save();
                $log_device= $import_request_note->importNote_logs->where('device_id',$device->id)->first();
                $log_device->delete();
            }
            if ( $import_request_note->import_request_image) {
                $media_file_name ='IMG_320_import_request_note_number_'.$import_request_note->import_request_note_SN.'.jpg';
                if (File::exists('uploads/import_request_notes_image/'.Carbon::parse($import_request_note->created_at)->format('Y').'/'.Carbon::parse($import_request_note->created_at)->format('m').'/'.Carbon::parse($import_request_note->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/'. $media_file_name)) {
                    unlink('uploads/import_request_notes_image/'.Carbon::parse($import_request_note->created_at)->format('Y').'/'.Carbon::parse($import_request_note->created_at)->format('m').'/'.Carbon::parse($import_request_note->created_at)->format('d').'/'.$import_request_note->import_request_note_SN.'/' . $media_file_name);
                }
            }
            $import_request_note->delete();
            
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'تم الحذف بنجاح',
                'SlowAlertMessage'     =>    'تم حذف مذكرة الإستعادة بنجاح وإعادة المواد إلى مصدرها السابق  .',
                'alert_type_A'         =>    'danger'
            ]);
        }


        

    }
    // multiDelete store &restore ------------------------
}
