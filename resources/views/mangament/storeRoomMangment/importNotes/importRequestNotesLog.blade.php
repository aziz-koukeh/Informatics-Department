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
                جدول {{$kind}} - عدد مذكرات الإدخال : {{count($importRequestNotes)}}
                @if ($exportType == 'all')
                    <form action="{{route('exportImportRequestNotes')}}" method="POST" style="float: left">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">Export <i class="fa-solid fa-file-export fa-xl"></i></button>
                    </form>
                @else
                    <form action="{{route('exportImportRequestNotesByDate')}}" method="POST" style="float: left">
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
                                <th>حالة الإدخال</th>
                                <th>المصدر</th>
                                <th>الموظف</th>
                                <th>تاريخ الادخال</th>
                                @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' || auth()->user()->level == 'مدير')
                                    <th>تفاصيل</th>
                                @endif
                            </tr>
                        </thead>
                        
                        <tbody>
                            @php
                                $num = 0;
                                $countDevices = 0;
                            @endphp
                            @forelse ($importRequestNotes as $importRequestNote)
                            <tr>
                                @php
                                $countDevices += count($importRequestNote->importNote_Devices);
                                @endphp
                                <td>{{++$num}}</td>
                                <td>{{$importRequestNote->import_request_note_folder}}</td>
                                <td>{{$importRequestNote->import_request_note_SN}}</td>
                                <td>{{count($importRequestNote->importNote_Devices)}}</td>
                                <td>{{$importRequestNote->import_request_note_status}}</td>
                                <td>{{$importRequestNote->import_device_source}}</td>
                                <td>{{$importRequestNote->import_device_source_from_employee}}</td>
                                <td>{{Carbon\Carbon::parse($importRequestNote->created_at)->format('Y-m-d')}}</td>
                                @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة'  || auth()->user()->level == 'مدير')
                                
                                    <td>
                                        <a href="{{route('showImportRequestNote',$importRequestNote->import_request_note_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a>
                                        @if (auth()->user()->profile->employee_department == 'المستودع' && auth()->user()->level == 'مشرف')
                                            <a class="ms-3 text-danger" href="{{route('destroyImportRequestNote',$importRequestNote->import_request_note_slug)}}"><i class="fa-regular fa-trash-can fa-xl"></i></a>
                                        @endif
                                    </td>
                                @endif
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
                                <th>حالة الإدخال</th>
                                <th>المصدر</th>
                                <th>الموظف</th>
                                <th>تاريخ الادخال</th>
                                @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' || auth()->user()->level == 'مدير')
                                    <th>تفاصيل</th>
                                @endif
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
