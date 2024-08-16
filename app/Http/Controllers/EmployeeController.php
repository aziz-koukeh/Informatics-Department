<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Institution;
use App\Models\Device;
use App\Models\ExportRequestNote;
use App\Models\ImportRequestNote;
use App\Models\RedirectDevice;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function allEmployees()
    {
        if (auth()->user()->profile->employee_department != 'الإدارة' 
        && auth()->user()->profile->employee_department != 'شعبة الأتمتة' 
        && auth()->user()->profile->employee_department != 'شعبة الديوان') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $ourInstitution= Institution::where('institution_name','دائرة المعلوماتية')->first();
        if ( $ourInstitution) {
            $ourEmployees=$ourInstitution->employees ;
            if ( !$ourEmployees) {
                $ourEmployees= [];
            }
        }else{
            $ourInstitution= Institution:: create([


                'institution_name'             => 'دائرة المعلوماتية',
                'institution_slug'             => Str::uuid()->toString(),
                'institution_phone'            => '+963 21 0000000',
                'institution_kind'             => 'circle_sec',
                'institution_map'              => null,
                'institution_address'          => 'حلب - الشهباء - دوار الغزالي',
                'institution_bio'              => null ,
                'parent_institution_id'        => null ,
            ]);
            $ourEmployees= [];
        }
        return view('mangament.employeeMangment.allEmployee',compact('ourEmployees','ourInstitution'));
    }

    public function showEmployee($employee_slug) 
    {

        $employee= Employee:: where('employee_slug',$employee_slug)->first();
        $institutions=Institution::where('institution_kind','circle_pri')
        ->where('institution_slug','<>',$employee->institution->institution_slug)
        // ->orWhere(function ($query)
        //     {
        //      $query->where('institution_kind','circle_sec')->where('institution_name','دائرة المعلوماتية');
        //     })
        ->get();
        return view('mangament.employeeMangment.showEmployee' ,compact('employee','institutions'));
    }

    public function allUsers()
    {

        if (auth()->user()->profile->employee_department != 'الإدارة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }

        $users=User::all();
        $ourInstitution= Institution::where('institution_name','دائرة المعلوماتية')->first();
        if ( $ourInstitution) {
            $ourEmployees=$ourInstitution->employees->whereNull('user_id') ;
            if ( !$ourEmployees) {
                $ourEmployees= [];
            }
        }else{
            $ourInstitution= Institution:: create([


                'institution_name'             => 'دائرة المعلوماتية',
                'institution_slug'             => Str::uuid()->toString(),
                'institution_phone'            => '+963 21 0000000',
                'institution_kind'             => 'circle_sec',
                'institution_map'              => null,
                'institution_address'          => 'حلب - الشهباء - دوار الغزالي',
                'institution_bio'              => null ,
                'parent_institution_id'        => null ,
            ]);
            $ourEmployees= [];
        }
        return view('mangament.userMangment.allUsers',compact('users','ourEmployees'));
 
    }

    public function showUser($user_slug) 
    {
        if (auth()->user()->profile->employee_department != 'الإدارة') {
            return redirect()->route('home')->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكنك الوصول إلى هذه الصفحة .',
                'alert_type_A'         =>    'warning'
            ]);
        }
        $user= User:: where('user_slug',$user_slug)->first();
        return view('mangament.userMangment.showUser',compact('user'));
    }

    public function updateUser(Request $request , $user_slug) 
    {
        $user= User:: where('user_slug',$user_slug)->first();
        if ($request->user_name) {
            $user->user_name =  $request->user_name ;
        }
        if ($request->level) {
            $user->level =  $request->level ;
        }
        if ($request->password) {
            $user->password =  Hash::make($request->password) ; 
        }
        $user->save() ; 
        return redirect()->back()->with([
            'MainSlowAlertMessage' =>    'نجح التحديث',
            'SlowAlertMessage'     =>    'نجح تحديث معلومات الحساب الخاص بالموظف '. $user->profile->employee_full_name  ,
            'alert_type_A'         =>    'success'
        ]);
    }



    public function storeEmployeeProfile(Request $request , $institution_slug)
    {
        $validator =  Validator::make($request->all(), [
            'employee_full_name'                   => 'required' ,
            'employee_father_name'                 => 'required' ,
            'employee_mother_name'                 => 'required' ,
            'employee_birth_day'                   => 'required' ,
            'employee_birth_place'                 => 'required' ,
            'employee_national_number'             => 'required' ,
            'employee_kid'                         => 'required' ,
            'employee_address'                     => 'required' ,
            'employee_marital_status'              => 'required' ,
            'employee_speciality_certificate'      => 'required' ,
            'employee_phone_number'                => 'required' ,
            'employee_self_number'                 => 'required' ,
            'employee_job_naming'                  => 'required' ,
            'employee_speciality'                  => 'required' ,
            'employee_categortion'                 => 'required' ,
            'employee_department'                  => 'nullable' ,
            'employee_job'                         => 'required' ,
            'employee_job_status'                  => 'required' ,

            'employee_recruitmant_name'            => 'nullable' ,
            'employee_recruitmant_number'          => 'nullable' ,
            'employee_recruitmant_backup_number'   => 'nullable' ,
            'employee_shateb_number'               => 'nullable' ,
            'employee_financial_number'            => 'nullable' ,
            'employee_join_date'                   => 'nullable' ,
            // 'employee_leave_date'                  => 'nullable' ,
            'employee_job_older'                   => 'nullable' ,

        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $checkEmployee = Employee::where('employee_national_number',$request->employee_national_number )->first();
        if ($checkEmployee) {
            return redirect()->back()->with([
                'MainSlowAlertMessage' =>    'فشل !!',
                'SlowAlertMessage'     =>    'لا يمكن إنشاء ملف لهذا الموظف فهذا الرقم الوطني خاص بموظف آخر . ' ,
                'alert_type_A'         =>    'warning'
            ]);
        }
        $institution=Institution::where('institution_slug',$institution_slug)->first();

        $employee= Employee:: create([
            'employee_slug'                        => Str::uuid()->toString(),
            'employee_full_name'                   => $request->employee_full_name ,
            'employee_father_name'                 => $request->employee_father_name ,
            'employee_mother_name'                 => $request->employee_mother_name ,
            'employee_birth_day'                   => $request->employee_birth_day ,
            'employee_birth_place'                 => $request->employee_birth_place ,
            'employee_national_number'             => $request->employee_national_number ,
            'employee_kid'                         => $request->employee_kid ,
            'employee_address'                     => $request->employee_address ,
            'employee_marital_status'              => $request->employee_marital_status ,
            'employee_speciality_certificate'      => $request->employee_speciality_certificate ,
            'employee_phone_number'                => $request->employee_phone_number ,
            'employee_self_number'                 => $request->employee_self_number ,
            'employee_job_naming'                  => $request->employee_job_naming ,
            'employee_speciality'                  => $request->employee_speciality ,
            'employee_categortion'                 => $request->employee_categortion ,
            'employee_department'                  => $request->employee_department ,
            'employee_job'                         => $request->employee_job ,
            'employee_job_status'                  => $request->employee_job_status ,

            'employee_recruitmant_name'            => $request->employee_recruitmant_name ,
            'employee_recruitmant_number'          => $request->employee_recruitmant_number ,
            'employee_recruitmant_backup_number'   => $request->employee_recruitmant_backup_number ,
            'employee_shateb_number'               => $request->employee_shateb_number ,
            'employee_financial_number'            => $request->employee_financial_number ,
            'employee_join_date'                   => $request->employee_join_date ,
            // 'employee_leave_date'                  => $request->employee_leave_date ,
            'employee_job_older'                   => $request->employee_job_older ,

            'institution_id'                       => $institution->id ,

        ]);
        if ($request->hasFile('employee_image')) {
            $photo= $request->employee_image;
            $newPhoto ='IMG_320_'.$request->employee_full_name.'.jpg';
            $photo->move('uploads/employees_image/', $newPhoto);
            $employee->employee_image='uploads/employees_image/'.$newPhoto;
        }
        $employee->save();


        
        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم الإنشاء بنجاح',
            'FastAlertMessage'     =>    'تم ملف بيانات الموظف '.$employee->employee_full_name . '  بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
        


    }


    public function updateEmployeeProfile(Request $request,  $employee_slug)
    {
        $employee= Employee:: where('employee_slug',$employee_slug)->first();
        if ( $request->employee_full_name ) {    
            $employee->employee_full_name = $request->employee_full_name ;
        }
        if ( $request->employee_father_name ) {    
            $employee->employee_father_name = $request->employee_father_name ;
        }
        if ( $request->employee_mother_name ) {    
            $employee->employee_mother_name = $request->employee_mother_name ;
        }
        if ( $request->employee_birth_day ) {    
            $employee->employee_birth_day = $request->employee_birth_day ;
        }
        if ( $request->employee_birth_place ) {    
            $employee->employee_birth_place = $request->employee_birth_place ;
        }
        if ( $request->employee_national_number ) {    
            $employee->employee_national_number = $request->employee_national_number ;
        }
        if ( $request->employee_kid ) {    
            $employee->employee_kid = $request->employee_kid ;
        }
        if ( $request->employee_address ) {    
            $employee->employee_address = $request->employee_address ;
        }
        if ( $request->employee_marital_status ) {    
            $employee->employee_marital_status = $request->employee_marital_status ;
        }
        if ( $request->employee_speciality_certificate ) {    
            $employee->employee_speciality_certificate = $request->employee_speciality_certificate ;
        }
        if ( $request->employee_phone_number ) {    
            $employee->employee_phone_number = $request->employee_phone_number ;
        }
        if ( $request->employee_self_number ) {    
            $employee->employee_self_number = $request->employee_self_number ;
        }
        if ( $request->employee_job_naming ) {    
            $employee->employee_job_naming = $request->employee_job_naming ;
        }
        if ( $request->employee_speciality ) {    
            $employee->employee_speciality = $request->employee_speciality ;
        }
        if ( $request->employee_categortion ) {    
            $employee->employee_categortion = $request->employee_categortion ;
        }
        if ( $request->employee_department ) {    
            $employee->employee_department = $request->employee_department ;
        }
        if ( $request->employee_job ) {    
            $employee->employee_job = $request->employee_job ;
        }
        if ( $request->employee_job_status ) {    
            $employee->employee_job_status = $request->employee_job_status ;
        }

        if ( $request->employee_recruitmant_name ) {    
            $employee->employee_recruitmant_name = $request->employee_recruitmant_name ;
        }
        if ( $request->employee_recruitmant_number ) {    
            $employee->employee_recruitmant_number = $request->employee_recruitmant_number ;
        }
        if ( $request->employee_recruitmant_backup_number ) {    
            $employee->employee_recruitmant_backup_number = $request->employee_recruitmant_backup_number ;
        }
        if ( $request->employee_shateb_number ) {    
            $employee->employee_shateb_number = $request->employee_shateb_number ;
        }
        if ( $request->employee_financial_number ) {    
            $employee->employee_financial_number = $request->employee_financial_number ;
        }
        if ( $request->employee_join_date ) {    
            $employee->employee_join_date = $request->employee_join_date ;
        }
        if ( $request->employee_leave_date ) {    
            $employee->employee_leave_date = $request->employee_leave_date ;
        }
        if ( $request->employee_job_older ) {    
            $employee->employee_job_older = $request->employee_job_older ;
        }
        if ($request->hasFile('employee_image')) {
            $photo= $request->employee_image;
            $newPhoto ='IMG_320_'.$request->employee_full_name.'.jpg';
            $photo->move('uploads/employees_image/', $newPhoto);
            $employee->employee_image='uploads/employees_image/'.$newPhoto;
        }
        $employee->save();

        return redirect()->back()->with([
            'MainFastAlertMessage' =>    'تم التحديث بنجاح',
            'FastAlertMessage'     =>    'تم تحديث بيانات الموظف '.$employee->employee_full_name . '  بنجاح .',
            'alert_type_A'         =>    'success'
        ]);
       


        
    }

    public function changeEmployeeInstitution(Request $request, $employee_slug)
    { 
        $validator =  Validator::make($request->all(), [
            'institution_slug'                   => 'required' ,
            'employee_job'                => 'required' ,
            'employee_join_date'                 => 'required' ,
            
        ]);
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $institution= Institution:: where('institution_slug',$request->institution_slug)->first();

        $employee= Employee:: where('employee_slug',$employee_slug)->first();

        $employee->institution_id = $institution->id ;
        $employee->employee_job = $request->employee_job ;
        $employee->employee_join_date = $request->employee_join_date ;
        $employee->update() ;

        $devices=Device::where('employee_id' , $employee->id)->get();
        foreach ($devices as $device) {
            $device->institution_id= $institution->id ;
            $device->updated_at= $device->updated_at;
            $device->update() ;
        }

        $export_request_notes=ExportRequestNote::where('employee_id' , $employee->id)->get();
        foreach ($export_request_notes as $export_request_note) {
            $export_request_note->institution_id= $institution->id ;
            $export_request_note->updated_at= $export_request_note->updated_at;
            $export_request_note->update() ;
        }

        $import_request_notes=ImportRequestNote::where('employee_id' , $employee->id)->get();
        foreach ($import_request_notes as $import_request_note) {
            $import_request_note->institution_id= $institution->id ;
            $import_request_note->updated_at= $import_request_note->updated_at;
            $import_request_note->update() ;
        }

        $redirect_from_device_notes=RedirectDevice::where('from_employee_id' , $employee->id)->get();
        foreach ($redirect_from_device_notes as $redirect_from_device_note) {
            $redirect_from_device_note->from_institution_id= $institution->id ;
            $redirect_from_device_note->updated_at= $redirect_from_device_note->updated_at;
            $redirect_from_device_note->update() ;
        }

        $redirect_to_device_notes=RedirectDevice::where('to_employee_id' , $employee->id)->get();
        foreach ($redirect_to_device_notes as $redirect_to_device_note) {
            $redirect_to_device_note->to_institution_id= $institution->id ;
            $redirect_from_device_note->updated_at= $redirect_from_device_note->updated_at;
            $redirect_to_device_note->update() ;
        }

        return redirect()->back()->with([
            'MainSlowAlertMessage' =>    'تم نقل بنجاح',
            'SlowAlertMessage'     =>    'تم نقل جميع تبعيات الموظف إلى المنشأة الجديدة  .',
            'alert_type_A'         =>    'success'
        ]);





    }

    public function destroyEmployeeProfile($employee_slug)
    {
        return redirect()->back()->with([
            'MainSlowAlertMessage'=>'عذراً',
            'SlowAlertMessage'=>' حذف ملف الموظف قيد الدراسة .',
            'alert_type_A'   =>'info'
        ]);
        // $employee= Employee:: where('employee_slug',$employee_slug)->first();
        // $institution= $employee->institution;
        // $employee->institution->save();
        // if ( $employee->employee_image) {
        //     $media_file_name ='IMG_320_'.$employee->employee_full_name.'.jpg';
        //     if (File::exists('uploads/employees_image/'. $media_file_name)) {
        //         unlink('uploads/employees_image/' . $media_file_name);
        //     }
        // }
        // $employee->delete();
        // return redirect()->route('showInstitution',$institution->institution_slug);
    }
    public function destroyUser($user_slug)
    {
        if (auth()->user()->profile->employee_department != 'الإدارة' && auth()->user()->level != 'مدير') {
            return redirect()->back()->with([
                'MainSlowAlertMessage'=>'فشل',
                'SlowAlertMessage'=>' لا يمكنك القيام بهذا الإجراء .',
                'alert_type_A'   =>'danger'
            ]);
        }
        $allUsers = User::all();
        if (count($allUsers) > 1) {
            $user= User:: where('user_slug',$user_slug)->first();
            $user->profile->user_id = null;
            $user->profile->save();
            $user->delete();
            return redirect()->route('allUsers')->with([
                'MainSlowAlertMessage'=>'نجح',
                'SlowAlertMessage'=>' تم حذف حساب الموظف بنجاح .',
                'alert_type_A'   =>'info'
            ]);
        }else{
            return redirect()->route('allUsers')->with([
                'MainSlowAlertMessage'=>'فشل',
                'SlowAlertMessage'=>' عزيزي لا يمكنك حذف الحساب الأخير .',
                'alert_type_A'   =>'danger'
            ]);
        }
        // $employee= Employee:: where('employee_slug',$employee_slug)->first();
        // $institution= $employee->institution;
        // $employee->institution->save();
        // if ( $employee->employee_image) {
        //     $media_file_name ='IMG_320_'.$employee->employee_full_name.'.jpg';
        //     if (File::exists('uploads/employees_image/'. $media_file_name)) {
        //         unlink('uploads/employees_image/' . $media_file_name);
        //     }
        // }
        // $employee->delete();
        // return redirect()->route('showInstitution',$institution->institution_slug);
    }
}
