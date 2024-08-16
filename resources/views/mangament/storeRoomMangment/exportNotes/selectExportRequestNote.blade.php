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
        <a class="text-dark">مذكرة تسليم إلى جهة {{$current_institution->institution_name}}</a> 
    </div> 
    <!-- root page End -->


    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
            <form  data-toggle="validator" role="form" method="post" action="{{route('storeExportRequestNote',$current_institution->institution_slug)}}" enctype="multipart/form-data">
                @csrf
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
                                    <p>
                                        <a href="{{route('showInstitution' ,$current_institution->institution_slug )}}" >
                                    
                                            {{-- @if ($current_institution->institution_kind == 'first')
                                                المدرسة الإبتدائية  
                                            @elseif ($current_institution->institution_kind == 'second')
                                                المدرسة الإعدادية
                                            @elseif ($current_institution->institution_kind == 'third_pub')
                                                الثانوية العامة
                                            @elseif ($current_institution->institution_kind == 'third_pro')
                                                ثانوية المهنية
                                            @elseif ($current_institution->institution_kind == 'college')
                                                معهد
                                            @elseif ($current_institution->institution_kind == 'compound')
                                                مجمع
                                            @elseif ($current_institution->institution_kind == 'circle_pri')
                                                دائرة عامة
                                            @elseif ($current_institution->institution_kind == 'circle_sec')
                                                دائرة فرعية
                                            @endif --}}
                                            {{$current_institution->institution_name}}
                                        </a>
                                    </p>
                                    <div class="form-floating form-group mb-1">
                                        @if ($current_institution->institution_kind == 'compound' || $current_institution->institution_kind == 'third_pro' || $current_institution->institution_kind == 'college' || $current_institution->institution_kind == 'circle_sec' )
                                            <input style="border: unset" type="text" class="form-control @error('export_request_note_by_person') is-invalid @enderror text-center" name="export_request_note_by_person" value="{{$current_institution->storekeeper->employee_full_name}}" id="export_request_note_by_person"  placeholder="export_request_note_by_person" readonly  >
                                            @error('export_request_note_by_person')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="help-block with-errors pull-right"></div>
                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                            <label for="export_request_note_by_person">أمين المستودع :</label>
                                        @elseif ($current_institution->institution_kind == 'first' || $current_institution->institution_kind == 'second' || $current_institution->institution_kind == 'third_pub' )
                                            <select class="form-control text-center @error('export_request_note_by_person') is-invalid @enderror mb-2"  name="export_request_note_by_person" id="export_request_note_by_person" required>
                                                @if (count($current_institution->employees)>0)
                                                    @foreach ($current_institution->employees as $employee)
                                                        <option value="{{$employee->employee_full_name}}">{{$employee->employee_job}} : {{$employee->employee_full_name}}</option>
                                                    @endforeach
                                                @endif
                                                <option value="else">موظف آخر</option>
                                            </select>
                                            @error('export_request_note_by_person')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        <div class="help-block with-errors pull-right"></div>
                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                        <label for="export_request_note_by_person">الشخص المستلم:</label>
                                        @endif
                                    </div>
                                    @if ($current_institution->institution_kind == 'first' || $current_institution->institution_kind == 'second' || $current_institution->institution_kind == 'third_pub'  )
                                        <div class="form-floating form-group mb-1">
                                            <input  type="text" class="form-control @error('export_request_note_by_person_else') is-invalid @enderror text-center" name="export_request_note_by_person_else" id="export_request_note_by_person_else"  placeholder="الموكل" >
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
                                        <input style="border: unset;height: 35px;" type="number" class="form-control @error('export_request_note_folder') is-invalid @enderror text-center" name="export_request_note_folder" id="export_request_note_folder"  placeholder="الجلد" required>
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
                                        <input style="border: unset;height: 35px;" type="number" class="form-control @error('export_request_note_SN') is-invalid @enderror text-center" name="export_request_note_SN" id="export_request_note_SN"  placeholder="المتسلسل" required>
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
                                        <input style="border: unset;height: 35px;" type="date" class="form-control @error('created_at') is-invalid @enderror text-center" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="created_at"  placeholder="التاريخ" required>
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

                    <div class="text-center wow fadeInUp" data-wow-delay="0.01s">
                        <h3 class="ff-secondary text-center text-primary fw-normal mb-2">الأجهزة المتاحة</h3>
                    </div>
                    <div class="row justify-content-center g-2 mb-4">
                        {{-- @php
                            $devices = collect($allowed_devices)->unique('device_model');
                            // $devices = collect($allowed_devices)->unique('device_file_card');
                        @endphp --}}

                        {{-- @forelse ($allowed_devices as $device) --}}
                            {{-- <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.07s">
                                <div class="card text-center shadow rounded overflow-hidden">
                                    <div class="rounded-circle overflow-hidden m-4">
                                        @if ($allowed_device->device_image)
                                            <img class="img-fluid" style="height: 150px" src="{{asset($allowed_device->device_image)}}" alt="">
                                        @else
                                            <img class="img-fluid" style="height: 150px" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" alt="">
                                        @endif
                                    </div>
                                    <h5 class="mb-0">{{$allowed_device->device_name}} </h5>
                                    <p class="mb-0">موديل : {{$allowed_device->device_model}}</p>
                                    <p class="mb-0">العدد المتاح : {{count($allowed_devices->where('device_model',$allowed_device->device_model))}}</p>
                                    <a href="{{route('showAllDevices',$allowed_device->device_model)}}"><small>تفاصيل الصنف</small></a>
                                    <div class="text-center my-3 mx-5">


                                        <input type="hidden" name="device_model[]"  value="{{$allowed_device->device_model}}" >
                                        <input type="number" name="device_count[]" min="0" max="{{count($allowed_devices->where('device_model',$allowed_device->device_model))}}" value="" class="w-100 text-center form-control" >
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="card shadow mb-4"   style="direction: rtl">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">جدول الأثاث</h6>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive py-1" >
                                            <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>اسم المادة</th>
                                                        <th>رقم المادة</th>
                                                        <th>موديل المادة</th>
                                                        <th>حالة المادة</th>
                                                        <th>تاريخ التسليم</th>
                                                        <th>تفاصيل</th>
                                                        <th>تحديد</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>اسم المادة</th>
                                                        <th>رقم المادة</th>
                                                        <th>موديل المادة</th>
                                                        <th>حالة المادة</th>
                                                        <th>تاريخ التسليم</th>
                                                        <th>تفاصيل</th>
                                                        <th>تحديد</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @php
                                                        $num=1
                                                    @endphp
                                                    @forelse ($allowed_devices as $device)
                                                        <tr>
                                                            <td>{{$num++}}</td>
                                                            <td>{{$device->device_name}}</td>
                                                            <td>{{$device->device_number}}</td>
                                                            <td>{{$device->device_model}}</td>
                                                            <td>{{$device->device_infos}}</td>
                                                            <td>{{Carbon\Carbon::parse($device->device_import_export_logs->last()->created_at)->format('Y-m-d')}}</td>
                                                            <td><a class="mb-3" href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                            <td>
                                                                <div class="form-switch px-1 mx-1" >
                                                                    <input class="form-check-input mx-0 px-0" type="checkbox" name="device_slug[]" role="switch" value="{{$device->device_slug}}" id="{{$device->device_slug}}">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
            
                                                        <tr>
                                                            <td colspan="6" class="text-center">لايوجد أثاث للتسليم</td>
            
                                                        </tr>
                                                    @endforelse
            
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- @empty
                            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.07s">
                                <div class="card text-center shadow rounded overflow-hidden">
                                    <div class="rounded-circle overflow-hidden m-4">
                                        <img class="img-fluid" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}" style="height: 300px" alt="">
                                    </div>
                                    <h5 class="mb-3">لا يوجد مواد متاحة</h5>

                                </div>
                            </div>

                        @endforelse --}}
                    </div>

                    <hr>
                    <div class="col-4">
                        <div class="form-floating form-group">
                            <input type="file" class="form-control @error('export_request_image') is-invalid @enderror text-center" name="export_request_image" id="export_request_image" placeholder="Subject" required>
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
                        <button class="btn btn-primary w-100 py-3" id="submit" type="submit">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
