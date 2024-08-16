@extends('layouts.app')

@section('css')
@endsection



@section('content')

    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        /
        <a href="{{route('allInstitutions')}}">المنشآت</a> 
        / 
        @if ($current_institution->main_institution)
        <a href="{{route('showInstitution',$current_institution->main_institution->institution_slug)}} ">{{$current_institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a href="{{route('showInstitution',$current_institution->institution_slug)}}">{{$current_institution->institution_name}}</a>  
        / 
        <a class="text-dark"> إستعادة من {{$current_institution->institution_name}} </a> 
    </div> 
    <!-- root page End -->

    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
            <form  data-toggle="validator" role="form" method="post" action="{{route('storeDevicesBack',$current_institution->institution_slug)}}" enctype="multipart/form-data">
                @csrf
                
                <div class="col-lg-12">
                    <div class="position-relative text-center mb-1 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-4 text-center">
                                <h5 class="mt-2">الجمهورية العربية السورية</h5>
                                <h6>وزارة التربية - مديرية التربية بحلب</h6>
                                <h6><b>دائرة المعلوماتيــــــة</b></h6>
                            </div>
                            <div class="col-4">
                                <h2 class="mt-2">مذكرة إستلام من</h2>
                                <p class="mb-1">
                                    الأجهزة  الموجودة في
                                    @if ($current_institution->institution_kind == 'first')
                                        مدرسة إبتدائية  
                                    @elseif ($current_institution->institution_kind == 'second')
                                        مدرسة إعدادية
                                    @elseif ($current_institution->institution_kind == 'third_pub')
                                        ثانوية عامة
                                    @elseif ($current_institution->institution_kind == 'third_pro')
                                        ثانوية مهنية
                                    @elseif ($current_institution->institution_kind == 'college')
                                        معهد
                                    @elseif ($current_institution->institution_kind == 'compound')
                                        مجمع
                                    @elseif ($current_institution->institution_kind == 'circle_pri')
                                        دائرة عامة
                                    @elseif ($current_institution->institution_kind == 'circle_sec')
                                        دائرة فرعية
                                    @endif
                                </p>
                                <p class="mb-1">
                                    {{$current_institution->institution_name}}
                                </p>
                                
                                <div class="form-floating form-group mb-1">
                                    @if ($current_institution->institution_kind == 'compound' || $current_institution->institution_kind == 'third_pro' || $current_institution->institution_kind == 'college' || $current_institution->institution_kind == 'circle_sec' )
                                        <input style="border: unset" type="text" class="form-control @error('import_device_source_from_employee') is-invalid @enderror text-center" name="import_device_source_from_employee" value="{{$current_institution->storekeeper->employee_full_name}}" id="import_device_source_from_employee"  placeholder="import_device_source_from_employee" readonly  >
                                    @elseif ($current_institution->institution_kind == 'first' || $current_institution->institution_kind == 'second' || $current_institution->institution_kind == 'third_pub' )
                                        <select class="form-control text-center @error('import_device_source_from_employee') is-invalid @enderror mb-2"  name="import_device_source_from_employee" id="import_device_source_from_employee" required>
                                            @if (count($current_institution->employees)>0)
                                                @foreach ($current_institution->employees as $employee)
                                                    <option value="{{$employee->employee_full_name}}">{{$employee->employee_job}} : {{$employee->employee_full_name}}</option>
                                                @endforeach
                                            @endif
                                            <option value="else">موظف آخر</option>
                                        </select>
                                    @endif
                                        @error('import_device_source_from_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    <div class="help-block with-errors pull-right"></div>
                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                    <label for="import_device_source_from_employee">الشخص المسلم:</label>
                                </div>
                                @if ($current_institution->institution_kind == 'first' || $current_institution->institution_kind == 'second' || $current_institution->institution_kind == 'third_pub'  )
                                    <div class="form-floating form-group mb-1">
                                        <input  type="text" class="form-control @error('import_device_source_from_employee_else') is-invalid @enderror text-center" name="import_device_source_from_employee_else" id="import_device_source_from_employee_else"  placeholder="الموكل" >
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
                                    <input style="border: unset;height: 35px;" type="number" class="form-control @error('import_request_note_folder') is-invalid @enderror text-center" name="import_request_note_folder" id="import_request_note_folder"  placeholder="الجلد" required>
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
                                    <input style="border: unset;height: 35px;" type="number" class="form-control @error('import_request_note_SN') is-invalid @enderror text-center" name="import_request_note_SN" id="import_request_note_SN"  placeholder="المتسلسل" required>
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
                <div class="card shadow mb-4 wow fadeInUp" data-wow-delay="0.1s"  style="direction: rtl">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">جدول المستلمات</h6>
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
                                        <th>اسم المستلم</th>
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
                                        <th>اسم المستلم</th>
                                        <th>تاريخ التسليم</th>
                                        <th>تفاصيل</th>
                                        <th>تحديد</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $num=1
                                    @endphp
                                    @forelse ($devices as $device)
                                        <tr>
                                            <td>{{$num++}}</td>
                                            <td>{{$device->device_name}}</td>
                                            <td>{{$device->device_number}}</td>
                                            <td>{{$device->device_model}}</td>
                                            <td>{{$device->device_infos}}</td>
                                            <td> {{$device->device_import_export_logs->last()->device_by_person}}</td>
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
                                            <td colspan="7" class="text-center">لايوجد أجهزة مستلمة بعد</td>

                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row g-1 justify-content-center">
                    <div class="col-4">
                        <div class="form-floating form-group">
                            <input type="file" class="form-control @error('import_request_image') is-invalid @enderror text-center" name="import_request_image" id="import_request_image" placeholder="Subject" required>
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
                        <button class="btn btn-primary w-100 py-3" id="submit" type="submit">إسترجاع</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
