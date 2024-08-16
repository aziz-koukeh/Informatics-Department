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
        <a href="{{route('redirectDevicesNotesLog')}}">مناقلات</a> 
        / 
        <a class="text-dark">مناقلة رقم : {{$redirectDevicesNote->redirect_note_number}} - تاريخ : {{Carbon\Carbon::parse($redirectDevicesNote->created_at)->format('Y-m-d')}}</a> 
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
                                <h5 class="mt-2">الجمهورية العربية السورية</h5>
                                <h6>وزارة التربية - مديرية التربية بحلب</h6>
                                <h6><b>دائرة المعلوماتيــــــة</b></h6>
                            </div>
                            <div class="col-4">
                                <h2 class="mt-2">مذكرة مناقلة</h2>
                                    
                                <h4 class="mb-1"> {{$redirectDevicesNote->redirect_note_status}} </h4>
                                
                            </div>
                            <div class="col-4 d-block " style="text-align:right">
                                <h5 class="mt-4 ">الرقم : {{$redirectDevicesNote->redirect_note_number}} </h5>
                                <h5 class="mb-1">التاريخ: {{Carbon\Carbon::parse($redirectDevicesNote->created_at)->format('Y-m-d')}} </h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 text-center">
                                <h2 class="mt-2">المسلم</h2>
                                @if ($redirectDevicesNote->device_from_side_institution)
                                    <h5 class="mb-1"> من <a href="{{route('showInstitution',$redirectDevicesNote->from_institution->institution_slug)}}">{{$redirectDevicesNote->device_from_side_institution}}</a> </h5>
                                @else
                                    <h5 class="mb-1">من عهدة <a href="{{route('showEmployee',$redirectDevicesNote->from_person->employee_slug)}}">{{$redirectDevicesNote->device_from_side_by_employee}}</a> </h5>
                                @endif

                            </div>
                            <div class="col-6">
                                <h2 class="mt-2">المستلم</h2>
                                    
                                @if ($redirectDevicesNote->device_to_side_institution)
                                    <h5 class="mb-1"> إلى <a href="{{route('showInstitution',$redirectDevicesNote->to_institution->institution_slug)}}">{{$redirectDevicesNote->device_to_side_institution}}</a> </h5>
                                @else
                                    <h5 class="mb-1">إلى عهدة <a href="{{route('showEmployee',$redirectDevicesNote->to_person->employee_slug)}}">{{$redirectDevicesNote->device_to_side_by_employee}}</a> </h5>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>                
            
                <div class="col-12  wow fadeInUp" data-wow-delay="0.1s">
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
                                            <th>اسم المستلم</th>
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
                                            <th>تاريخ التسليم</th>
                                            <th>تفاصيل</th>
                                        
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
                                                <td>{{Carbon\Carbon::parse($device->device_import_export_logs->last()->created_at)->format('Y-m-d')}}</td>
                                                <td><a class="mb-3" href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                
                                            </tr>
                                        @empty

                                            <tr>
                                                <td colspan="7" class="text-center">لايوجد أثاث للتسليم</td>

                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                    
                
            </div>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
