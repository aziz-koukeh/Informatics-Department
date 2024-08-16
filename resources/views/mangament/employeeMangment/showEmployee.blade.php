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
        @if ($employee->institution->main_institution)
        <a href="{{route('showInstitution',$employee->institution->main_institution->institution_slug)}} ">{{$employee->institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a href="{{route('showInstitution',$employee->institution->institution_slug)}}">{{$employee->institution->institution_name}}</a>  
        / 
        <a class="text-dark">{{$employee->employee_full_name}}</a> 
    </div> 
    <!-- root page End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer pt-2 wow fadeIn" style="min-height: calc(100vh - 95px)">
        <div class="container py-2 px-lg-5">
            <div class="row g-5" style="direction: rtl">

                <div class="col-md-6 col-lg-4"  style="text-align: right;direction: rtl">
                    <h5 class="text-white mb-4">تفاصيل المعلومات الشخصية</h5>
                    @if ($employee->employee_father_name)
                        <a class="btn btn-link"> الأب : {{$employee->employee_father_name}} </a>
                    @endif
                    @if ($employee->employee_mother_name)
                        <a class="btn btn-link"> الأم : {{$employee->employee_mother_name}} </a>
                    @endif
                    @if ($employee->employee_birth_place)
                        <a class="btn btn-link"> مكان الولادة : {{$employee->employee_birth_place}} </a>
                    @endif
                    @if ($employee->employee_birth_day)
                        <a class="btn btn-link"> تاريخ الولادة : {{Carbon\Carbon::parse($employee->employee_birth_day)->format('Y-m-d')}} </a>
                    @endif
                    @if ($employee->employee_marital_status)
                        <a class="btn btn-link"> الحالة الإجتماعية : {{$employee->employee_marital_status}} </a>
                    @endif
                    @if ($employee->employee_kid)
                        <a class="btn btn-link"> القيد : {{$employee->employee_kid}} </a>
                    @endif
                    @if ($employee->employee_national_number)
                        <a class="btn btn-link"> الرقم الوطني : {{$employee->employee_national_number}} </a>
                    @endif
                    @if ($employee->employee_speciality_certificate)
                        <a class="btn btn-link"> المؤهل العلمي : {{$employee->employee_speciality_certificate}} </a>
                    @endif
                    @if ($employee->employee_address)
                        <p><i class="fa fa-map-marker-alt ms-2"></i> عنوان السكن : {{$employee->employee_address}}</p>
                    @endif
                    @if ($employee->employee_phone_number)
                        <p><i class="fa fa-phone-alt ms-2"></i> هاتف : {{$employee->employee_phone_number}}</p>
                    @endif
                    
                </div>
                <div class="col-md-6 col-lg-4" style="text-align: right;direction: rtl">
                    <h5 class="text-white mb-4">تفاصيل المعلومات الوظيفية</h5>
                    <a class="btn btn-link"> المنشأة التابع لها : {{$employee->institution->institution_name}}</a>
                    @if ($employee->employee_department)
                        <a class="btn btn-link"> اسم القسم : {{$employee->employee_department}}</a>
                    @endif
                    @if ($employee->employee_job)
                        <a class="btn btn-link"> العمل المكلف به : {{$employee->employee_job}}</a>
                    @endif
                    @if ($employee->employee_job_naming)
                        <a class="btn btn-link"> المسمى الوظيفي : {{$employee->employee_job_naming}}</a>
                    @endif
                    @if ($employee->employee_speciality)
                        <a class="btn btn-link"> الاختصاص : {{$employee->employee_speciality}}</a>
                    @endif
                    @if ($employee->employee_categortion)
                        <a class="btn btn-link"> الفئة : 
                            @if ($employee->employee_categortion == 'first')
                            أولى
                            @elseif ($employee->employee_categortion == 'second')
                            ثانية
                            @elseif ($employee->employee_categortion == 'third')
                            ثالثة
                            @elseif ($employee->employee_categortion == 'fourth')
                            رابعة
                            @elseif ($employee->employee_categortion == 'fifth')
                            خامسة
                            @endif
                            
                        </a>
                    @endif
                    @if ($employee->employee_job_status)
                        <a class="btn btn-link"> نوع التعيين : 
                            @if ($employee->employee_job_status == 'standing')
                            دائم
                            @elseif ($employee->employee_job_status == 'temporaling')
                            مؤقت
                            @endif
                        </a>
                    @endif
                    @if ($employee->employee_join_date)
                        <a class="btn btn-link"> تاريخ التعيين : {{Carbon\Carbon::parse($employee->employee_join_date)->format('Y-m-d')}} </a>
                    @endif
                    @if ($employee->employee_job_older)
                        <a class="btn btn-link"> القدم الوظيفي : {{Carbon\Carbon::parse($employee->employee_job_older)->format('Y-m-d')}} </a>
                    @endif
                    @if ($employee->employee_self_number)
                        <a class="btn btn-link"> الرقم الذاتي : {{$employee->employee_self_number}}</a>
                    @endif
                    @if ($employee->institution->institution_name == 'دائرة المعلوماتية')
                        @if ($employee->employee_financial_number)
                            <a class="btn btn-link"> الرقم المالي : {{$employee->employee_financial_number}}</a>
                        @endif
                    @endif

                </div>
                <div class="col-md-6 col-lg-4 " style="direction: ltr">
                    <div class="team-item2 mt-5">
                        <div class="d-flex ">
                            <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                                @if (
                                (auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي' && $employee->institution->institution_name != 'دائرة المعلوماتية')
                                || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                                || (auth()->user()->profile->employee_department == 'شعبة الديوان' && $employee->institution->institution_name == 'دائرة المعلوماتية')
                                )
                                    @if (auth()->user()->level == 'مشرف' || auth()->user()->profile->employee_department == 'شعبة الديوان')
                                        <a class="btn btn-square text-primary bg-white my-1" data-bs-toggle="modal" data-bs-target="#editEmployee"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                                    @endif
                                    @if (count($institutions)>0 && $employee->institution->institution_kind == 'circle_pri' && auth()->user()->profile->employee_department == 'شعبة الأتمتة' )
                                        <a class="btn btn-square text-primary bg-white my-1"  data-bs-toggle="modal" data-bs-target="#changeInstitution"><i class="fa-solid fa-street-view fa-xl"></i></a>
                                    @endif
                                    @if (auth()->user()->level == 'مشرف')
                                        <a class="btn btn-square text-primary bg-white my-1" href="{{route('destroyEmployeeProfile',$employee->employee_slug)}}"><i class="fa-solid fa-trash-can fa-xl"></i></a>
                                    @endif
                                @endif
                            </div>
                            @if ($employee->employee_image)
                                 <img style="max-width: 75%;" class="img-fluid rounded-3 w-100" src="{{asset($employee->employee_image)}}" alt="">
                            @else
                                 <img style="max-width: 75%;" class="img-fluid rounded-3 w-100" src="{{asset('assets/img/team-1.jpg')}}" alt="">
                            @endif
                        </div>
                        <div class="px-4 py-3 text-center">
                            <h5 class="fw-bold m-0">{{$employee->employee_full_name}}</h5>
                            <p class=" m-0 d-inline text-secondary">{{$employee->employee_job}} - </p>
                            <p class=" m-0 d-inline text-secondary">
                                @if ($employee->employee_department)
                                    {{$employee->employee_department}}
                                @else
                                    {{$employee->institution->institution_name}}
                                @endif
                            </p>
                        </div>
                    </div>
                    @if ($employee->institution->institution_kind == 'circle_pri' || $employee->institution->institution_name == 'دائرة المعلوماتية' || $employee->employee_job == 'مدرس معلوماتية')
                        <div class="d-flex row justify-content-center pt-2">
                            @if ( auth()->user()->profile->employee_department == 'شعبة المناقلات' && count($employee->employee_devices)>0 )
                                <a class="btn btn-outline-light btn-social" href="{{route('selectNextSideFromPerson',$employee->employee_slug)}}"><i class="fa-solid fa-retweet fa-xl"></i></a>
                            @endif
                            @if ( auth()->user()->profile->employee_department == 'المستودع' )
                                @if (count($employee->employee_devices)>0)
                                    <a class="btn btn-outline-light btn-social" href="{{route('selectDevicesToRestoreBackFromPerson',$employee->employee_slug)}}"><i class="fa-solid fa-upload fa-xl"></i></a>
                                @endif
                                <a class="btn btn-outline-light btn-social" href="{{route('selectExportRequestNoteForPerson',$employee->employee_slug)}}"><i class="fa-solid fa-download fa-xl"></i></a>
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        </div>
        @if ($employee->institution->institution_kind == 'circle_pri' || $employee->institution->institution_name == 'دائرة المعلوماتية' || $employee->employee_job == 'مدرس معلوماتية')
            <!-- DataTales Example Start -->
            <!-- Begin Page Content -->
            <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="container px-lg-5">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4"  style="direction: rtl">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">جدول أجهزة العهدة</h6>
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
                                            <th>تاريخ التسليم</th>
                                            <th>تفاصيل</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $num=1
                                        @endphp
                                        @forelse ($employee->employee_devices as $device)

                                                <tr>
                                                    <td>{{$num++}}</td>
                                                    <td>{{$device->device_name}}</td>
                                                    <td>{{$device->device_number}}</td>
                                                    <td>{{$device->device_model}}</td>
                                                    <td>{{$device->device_infos}}</td>
                                                    <td>{{Carbon\Carbon::parse($device->device_import_export_logs->last()->created_at)->format('Y-m-d')}}</td>
                                                    <td><a class="mb-3" href="{{route('showDevice',$device->device_slug)}}"><i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i></a></td>
                                                </tr>

                                        @empty

                                            <tr>
                                                <td colspan="6" class="text-center">لايوجد أجهزة مستلمة بعد</td>

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
        @endif
        
    </div>
    <!-- Footer End -->


    @if (auth()->user()->level == 'مشرف' || auth()->user()->profile->employee_department == 'شعبة الديوان')
        <!-- Full Screen editEmployee Start -->
            <div class="modal fade" id="editEmployee" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);height: 100%;">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <!-- Contact Start -->
                                <div class="container-fluid py-1"  style="direction: rtl">
                                    <form  data-toggle="validator" role="form" method="post" action="{{route('updateEmployeeProfile',$employee->employee_slug)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="position-relative  text-center mb-3 pb-2">
                                                    <h2 class="mt-2 text-light">تعديل المعلومات</h2>
                                                </div>
                                                <div class="row g-1 mb-1">
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_full_name') is-invalid @enderror" id="employee_full_name" name="employee_full_name" placeholder="employee_full_name"  value="{{$employee->employee_full_name}}">
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
                                                                    <input type="text" class="form-control @error('employee_father_name') is-invalid @enderror" id="employee_father_name" name="employee_father_name" placeholder="employee_father_name" value="{{$employee->employee_father_name}}">
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
                                                                    <input type="text" class="form-control @error('employee_mother_name') is-invalid @enderror" id="employee_mother_name" name="employee_mother_name" placeholder="employee_mother_name" value="{{$employee->employee_mother_name}}">
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
                                                                    <input type="date" class="form-control @error('employee_birth_day') is-invalid @enderror" id="employee_birth_day" name="employee_birth_day" placeholder="employee_birth_day" 
                                                                    @if ($employee->employee_birth_day)
                                                                        value="{{Carbon\Carbon::parse($employee->employee_birth_day)->format('Y-m-d')}}"
                                                                    @endif
                                                                    >
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
                                                                    <input type="text" class="form-control @error('employee_birth_place') is-invalid @enderror" id="employee_birth_place" name="employee_birth_place" placeholder="employee_birth_place"  value="{{$employee->employee_birth_place}}">
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
                                                                    <input type="text" class="form-control @error('employee_kid') is-invalid @enderror" id="employee_kid" name="employee_kid" placeholder="employee_kid" value="{{$employee->employee_kid}}">
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
                                                            <input type="text" class="form-control @error('employee_national_number') is-invalid @enderror" id="employee_national_number" name="employee_national_number" placeholder="employee_national_number" value="{{$employee->employee_national_number}}">
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
                                                            <input type="text" class="form-control @error('employee_phone_number') is-invalid @enderror" id="employee_phone_number" name="employee_phone_number" placeholder="employee_phone_number" value="{{$employee->employee_phone_number}}">
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
                                                            <input type="text" class="form-control @error('employee_marital_status') is-invalid @enderror" id="employee_marital_status" name="employee_marital_status" placeholder="employee_marital_status" value="{{$employee->employee_marital_status}}">
                                                                @error('employee_marital_status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="employee_marital_status">الحالة العائلية</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_address') is-invalid @enderror" id="employee_address" name="employee_address" placeholder="employee_address" value="{{$employee->employee_address}}">
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_speciality_certificate') is-invalid @enderror" id="employee_speciality_certificate" name="employee_speciality_certificate" placeholder="employee_speciality_certificate" value="{{$employee->employee_speciality_certificate}}">
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_job_naming') is-invalid @enderror" id="employee_job_naming" name="employee_job_naming" placeholder="employee_job_naming" value="{{$employee->employee_job_naming}}">
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
                                                    
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <select class="form-control text-center @error('employee_categortion') is-invalid @enderror"  name="employee_categortion" id="employee_categortion" placeholder="employee_categortion" >
                                                                <option
                                                                @if ($employee->employee_categortion == 'first')
                                                                    selected
                                                                @endif
                                                                value="first">أولى</option>
                                                                <option
                                                                @if ($employee->employee_categortion == 'second')
                                                                    selected
                                                                @endif
                                                                value="second">ثانية</option>
                                                                <option
                                                                @if ($employee->employee_categortion == 'third')
                                                                    selected
                                                                @endif
                                                                value="third">ثالثة</option>
                                                                <option
                                                                @if ($employee->employee_categortion == 'fourth')
                                                                    selected
                                                                @endif
                                                                value="fourth">رابعة</option>
                                                                <option
                                                                @if ($employee->employee_categortion == 'fifth')
                                                                    selected
                                                                @endif
                                                                value="fifth">خامسة</option>
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <select class="form-control text-center @error('employee_job_status') is-invalid @enderror"  name="employee_job_status" id="employee_job_status" placeholder="employee_job_status" >
                                                                <option value=""></option>
                                                                <option 
                                                                @if ($employee->employee_job_status == 'standing')
                                                                    selected
                                                                @endif
                                                                value="standing">دائم</option>
                                                                <option 
                                                                @if ($employee->employee_job_status == 'temporaling')
                                                                    selected
                                                                @endif
                                                                value="temporaling">مؤقت</option>
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
                                                    
                                                    
                                                </div>
                                                <div class="row g-1 mb-1">


                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_speciality') is-invalid @enderror" id="employee_speciality" name="employee_speciality" placeholder="employee_speciality" value="{{$employee->employee_speciality}}">
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
                                                    @if ($employee->institution->institution_name == 'دائرة المعلوماتية')
                                                        <div class="col-md-3">
                                                            <div class="form-floating form-group">
                                                                <select class="form-control text-center @error('employee_department') is-invalid @enderror"  name="employee_department" id="employee_department" placeholder="employee_department" required>
                                                                    <option
                                                                    @if ($employee->employee_department == 'الإدارة')
                                                                    selected
                                                                    @endif
                                                                    value="الإدارة">الإدارة</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'شعبة الصيانة')
                                                                    selected
                                                                    @endif
                                                                    value="شعبة الصيانة">شعبة الصيانة</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'شعبة الديوان')
                                                                    selected
                                                                    @endif
                                                                    value="شعبة الديوان">شعبة الديوان</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'المستودع')
                                                                    selected
                                                                    @endif
                                                                    value="المستودع">المستودع</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'شعبة المناقلات')
                                                                    selected
                                                                    @endif
                                                                    value="شعبة المناقلات">شعبة المناقلات</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'شعبة أتمتة')
                                                                    selected
                                                                    @endif
                                                                    value="شعبة أتمتة">شعبة أتمتة</option>
                                                                    <option
                                                                    @if ($employee->employee_department == 'شعبة الحاسب التعليمي')
                                                                    selected
                                                                    @endif
                                                                    value="شعبة الحاسب التعليمي">شعبة الحاسب التعليمي</option>
                                                                </select>
                                                                @error('employee_department')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="employee_department">القسم</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            
                                                            @if ($employee->institution->institution_kind == 'first' || $employee->institution->institution_kind == 'second' || $employee->institution->institution_kind == 'third_pub')
                                                                <select class="form-control text-center @error('employee_job') is-invalid @enderror"  name="employee_job" id="employee_job" placeholder="employee_job" required>
                                                                    
                                                                    <option selected value="{{$employee->employee_job}}">{{$employee->employee_job}}</option>
                                                                    @if (!$employee->institution->manager_first)
                                                                        <option value="مدير ف1">مدير ف1</option>
                                                                    @endif
                                                                    @if (!$employee->institution->manager_second)
                                                                        <option value="مدير ف2">مدير ف2</option>
                                                                    @endif
                                                                    @if (!$employee->institution->amanuensis_first)
                                                                        <option value="أمين السر ف1">أمين السر ف1</option>
                                                                    @endif
                                                                    @if (!$employee->institution->amanuensis_second)
                                                                    <option value="أمين السر ف2">أمين السر ف2</option>
                                                                    @endif
                                                                    <option value="أمين سر الحاسوب">أمين سر الحاسوب</option>
                                                                    <option value="مدرس معلوماتية">مدرس معلوماتية</option>
                                                                </select>
                                                            @else
                                                                <input type="text" class="form-control @error('employee_job') is-invalid @enderror" id="employee_job" name="employee_job" placeholder="employee_job" value="{{$employee->employee_job}}" required>
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

                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_self_number') is-invalid @enderror" id="employee_self_number" name="employee_self_number" placeholder="employee_self_number" value="{{$employee->employee_self_number}}">
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
                                                @if ($employee->institution->institution_name == 'دائرة المعلوماتية')
                                                    
                                                
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
                                                                        <div class="col-md-3">
                                                                            <div class="form-floating form-group">
                                                                                <input type="text" class="form-control @error('employee_financial_number') is-invalid @enderror" id="employee_financial_number" name="employee_financial_number" placeholder="employee_financial_number" value="{{$employee->employee_financial_number}}">
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
                                                                                <input type="text" class="form-control @error('employee_shateb_number') is-invalid @enderror" id="employee_shateb_number" name="employee_shateb_number" placeholder="employee_shateb_number" value="{{$employee->employee_shateb_number}}">
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
                                                                                <input type="date" class="form-control @error('employee_join_date') is-invalid @enderror" id="employee_join_date" name="employee_join_date" placeholder="employee_join_date" 
                                                                                @if ($employee->employee_join_date)
                                                                                    value="{{Carbon\Carbon::parse($employee->employee_join_date)->format('Y-m-d')}}"
                                                                                @endif
                                                                                max='{{Carbon\Carbon::today()->format('Y-m-d')}}' 
                                                                                >
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
                                                                                <input type="date" class="form-control @error('employee_job_older') is-invalid @enderror" id="employee_job_older" name="employee_job_older" placeholder="employee_job_older" 
                                                                                @if ($employee->employee_job_older)
                                                                                    value="{{Carbon\Carbon::parse($employee->employee_job_older)->format('Y-m-d')}}"
                                                                                @endif
                                                                                max='{{Carbon\Carbon::today()->format('Y-m-d')}}'  >
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
                                                                    <div class="row g-1 mb-1">

                                                                        <div class="col-md-4">
                                                                            <div class="form-floating form-group">
                                                                                <input type="text" class="form-control @error('employee_recruitmant_name') is-invalid @enderror" id="employee_recruitmant_name" name="employee_recruitmant_name" placeholder="employee_recruitmant_name" value="{{$employee->employee_recruitmant_name}}">
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
                                                                                <input type="text" class="form-control @error('employee_recruitmant_number') is-invalid @enderror" id="employee_recruitmant_number" name="employee_recruitmant_number" placeholder="employee_recruitmant_number" value="{{$employee->employee_recruitmant_number}}">
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
                                                                                <input type="text" class="form-control @error('employee_recruitmant_backup_number') is-invalid @enderror" id="employee_recruitmant_backup_number" name="employee_recruitmant_backup_number" placeholder="employee_recruitmant_backup_number" value="{{$employee->employee_recruitmant_backup_number}}">
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
                                                            <label for="employee_image">صورة الموظف</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
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
        <!-- Full Screen editEmployee End -->
    @endif
    @if (count($institutions)>0 && $employee->institution->institution_kind == 'circle_pri' && auth()->user()->profile->employee_department == 'شعبة الأتمتة')
        <!-- Modal changeInstitution -->
            <div class="modal fade" id="changeInstitution" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center" style="direction:ltr">
                            <!-- Contact Start -->
                            <div class="container-fluid"  style="direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{route('changeEmployeeInstitution' , $employee->employee_slug)}}">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="row g-1 mb-1">
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <select class="form-control text-center @error('institution_slug') is-invalid @enderror"  name="institution_slug" id="institution_slug" required>
                                                            <option value="">اختيار</option>
                                                            @foreach ($institutions as $institution)
                                                                
                                                                <option value="{{$institution->institution_slug}}" >{{$institution->institution_name}}</option>
                                                            @endforeach
                                                        </select>
                                                            @error('institution_slug')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_slug">اختر المنشأة</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row g-1 mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control text-center @error('employee_job') is-invalid @enderror" id="employee_job" name="employee_job" placeholder="employee_job" required>
                                                            @error('employee_job')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="employee_job">المهمة الموكلة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="date" class="form-control @error('employee_join_date') is-invalid @enderror" id="employee_join_date" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="employee_join_date" placeholder="employee_join_date" required>
                                                            @error('employee_join_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="employee_join_date">تاريخ الإلتحاق بالمنشأة</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تغيير المنشأة</button>
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
        <!-- Modal changeInstitution -->
    @endif




@endsection




@section('script')
@endsection
