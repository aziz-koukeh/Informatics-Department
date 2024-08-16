@extends('layouts.app')

@section('css')



@endsection



@section('content')





    @if (count($devices) == 0 && count($employees) == 0 && count($institutions) == 0)
        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">

            <!-- Newsletter Start -->
            <div class="container-xxl bg-primary newsletter  py-5">
                <div class="py-3">
                    <div class="row align-items-center" style="min-height: calc(100vh - 225px);">
                        <div class="col-12  text-center col-md-7">
                            <h3 class="text-white">!! لا يوجد نتائج بحث</h3>
                            <div class="position-relative w-100 my-3" style="direction: rtl;">
                                <form action="{{route('searchPage')}}">
                                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" name="keyword" value="{{ old('keyword',request()->keyword) }}" placeholder="البحث عن ....." style="height: 48px;">
                                    <button type="search"  class="btn shadow-none position-absolute top-0 end-0 my-1 me-2"><i class="fa fa-search text-primary fs-4"></i></button>
                                </form>
                            </div>
                            <h5 class="text-white text-xs">عدد النتائج : <b>{{count($devices)}}</b></h5>
                        </div>
                        <div class="col-md-5 text-center mb-n5 d-none d-md-block">
                            <img class="img-fluid" style="height: 250px;" src="{{asset('assets/img/newsletter.png')}}">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Newsletter End -->

        </div>
        <!-- Navbar & Hero End -->
    @endif
    
    @if (count($devices) >0)
        <!-- DataTales Devices Start -->
        <!-- Begin Page Content -->
        <div class="container-xxl pt-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="card shadow mb-4"  style="direction: rtl">
                <div class="card-header py-3 d-inline-flex w-100">
                    <h3 class="font-weight-bold text-primary ms-5 me-2">نتائج البحث - مواد</h3>
                    <div class="position-relative w-25 mx-2" style="direction: rtl;">
                        <form action="{{route('searchPage')}}">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" name="keyword" value="{{ old('keyword',request()->keyword) }}" placeholder="البحث عن ....." style="height: 48px;">
                            <button type="search"  class="btn shadow-none position-absolute top-0 end-0 my-1 me-2"><i class="fa fa-search text-primary fs-4"></i></button>
                        </form>
                    </div>
                    <h5 class="text-primary mt-4 text-xs  mx-2">عدد النتائج : <b>{{count($devices)}}</b></h5>
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
                                    <th>مكان المادة</th>
                                    <th>المصدر</th>
                                    <th>رقم المذكرة</th>
                                    <th>رقم الجلد</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المادة</th>
                                    <th>رقم المادة</th>
                                    <th>موديل المادة</th>
                                    <th>مكان المادة</th>
                                    <th>المصدر</th>
                                    <th>رقم المذكرة</th>
                                    <th>رقم الجلد</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                @php
                                    $num = 0;
                                @endphp
                                @forelse ($devices as $device)
                                <tr>
                                    <td>{{++$num}}</td>
                                    <td>{{$device->device_name}}</td>
                                    <td>{{$device->device_number}}</td>
                                    <td>{{$device->device_model}}</td>
                                    <td>
                                        @if ($device->employee)
                                            <a class="text-secondary" href="{{route('showEmployee',$device->employee->employee_slug)}}">
                                                عهدة الموظف {{$device->employee->employee_full_name }}
                                            </a>
                                        @elseif ($device->institution)
                                            <a class="text-primary" href="{{route('showInstitution',$device->institution->institution_slug)}}">
                                                في منشأة {{$device->institution->institution_name}}
                                            </a>
                                        @else
                                            <span class="text-success">مستودع الدائرة</span>
                                        @endif
                                    </td>
                                    
                                    <td>{{$device->device_importNotes->first()->import_device_source}}</td>
                                    <td>
                                        <a class="text-info" href="{{route('showImportRequestNote',$device->device_importNotes->first()->import_request_note_slug)}}">
                                            {{$device->device_importNotes->first()->import_request_note_SN}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$device->device_importNotes->first()->import_request_note_folder}}
                                    </td>
                                    <td>{{Carbon\Carbon::parse($device->device_importNotes->first()->created_at)->format('Y-m-d')}}</td>
                                    <td>
                                        <a href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                    </td>
                                    
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="10">لا يوجد نتائج</td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- DataTales Devices End -->
    @endif
        
    
    @if (count($employees) >0)
    
        <!-- DataTales Employees Start -->
        <!-- Begin Page Content -->
        <div class="container-xxl py-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="card shadow mb-4"  style="direction: rtl">
                <div class="card-header py-3 d-inline-flex w-100">
                    <h3 class="font-weight-bold text-primary ms-5 me-2">نتائج البحث - موظفين</h3>
                    <div class="position-relative w-25 mx-2" style="direction: rtl;">
                        <form action="{{route('searchPage')}}">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" name="keyword" value="{{ old('keyword',request()->keyword) }}" placeholder="البحث عن ....." style="height: 48px;">
                            <button type="search"  class="btn shadow-none position-absolute top-0 end-0 my-1 me-2"><i class="fa fa-search text-primary fs-4"></i></button>
                        </form>
                    </div>
                    <h5 class="text-primary mt-4 text-xs  mx-2">عدد النتائج : <b>{{count($employees)}}</b></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-1 " >
                        <table class="table table-bordered table-hover text-center" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الموظف</th>
                                    <th>عمل الموظف</th>
                                    <th>المنشأة التابع لها</th>
                                    <th>نوع المنشأة</th>
                                    <th>رقم الهاتف</th>
                                    <th>الرقم الوطني</th>
                                    <th>الرقم الذاتي</th>
                                    <th>عدد مواد العهدة</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الموظف</th>
                                    <th>عمل الموظف</th>
                                    <th>المنشأة التابع لها</th>
                                    <th>نوع المنشأة</th>
                                    <th>رقم الهاتف</th>
                                    <th>الرقم الوطني</th>
                                    <th>الرقم الذاتي</th>
                                    <th>عدد مواد العهدة</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                @php
                                    $num1 = 0;
                                @endphp
                                @forelse ($employees as $employee)
                                <tr>
                                    <td>{{ ++$num1 }}</td>
                                    <td>{{$employee->employee_full_name}}</td>
                                    <td>{{$employee->employee_job}}</td>
                                    <td>
                                        <a href="{{route('showInstitution' ,$employee->institution->institution_slug)}}">
                                            {{$employee->institution->institution_name}}
                                        </a>
                                    </td>
                                    <td>
                                    @if ($employee->institution->institution_kind == 'first')
                                        مدرسة إبتدائية  
                                    @elseif ($employee->institution->institution_kind == 'second')
                                        مدرسة إعدادية
                                    @elseif ($employee->institution->institution_kind == 'third_pub')
                                        ثانوية عامة
                                    @elseif ($employee->institution->institution_kind == 'third_pro')
                                        ثانوية مهنية
                                    @elseif ($employee->institution->institution_kind == 'college')
                                        معهد
                                    @elseif ($employee->institution->institution_kind == 'compound')
                                        مجمع
                                    @elseif ($employee->institution->institution_kind == 'circle_pri')
                                        دائرة عامة
                                    @elseif ($employee->institution->institution_kind == 'circle_sec')
                                        دائرة فرعية
                                    @endif</td>
                                    <td>{{$employee->employee_phone_number}}</td>
                                    <td>{{$employee->employee_national_number}}</td>
                                    <td>{{$employee->employee_self_number}}</td>
                                    <td>
                                        @if ($employee->institution->institution_kind == 'circle_pri' || $employee->institution->institution_name == 'دائرة المعلوماتية' || $employee->employee_job == 'مدرس معلوماتية' )
                                            @if (count($employee->employee_devices) >0)
                                                {{count($employee->employee_devices)}}
                                            @else
                                                -
                                            @endif
                                        @else
                                            لا يوجد عهد شخصية 
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <a href="{{route('showEmployee',$employee->employee_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                    </td>
                                    
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="8">لا يوجد نتائج</td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- DataTales Employees End -->
    @endif

    
    @if (count($institutions) >0)
        <!-- DataTales Institution Start -->
        <!-- Begin Page Content -->
        <div class="container-xxl pb-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="card shadow mb-4"  style="direction: rtl">
                <div class="card-header py-3 d-inline-flex w-100">
                    <h3 class="font-weight-bold text-primary ms-5 me-2">نتائج البحث - منشآت</h3>
                    <div class="position-relative w-25 mx-2" style="direction: rtl;">
                        <form action="{{route('searchPage')}}">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" name="keyword" value="{{ old('keyword',request()->keyword) }}" placeholder="البحث عن ....." style="height: 48px;">
                            <button type="search"  class="btn shadow-none position-absolute top-0 end-0 my-1 me-2"><i class="fa fa-search text-primary fs-4"></i></button>
                        </form>
                    </div>
                    <h5 class="text-primary mt-4 text-xs  mx-2">عدد النتائج : <b>{{count($institutions)}}</b></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-1 " >
                        <table class="table table-bordered table-hover text-center" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المنشأة</th>
                                    <th>نوع المنشأة</th>
                                    <th>رقم الهاتف</th>
                                    <th>مدير المنشأة</th>
                                    <th>عدد الموظفين</th>
                                    <th>عدد المواد المستلمة</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المنشأة</th>
                                    <th>نوع المنشأة</th>
                                    <th>رقم الهاتف</th>
                                    <th>مدير المنشأة</th>
                                    <th>عدد الموظفين</th>
                                    <th>عدد المواد المستلمة</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                                @php
                                    $num2 = 0;
                                @endphp
                                @forelse ($institutions as $institution)
                                <tr>
                                    <td>{{ ++$num2 }}</td>
                                    <td>{{$institution->institution_name}}</td>
                                    <td>
                                        @if ($institution->institution_kind == 'first')
                                            مدرسة إبتدائية  
                                        @elseif ($institution->institution_kind == 'second')
                                            مدرسة إعدادية
                                        @elseif ($institution->institution_kind == 'third_pub')
                                            ثانوية عامة
                                        @elseif ($institution->institution_kind == 'third_pro')
                                            ثانوية مهنية
                                        @elseif ($institution->institution_kind == 'college')
                                            معهد
                                        @elseif ($institution->institution_kind == 'compound')
                                            مجمع
                                        @elseif ($institution->institution_kind == 'circle_pri')
                                            دائرة عامة
                                        @elseif ($institution->institution_kind == 'circle_sec')
                                            دائرة فرعية
                                        @endif
                                    </td>
                                    <td>{{$institution->institution_phone}}</td>
                                    <td>
                                        @if ($institution->manager)
                                            {{$institution->manager->employee_full_name}}
                                        @elseif ($institution->manager_first)
                                            {{$institution->manager_first->employee_full_name}}
                                        @endif
                                    </td>
                                    <td>{{count($institution->employees)}}</td>
                                    <td>{{count($institution->institution_devices)}}</td>
                                    <td>
                                        <a href="{{route('showInstitution',$institution->institution_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                    </td>
                                    
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="8">لا يوجد نتائج</td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- DataTales Institution End -->
    @endif


@endsection
