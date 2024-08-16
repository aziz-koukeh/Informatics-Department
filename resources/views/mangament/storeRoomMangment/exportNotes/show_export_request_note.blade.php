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
        <a href="{{route('exportRequestNotesLog')}}">مذكرات تسليم</a> 
        / 
        @if ($export_request_note->exported_to_employee)
            
            <span class="text-dark"> مذكرة تسليم إلى عهدة <a href="{{route('showEmployee',$export_request_note->exported_to_employee->employee_slug)}}">{{$export_request_note->exported_to_employee->employee_full_name}}</a> -رقم : {{$export_request_note->export_request_note_SN}} - تاريخ : {{Carbon\Carbon::parse($export_request_note->created_at)->format('Y-m-d')}}</span> 
        @else
            
            <span class="text-dark"> مذكرة تسليم إلى <a href="{{route('showInstitution',$export_request_note->exported_to->institution_slug)}}">{{$export_request_note->exported_to->institution_name}}</a> -رقم : {{$export_request_note->export_request_note_SN}} - تاريخ : {{Carbon\Carbon::parse($export_request_note->created_at)->format('Y-m-d')}}</span> 
        @endif
    </div> 
    <!-- root page End -->


    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="position-relative text-center mb-1 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-4 text-center">
                                <h5>الجمهورية العربية السورية</h5>
                                <h6>وزارة التربية - مديرية التربية بحلب</h6>
                                <h6><b>دائرة المعلوماتيــــــة</b></h6>
                            </div>
                            <div class="col-4">
                                <h2 class="mt-2">مذكرة تسليم</h2>
                                <p class="mb-1">إلى
                                    <a 
                                    @if ($export_request_note->exported_to_employee)
                                        href="{{route('showEmployee' ,$export_request_note->exported_to_employee->employee_slug)}}"
                                    @else
                                        href="{{route('showInstitution' ,$export_request_note->exported_to->institution_slug )}}"
                                    @endif
                                    
                                    >
                                        @if ($export_request_note->exported_to->institution_kind == 'first')
                                            مدرسة إبتدائية  
                                        @elseif ($export_request_note->exported_to->institution_kind == 'second')
                                            مدرسة إعدادية
                                        @elseif ($export_request_note->exported_to->institution_kind == 'third_pub')
                                            ثانوية عامة
                                        @elseif ($export_request_note->exported_to->institution_kind == 'third_pro')
                                            ثانوية مهنية
                                        @elseif ($export_request_note->exported_to->institution_kind == 'college')
                                            معهد
                                        @elseif ($export_request_note->exported_to->institution_kind == 'compound')
                                            مجمع
                                        @elseif ($export_request_note->exported_to->institution_kind == 'circle_pri')
                                            عهدة الموظف  {{$export_request_note->exported_to_employee->employee_full_name}}
                                        @elseif ($export_request_note->exported_to->institution_kind == 'circle_sec')
                                            دائرة فرعية
                                        @endif
                                        @if ($export_request_note->exported_to->institution_kind != 'circle_pri')
                                            {{$export_request_note->exported_to->institution_name}}
                                        @endif
                                    </a>
                                </p>
                                @if (!$export_request_note->exported_to_employee )
                                    <p class="mb-2">الشخص المستلم: {{$export_request_note->export_request_note_by_person}}</label>
                                @endif  

                            </div>
                            <div class="col-4 d-block ">
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="number" class="form-control text-center" id="export_request_note_folder" value="{{$export_request_note->export_request_note_folder}}"  placeholder="الجلد" disabled>
                                    <label for="export_request_note_folder">رقم الجلد:</label>
                                </div>
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="number" class="form-control text-center" id="export_request_note_SN" value="{{$export_request_note->export_request_note_SN}}"  placeholder="المتسلسل" disabled>
                                    <label for="export_request_note_SN">الرقم المتسلسل:</label>
                                </div>
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="date" class="form-control text-center" id="created_at" value="{{Carbon\Carbon::parse($export_request_note->created_at)->format('Y-m-d')}}"  placeholder="التاريخ" disabled>
                                    <label for="created_at">التاريخ:</label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="text-center wow fadeInUp " data-wow-delay="0.01s">
                    <h4 class="ff-secondary text-center text-primary fw-normal mb-2 d-inline-flex me-3">الأجهزة المستلمة</h4>
                    <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#export_request_image">عرض المذكرة</button>
                    @if (auth()->user()->profile->employee_department == 'المستودع' )
                        <button class="badge rounded-pill bg-primary py-3" data-bs-toggle="modal" data-bs-target="#edit_export_request">تعديل المذكرة</button>

                        <!-- Full Screen edit_export_request Start -->
                        <div class="modal fade" id="edit_export_request" tabindex="-1">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);direction:ltr;height:auto;">
                                    <div class="modal-header border-0" style="direction:rtl">
                                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex align-items-center justify-content-center">

                                        <!-- Team Start -->
                                        <div class="container pt-3 pb-3" style="direction: rtl">
                                            <div class="container">
                                                <form  data-toggle="validator" role="form" method="post" action="{{route('updateExportRequestNote',$export_request_note->export_request_note_slug)}}" enctype="multipart/form-data">
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
                                                                        <h2 class="mt-2 text-white">مذكرة تسليم</h2>
                                                                        <p class="text-white">
                                                                            @if ($export_request_note->exported_to->institution_kind == 'first')
                                                                                مدرسة إبتدائية  
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'second')
                                                                                مدرسة إعدادية
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'third_pub')
                                                                                ثانوية عامة
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'third_pro')
                                                                                ثانوية مهنية
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'college')
                                                                                معهد
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'compound')
                                                                                مجمع
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'circle_pri')
                                                                                عهدة شخصية
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'circle_sec')
                                                                                دائرة فرعية
                                                                            @endif
                                                                            @if ($export_request_note->exported_to->institution_kind != 'circle_pri')
                                                                                {{$export_request_note->exported_to->institution_name}}
                                                                            @endif
                                                                        </p>
                                                                        <div class="form-floating form-group">
                                                                            @if ($export_request_note->exported_to->institution_kind == 'compound' || $export_request_note->exported_to->institution_kind == 'third_pro' || $export_request_note->exported_to->institution_kind == 'college' || $export_request_note->exported_to->institution_kind == 'circle_sec' )
                                                                                <input style="border: unset" type="text" class="form-control @error('export_request_note_by_person') is-invalid @enderror text-center" name="export_request_note_by_person" value="{{$export_request_note->exported_to->storekeeper->employee_full_name}}" id="export_request_note_by_person"  placeholder="export_request_note_by_person" readonly  >
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'circle_pri' )
                                                                                <input style="border: unset" type="text" class="form-control @error('export_request_note_by_person') is-invalid @enderror text-center" name="export_request_note_by_person" value="{{$export_request_note->export_request_note_by_person}}" id="export_request_note_by_person"  placeholder="export_request_note_by_person" readonly  >
                                                                                <input type="hidden" name="employee_slug" value="{{$export_request_note->exported_to_employee->employee_slug}}">
                                                                        
                                                                            @elseif ($export_request_note->exported_to->institution_kind == 'first' || $export_request_note->exported_to->institution_kind == 'second' || $export_request_note->exported_to->institution_kind == 'third_pub' )
                                                                                @php
                                                                                    $person =null ;
                                                                                    if (count($export_request_note->exported_to->employees) >0 ) {
                                                                                        foreach ($export_request_note->exported_to->employees as $employee) {
                                                                                            if ($employee->employee_full_name == $export_request_note->export_request_note_by_person ) {
                                                                                                $person ='check' ;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    
                                                                                @endphp
                                                                                <select class="form-control text-center @error('export_request_note_by_person') is-invalid @enderror mb-2"  name="export_request_note_by_person" id="export_request_note_by_person" required>
                                                                                    @if (count($export_request_note->exported_to->employees)>0)
                                                                                        @foreach ($export_request_note->exported_to->employees as $employee)
                                                                                        <option
                                                                                            @if ($employee->employee_full_name == $export_request_note->export_request_note_by_person)
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

                                                                                @error('export_request_note_by_person')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="export_request_note_by_person">الشخص المستلم:</label>
                                                                        </div>

                                                                        @if ($export_request_note->exported_to->institution_kind == 'first' || $export_request_note->exported_to->institution_kind == 'second' || $export_request_note->exported_to->institution_kind == 'third_pub'  )
                                                                            <div class="form-floating form-group mb-1">
                                                                                <input  type="text" class="form-control @error('export_request_note_by_person_else') is-invalid @enderror text-center" name="export_request_note_by_person_else"  @if ($person == null) value="{{$export_request_note->export_request_note_by_person}}" @endif id="export_request_note_by_person_else"  placeholder="الموكل" >
                                                                                    @error('export_request_note_by_person_else')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                <div class="help-block with-errors pull-right"></div>
                                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                <label for="export_request_note_by_person_else">الموظف الموكل :</label>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                    <div class="col-4 d-block ">
                                                                        <div class="form-floating form-group mb-1">
                                                                            <input style="border: unset;" type="number" class="form-control @error('export_request_note_folder') is-invalid @enderror text-center" name="export_request_note_folder" id="export_request_note_folder" value="{{$export_request_note->export_request_note_folder}}" placeholder="الجلد" required>
                                                                                @error('export_request_note_folder')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="export_request_note_folder">رقم الجلد:</label>
                                                                        </div>
                                                                        <div class="form-floating form-group mb-1">
                                                                            <input style="border: unset;" type="number" class="form-control @error('export_request_note_SN') is-invalid @enderror text-center" name="export_request_note_SN" id="export_request_note_SN" value="{{$export_request_note->export_request_note_SN}}" placeholder="المتسلسل" required>
                                                                                @error('export_request_note_SN')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="export_request_note_SN">الرقم المتسلسل:</label>
                                                                        </div>
                                                                        <div class="form-floating form-group mb-1">
                                                                            <input style="border: unset;" type="date" class="form-control @error('created_at') is-invalid @enderror text-center" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="created_at" value="{{Carbon\Carbon::parse($export_request_note->created_at)->format('Y-m-d')}}" placeholder="التاريخ" readonly>
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

                                                        <div class="row justify-content-center g-2 mb-4">
                                                            @php
                                                                $this_Note_Devices =$export_request_note->exportNote_Devices; // عدد أجهزة المذكرة
                                                                $device_model_Devices = collect($this_Note_Devices)->unique('device_model'); // اصناف المواد في المذكرة

                                                                $alloweds = collect($allowed_devices)->unique('device_model');
                                                            @endphp


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
                                                                        <p class="mb-0 text-xs">موديل : {{$allowed_device->device_model}}</p>
                                                                        <a class="mb-0" href="{{route('showAllDevices',$allowed_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                                                                        @php
                                                                        // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------
                                                                            $id_array= [];
                                                                            foreach ($this_Note_Devices->where('device_model',$allowed_device->device_model) as $key => $device) {
                                                                                $id_array[$key]=  $device->id;
                                                                            }
                                                                        // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------

                                                                        @endphp
                                                                        <div class="text-center form-floating form-group my-3 mx-5">
                                                                            <input type="hidden" name="device_model[]" value="{{$allowed_device->device_model}}" >
                                                                            <input type="number" name="device_count[]" id="{{$allowed_device->device_slug}}" min="0" max="{{count($allowed_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array)) + count($this_Note_Devices->where('device_model',$allowed_device->device_model)) }}" value="{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}" class="w-100 text-center form-control" placeholder="العدد" >
                                                                        
                                                                        @if (count($this_Note_Devices->where('device_model',$allowed_device->device_model)) > 0)
                                                                            <label for="{{$allowed_device->device_slug}}" class="mb-0 text-primary text-xs">الكمية المسجلة للمادة</label>
                                                                        @endif
                                                                    </div>
                                                                        <p class="mb-3 text-success text-xs">الكمية المسموحة إضافتها للمذكرة :{{count($allowed_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array))}}</p>

                                                                    </div>
                                                                </div>
                                                            @empty

                                                            @endforelse
                                                        </div>
                                                        <hr>
                                                        <div class="row justify-content-center g-2 mb-4">
                                                            <h3 class="text-center text-white"> أجهزة متاحة أخرى</h3>
                                                            @php
                                                                $device_cards =[];
                                                                foreach ($device_model_Devices as $key => $device) {
                                                                    $device_cards[$key] = $device->device_model;
                                                                }
                                                            @endphp
                                                            {{-- @dd($device_cards) --}}

                                                            @forelse ($alloweds->whereNotIn('device_model',$device_cards) as $allowed_device)
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
                                                                        <p class="mb-0 text-xs">موديل : {{$allowed_device->device_model}}</p>
                                                                        <a class="mb-0" href="{{route('showAllDevices',$allowed_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                                                                        @php
                                                                        // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------
                                                                            $id_array= [];
                                                                            foreach ($this_Note_Devices->where('device_model',$allowed_device->device_model) as $key => $device) {
                                                                                $id_array[$key]=  $device->id;
                                                                            }
                                                                        // التعرف على الأيديدات الأجهزة الموجودة في المذكرة لتجنبها لاحقا لعدم تكرارها في نفس المذكرة  ----------

                                                                        @endphp
                                                                        <div class="text-center form-floating form-group my-3 mx-5">
                                                                            <input type="hidden" name="device_model[]" value="{{$allowed_device->device_model}}" >
                                                                            <input type="number" name="device_count[]" id="{{$allowed_device->device_slug}}" min="0" max="{{count($allowed_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array)) + count($this_Note_Devices->where('device_model',$allowed_device->device_model)) }}" value="{{count($this_Note_Devices->where('device_model',$allowed_device->device_model))}}" class="w-100 text-center form-control"  placeholder="العدد" >
                                                                            
                                                                            <label for="{{$allowed_device->device_slug}}" class="mb-3 text-success text-xs">الكمية حتى :{{count($allowed_devices->where('device_model',$allowed_device->device_model)->whereNotIn('id',$id_array))}}</label>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @empty

                                                            @endforelse
                                                        </div>

                                                        <hr>
                                                        <div class="col-4">
                                                            <div class="form-floating form-group">
                                                                <input type="file" class="form-control @error('export_request_image') is-invalid @enderror text-center" name="export_request_image" id="export_request_image" placeholder="Subject">
                                                                    @error('export_request_image')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="export_request_image">صورة عن المذكرة:</label>
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
                        <!-- Full Screen edit_export_request End -->
                    @endif 
                    <!-- Full Screen export_request_image Start -->
                    <div class="modal fade" id="export_request_image" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                                <div class="modal-header border-0" style="direction:rtl">
                                    <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex align-items-center justify-content-center" style="max-height:100vh ">

                                    <img class="img-fluid mx-auto" style="max-height:85vh " src="{{asset($export_request_note->export_request_image)}}">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Full Screen export_request_image End -->
                </div>
                <div class="row justify-content-center g-2 mb-4">
                    @php
                        $devices = collect($export_request_note->exportNote_Devices)->unique('device_model');
                    @endphp

                    @forelse ($devices as $export_request_note_device)
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.07s">
                            <div class="card text-center shadow rounded overflow-hidden">
                                <div class="rounded-circle overflow-hidden m-4">
                                    @if ($export_request_note_device->device_image)
                                        <img class="img-fluid" style="height: 150px" src="{{asset($export_request_note_device->device_image)}}" alt="">
                                    @else
                                        <img class="img-fluid" style="height: 150px" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" alt="">
                                    @endif
                                </div>
                                <h5 class="mb-0">{{$export_request_note_device->device_name}}</h5>
                                <p class="mb-0 text-xs">موديل : {{$export_request_note_device->device_model}}</p>
                                <p class="mb-0 text-xs">كمية المادة :{{count($export_request_note->exportNote_Devices->where('device_model',$export_request_note_device->device_model))}}</p>
                                <a class="mb-3" href="{{route('showAllDevices',$export_request_note_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.07s">
                            <div class="card text-center shadow rounded overflow-hidden">
                                <div class="rounded-circle overflow-hidden m-4">
                                    <img class="img-fluid" src="{{asset('assets/img/portfolio-3.jpg')}}" alt="">
                                </div>
                                <h5 class="mb-0">لا يوجد مواد متاحة</h5>

                            </div>
                        </div>

                    @endforelse
                </div>

            </div>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
