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
        @if ($institution->main_institution)
        <a href="{{route('showInstitution',$institution->main_institution->institution_slug)}} ">{{$institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a class="text-dark">{{$institution->institution_name}}</a> 
    </div> 
    <!-- root page End -->


    <!-- About Start -->
    <div class="container-xxl py-5"  style="/*min-height: calc(100vh - 95px);*/direction: rtl">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-title position-relative mb-4 pb-2">
                        <h6 class="position-relative text-primary ps-4">حول
                            @if ($institution->institution_kind == 'first')
                                المدرسة الإبتدائية  
                            @elseif ($institution->institution_kind == 'second')
                                المدرسة الإعدادية
                            @elseif ($institution->institution_kind == 'third_pub')
                                الثانوية العامة
                            @elseif ($institution->institution_kind == 'third_pro')
                                الثانوية المهنية
                            @elseif ($institution->institution_kind == 'college')
                                المعهد
                            @elseif ($institution->institution_kind == 'compound')
                                المجمع
                            @elseif ($institution->institution_kind == 'circle_pri')
                                الدائرة العامة
                            @elseif ($institution->institution_kind == 'circle_sec')
                                الدائرة الفرعية
                            @endif
                        </h6>
                        <h2 class="mt-2">{{$institution->institution_name}}</h2>
                    </div>
                    <p class="mb-4">{{$institution->institution_bio}}</p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub')
                                @if ($institution->manager_first)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>المدير ف1 : {{$institution->manager_first->employee_full_name}}</h6>
                                @endif
                                
                                @if ($institution->amanuensis_first)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>أمين السر ف1 : {{$institution->amanuensis_first->employee_full_name}}</h6>
                                @endif
                            @else
                                @if ($institution->manager)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>المدير  : {{$institution->manager->employee_full_name}}</h6>
                                @endif
                                
                                @if ($institution->storekeeper)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>أمين المستودع : {{$institution->storekeeper->employee_full_name}}</h6>
                                    
                                @endif
                            @endif
                            
                        </div>
                        <div class="col-sm-6">
                            @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub')
                                @if ($institution->manager_second)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>المدير ف2 : {{$institution->manager_second->employee_full_name}}</h6>
                                @endif
                                
                                @if ($institution->amanuensis_second)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>أمين السر ف2 : {{$institution->amanuensis_second->employee_full_name}}</h6>
                                @endif
                            @endif
                            
                        </div>
                        @if (count($institution->computer_saver) > 0 )
                            <div class="col-sm-6">
                                @foreach ($institution->computer_saver as $computer_saver)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>أمين سر الحاسوب : {{$computer_saver->employee_full_name}}</h6>
                                @endforeach
                                
                            </div>
                        @endif
                        @if (count($institution->computer_teacher) > 0 )
                            <div class="col-sm-6">
                                @foreach ($institution->computer_teacher as $computer_teacher)
                                    <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>مدرس معلوماتية : {{$computer_teacher->employee_full_name}}</h6>
                                @endforeach
                            </div>
                        @endif
                        @if (count($institution->employees) > 0 )
                            <div class="col-sm-12">
                                <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>عدد الموظفين التابعين : {{count($institution->employees)}}</h6>
                            </div>
                        @endif
                    </div>


                    <!-- institution options -->
                    <div class="d-flex align-items-center mt-4">
                        <a class="btn btn-primary rounded-pill px-4 me-3" href="{{route('institutionMap',$institution->institution_slug)}}"><i class="fa-solid fa-location-dot fa-xl"></i></a>
                        @if (
                        (auth()->user()->profile->employee_department != 'شعبة الصيانة'
                        || auth()->user()->profile->employee_department != 'شعبة الديوان' ) && $institution->institution_name != 'دائرة المعلوماتية'
                        || ((auth()->user()->profile->employee_department == 'الإدارة' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' )
                        && $institution->institution_name == 'دائرة المعلوماتية')
                        )
                            <a class="btn btn-outline-primary btn-square me-3" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                        @endif
                        @if ($institution->institution_name != 'دائرة المعلوماتية' && (auth()->user()->profile->employee_department != 'شعبة الصيانة' || auth()->user()->profile->employee_department != 'شعبة الديوان' ) )
                            <a class="btn btn-outline-primary btn-square me-3"  data-bs-toggle="modal" data-bs-target="#addEmployee"><i class="fa-solid fa-person-circle-plus fa-xl"></i></a>
                        @endif
                        @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub' 
                        && (auth()->user()->profile->employee_department == 'الإدارة' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' || auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي' ))
                        {{-- إضافة الشرط للموديل في حال وجوده للتجهيزات القاعات الحاسوبية --}}
                            <a class="btn btn-outline-primary btn-square me-3" href="#"><i class="fa-solid fa-network-wired fa-xl"></i></a>
                        @endif


                        @if (!$institution->main_institution)
                            @if (count($institution->institution_devices)>0)
                                
                                @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub' 
                                && (auth()->user()->profile->employee_department == 'شعبة المناقلات' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' ))
                                    <a class="btn btn-outline-primary btn-square me-3" href="{{route('selectNextSide',$institution->institution_slug)}}"><i class="fa-solid fa-retweet fa-xl"></i></a>
                                @endif
                            @endif
                            @if ($institution->institution_kind == 'compound'
                            && (auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي' 
                            || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                            || auth()->user()->profile->employee_department == 'الإدارة' ))
                                <a class="btn btn-outline-primary rounded-pill px-2 me-3" data-bs-toggle="modal" data-bs-target="#createNew">
                                    <i class="fa-solid fa-plus fa-xl"></i>
                                    <i class="fa-solid fa-hotel fa-xl"></i>
                                </a>
                                <a class="btn btn-outline-primary btn-square me-3" href="{{route('devices_sub_main_institution',$institution->institution_slug)}}"><i class=" fa-solid fa-rotate-right fa-xl"></i></a>

                            @endif
                            @if ($institution->institution_kind != 'circle_pri' && $institution->institution_name != 'دائرة المعلوماتية'
                            && (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' )
                            )
                                <a class="btn btn-outline-primary btn-square me-3" href="{{route('selectExportRequestNote',$institution->institution_slug)}}"><i class="fa-solid fa-download fa-xl"></i></a>
                                @if (count($institution->institution_devices)>0)
                                    <a class="btn btn-outline-primary btn-square me-3" href="{{route('selectDevicesToRestoreBack',$institution->institution_slug)}}"><i class="fa-solid fa-upload fa-xl"></i></a>
                                @endif
                            @endif
                        @else
                            @if (auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي' 
                            || auth()->user()->profile->employee_department == 'شعبة الأتمتة'  
                            || auth()->user()->profile->employee_department == 'الإدارة' )
                                
                                <a class="btn btn-outline-primary btn-square me-3" href="{{route('devices_main_sub_institution',$institution->institution_slug)}}"><i class=" fa-solid fa-computer fa-xl"></i></a>
                            @endif
                        @endif
                    </div>
                    <!-- institution options -->

                </div>
                <div class="col-lg-6 justify-content-center">
                    @if ($institution->institution_image)
                        <img class="img-fluid wow zoomIn mx-auto" style="height: 400px ;object-fit: cover" data-wow-delay="0.5s" src="{{asset($institution->institution_image)}}">
                    @else
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{asset('assets/img/about.png')}}">
                    @endif
                </div>
            </div>
        
    

            {{-- @if (!$institution->main_institution) --}}
                <hr>
                @if ($institution->institution_name != 'دائرة المعلوماتية')
                    <ul class="nav nav-tabs wow fadeInUp" data-wow-delay="0.1s" id="myTab" role="tablist" style="direction: rtl">
                        @if ($institution->institution_kind != 'circle_pri' )
                            <li class="nav-item mx-1" role="presentation">
                            <button class="nav-link active" id="devices-tab" data-bs-toggle="tab" data-bs-target="#devices" type="button" role="tab" aria-controls="devices" aria-selected="true">أجهزة</button>
                            </li>
                        @endif
                            <li class="nav-item mx-1" role="presentation">
                                <button class="nav-link  @if ($institution->institution_kind == 'circle_pri') active @endif" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees" aria-selected="false">الموظفين</button>
                            </li>
                        @if ($institution->institution_kind == 'compound')
                            <li class="nav-item mx-1" role="presentation">
                            <button class="nav-link " id="school-tab" data-bs-toggle="tab" data-bs-target="#school" type="button" role="tab" aria-controls="school" aria-selected="false">المدارس التابعة</button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content p-2" id="myTabContent">
                        @if ($institution->institution_kind != 'circle_pri' )
                            <div class="tab-pane fade show active" id="devices" role="tabpanel" aria-labelledby="devices-tab">

                                <!-- DataTales Example Start -->
                                <!-- Begin Page Content -->
                                <div class="container-xxl pb-5 wow fadeInUp" data-wow-delay="0.1s">

                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4"  style="direction: rtl">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">جدول المستلمات</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive py-1 " >
                                                <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم المادة</th>
                                                            <th>رقم المادة</th>
                                                            <th>موديل المادة</th>
                                                            <th>حالة المادة</th>
                                                            <th>اسم المستلم</th>
                                                            @if ($institution->institution_kind == 'compound' )
                                                                <th>مكان المادة</th>
                                                            @endif
                                                            <th>تاريخ التسليم</th>
                                                            <th>تفاصيل</th>
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
                                                            @if ($institution->institution_kind == 'compound' )
                                                                <th>مكان المادة</th>
                                                            @endif
                                                            <th>تاريخ التسليم</th>
                                                            <th>تفاصيل</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @php
                                                            $num=1
                                                        @endphp
                                                        {{-- @dd($devices) --}}

                                                        @if ($institution->main_institution)
                                                            @forelse ($institution->sub_institution_devices as $device)
                                                                

                                                                    <tr>
                                                                        <td>{{$num++}}</td>
                                                                        <td>{{$device->device_name}}</td>
                                                                        <td>{{$device->device_number}}</td>
                                                                        <td>{{$device->device_model}}</td>
                                                                        <td>{{$device->device_infos}}</td>
                                                                        <td> {{$device->device_import_export_logs->last()->device_by_person}}</td>
                                                                        
                                                                        <td>{{Carbon\Carbon::parse($device->device_import_export_logs->last()->created_at)->format('Y-m-d')}}</td>
                                                                        <td><a class="mb-3" href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                                    </tr>

                                                                
                                                            @empty

                                                                <tr>
                                                                    <td colspan="7" class="text-center">لايوجد أجهزة مستلمة بعد</td>

                                                                </tr>
                                                            @endforelse
                                                        @else
                                                            @forelse ($institution->institution_devices as $device)
                                                                <tr>
                                                                    <td>{{$num++}}</td>
                                                                    <td>{{$device->device_name}}</td>
                                                                    <td>{{$device->device_number}}</td>
                                                                    <td>{{$device->device_model}}</td>
                                                                    <td>{{$device->device_infos}}</td>
                                                                    <td> {{$device->device_import_export_logs->last()->device_by_person}}</td>
                                                                    @if ($institution->institution_kind == 'compound')
                                                                        @if ($device->sub_institution)
                                                                            <td>{{$device->sub_institution->institution_name}}</td>
                                                                        @else
                                                                            <td> - </td>
                                                                            
                                                                        @endif
                                                                    @endif
                                                                    <td>{{Carbon\Carbon::parse($device->device_import_export_logs->last()->created_at)->format('Y-m-d')}}</td>
                                                                    <td><a class="mb-3" href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                                </tr>
                                                            @empty

                                                                <tr>
                                                                    <td colspan="7" class="text-center">لايوجد أجهزة مستلمة بعد</td>

                                                                </tr>
                                                            @endforelse
                                                        
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- DataTales Example End -->
                                
                            </div>
                        @endif
                        
                            <div class="tab-pane fade  @if ($institution->institution_kind == 'circle_pri') show active @endif" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                                <!-- DataTales Example Start -->
                                <!-- Begin Page Content -->
                                <div class="container-xxl pb-5 ">

                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4"  style="direction: rtl">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">جدول المستلمات</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive py-1 " >
                                                <table class="table table-bordered table-hover text-center" id="dataTable1" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم الموظف</th>
                                                            <th>عمل الموظف</th>
                                                            <th>قدم الموظف</th>
                                                            
                                                            <th>تفاصيل</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم الموظف</th>
                                                            <th>عمل الموظف</th>
                                                            <th>قدم الموظف</th>
                                                            
                                                            <th>تفاصيل</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @php
                                                            $num1=1
                                                        @endphp


                                                            @forelse ($institution->employees as $employee)
                                                                <tr>
                                                                    <td>{{ $num1++ }}</td>
                                                                    <td>{{$employee->employee_full_name}}</td>
                                                                    <td>{{$employee->employee_job}}</td>
                                                                    <td>{{Carbon\Carbon::parse($employee->employee_job_older)->format('Y-m-d')}}</td>
                                                                    <td><a class="mb-3" href="{{route('showEmployee',$employee->employee_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                                </tr>
                                                            @empty

                                                                <tr>
                                                                    <td colspan="5" class="text-center">لا يوجد موطفين محفوظين</td>

                                                                </tr>
                                                            @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- DataTales Example End -->
                                

                            </div>

                        @if ($institution->institution_kind == 'compound')
                            <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="school-tab">
                                 <!-- DataTales Example Start -->
                                <!-- Begin Page Content -->
                                <div class="container-xxl pb-5 ">

                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4"  style="direction: rtl">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">جدول المستلمات</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive py-1 " >
                                                <table class="table table-bordered table-hover text-center" id="dataTable2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم المنشآة</th>
                                                            <th>المرحلة</th>
                                                            <th>المدير</th>
                                                            <th>أمين السر</th>
                                                            <th>أمين سر الحاسوب</th>
                                                            <th>عدد المواد</th>
                                                            <th>تفاصيل</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>اسم المنشآة</th>
                                                            <th>المرحلة</th>
                                                            <th>المدير</th>
                                                            <th>أمين السر</th>
                                                            <th>أمين سر الحاسوب</th>
                                                            <th>عدد المواد</th>
                                                            <th>تفاصيل</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @php
                                                            $num2=1
                                                        @endphp


                                                            @forelse ($institution->sub_institutions as $sub_institution)
                                                                <tr>
                                                                    <td>{{ $num2++ }}</td>
                                                                    <td>{{$sub_institution->institution_name}}</td>
                                                                    <td>
                                                                        @if ($sub_institution->institution_kind == 'first')
                                                                            تعليم أساسي
                                                                        @elseif ($sub_institution->institution_kind == 'second')
                                                                            مدرسة إعدادية
                                                                        @elseif ($sub_institution->institution_kind == 'third_pub')
                                                                            ثانوية عامة
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($sub_institution->manager_first )
                                                                            <a href="{{route('showEmployee',$sub_institution->manager_first->employee_slug)}}">
                                                                            {{$sub_institution->manager_first->employee_full_name}}</a>
                                                                        @else
                                                                            لم يسجل بعد
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($sub_institution->amanuensis_first )
                                                                            <a href="{{route('showEmployee',$sub_institution->amanuensis_first->employee_slug)}}">
                                                                            {{$sub_institution->amanuensis_first->employee_full_name}}</a>
                                                                        @else
                                                                            لم يسجل بعد
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (count($sub_institution->computer_saver)>0 )
                                                                            @foreach ($sub_institution->computer_saver as $computer_saver)
                                                                                <a href="{{route('showEmployee',$computer_saver->employee_slug)}}">
                                                                                {{$computer_saver->employee_full_name}}</a>
                                                                            @endforeach
                                                                        @else
                                                                            لم يسجل بعد
                                                                        @endif
                                                                    </td>
                                                                    <td>{{count($sub_institution->sub_institution_devices)}}</td>
                                                                    <td><a class="mb-3" href="{{route('showInstitution',$sub_institution->institution_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                                </tr>
                                                            @empty

                                                                <tr>
                                                                    <td colspan="8" class="text-center">لا يوجد مدارس تابعة مسجلة  </td>

                                                                </tr>
                                                            @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- DataTales Example End -->
                                
                            </div>
                        @endif
                    </div>
                @endif


                @if ($institution->institution_kind == 'compound'
                && (auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' ))
                    <!-- Full Screen createNew Start -->
                    <div class="modal fade" id="createNew" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                                <div class="modal-header border-0" style="direction:rtl">
                                    <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex align-items-center justify-content-center">
                                    <!-- Contact Start -->
                                        <div class="container-fluid my-5  py-5"  style="min-height: calc(100vh - 95px);direction: rtl">
                                            <form  data-toggle="validator" role="form" method="post" action="{{route('storeInstitution')}}"  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-8">
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-8">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_name') is-invalid @enderror" id="institution_name" name="institution_name" placeholder="institution_name" required>
                                                                    <input type="hidden" name="parent_institution_id" value="{{$institution->id}}">
                                                                        @error('institution_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_name">اسم المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating form-group">
                                                                    <select class="form-control text-center @error('institution_kind') is-invalid @enderror"  name="institution_kind" id="institution_kind" required>
                                                                        <option value="">اختيار</option>
                                                                        <option value="first" >أساسي</option>
                                                                        <option value="second">إعدادي</option>
                                                                        <option value="third_pub">ثانوي عام</option>
                                                                    </select>
                                                                        @error('institution_kind')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_kind">نوع المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-8">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_map') is-invalid @enderror" id="institution_map" name="institution_map" placeholder="institution_map">
                                                                        @error('institution_map')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_map">موقع المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating form-group">
                                                                    <input type="tel" class="form-control @error('institution_phone') is-invalid @enderror" id="institution_phone" name="institution_phone" placeholder="institution_phone" required>
                                                                        @error('institution_phone')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_phone">رقم هاتف المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row g-1 mb-3">
                                                            <div class="col-md-12">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_bio') is-invalid @enderror" id="institution_bio" name="institution_bio" placeholder="institution_bio">
                                                                        @error('institution_bio')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_bio">حول المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating form-group">
                                                                    <input type="file" class="form-control @error('institution_image') is-invalid @enderror" id="institution_image" name="institution_image" placeholder="institution_image">
                                                                        @error('institution_image')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_image">صورة المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_address') is-invalid @enderror" id="institution_address" name="institution_address" placeholder="institution_address">
                                                                        @error('institution_address')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_address">عنوان المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <button class="btn btn-primary w-100 py-3" id="submit" type="submit">حفظ</button>
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
                    <!-- Full Screen createNew End -->
                @endif

            {{-- @endif --}}
            
            @if ($institution->institution_name != 'دائرة المعلوماتية' 
            && (auth()->user()->profile->employee_department != 'شعبة الصيانة' || auth()->user()->profile->employee_department != 'شعبة الديوان' ))
                <!-- Full Screen addEmployee Start -->
                    <div class="modal fade" id="addEmployee" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);height: 100%;">
                                <div class="modal-header border-0" style="direction:rtl">
                                    <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex align-items-center justify-content-center">
                                    <!-- Contact Start -->
                                        <div class="container-fluid py-1"  style="direction: rtl">
                                            <form  data-toggle="validator" role="form" method="post" action="{{route('storeEmployeeProfile',$institution->institution_slug)}}"  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12">
                                                        <div class="position-relative  text-center mb-3 pb-2">
                                                            <h2 class="mt-2 text-light">إضافة موظف</h2>
                                                        </div>
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-3">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_full_name') is-invalid @enderror" id="employee_full_name" name="employee_full_name" placeholder="employee_full_name" required>
                                                                        @error('employee_full_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_full_name">اسم الموظف</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="row g-1">
                                                                    <div class="col-md-2">
                                                                        <div class="form-floating form-group">
                                                                            <input type="text" class="form-control @error('employee_father_name') is-invalid @enderror" id="employee_father_name" name="employee_father_name" placeholder="employee_father_name" required>
                                                                                @error('employee_father_name')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="employee_father_name">اسم الأب</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-floating form-group">
                                                                            <input type="text" class="form-control @error('employee_mother_name') is-invalid @enderror" id="employee_mother_name" name="employee_mother_name" placeholder="employee_mother_name" required>
                                                                                @error('employee_mother_name')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="employee_mother_name">اسم الأم</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-floating form-group">
                                                                            <input type="date" class="form-control @error('employee_birth_day') is-invalid @enderror" id="employee_birth_day" name="employee_birth_day" placeholder="employee_birth_day" required>
                                                                                @error('employee_birth_day')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="employee_birth_day">تاريخ الميلاد</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-floating form-group">
                                                                            <input type="text" class="form-control @error('employee_birth_place') is-invalid @enderror" id="employee_birth_place" name="employee_birth_place" placeholder="employee_birth_place" required >
                                                                                @error('employee_birth_place')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="employee_birth_place">مكان الولادة</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-floating form-group">
                                                                            <input type="text" class="form-control @error('employee_kid') is-invalid @enderror" id="employee_kid" name="employee_kid" placeholder="employee_kid" required>
                                                                                @error('employee_kid')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                            <div class="help-block with-errors pull-right"></div>
                                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                                            <label for="employee_kid">القيد</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-3">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_national_number') is-invalid @enderror" id="employee_national_number" name="employee_national_number" placeholder="employee_national_number" required>
                                                                        @error('employee_national_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_national_number">الرقم الوطني</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_phone_number') is-invalid @enderror" id="employee_phone_number" name="employee_phone_number" placeholder="employee_phone_number" required>
                                                                        @error('employee_phone_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_phone_number">رقم الهاتف</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_marital_status') is-invalid @enderror" id="employee_marital_status" name="employee_marital_status" placeholder="employee_marital_status" >
                                                                        @error('employee_marital_status')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_marital_status">الحالة العائلية (اختياري)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_address') is-invalid @enderror" id="employee_address" name="employee_address" placeholder="employee_address" required>
                                                                        @error('employee_address')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_address">عنوان السكن</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_speciality_certificate') is-invalid @enderror" id="employee_speciality_certificate" name="employee_speciality_certificate" placeholder="employee_speciality_certificate" required>
                                                                        @error('employee_speciality_certificate')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_speciality_certificate">المؤهل العلمي - الشهادة المعين عليها</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_job_naming') is-invalid @enderror" id="employee_job_naming" name="employee_job_naming" placeholder="employee_job_naming" required>
                                                                        @error('employee_job_naming')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_job_naming">المسمى الوظيفي</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_speciality') is-invalid @enderror" id="employee_speciality" name="employee_speciality" placeholder="employee_speciality" required>
                                                                        @error('employee_speciality')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_speciality">الاختصاص</label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    
                                                                    @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub')
                                                                        <select class="form-control text-center @error('employee_job') is-invalid @enderror"  name="employee_job" id="employee_job" placeholder="employee_job" required>
                                                                            <option ></option>
                                                                            @if (!$institution->manager_first)
                                                                                <option value="مدير ف1">مدير ف1</option>
                                                                            @endif
                                                                            @if (!$institution->manager_second)
                                                                                <option value="مدير ف2">مدير ف2</option>
                                                                            @endif
                                                                            @if (!$institution->amanuensis_first)
                                                                                <option value="أمين السر ف1">أمين السر ف1</option>
                                                                            @endif
                                                                            @if (!$institution->amanuensis_second)
                                                                            <option value="أمين السر ف2">أمين السر ف2</option>
                                                                            @endif
                                                                            <option value="أمين سر الحاسوب">أمين سر الحاسوب</option>
                                                                            <option value="مدرس معلوماتية">مدرس معلوماتية</option>
                                                                        </select>
                                                                    @else
                                                                        <input type="text" class="form-control @error('employee_job') is-invalid @enderror" id="employee_job" name="employee_job" placeholder="employee_job" required>
                                                                    @endif
                                                                    @error('employee_job')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_job">العمل المكلف به</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-floating form-group">
                                                                    <select class="form-control text-center @error('employee_categortion') is-invalid @enderror"  name="employee_categortion" id="employee_categortion" placeholder="employee_categortion" required>
                                                                        <option ></option>
                                                                        <option value="first">أولى</option>
                                                                        <option value="second">ثانية</option>
                                                                        <option value="third">ثالثة</option>
                                                                        <option value="fourth">رابعة</option>
                                                                        <option value="fifth">خامسة</option>
                                                                    </select>
                                                                        @error('employee_categortion')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_categortion">الفئة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-floating form-group">
                                                                    <select class="form-control text-center @error('employee_job_status') is-invalid @enderror"  name="employee_job_status" id="employee_job_status" placeholder="employee_job_status" required>
                                                                        <option value="standing">دائم</option>
                                                                        <option value="temporaling">مؤقت</option>
                                                                    </select>
                                                                        @error('employee_job_status')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_job_status">نوع التعيين</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('employee_self_number') is-invalid @enderror" id="employee_self_number" name="employee_self_number" placeholder="employee_self_number" required>
                                                                        @error('employee_self_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_self_number">الرقم الذاتي</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>

                                                        @if ($institution->institution_name == 'دائرة المعلوماتية')                                            
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item" style="background-color: unset;border:unset">
                                                                    <h2 class="accordion-header" id="headingTwo">
                                                                        <button class="collapsed btn btn-outline-secondary bg-white fw-bold p-1 w-100" style="vertical-align:middle;height: calc(3.5rem + 2px);" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        المزيد (اختياري)
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body px-0 py-2">

                                                                            <div class="row g-1 mb-1">

                                                                                <div class="col-md-4">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="text" class="form-control @error('employee_recruitmant_name') is-invalid @enderror" id="employee_recruitmant_name" name="employee_recruitmant_name" placeholder="employee_recruitmant_name">
                                                                                            @error('employee_recruitmant_name')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_recruitmant_name">شعبة التجنيد</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="text" class="form-control @error('employee_recruitmant_number') is-invalid @enderror" id="employee_recruitmant_number" name="employee_recruitmant_number" placeholder="employee_recruitmant_number">
                                                                                            @error('employee_recruitmant_number')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_recruitmant_number">رقم التجنيد</label>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-4">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="text" class="form-control @error('employee_recruitmant_backup_number') is-invalid @enderror" id="employee_recruitmant_backup_number" name="employee_recruitmant_backup_number" placeholder="employee_recruitmant_backup_number">
                                                                                            @error('employee_recruitmant_backup_number')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_recruitmant_backup_number">رقم الاحتياط</label>
                                                                                    </div>
                                                                                </div>
                                    
                                                                            </div>
                                    
                                                                            <div class="row g-1 mb-1">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="text" class="form-control @error('employee_financial_number') is-invalid @enderror" id="employee_financial_number" name="employee_financial_number" placeholder="employee_financial_number" >
                                                                                            @error('employee_financial_number')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_financial_number">رقم المالي</label>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-3">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="text" class="form-control @error('employee_shateb_number') is-invalid @enderror" id="employee_shateb_number" name="employee_shateb_number" placeholder="employee_shateb_number">
                                                                                            @error('employee_shateb_number')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_shateb_number">رقم الشطب</label>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-3">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="date" class="form-control @error('employee_join_date') is-invalid @enderror" id="employee_join_date" name="employee_join_date" placeholder="employee_join_date">
                                                                                            @error('employee_join_date')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_join_date">تاريخ الإلتحاق</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-floating form-group">
                                                                                        <input type="date" class="form-control @error('employee_job_older') is-invalid @enderror" id="employee_job_older" name="employee_job_older" placeholder="employee_job_older">
                                                                                            @error('employee_job_older')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                        <div class="help-block with-errors pull-right"></div>
                                                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                                                        <label for="employee_job_older">القدم الوظيفي</label>
                                                                                    </div>
                                                                                </div>
                                    
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endif

                                                        <div class="row g-1 mb-3 justify-content-center">
                                                            <div class="col-md-3">
                                                                <div class="form-floating form-group">
                                                                    <input type="file" class="form-control @error('employee_image') is-invalid @enderror" id="employee_image" name="employee_image"  placeholder="employee_image">
                                                                        @error('employee_image')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="employee_image">صورة الموظف (اختياري)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <button class="btn btn-primary w-100 py-3" id="submit" type="submit">إضافة</button>
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
                <!-- Full Screen addEmployee End -->
            @endif

            @if (
            (auth()->user()->profile->employee_department != 'شعبة الصيانة'
            || auth()->user()->profile->employee_department != 'شعبة الديوان' ) && $institution->institution_name != 'دائرة المعلوماتية'
            || ((auth()->user()->profile->employee_department == 'الإدارة' || auth()->user()->profile->employee_department != 'شعبة الأتمتة' )
            && $institution->institution_name == 'دائرة المعلوماتية')
            )
                <!-- Full Screen edit Start -->
                    <div class="modal fade" id="edit" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                                <div class="modal-header border-0" style="direction:rtl">
                                    <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex align-items-center justify-content-center">
                                    <!-- Contact Start -->
                                        <div class="container-fluid py-1"  style="min-height: calc(100vh - 95px);direction: rtl">
                                            <form  data-toggle="validator" role="form" method="post" action="{{route('updateInstitution',$institution->institution_slug)}}"  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-8">
                                                        <div class="position-relative  text-center mb-3 pb-2">
                                                            <h2 class="mt-2 text-light">{{$institution->institution_name}}</h2>
                                                        </div>
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-8">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_name') is-invalid @enderror" id="institution_name" name="institution_name" placeholder="institution_name" value="{{$institution->institution_name}}" 
                                                                    @if ($institution->institution_name == 'دائرة المعلوماتية')
                                                                        readonly
                                                                    @else
                                                                        required
                                                                    @endif
                                                                    >
                                                                        @error('institution_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_name">اسم المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating form-group">
                                                                    <select class="form-control text-center @error('institution_kind') is-invalid @enderror"  name="institution_kind" id="institution_kind" disabled>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'first')
                                                                            selected
                                                                        @endif
                                                                        value="first" >أساسي</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'second')
                                                                            selected
                                                                        @endif
                                                                        value="second">إعدادي</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'third_pub')
                                                                            selected
                                                                        @endif
                                                                        value="third_pub">ثانوي عام</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'third_pro')
                                                                            selected
                                                                        @endif
                                                                        value="third_pro">ثانوي مهني</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'college')
                                                                            selected
                                                                        @endif
                                                                        value="college">معهد</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'compound')
                                                                            selected
                                                                        @endif
                                                                        value="compound">مجمع</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'circle_pri')
                                                                            selected
                                                                        @endif
                                                                        value="circle_pri">دائرة عامة</option>
                                                                        <option
                                                                        @if ($institution->institution_kind == 'circle_sec')
                                                                            selected
                                                                        @endif
                                                                        value="circle_sec">دائرة فرعية</option>
                                                                    </select>
                                                                        @error('institution_kind')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_kind">نوع المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row g-1 mb-1">
                                                            <div class="col-md-8">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_map') is-invalid @enderror" id="institution_map" name="institution_map" placeholder="institution_map" value="{{$institution->institution_map}}">
                                                                        @error('institution_map')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_map">موقع المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating form-group">
                                                                    <input type="tel" class="form-control @error('institution_phone') is-invalid @enderror" id="institution_phone" name="institution_phone" placeholder="institution_phone" value="{{$institution->institution_phone}}" >
                                                                        @error('institution_phone')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_phone">رقم هاتف المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        
                                                        <div class="row g-1 mb-3">
                                                            <div class="col-md-12">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_bio') is-invalid @enderror" id="institution_bio" name="institution_bio"  value="{{$institution->institution_bio}}" placeholder="institution_bio">
                                                                        @error('institution_bio')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_bio">حول المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating form-group">
                                                                    <input type="file" class="form-control @error('institution_image') is-invalid @enderror" id="institution_image" name="institution_image"  placeholder="institution_image">
                                                                        @error('institution_image')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_image">صورة المنشأة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating form-group">
                                                                    <input type="text" class="form-control @error('institution_address') is-invalid @enderror" id="institution_address" name="institution_address" value="{{$institution->institution_address}}"  placeholder="institution_address">
                                                                        @error('institution_address')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="institution_address">عنوان المنشأة</label>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تعديل</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        @if ($institution->institution_image)
                                                            <img class="img-fluid wow zoomIn py-5" style="height: 95vh; object-fit:cover" id="photo" src="{{asset($institution->institution_image)}}">
                                                        @else
                                                            <img class="img-fluid wow zoomIn py-5" style="height: 95vh; object-fit:cover" src="{{asset('assets/img/about.png')}}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <!-- Contact End -->
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Full Screen edit End -->
            @endif
        </div>
    </div>
    <!-- About End -->
@endsection




@section('script')
<script>

    const fileSelector = document.querySelector('input')

    fileSelector.onchange = () => {
    var file = fileSelector.files[8]
    var imgUrl = window.URL.createObjectURL(new Blob([file], { type: 'image/jpg' }))
    var photo =document.getElementsById('photo');
    photo.src = imgUrl
}
</script>
@endsection
