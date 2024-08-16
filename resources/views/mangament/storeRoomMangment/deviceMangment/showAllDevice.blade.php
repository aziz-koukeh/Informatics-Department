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
        <a class="text-dark"> صالح </a> 
    </div> 
    <!-- root page End -->


    <!-- About Start -->
    <div class="container-xxl pt-5"  style="direction: rtl">
        <div class="container px-lg-5">
            <div class="row g-1">
                @php
                    $device = $devices->first();
                @endphp
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-title position-relative mb-4 pb-2">
                        <h6 class="position-relative text-primary ps-4">حول المادة</h6>
                        <h2 class="mt-2">{{$device->device_name}}</h2>
                    </div>
                    
                    <p class="mb-4">مواصفات المادة :{{$device->device_details}}</p>
                    <div class="row g-1 mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>رقم المادة : {{$device->device_number}}</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>موديل المادة : {{$device->device_model}}</h6>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>رقم بطاقة المادة : {{$device->device_file_card}}</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>وحدة المادة : {{$device->device_weight}}</h6>
                        </div>
                    </div>
                    <div class="row g-1 ">
                        <div class="col-sm-12">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>ملحقات المادة : {{$device->device_belongings}}</h6>
                        </div>
                        <div class="col-sm-12">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>عدد الملحقات : {{$device->device_belongings_count}}</h6>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 justify-content-center">
                    @if ($device->device_image)
                        <img class="img-fluid wow zoomIn mx-auto" style="max-height: 400px" data-wow-delay="0.5s" src="{{asset($device->device_image)}}">
                    @else
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{asset('assets/img/undraw_progressive_app_m-9-ms.svg')}}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    <!-- DataTales Example Start -->
    <!-- Begin Page Content -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <!-- DataTales Example -->
        <div class="card shadow mb-4"  style="direction: rtl">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">سجل الصنف - العدد : {{count($devices)}}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive py-1 " >
                    <table class="table table-bordered table-hover text-center" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المادة</th>
                                <th>حالة المادة</th>
                                <th>مكان المادة</th>
                                <th>المصدر</th>
                                <th>رقم المذكرة</th>
                                <th>تاريخ الإدخال</th>
                                <th>تفاصيل</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>اسم المادة</th>
                                <th>حالة المادة</th>
                                <th>مكان المادة</th>
                                <th>المصدر</th>
                                <th>رقم المذكرة</th>
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
                                <td>{{$device->device_infos}}</td>
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
                                <td>{{Carbon\Carbon::parse($device->device_importNotes->first()->created_at)->format('Y-m-d')}}</td>
                                <td>
                                    <a href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                </td>
                                
                            </tr>

                            @empty
                            <tr>
                                <td colspan="7">لا يوجد مذكرات إدخال</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- DataTales Example End -->


@endsection




@section('script')

@endsection
