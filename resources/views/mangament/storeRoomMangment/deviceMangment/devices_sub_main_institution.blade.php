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
        @if ($main_institution->main_institution)
        <a href="{{route('showInstitution',$main_institution->main_institution->institution_slug)}} ">{{$main_institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a href="{{route('showInstitution',$main_institution->institution_slug)}}">{{$main_institution->institution_name}}</a>  
        / 
        <a class="text-dark">  نقل إلى {{$main_institution->institution_name}} </a> 
    </div> 
    <!-- root page End -->

    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
            <form  data-toggle="validator" role="form" method="post" action="{{route('store_devices_to_main_institution',$main_institution->institution_slug)}}">
                @csrf

                <div class="card shadow mb-4"   style="direction: rtl">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">جدول أجهزة {{$main_institution->institution_name}}</h6>
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
                                        <th>مكان المادة</th>
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
                                        <th>مكان المادة</th>
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
                                            <td>{{$device->device_import_export_logs->last()->device_by_person}}</td>
                                            <td>{{$device->sub_institution->institution_name}}</td>
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
                                            <td colspan="7" class="text-center">لايوجد أجهزة  مسلمة</td>

                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تحديد</button>
            </form>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
