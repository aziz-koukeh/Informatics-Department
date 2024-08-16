@extends('layouts.app')

@section('css')



@endsection



@section('content')

    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        <a href="{{route('storeRoom')}}">المستودع</a> 
        /
        <a href="{{route('importRequestNotesLog')}}">مذكرات إدخال</a> 
        / 
        @if ($import_request_note->import_type == 'restore')
            @if ($import_request_note->imported_from_employee)
                
                <span class="text-dark"> مذكرة إستعادة من عهدة <a href="{{route('showEmployee',$import_request_note->imported_from_employee->employee_slug)}}">{{$import_request_note->imported_from_employee->employee_full_name}}</a> -رقم : {{$import_request_note->import_request_note_SN}} - تاريخ : {{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}</span> 
            @else
                
                <span class="text-dark"> مذكرة إستعادة من <a href="{{route('showInstitution',$import_request_note->imported_from->institution_slug)}}">{{$import_request_note->imported_from->institution_name}}</a> -رقم : {{$import_request_note->import_request_note_SN}} - تاريخ : {{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}</span> 
            @endif
        @elseif ($import_request_note->import_type == 'store')
            <span class="text-dark"> مذكرة إدخال من  {{$import_request_note->import_device_source}} -رقم : {{$import_request_note->import_request_note_SN}} - تاريخ : {{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}</span> 


        @endif
    </div> 
    <!-- root page End -->



    <!-- Contact Start -->
    <div class="container-fluid py-5"  style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="position-relative text-center mb-1 pb-2 ">
                    <div class="row">
                        <div class="col-4 text-center">
                            <h5>الجمهورية العربية السورية</h5>
                            <h6>وزارة التربية - مديرية التربية بحلب</h6>
                            <h6><b>دائرة المعلوماتيــــــة</b></h6>
                        </div>
                        <div class="col-4  text-center">
                            @if ($import_request_note->import_type == 'store')
                                <h2 class="mt-2">مذكرة إدخال</h2>
                                @if ($import_request_note->imported_from)
                                    <a href="{{route('showInstitution',$import_request_note->imported_from->institution_slug)}}" class="mb-1" ><b>{{$import_request_note->import_request_note_status}}</b></a>
                                
                                @else
                                    <p class="mb-1" ><b>{{$import_request_note->import_request_note_status}}</b></p>
                                    
                                @endif
                                <p class="mb-1" ><b>{{$import_request_note->import_device_source_from_employee}}</b></p>
                            @elseif ($import_request_note->import_type == 'restore')
                                <h2 class="mt-2">مذكرة إدخال إستعادة</h2>
                                <p class="mb-2"> من 
                                    <a 
                                    @if ($import_request_note->imported_from_employee)
                                        href="{{route('showEmployee' ,$import_request_note->imported_from_employee->employee_slug)}}"
                                    @else
                                        href="{{route('showInstitution' ,$import_request_note->imported_from->institution_slug )}}"
                                    @endif
                                    
                                    >

                                        @if ($import_request_note->imported_from->institution_kind == 'first')
                                            مدرسة إبتدائية  
                                        @elseif ($import_request_note->imported_from->institution_kind == 'second')
                                            مدرسة إعدادية
                                        @elseif ($import_request_note->imported_from->institution_kind == 'third_pub')
                                            ثانوية عامة
                                        @elseif ($import_request_note->imported_from->institution_kind == 'third_pro')
                                            ثانوية مهنية
                                        @elseif ($import_request_note->imported_from->institution_kind == 'college')
                                            معهد
                                        @elseif ($import_request_note->imported_from->institution_kind == 'compound')
                                            مجمع
                                        @elseif ($import_request_note->imported_from->institution_kind == 'circle_pri')
                                            عهدة الموظف {{$import_request_note->imported_from_employee->employee_full_name}}
                                        @elseif ($import_request_note->imported_from->institution_kind == 'circle_sec')
                                            دائرة فرعية
                                        @endif
                                        @if ($import_request_note->imported_from->institution_kind != 'circle_pri')
                                            {{$import_request_note->imported_from->institution_name}}
                                        @endif
                                    </a>
                                </p>
                                @if ($import_request_note->import_device_source_from_employee != $import_request_note->import_device_source )
                                    <p class="mb-2"> اسم الموظف : <b>{{$import_request_note->import_device_source_from_employee}}</b></p>
                                @endif
                            @endif
                        </div>
                        <div class="col-4 d-block ">
                            <div class="form-floating form-group mb-1">
                                <input style="border: unset;height: 35px;" type="number" class="form-control text-center" value="{{$import_request_note->import_request_note_folder}}" name="import_request_note_folder" id="import_request_note_folder"  placeholder="الجلد" readonly>
                                <label for="import_request_note_folder">رقم الجلد:</label>
                            </div>
                            <div class="form-floating form-group mb-1">
                                <input style="border: unset;height: 35px;" type="number" class="form-control text-center" value="{{$import_request_note->import_request_note_SN}}" name="import_request_note_SN" id="import_request_note_SN"  placeholder="المتسلسل" readonly>
                                <label for="import_request_note_SN">الرقم المتسلسل:</label>
                            </div>
                            <div class="form-floating form-group mb-1">
                                <input style="border: unset;height: 35px;" type="date" class="form-control  text-center" value="{{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}" name="created_at" id="created_at"  placeholder="التاريخ" readonly>
                                <label for="created_at">التاريخ:</label>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center wow fadeInUp mb-2 " data-wow-delay="0.01s">
                    @if ($import_request_note->import_type == 'store')
                        <h4 class="ff-secondary text-center text-primary fw-normal mb-2 d-inline-flex me-3">الأجهزة المدخلة</h4>
                        <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#viewImportRequestNoteStore">عرض المذكرة</button>
                        @if (auth()->user()->profile->employee_department == 'المستودع' )
                            <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#editImportRequestNoteStore">تعديل المذكرة</button>
                        @endif
                    @elseif ($import_request_note->import_type == 'restore')
                        <h4 class="ff-secondary text-center text-primary fw-normal mb-2 d-inline-flex me-3">الأجهزة المستعادة</h4>
                        @if (auth()->user()->profile->employee_department == 'المستودع' )
                            <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#viewImportRequestNoteRestore">عرض المذكرة</button>
                        @endif
                        <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#editImportRequestNoteRestore">تعديل المذكرة</button>
                    @endif

                </div>
                @if ($import_request_note->import_type == 'store')


                    <div class="table-responsive">
                        <table class="table table-hover  table-striped table-bordered table-sm  caption-top text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col"  class="text-dark" style="width: 20px">الرقم</th>
                                    <th colspan="2" class="text-dark" >التفاصيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $num=0;
                                    $devices = collect($import_request_note->importNote_Devices)->unique('device_model');
                                @endphp
                                @forelse ($devices as $device)
                                <tr >
                                    <th scope="row" style="vertical-align:middle">{{++$num}}</th>
                                    <td colspan="2">
                                        <div class="row g-2 mb-1">
                                            <div class="col-md-2">
                                                <div class="form-floating form-group">
                                                    <input type="text" class="form-control" id="device_name{{$device->device_slug}}" value="{{$device->device_name}}" name="device_name" placeholder="device_name" readonly>
                                                    <label for="device_name{{$device->device_slug}}">اسم المادة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-floating form-group">
                                                    <input type="text" class=" form-control" id="device_number{{$device->device_slug}}" value="{{$device->device_number}}"  name="device_number" placeholder="Your device_number" readonly>
                                                    <label for="device_number{{$device->device_slug}}">رمز المادة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-group">
                                                    <input class="form-control" placeholder="device_details" id="device_details{{$device->device_slug}}" value="{{$device->device_details}}"  name="device_details" readonly>
                                                    <label for="device_details">مواصفات المادة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-floating form-group">
                                                    <input type="text" class="form-control" id="device_weight{{$device->device_slug}}" value="{{$device->device_weight}}"  name="device_weight" placeholder="device_weight" readonly>
                                                    <label for="device_weight{{$device->device_slug}}">الوحدة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-floating form-group">
                                                    <input type="number" class="form-control" id="device_count{{$device->device_slug}}" value="{{count($import_request_note->importNote_Devices->where('device_file_card',$device->device_file_card))}}"  name="device_count" placeholder="device_count" readonly>
                                                    <label for="device_count{{$device->device_slug}}">الكمية</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-floating form-group">
                                                    <input type="number" class="form-control" id="device_file_card{{$device->device_slug}}" value="{{$device->device_file_card}}"  name="device_file_card"  placeholder="device_file_card" readonly>
                                                    <label for="device_file_card{{$device->device_slug}}">رقم البطاقة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-group">
                                                    <input class="form-control" placeholder="device_notes" id="device_notes{{$device->device_slug}}" value="{{$device->device_notes}}"  name="device_notes" readonly>
                                                    <label for="device_notes{{$device->device_slug}}">ملاحظات</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row g-1">
                                            <div class="col-md-9">
                                                <div class="form-floating form-group">
                                                    <input class="form-control" placeholder="device_belongings" id="device_belongings{{$device->device_slug}}" value="{{$device->device_belongings}}"  name="device_belongings" readonly>
                                                    <label for="device_belongings{{$device->device_slug}}">ملحقات المادة</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-floating form-group">
                                                    <input type="number" class="form-control" id="device_belongings_count{{$device->device_slug}}" value="{{$device->device_belongings_count}}"  name="device_belongings_count" placeholder="device_belongings_count" readonly>
                                                    <label for="device_belongings_count{{$device->device_slug}}">عدد الملحقات</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-floating form-group">
                                                    <button class="btn btn-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#viewDeviceImage{{$device->device_slug}}">عرض المادة</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Full Screen viewDeviceImage Start -->
                                        <div class="modal fade" id="viewDeviceImage{{$device->device_slug}}" tabindex="-1">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);direction: ltr">
                                                    <div class="modal-header border-0" style="direction:rtl">
                                                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body d-flex align-items-center justify-content-center" style="max-height:90vh ">
                                                        @if ($device->device_image)
                                                            <img class="img-fluid mx-auto" style="max-height:75vh " src="{{asset($device->device_image)}}">
                                                        @else
                                                        <img class="img-fluid" style="max-height:75vh " src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}">
                                                        text-xs<p> لا يوجد صورة للمادة</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Full Screen viewDeviceImage End -->

                                </tr>
                                @empty

                                @endforelse


                            </tbody>

                        </table>


                    </div>
                @else

                    <div class="row justify-content-center g-2 mb-4">
                        @php
                            $devices = collect($import_request_note->importNote_Devices)->unique('device_model');
                        @endphp

                        @forelse ($devices as $device)
                            <div class="col-lg-2 col-md-6  wow fadeInUp" data-wow-delay="0.07s">
                                <div class="card text-center shadow rounded overflow-hidden">
                                    <div class="rounded-circle overflow-hidden m-4">
                                        @if ($device->device_image)
                                            <img class="img-fluid" style="height: 150px" src="{{asset($device->device_image)}}" alt="">
                                        @else
                                            <img class="img-fluid" style="height: 150px" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" alt="">
                                        @endif
                                    </div>
                                    <h5 class="mb-0">{{$device->device_name}}</h5>
                                    <p class="mb-0  text-xs">الموديل :{{$device->device_model}}</p>
                                    <p class="mb-0">كمية المادة :{{count($import_request_note->importNote_Devices->where('device_model',$device->device_model))}}</p>
                                    <a class="mb-3" href="{{route('showAllDevices',$device->device_model)}}"><small>تفاصيل الصنف</small></a>

                                </div>
                            </div>
                        @empty
                            <div class="col-lg-12 col-md-6 ">
                                <div class="card text-center shadow rounded overflow-hidden">
                                    <div class="rounded-circle overflow-hidden m-4">
                                        <img class="img-fluid" src="{{asset('assets/img/portfolio-3.jpg')}}" alt="">
                                    </div>
                                    <h5 class="mb-0">لا يوجد مواد متاحة</h5>

                                </div>
                            </div>

                        @endforelse
                    </div>

                @endif


            </div>
        </div>
    </div>
    <!-- Contact End -->
   
    @if ($import_request_note->import_type == 'restore')
        
        <!-- Full Screen viewImportRequestNoteRestore Start -->
        <div class="modal fade" id="viewImportRequestNoteRestore" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                    <div class="modal-header border-0" style="direction:rtl">
                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center" style="max-height:100vh ">

                        <img class="img-fluid mx-auto" style="max-height:85vh " src="{{asset($import_request_note->import_request_image)}}">

                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen viewImportRequestNoteRestore End -->
        @if (auth()->user()->profile->employee_department == 'المستودع' )
            <!-- Full Screen editImportRequestNoteRestore Start -->
            <div class="modal fade" id="editImportRequestNoteRestore" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);direction:ltr;height:auto;">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center">

                            <!-- Team Start -->
                            <div class="container pt-3 pb-3" style="direction: rtl">
                                <div class="container">
                                    <form  data-toggle="validator" role="form" method="post" action="{{route('updateDevicesBack' , $import_request_note->import_request_note_slug)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="position-relative text-center mb-1 pb-2 ">
                                                    <div class="row">
                                                        <div class="col-4 text-center text-white">
                                                            <h5 class="text-white">الجمهورية العربية السورية</h5>
                                                            <h6 class="text-white">وزارة التربية - مديرية التربية بحلب</h6>
                                                            <h6 class="text-white"><b>دائرة المعلوماتيــــــة</b></h6>
                                                        </div>
                                                        <div class="col-4">
                                                            <h2 class="mt-2 text-white">مذكرة إدخال إستعادة</h2>
                                                            <p class="mb-1 text-white" > من
                                                                @if ($import_request_note->imported_from->institution_kind == 'first')
                                                                    مدرسة إبتدائية  
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'second')
                                                                    مدرسة إعدادية
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'third_pub')
                                                                    ثانوية عامة
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'third_pro')
                                                                    ثانوية مهنية
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'college')
                                                                    معهد
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'compound')
                                                                    مجمع
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'circle_pri')
                                                                    عهدة موظف
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'circle_sec')
                                                                    دائرة فرعية
                                                                @endif
                                                                <b>
                                                                @if ($import_request_note->imported_from->institution_kind != 'circle_pri')
                                                                    {{$import_request_note->imported_from->institution_name}}
                                                                
                                                                @endif
                                                                </b></p>


                                                            <div class="form-floating form-group">
                                                                @if ($import_request_note->imported_from->institution_kind == 'compound' || $import_request_note->imported_from->institution_kind == 'third_pro' || $import_request_note->imported_from->institution_kind == 'college' || $import_request_note->imported_from->institution_kind == 'circle_sec' )
                                                                    <input style="border: unset" type="text" class="form-control @error('import_device_source_from_employee') is-invalid @enderror text-center" name="import_device_source_from_employee" value="{{$import_request_note->imported_from->storekeeper->employee_full_name}}" id="import_device_source_from_employee"  placeholder="import_device_source_from_employee" readonly  >
                                                                
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'circle_pri' )
                                                                    <input style="border: unset" type="text" class="form-control @error('import_device_source_from_employee') is-invalid @enderror text-center" name="import_device_source_from_employee" value="{{$import_request_note->import_device_source_from_employee}}" id="import_device_source_from_employee"  placeholder="import_device_source_from_employee" readonly  >
                                                                    
                                                                    <input type="hidden" name="employee_slug" value="{{$import_request_note->imported_from_employee->employee_slug}}">
                                                            
                                                                @elseif ($import_request_note->imported_from->institution_kind == 'first' || $import_request_note->imported_from->institution_kind == 'second' || $import_request_note->imported_from->institution_kind == 'third_pub' )
                                                                    @php
                                                                        $person =null ;
                                                                        if (count($import_request_note->imported_from->employees) >0 ) {
                                                                            foreach ($import_request_note->imported_from->employees as $employee) {
                                                                                if ($employee->employee_full_name == $import_request_note->import_device_source_from_employee ) {
                                                                                    $person ='check' ;
                                                                                }
                                                                            }
                                                                        }
                                                                        
                                                                    @endphp
                                                                    <select class="form-control text-center @error('import_device_source_from_employee') is-invalid @enderror mb-2"  name="import_device_source_from_employee" id="import_device_source_from_employee" required>
                                                                        
                                                                        @if (count($import_request_note->imported_from->employees)>0)
                                                                            @foreach ($import_request_note->imported_from->employees as $employee)
                                                                            <option
                                                                                @if ($employee->employee_full_name == $import_request_note->import_device_source_from_employee)
                                                                                    selected
                                                                                @endif
                                                                            value="{{$employee->employee_full_name}}">{{$employee->employee_job}} : {{$employee->employee_full_name}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                        <option
                                                                        @if ($person == null)
                                                                            selected
                                                                        @endif
                                                                        value="else">موظف آخر</option>
                                                                    </select>
                                                                @endif

                                                                    @error('import_device_source_from_employee')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="import_device_source_from_employee">الموظف :</label>
                                                            </div>

                                                            @if ($import_request_note->imported_from->institution_kind == 'first' || $import_request_note->imported_from->institution_kind == 'second' || $import_request_note->imported_from->institution_kind == 'third_pub'  )
                                                                <div class="form-floating form-group mb-1">
                                                                    <input  type="text" class="form-control @error('import_device_source_from_employee_else') is-invalid @enderror text-center" name="import_device_source_from_employee_else"  @if ($person == null) value="{{$import_request_note->import_device_source_from_employee}}" @endif id="import_device_source_from_employee_else"  placeholder="الموكل" >
                                                                        @error('import_device_source_from_employee_else')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="import_device_source_from_employee_else">الموظف الموكل :</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-4 d-block ">
                                                            <div class="form-floating form-group mb-1">
                                                                <input style="border: unset;" type="number" class="form-control @error('import_request_note_folder') is-invalid @enderror text-center" name="import_request_note_folder" id="import_request_note_folder" value="{{$import_request_note->import_request_note_folder}}" placeholder="الجلد" required>
                                                                    @error('import_request_note_folder')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="import_request_note_folder">رقم الجلد:</label>
                                                            </div>
                                                            <div class="form-floating form-group mb-1">
                                                                <input style="border: unset;" type="number" class="form-control @error('import_request_note_SN') is-invalid @enderror text-center" name="import_request_note_SN" id="import_request_note_SN" value="{{$import_request_note->import_request_note_SN}}" placeholder="المتسلسل" required>
                                                                    @error('import_request_note_SN')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="import_request_note_SN">الرقم المتسلسل:</label>
                                                            </div>
                                                            <div class="form-floating form-group mb-1">
                                                                <input style="border: unset;" type="date" class="form-control @error('created_at') is-invalid @enderror text-center" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="created_at" value="{{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}" placeholder="التاريخ" readonly>
                                                                    @error('created_at')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="created_at">التاريخ:</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            @php
                                                $this_Note_Devices =$import_request_note->importNote_Devices; // عدد أجهزة المذكرة
                                                $device_model_Devices = collect($this_Note_Devices)->unique('device_model'); // اصناف المواد في المذكرة
                                                $institution_all_devices = $import_request_note->imported_from->institution_devices ;
                                                $institution_devices = collect($institution_all_devices)->unique('device_model');
                                            @endphp
                                            <div class="row justify-content-center g-2 mb-4">


                                                @forelse ($device_model_Devices as $allowed_device)
                                                    <div class="col-lg-3 col-md-6 bg-gray">
                                                        <div class="card text-center shadow rounded overflow-hidden" style="height: 382px">
                                                            <div class="rounded-circle overflow-hidden m-4">
                                                                @if ($allowed_device->device_image)
                                                                    <img class="img-fluid" style="height: 150px" src="{{asset($allowed_device->device_image)}}" alt="">
                                                                @else
                                                                    <img class="img-fluid" style="height: 150px" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" alt="">
                                                                @endif
                                                            </div>
                                                            <h5 class="mb-0">{{$allowed_device->device_name}}</h5>

                                                            <p class="mb-0 text-primary text-xs">الموديل :{{$allowed_device->device_model}}</p>
                                                            <a class="mb-0" href="{{route('showAllDevices',$allowed_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                                                            @php
                                                            // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------
                                                                $id_array= [];
                                                                foreach ($this_Note_Devices->where('device_model',$allowed_device->device_model) as $key => $device) {
                                                                    $id_array[$key]=  $device->id;
                                                                }
                                                            // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------

                                                            @endphp
                                                            <div class="text-center my-3 mx-5">
                                                                <input type="hidden" name="device_model[]" value="{{$allowed_device->device_model}}" >
                                                                <input type="number" name="device_count[]" min="0" max="{{count($institution_all_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array)) + count($this_Note_Devices->where('device_model',$allowed_device->device_model)) }}" value="{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}" class="w-100 text-center form-control" >
                                                            </div>
                                                            @if (count($this_Note_Devices->where('device_model',$allowed_device->device_model)) > 0)
                                                                <p class="mb-0 text-primary  text-xs">الكمية المسجلة للمادة :{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}</p>
                                                            @endif

                                                            <p class="mb-3 
                                                            @if (count($institution_all_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array)) > 0)
                                                            text-success 
                                                            @else
                                                            text-dark
                                                            @endif
                                                            text-xs">الكمية الموجودة في الجهة حالياً :{{count($institution_all_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array))}}</p>

                                                        </div>
                                                    </div>
                                                @empty

                                                @endforelse
                                            </div>

                                            <hr>
                                            @php
                                                $device_cards =[];
                                                foreach ($device_model_Devices as $key => $device) {
                                                    $device_cards[$key] = $device->device_model;
                                                }
                                            @endphp
                                            @if (count($institution_devices->whereNotIn('device_model',$device_cards))>0)
                                                
                                                <div class="row justify-content-center g-2 mb-4">
                                                    <h3 class="text-center text-white"> أجهزة أخرى</h3>
                                                    {{-- @dd($device_cards) --}}

                                                    @forelse ($institution_devices->whereNotIn('device_model',$device_cards) as $allowed_device)
                                                        <div class="col-lg-3 col-md-6 bg-gray">
                                                            <div class="card text-center shadow rounded overflow-hidden" style="height: 382px">
                                                                <div class="rounded-circle overflow-hidden m-4">
                                                                    @if ($allowed_device->device_image)
                                                                        <img class="img-fluid" style="height: 150px" src="{{asset($allowed_device->device_image)}}" alt="">
                                                                    @else
                                                                        <img class="img-fluid" style="height: 150px" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" alt="">
                                                                    @endif
                                                                </div>
                                                                <h5 class="mb-0">{{$allowed_device->device_name}}</h5>

                                                                <p class="mb-0 text-primary  text-xs">الموديل :{{$allowed_device->device_model}}</p>
                                                                <a class="mb-0" href="{{route('showAllDevices',$allowed_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                                                                @php
                                                                // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------
                                                                    $id_array= [];
                                                                    foreach ($this_Note_Devices->where('device_model',$allowed_device->device_model) as $key => $device) {
                                                                        $id_array[$key]=  $device->id;
                                                                    }
                                                                // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------

                                                                @endphp
                                                                <div class="text-center my-3 mx-5">
                                                                    <input type="hidden" name="device_model[]" value="{{$allowed_device->device_model}}" >
                                                                    <input type="number" name="device_count[]" min="0" max="{{count($institution_all_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array)) + count($this_Note_Devices->where('device_model',$allowed_device->device_model)) }}" value="{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}" class="w-100 text-center form-control" >
                                                                </div>
                                                                @if (count($this_Note_Devices->where('device_model',$allowed_device->device_model)) > 0)
                                                                    <p class="mb-0 text-primary text-xs">الكمية المسجلة للمادة :{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}</p>
                                                                @endif

                                                                <p class="mb-3 text-success  text-xs">الكمية الموجودة في الجهة حالياً :{{count($institution_all_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array))}}</p>

                                                            </div>
                                                        </div>
                                                    @empty

                                                    @endforelse
                                                </div>

                                            @endif
                                            <div class="col-4">
                                                <div class="form-floating form-group">
                                                    <input type="file" class="form-control @error('import_request_image') is-invalid @enderror text-center" name="import_request_image" id="import_request_image" placeholder="Subject">
                                                        @error('import_request_image')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    <div class="help-block with-errors pull-right"></div>
                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                    <label for="import_request_image">صورة عن المذكرة:</label>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تعديل</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Team End -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- Full Screen editImportRequestNoteRestore End -->
        @endif

    @elseif ($import_request_note->import_type == 'store')

        <!-- Full Screen viewImportRequestNoteStore Start -->
        <div class="modal fade" id="viewImportRequestNoteStore" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                    <div class="modal-header border-0" style="direction:rtl">
                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center" style="max-height:100vh ">
                        <img class="img-fluid mx-auto" style="max-height:85vh "src="{{asset($import_request_note->import_request_image)}}">
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen viewImportRequestNoteStore End -->

        @if (auth()->user()->profile->employee_department == 'المستودع' )
            <!-- Full Screen editImportRequestNoteStore Start -->
            <div class="modal fade" id="editImportRequestNoteStore" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center" style="max-height:100vh ">
                            <!-- Contact Start -->
                            <div class="container-fluid mt-5 py-5"  style="min-height: calc(100vh - 95px);direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{route('updateImportRequestNote' , $import_request_note->import_request_note_slug)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="position-relative text-center mb-1 pb-2">
                                                <div class="row">
                                                    <div class="col-4 text-center text-white">
                                                        <h5 class="text-white">الجمهورية العربية السورية</h5>
                                                        <h6 class="text-white">وزارة التربية - مديرية التربية بحلب</h6>
                                                        <h6 class="text-white"><b>دائرة المعلوماتيــــــة</b></h6>
                                                    </div>
                                                    <div class="col-4">
                                                        <h2 class="mt-2 text-white">مذكرة إدخال</h2>
                                                        
                                                        @php
                                                            $source = null; 
                                                        @endphp
                                                        @forelse ($institutions as $institution)
                                                            @php
                                                                if ($institution->institution_name == $import_request_note->import_device_source){
                                                                    $source = 'check'; 
                                                                }
                                                            @endphp
                                                        @empty
                                                        @endforelse

                                                        <div class="form-floating form-group mb-2">
                                                            <select class="form-control text-center @error('import_device_source_from_employee') is-invalid @enderror"  name="import_device_source_from_employee" id="import_device_source_from_employee" required>
                                                                <option
                                                                @if ($source == null)
                                                                    selected
                                                                @endif
                                                                value="else">جهة أخرى</option>
                                                                @forelse ($institutions->where('institution_name','<>','دائرة المعلوماتية') as $institution)
                                                                    <option
                                                                        @if ($institution->institution_name == $import_request_note->import_device_source)
                                                                            selected
                                                                        @endif
                                                                    value="{{$institution->institution_slug}}">أمين مستودع 
                                                                    {{$institution->institution_name}} </option>
                                                                    
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                            @error('import_device_source_from_employee')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="import_device_source_from_employee">الجهة المسلمة:</label>
                                                        </div>
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('import_device_source') is-invalid @enderror text-center" name="import_device_source" @if ($source == null) value="{{$import_request_note->import_device_source}}" @endif id="import_device_source" placeholder="Subject" >
                                                            @error('import_device_source')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="import_device_source">الجهة المسلمة:</label>
                                                        </div>
                                                        {{-- ------------------------------------- --}}

                                                    </div>
                                                    <div class="col-4 d-block ">
                                                        <div class="form-floating form-group mb-1">
                                                            <input type="number" class="form-control @error('import_request_note_folder') is-invalid @enderror text-center"  value="{{$import_request_note->import_request_note_folder}}" name="import_request_note_folder" id="edit_import_request_note_folder"  placeholder="الجلد" required>
                                                                @error('import_request_note_folder')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="edit_import_request_note_folder">رقم الجلد:</label>
                                                        </div>
                                                        <div class="form-floating form-group mb-1">
                                                            <input type="number" class="form-control @error('import_request_note_SN') is-invalid @enderror text-center" value="{{$import_request_note->import_request_note_SN}}" name="import_request_note_SN" id="edit_import_request_note_SN"  placeholder="المتسلسل" required>
                                                                @error('import_request_note_SN')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="edit_import_request_note_SN">الرقم المتسلسل:</label>
                                                        </div>
                                                        <div class="form-floating form-group mb-1">
                                                            <input type="date" class="form-control @error('created_at') is-invalid @enderror text-center" value="{{Carbon\Carbon::parse($import_request_note->created_at)->format('Y-m-d')}}" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="edit_created_at"  placeholder="التاريخ" readonly>
                                                                @error('created_at')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="edit_created_at">التاريخ:</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <caption><h4 class="fw-bolder text-white">المواد المدخلة:</h4></caption>
                                                <table class="table table-hover table-sm  table-striped table-bordered caption-top text-center">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th scope="col"  class="text-dark" style="width: 20px">الرقم</th>
                                                            <th colspan="2"  class="text-dark" >التفاصيل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $editNum =0;
                                                            $devices = collect($import_request_note->importNote_Devices)->unique('device_file_card');
                                                        @endphp
                                                        @forelse ($devices as $device)
                                                            <tr>

                                                                <th scope="row" style="vertical-align:middle">{{++$editNum}}</th>
                                                                <td colspan="2">
                                                                    <div class="row g-1 mb-1">
                                                                        <div class="col-md-2">
                                                                            <div class="form-floating form-group">
                                                                                <input type="text" class="form-control @error('device_name') is-invalid @enderror" id="edit_device_name{{$device->device_slug}}" value="{{$device->device_name}}" name="device_name[]" placeholder="device_name" required>
                                                                                    @error('device_name')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_name{{$device->device_slug}}">اسم المادة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="form-floating form-group">
                                                                                <input type="text" class=" form-control @error('device_number') is-invalid @enderror" id="edit_device_number{{$device->device_slug}}" value="{{$device->device_number}}" name="device_number[]" placeholder="Your device_number" required>
                                                                                    @error('device_number')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right text-xs"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_number{{$device->device_slug}}">رمز المادة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-floating form-group">
                                                                                <textarea class="form-control @error('device_details') is-invalid @enderror" placeholder="device_details" id="edit_device_details{{$device->device_slug}}" value="{{$device->device_details}}" name="device_details[]"></textarea>
                                                                                    @error('device_details')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_details{{$device->device_slug}}">مواصفات المادة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="form-floating form-group">
                                                                                <input type="text" class="form-control @error('device_weight') is-invalid @enderror" id="edit_device_weight{{$device->device_slug}}" value="{{$device->device_weight}}" name="device_weight[]" placeholder="device_weight">
                                                                                    @error('device_weight')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_weight{{$device->device_slug}}">الوحدة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="form-floating form-group">
                                                                                <input type="number" class="form-control @error('device_count') is-invalid @enderror" id="edit_device_count{{$device->device_slug}}" value="{{count($import_request_note->importNote_Devices->where('device_file_card',$device->device_file_card))}}" name="device_count[]" min="1" value="1" placeholder="device_count" >
                                                                                    @error('device_count')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_count{{$device->device_slug}}">الكمية</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="form-floating form-group">
                                                                                <input type="number" class="form-control @error('device_file_card') is-invalid @enderror" id="edit_device_file_card{{$device->device_slug}}" value="{{$device->device_file_card}}" name="device_file_card[]"  placeholder="device_file_card" required>
                                                                                    @error('device_file_card')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_file_card{{$device->device_slug}}">رقم البطاقة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-floating form-group">
                                                                                <textarea class="form-control @error('device_notes') is-invalid @enderror" placeholder="device_notes" id="edit_device_notes{{$device->device_slug}}" value="{{$device->device_notes}}" name="device_notes[]" ></textarea>
                                                                                    @error('device_notes')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_notes{{$device->device_slug}}">ملاحظات</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row g-1">
                                                                        <div class="col-md-6">
                                                                            <div class="form-floating form-group">
                                                                                <textarea class="form-control @error("device_belongings") is-invalid @enderror" placeholder="device_belongings" id="edit_device_belongings{{$device->device_slug}}" value="{{$device->device_belongings}}" name="device_belongings[]" ></textarea>
                                                                                    @error("device_belongings")
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_belongings{{$device->device_slug}}">ملحقات المادة</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-floating form-group">
                                                                                <input type="number" class="form-control @error("device_belongings_count") is-invalid @enderror" id="edit_device_belongings_count{{$device->device_slug}}" value="{{$device->device_belongings_count}}" name="device_belongings_count[]" placeholder="device_belongings_count" >
                                                                                    @error("device_belongings_count")
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="edit_device_belongings_count{{$device->device_slug}}">عدد الملحقات</label>
                                                                            </div>
                                                                        </div>


                                                                            <div class="col-md-3">
                                                                                <div class="form-floating form-group">
                                                                                    <input type="file" class="form-control @error('device_image') is-invalid @enderror text-center" name="device_image[]" id="edit_device_image{{$device->device_slug}}" placeholder="Subject">
                                                                                        @error('device_image')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    <div class="help-block with-errors pull-right"></div>
                                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                    <label for="edit_device_image{{$device->device_slug}}">صورة عن المادة:</label>
                                                                                </div>
                                                                            </div>

                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        @empty

                                                        @endforelse


                                                    </tbody>
                                                </table>




                                            </div>
                                            
                                            
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-floating form-group">
                                                            <input type="file" class="form-control @error('import_request_image') is-invalid @enderror text-center" name="import_request_image" id="import_request_image" placeholder="Subject" >
                                                                @error('import_request_image')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="import_request_image">صورة عن المذكرة:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تعديل</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Contact End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Full Screen editImportRequestNoteStore End -->
        @endif
    @endif
    
@endsection




@section('script')


@endsection
