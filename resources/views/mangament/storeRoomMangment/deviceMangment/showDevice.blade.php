@extends('layouts.app')

@section('css')
@endsection



@section('content')
    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        @if ($device->institution || $device->employee)
            <a href="{{route('allInstitutions')}}">المنشآت</a> 
            / 
            @if ($device->institution->main_institution)
            <a href="{{route('showInstitution',$device->institution->main_institution->institution_slug)}} ">{{$device->institution->main_institution->institution_name}}</a> 
            /
            @endif
            <a href="{{route('showInstitution',$device->institution->institution_slug)}}">{{$device->institution->institution_name}}</a>  
            / 
            @if ($device->employee)
                <a href="{{route('showEmployee',$device->employee->employee_slug)}}">{{$device->employee->employee_full_name}}</a>  
                / 
            @endif
        @else
            <a href="{{route('storeRoom')}}">المستودع</a> 
            /
        @endif
        
        <a class="text-dark"> {{$device->device_name}} - {{$device->device_number}} - موديل : {{$device->device_model}} </a> 
    </div> 
    <!-- root page End -->


    <!-- About Start -->
    <div class="container-xxl pt-5"  style="/*min-height: calc(100vh - 95px)*/;direction: rtl">
        <div class="container px-lg-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-title position-relative mb-4 pb-2">
                        <h6 class="position-relative text-primary ps-4">حول المادة</h6>
                        <h2 class="mt-2">{{$device->device_name}}</h2>
                    </div>
                    <p class="mb-2">حالة المادة :{{$device->device_infos}}</p>
                    <p class="mb-2">ملاحظات :{{$device->device_notes}}</p>
                    <p class="mb-2">تقرير المادة :{{$device->device_report}}</p>
                    <p class="mb-4">مواصفات المادة :{{$device->device_details}}</p>
                    <div class="row g-1 mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>رقم المادة :{{$device->device_number}}</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>رقم بطاقة المادة :{{$device->device_file_card}}</h6>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>وحدة المادة :{{$device->device_weight}}</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>مصدر المادة :{{$device->device_importNotes->first()->import_device_source}}</h6>
                        </div>
                    </div>
                    <div class="row g-1 ">
                        <div class="col-sm-12">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>ملحقات المادة :{{$device->device_belongings}}</h6>
                        </div>
                        <div class="col-sm-12">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>عدد الملحقات :{{$device->device_belongings_count}}</h6>
                        </div>
                    </div>
                    @if (
                    auth()->user()->profile->employee_department == 'شعبة الصيانة'  
                    )
                        <div class="d-flex align-items-center mt-4">
                            <a class="btn btn-outline-primary btn-square me-3" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                            {{-- <a class="btn btn-outline-primary btn-square me-3" href="#"><i class="fa-solid fa-upload fa-xl"></i></a>
                            <a class="btn btn-outline-primary btn-square" href="#"><i class="fa-solid fa-retweet fa-xl"></i></a> --}}
                        </div>
                    @endif
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
        <div class="container px-lg-5">
            <!-- DataTales Example -->
            <div class="card shadow mb-4"  style="direction: rtl">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">سجل حركة المادة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-1 " >
                        <table class="table table-bordered table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الحالة</th>
                                    <th>رقم المذكرة الإدخال</th>
                                    <th>رقم المذكرة التسليم</th>
                                    <th>رقم المناقلة</th>
                                    <th>الموظف</th>
                                    <th>تاريخ المذكرة</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>الحالة</th>
                                    <th>رقم المذكرة الإدخال</th>
                                    <th>رقم المذكرة التسليم</th>
                                    <th>رقم المناقلة</th>
                                    <th>اسم الموظف</th>
                                    <th>تاريخ المذكرة</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                    $num=0;
                                @endphp
                                @forelse ($device->device_import_export_logs as $log)
                                    <tr>
                                        {{-- @dd($log->log_ImportNote->import_request_note_SN) --}}
                                        <td>{{++$num}}</td>
                                        <td>{{$log->device_log_status}}</td>
                                        <td>
                                            @if ($log->log_ImportNote != null)
                                            <a href="{{route('showImportRequestNote',$log->log_ImportNote->import_request_note_slug)}}">
                                                {{$log->log_ImportNote->import_request_note_SN}}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($log->log_ExportNote != null)
                                            <a href="{{route('showExportRequestNote',$log->log_ExportNote->export_request_note_slug)}}">
                                                {{$log->log_ExportNote->export_request_note_SN}}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($log->log_RedirectNote != null)
                                            <a href="{{route('showRedirectDeviceNote',$log->log_RedirectNote->redirect_note_slug)}}">
                                                {{$log->log_RedirectNote->redirect_note_number}}
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{$log->device_by_person}}</td>
                                        <td>{{Carbon\Carbon::parse($log->created_at)->format('Y-m-d')}}</td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="7">لا يوجد سجل للجهاز </td>
                                </tr>

                                @endforelse



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- DataTales Example End -->

    @if (
    auth()->user()->profile->employee_department == 'شعبة الصيانة'  
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

                    <!-- Contact Start -->
                            <div class="container-fluid py-1"  style="min-height: calc(100vh - 95px);direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{route('updateDevice',$device->device_slug)}}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-2 mb-3 justify-content-center">
                                        <div class="col-md-6">
                                            <div class="position-relative  text-center mb-3 pb-2">
                                                <h2 class="mt-2 text-light">{{$device->device_name}}</h2>
                                            </div>
                                            <div class="row g-1 text-center">
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <textarea class="form-control @error('device_details') is-invalid @enderror" placeholder="device_details" id="device_details" name="device_details">{{$device->device_details}}</textarea>
                                                            @error('device_details')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_details">مواصفات المادة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-floating form-group">
                                                        <textarea class="form-control @error('device_notes') is-invalid @enderror" placeholder="device_notes" id="device_notes" name="device_notes" >{{$device->device_notes}}</textarea>
                                                            @error('device_notes')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_notes">ملاحظات</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('device_infos') is-invalid @enderror" placeholder="device_infos" id="device_infos" name="device_infos" value="{{$device->device_infos}}">
                                                            @error('device_infos')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_infos">حالة المادة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <textarea class="form-control @error('device_report') is-invalid @enderror" placeholder="device_report" id="device_report" name="device_report" >{{$device->device_report}}</textarea>
                                                            @error('device_report')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_report">تقرير المادة</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h4 class="mt-2 text-light mx-3">ملحقات المادة</h4>
                                            <div class="row g-1 mb-3">
                                                <div class="col-md-9">
                                                    <div class="form-floating form-group">
                                                        <textarea class="form-control @error("device_belongings") is-invalid @enderror" placeholder="device_belongings" id="device_belongings" name="device_belongings" >{{$device->device_belongings}}</textarea>
                                                            @error("device_belongings")
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_belongings">ملحقات المادة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating form-group">
                                                        <input type="number" class="form-control @error("device_belongings_count") is-invalid @enderror" id="device_belongings_count" name="device_belongings_count"  value="{{$device->device_belongings_count}}" placeholder="device_belongings_count" >
                                                            @error("device_belongings_count")
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="device_belongings_count">عدد الملحقات</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row  g-2">

                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تحديث</button>
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
        <!-- Full Screen edit End -->
    @endif

@endsection




@section('script')

@endsection
