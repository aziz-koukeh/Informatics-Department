@extends('layouts.app')

@section('css')
@endsection



@section('content')



    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        <a class="text-dark"> المناقلات </a> 
    </div> 
    <!-- root page End -->


    <!-- DataTales Example Start -->
    <!-- Begin Page Content -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" style="min-height: calc(100vh - 95px)">
        <div class="card shadow mb-4"  style="direction: rtl">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"> سجل المناقلات </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive py-1 " >
                    <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم المذكرة</th>
                                <th>نوع المناقلة</th>
                                <th>عدد المواد</th>
                                <th>المصدر</th>
                                <th>اسم موظف المصدر</th>
                                <th>المستلم</th>
                                <th>اسم موظف المستلم</th>
                                <th>تاريخ المناقلة</th>
                                <th>تفاصيل</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>رقم المذكرة</th>
                                <th>نوع المناقلة</th>
                                <th>عدد المواد</th>
                                <th>المصدر</th>
                                <th>اسم موظف المصدر</th>
                                <th>المستلم</th>
                                <th>اسم موظف المستلم</th>
                                <th>تاريخ المناقلة</th>
                                <th>تفاصيل</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $num = 0;
                            @endphp
                            @forelse ($redirectDevicesNotes as $redirectDevicesNote)
                            <tr>
                                <td>{{++$num}}</td>
                                <td>{{$redirectDevicesNote->redirect_note_number}}</td>
                                <td>{{$redirectDevicesNote->redirect_note_status}}</td>
                                <td>{{count($redirectDevicesNote->redirectNote_Devices)}}</td>

                                <td>
                                    @if ($redirectDevicesNote->device_from_side_institution)
                                        {{$redirectDevicesNote->device_from_side_institution}}
                                    @else
                                        عهدة
                                    @endif
                                </td>
                                <td>{{$redirectDevicesNote->device_from_side_by_employee}}</td>

                                <td>
                                    @if ($redirectDevicesNote->device_to_side_institution)
                                        {{$redirectDevicesNote->device_to_side_institution}}
                                    @else
                                        عهدة
                                    @endif
                                </td>
                                <td>{{$redirectDevicesNote->device_to_side_by_employee}}</td>
                                
                                
                                <td>{{Carbon\Carbon::parse($redirectDevicesNote->created_at)->format('Y-m-d')}}</td>
                                <td><a href="{{route('showRedirectDeviceNote',$redirectDevicesNote->redirect_note_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                    @if (auth()->user()->profile->employee_department == 'شعبة المناقلات' && auth()->user()->level == 'مشرف')
                                        <a class="ms-3 text-danger" href="{{route('destroyRedirectDeviceNote',$redirectDevicesNote->redirect_note_slug)}}"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                                    @endif
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="10">لا يوجد مناقلات </td>
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
