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
        <a class="text-dark"> {{$kind}} </a> 
    </div> 
    <!-- root page End -->


    <!-- DataTales Example Start -->
    <!-- Begin Page Content -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" style="min-height: calc(100vh - 95px)">
        <div class="card shadow mb-4"  style="direction: rtl">
            <div class="card-header py-3">
                جدول {{$kind}} - عدد مذكرات التسليم : {{count($exportRequestNotes)}}
            </div>
            <div class="card-body">
                <div class="table-responsive py-1 " >
                    <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الجلد</th>
                                <th>رقم المذكرة</th>
                                <th>عدد المواد</th>
                                <th>المنشأة</th>
                                <th>المستلم</th>
                                <th>تاريخ التسليم</th>
                                <th>تفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $num = 0;
                                $countDevices = 0;
                            @endphp
                            @forelse ($exportRequestNotes as $exportRequestNote)
                            <tr>
                                @php
                                $countDevices += count($exportRequestNote->exportNote_Devices);
                                @endphp
                                <td>{{++$num}}</td>
                                <td>{{$exportRequestNote->export_request_note_folder}}</td>
                                <td>{{$exportRequestNote->export_request_note_SN}}</td>
                                <td>{{count($exportRequestNote->exportNote_Devices)}}</td>
                                <td>
                                @if ($exportRequestNote->exported_to->institution_kind == 'first')
                                    مدرسة إبتدائية  
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'second')
                                    مدرسة إعدادية
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'third_pub')
                                    ثانوية عامة
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'third_pro')
                                    ثانوية مهنية
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'college')
                                    معهد
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'compound')
                                    مجمع
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'circle_pri')
                                    عهدة شخصية
                                @elseif ($exportRequestNote->exported_to->institution_kind == 'circle_sec')
                                    دائرة فرعية
                                @endif
                                @if ($exportRequestNote->exported_to->institution_kind != 'circle_pri')
                                    
                                    {{$exportRequestNote->exported_to->institution_name}}</td>
                                @endif
                                <td>{{$exportRequestNote->export_request_note_by_person}}</td>
                                <td>{{Carbon\Carbon::parse($exportRequestNote->created_at)->format('Y-m-d')}}</td>
                                <td>
                                    <a href="{{route('showExportRequestNote',$exportRequestNote->export_request_note_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                    @if (auth()->user()->profile->employee_department == 'المستودع' && auth()->user()->level == 'مشرف')
                                        <a class="ms-3 text-danger" href="{{route('destroyExportRequestNote',$exportRequestNote->export_request_note_slug)}}"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                                    @endif
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="7">لا يوجد مذكرات إدخال</td>
                            </tr>
                            @endforelse


                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>رقم الجلد</th>
                                <th>رقم المذكرة</th>
                                <th>عدد المواد - {{$countDevices}}</th>
                                <th>المنشأة</th>
                                <th>المستلم</th>
                                <th>تاريخ التسليم</th>
                                <th>تفاصيل</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- DataTales Example End -->




@endsection




@section('script')

@endsection
