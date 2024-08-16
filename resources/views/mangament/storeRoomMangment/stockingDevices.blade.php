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
        <a class="text-dark"> الأجهزة </a> 
    </div> 
    <!-- root page End -->



    <!-- DataTales Devices Start -->
    <!-- Begin Page Content -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="card shadow mb-4"  style="direction: rtl">
            <div class="card-header py-3  w-100">
                جدول {{$kind}} - عدد المواد : {{count($devices)}} 

                @if ($exportType == 'all')
                     <form action="{{route('exportStockingDevices')}}" method="POST" style="float: left">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">Export <i class="fa-solid fa-file-export fa-xl"></i></button>
                    </form>
                @else
                    <form action="{{route('exportStockingDevicesByDate')}}" method="POST" style="float: left">
                        @csrf

                        @if ($exportType == 'currentYear')
                            <input type="hidden" name="currentYear" value="{{$date}}">

                        @elseif ($exportType == 'year')
                            <input type="hidden" name="year" value="{{$date}}">

                        @elseif ($exportType == 'month')
                            <input type="hidden" name="month" value="{{$date}}">
                            
                        @endif

                        <button type="submit" class="btn btn-outline-success">تصدير <i class="fa-solid fa-file-export fa-xl"></i></button>
                    </form>
                @endif
                
                
                <button class="btn btn-outline-success mx-1" style="float: left">طباعة <i class="fa-solid fa-print fa-xl"></i></button>


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





@endsection




@section('script')
@endsection
