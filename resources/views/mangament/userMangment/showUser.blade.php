@extends('layouts.app')

@section('css')
@endsection



@section('content')
    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        <a href="{{route('allUsers')}}">المستخدمين</a> 
        / 
        <a class="text-dark"> {{$user->profile->employee_full_name}} </a> 
    </div> 
    <!-- root page End -->
     <!-- Footer Start -->
     <div class="container-fluid bg-primary text-light footer pt-2 wow fadeIn" style="min-height: calc(100vh - 95px)">
        <div class="container py-2 px-lg-5">
            <div class="row g-5" style="direction: rtl">
                <div class="col-md-6 col-lg-3" style="text-align: right;direction: rtl">
                    <h5 class="text-white mb-4">تفاصيل معلومات الحساب</h5>
                    <a class="btn btn-link"> اسم المستخدم : {{$user->profile->employee_full_name}}</a>
                    <a class="btn btn-link"> اسم الحساب : {{$user->user_name}}</a>
                    
                    
                    @if ($user->profile->employee_job_status)
                        <a class="btn btn-link"> نوع الحساب : 
                            @if ($user->level == 'مدير')
                                <p class="text-warning d-inline m-0">مدير <i class="fa-solid fa-user-lock"></i></p>
                            @elseif ($user->level == 'مشرف')
                                <p class="text-success d-inline m-0">مشرف قسم <i class="fa-solid fa-user-shield"></i></p>
                            @elseif ($user->level == 'مستخدم')
                                <p class="text-info d-inline m-0">مستخدم <i class="fa-solid fa-user-tie"></i></p>
                            @endif
                        </a>
                    @endif
                   

                </div>
                <div class="col-md-6 col-lg-3"  style="text-align: right;direction: rtl">
                    <h5 class="text-white mb-4">تفاصيل المعلومات الشخصية</h5>
                    @if ($user->profile->employee_father_name)
                        <a class="btn btn-link"> الأب : {{$user->profile->employee_father_name}} </a>
                    @endif
                    @if ($user->profile->employee_mother_name)
                        <a class="btn btn-link"> الأم : {{$user->profile->employee_mother_name}} </a>
                    @endif
                    @if ($user->profile->employee_birth_place)
                        <a class="btn btn-link"> مكان الولادة : {{$user->profile->employee_birth_place}} </a>
                    @endif
                    @if ($user->profile->employee_birth_day)
                        <a class="btn btn-link"> تاريخ الولادة : {{Carbon\Carbon::parse($user->profile->employee_birth_day)->format('Y-m-d')}} </a>
                    @endif
                    @if ($user->profile->employee_marital_status)
                        <a class="btn btn-link"> الحالة الإجتماعية : {{$user->profile->employee_marital_status}} </a>
                    @endif
                    @if ($user->profile->employee_kid)
                        <a class="btn btn-link"> القيد : {{$user->profile->employee_kid}} </a>
                    @endif
                    @if ($user->profile->employee_national_number)
                        <a class="btn btn-link"> الرقم الوطني : {{$user->profile->employee_national_number}} </a>
                    @endif
                    @if ($user->profile->employee_speciality_certificate)
                        <a class="btn btn-link"> المؤهل العلمي : {{$user->profile->employee_speciality_certificate}} </a>
                    @endif
                    @if ($user->profile->employee_address)
                        <p><i class="fa fa-map-marker-alt ms-2"></i> عنوان السكن : {{$user->profile->employee_address}}</p>
                    @endif
                    @if ($user->profile->employee_phone_number)
                        <p><i class="fa fa-phone-alt ms-2"></i> هاتف : {{$user->profile->employee_phone_number}}</p>
                    @endif
                    
                </div>
                <div class="col-md-6 col-lg-3" style="text-align: right;direction: rtl">
                    <h5 class="text-white mb-4">تفاصيل المعلومات الوظيفية</h5>
                    <a class="btn btn-link"> المنشأة التابع لها : {{$user->profile->institution->institution_name}}</a>
                    @if ($user->profile->employee_department)
                        <a class="btn btn-link"> القسم : {{$user->profile->employee_department}}</a>
                    @endif
                    @if ($user->profile->employee_job)
                        <a class="btn btn-link"> العمل المكلف به : {{$user->profile->employee_job}}</a>
                    @endif
                    @if ($user->profile->employee_job_naming)
                        <a class="btn btn-link"> المسمى الوظيفي : {{$user->profile->employee_job_naming}}</a>
                    @endif
                    @if ($user->profile->employee_speciality)
                        <a class="btn btn-link"> الاختصاص : {{$user->profile->employee_speciality}}</a>
                    @endif
                    @if ($user->profile->employee_categortion)
                        <a class="btn btn-link"> الفئة : 
                            @if ($user->profile->employee_categortion == 'first')
                            أولى
                            @elseif ($user->profile->employee_categortion == 'second')
                            ثانية
                            @elseif ($user->profile->employee_categortion == 'third')
                            ثالثة
                            @elseif ($user->profile->employee_categortion == 'fourth')
                            رابعة
                            @elseif ($user->profile->employee_categortion == 'fifth')
                            خامسة
                            @endif
                            
                        </a>
                    @endif
                    @if ($user->profile->employee_job_status)
                        <a class="btn btn-link"> نوع التعيين : 
                            @if ($user->profile->employee_job_status == 'standing')
                            دائم
                            @elseif ($user->profile->employee_job_status == 'temporaling')
                            مؤقت
                            @endif
                        </a>
                    @endif
                    @if ($user->profile->employee_join_date)
                        <a class="btn btn-link"> تاريخ التعيين : {{Carbon\Carbon::parse($user->profile->employee_join_date)->format('Y-m-d')}} </a>
                    @endif
                    @if ($user->profile->employee_job_older)
                        <a class="btn btn-link"> القدم الوظيفي : {{Carbon\Carbon::parse($user->profile->employee_job_older)->format('Y-m-d')}} </a>
                    @endif
                    @if ($user->profile->employee_self_number)
                        <a class="btn btn-link"> الرقم الذاتي : {{$user->profile->employee_self_number}}</a>
                    @endif
                    @if ($user->profile->institution->institution_name == 'دائرة المعلوماتية')
                        @if ($user->profile->employee_financial_number)
                            <a class="btn btn-link"> الرقم المالي : {{$user->profile->employee_financial_number}}</a>
                        @endif
                    @endif

                </div>

                <div class="col-md-6 col-lg-3 " style="direction: ltr">
                    <div class="team-item2 mt-5">
                        <div class="d-flex">
                            <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                                @if (auth()->user()->level == 'مدير' ) 
                                    <a class="btn btn-square text-primary bg-white my-1" data-bs-toggle="modal" data-bs-target="#editEmployee"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
                                    <a class="btn btn-square text-primary bg-white my-1" data-bs-toggle="modal" data-bs-target="#editUser"><i class="fa-solid fa-screwdriver-wrench fa-xl"></i></a>
                                @endif
                            </div>
                            @if ($user->profile->employee_image)
                                 <img style="max-width: 75%;" class="img-fluid rounded-3 w-100" src="{{asset($user->profile->employee_image)}}" alt="">
                            @else
                                 <img style="max-width: 75%;" class="img-fluid rounded-3 w-100" src="{{asset('assets/img/team-1.jpg')}}" alt="">
                            @endif
                        </div>
                        <div class="px-4 py-3">
                            <h5 class="fw-bold m-0">{{$user->profile->employee_full_name}}</h5>
                            <small class="text-secondary">{{$user->profile->employee_department}} -</small>
                            <small class="text-secondary">{{$user->profile->employee_job}}</small>
                        </div>
                    </div>
                   
                </div>

            </div>
        </div>
        
    </div>
    <!-- Footer End -->


    @if (auth()->user()->level == 'مدير' ) 
        <!-- Full Screen editEmployee Start -->
            <div class="modal fade" id="editEmployee" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);height: 100%;">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center" style=";height: 100%;">
                            <!-- Contact Start -->
                                <div class="container-fluid py-1"  style="direction: rtl">
                                    <form  data-toggle="validator" role="form" method="post" action="{{route('updateEmployeeProfile',$user->profile->employee_slug)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="position-relative  text-center mb-3 pb-2">
                                                    <h2 class="mt-2 text-light">تعديل المعلومات</h2>
                                                </div>
                                                <div class="row g-1 mb-1">
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_full_name') is-invalid @enderror" id="employee_full_name" name="employee_full_name" placeholder="employee_full_name"  value="{{$user->profile->employee_full_name}}">
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
                                                                    <input type="text" class="form-control @error('employee_father_name') is-invalid @enderror" id="employee_father_name" name="employee_father_name" placeholder="employee_father_name" value="{{$user->profile->employee_father_name}}">
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
                                                                    <input type="text" class="form-control @error('employee_mother_name') is-invalid @enderror" id="employee_mother_name" name="employee_mother_name" placeholder="employee_mother_name" value="{{$user->profile->employee_mother_name}}">
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
                                                                    @if ($user->profile->employee_birth_day)
                                                                        value="{{Carbon\Carbon::parse($user->profile->employee_birth_day)->format('Y-m-d')}}"
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
                                                                    <input type="text" class="form-control @error('employee_birth_place') is-invalid @enderror" id="employee_birth_place" name="employee_birth_place" placeholder="employee_birth_place"  value="{{$user->profile->employee_birth_place}}">
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
                                                                    <input type="text" class="form-control @error('employee_kid') is-invalid @enderror" id="employee_kid" name="employee_kid" placeholder="employee_kid" value="{{$user->profile->employee_kid}}">
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
                                                            <input type="text" class="form-control @error('employee_national_number') is-invalid @enderror" id="employee_national_number" name="employee_national_number" placeholder="employee_national_number" value="{{$user->profile->employee_national_number}}">
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
                                                            <input type="text" class="form-control @error('employee_phone_number') is-invalid @enderror" id="employee_phone_number" name="employee_phone_number" placeholder="employee_phone_number" value="{{$user->profile->employee_phone_number}}">
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
                                                            <input type="text" class="form-control @error('employee_marital_status') is-invalid @enderror" id="employee_marital_status" name="employee_marital_status" placeholder="employee_marital_status" value="{{$user->profile->employee_marital_status}}">
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
                                                            <input type="text" class="form-control @error('employee_address') is-invalid @enderror" id="employee_address" name="employee_address" placeholder="employee_address" value="{{$user->profile->employee_address}}">
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
                                                            <input type="text" class="form-control @error('employee_speciality_certificate') is-invalid @enderror" id="employee_speciality_certificate" name="employee_speciality_certificate" placeholder="employee_speciality_certificate" value="{{$user->profile->employee_speciality_certificate}}">
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
                                                            <input type="text" class="form-control @error('employee_job_naming') is-invalid @enderror" id="employee_job_naming" name="employee_job_naming" placeholder="employee_job_naming" value="{{$user->profile->employee_job_naming}}">
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
                                                                <option value=""></option>
                                                                <option
                                                                @if ($user->profile->employee_categortion == 'first')
                                                                    selected
                                                                @endif
                                                                value="first">أولى</option>
                                                                <option
                                                                @if ($user->profile->employee_categortion == 'second')
                                                                    selected
                                                                @endif
                                                                value="second">ثانية</option>
                                                                <option
                                                                @if ($user->profile->employee_categortion == 'third')
                                                                    selected
                                                                @endif
                                                                value="third">ثالثة</option>
                                                                <option
                                                                @if ($user->profile->employee_categortion == 'fourth')
                                                                    selected
                                                                @endif
                                                                value="fourth">رابعة</option>
                                                                <option
                                                                @if ($user->profile->employee_categortion == 'fifth')
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
                                                                @if ($user->profile->employee_job_status == 'standing')
                                                                    selected
                                                                @endif
                                                                value="standing">دائم</option>
                                                                <option 
                                                                @if ($user->profile->employee_job_status == 'temporaling')
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_speciality') is-invalid @enderror" id="employee_speciality" name="employee_speciality" placeholder="employee_speciality" value="{{$user->profile->employee_speciality}}">
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <select class="form-control text-center @error('employee_department') is-invalid @enderror"  name="employee_department" id="employee_department" placeholder="employee_department">
                                                                <option
                                                                @if ($user->profile->employee_department == 'الإدارة')
                                                                selected
                                                                @endif
                                                                value="الإدارة">الإدارة</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'شعبة الصيانة')
                                                                selected
                                                                @endif
                                                                value="شعبة الصيانة">شعبة الصيانة</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'شعبة الديوان')
                                                                selected
                                                                @endif
                                                                value="شعبة الديوان">شعبة الديوان</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'المستودع')
                                                                selected
                                                                @endif
                                                                value="المستودع">المستودع</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'شعبة المناقلات')
                                                                selected
                                                                @endif
                                                                value="شعبة المناقلات">شعبة المناقلات</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'شعبة الأتمتة')
                                                                selected
                                                                @endif
                                                                value="شعبة الأتمتة">شعبة الأتمتة</option>
                                                                <option
                                                                @if ($user->profile->employee_department == 'شعبة الحاسب التعليمي')
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
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_job') is-invalid @enderror" id="employee_job" name="employee_job" placeholder="employee_job" value="{{$user->profile->employee_job}}" >
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
                                                            <input type="text" class="form-control @error('employee_self_number') is-invalid @enderror" id="employee_self_number" name="employee_self_number" placeholder="employee_self_number" value="{{$user->profile->employee_self_number}}">
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
                                                                            <input type="text" class="form-control @error('employee_financial_number') is-invalid @enderror" id="employee_financial_number" name="employee_financial_number" placeholder="employee_financial_number" value="{{$user->profile->employee_financial_number}}">
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
                                                                            <input type="text" class="form-control @error('employee_shateb_number') is-invalid @enderror" id="employee_shateb_number" name="employee_shateb_number" placeholder="employee_shateb_number" value="{{$user->profile->employee_shateb_number}}">
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
                                                                            @if ($user->profile->employee_join_date)
                                                                                value="{{Carbon\Carbon::parse($user->profile->employee_join_date)->format('Y-m-d')}}"
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
                                                                            @if ($user->profile->employee_job_older)
                                                                                value="{{Carbon\Carbon::parse($user->profile->employee_job_older)->format('Y-m-d')}}"
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_name') is-invalid @enderror" id="employee_recruitmant_name" name="employee_recruitmant_name" placeholder="employee_recruitmant_name" value="{{$user->profile->employee_recruitmant_name}}">
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_number') is-invalid @enderror" id="employee_recruitmant_number" name="employee_recruitmant_number" placeholder="employee_recruitmant_number" value="{{$user->profile->employee_recruitmant_number}}">
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_backup_number') is-invalid @enderror" id="employee_recruitmant_backup_number" name="employee_recruitmant_backup_number" placeholder="employee_recruitmant_backup_number" value="{{$user->profile->employee_recruitmant_backup_number}}">
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
        <!-- Modal editUser -->
            <div class="modal fade" id="editUser" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center" style="direction:ltr">
                            <!-- Contact Start -->
                            <div class="container-fluid"  style="direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{route('updateUser', $user->user_slug)}}">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="row g-1 mb-3">
                                                
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control text-center @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ $user->user_name }}" placeholder="user_name" required>
                                                            @error('user_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="user_name">اسم الحساب</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <select class="form-control text-center @error('level') is-invalid @enderror"  name="level" id="level" required>
                                                            <option 
                                                            @if ($user->level == 'مدير')
                                                            selected
                                                            @endif
                                                            value="مدير">مدير</option>
                                                            <option
                                                            @if ($user->level == 'مشرف')
                                                            selected
                                                            @endif
                                                            value="مشرف">مشرف</option>
                                                            <option 
                                                            @if ($user->level == 'مستخدم')
                                                            selected
                                                            @endif
                                                            value="مستخدم">مستخدم</option>
                                                        </select>
                                                            @error('level')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="level">اختر الصلاحية</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="password" class="form-control text-center @error('password') is-invalid @enderror" id="password" name="password" minlength="6" placeholder="password" autocomplete="new-password" >
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="password">كلمة المرور</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="password" class="form-control text-center @error('password-confirm') is-invalid @enderror" id="password-confirm" minlength="6" name="password_confirmation" placeholder="password-confirm" autocomplete="new-password" >
                                                            @error('password-confirm')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="password-confirm">تأكيد كلمة المرور</label>
                                                    </div>

                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">تحديث الحساب</button>
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
        <!-- Modal editUser -->
    @endif





@endsection




@section('script')
@endsection
