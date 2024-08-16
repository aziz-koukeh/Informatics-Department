@extends('layouts.app')

@section('css')
@endsection



@section('content')
    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('showInstitution',$ourInstitution->institution_slug)}}"> دائرة المعلوماتية </a> 
        @if (auth()->user()->profile->employee_department == 'الإدارة' 
        || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
        || auth()->user()->profile->employee_department == 'شعبة الديوان')
        - 
            <a class="btn btn-primary rounded-pill px-4 py-1"  data-bs-toggle="modal" data-bs-target="#addEmployee"><i class="fa-solid fa-person-circle-plus"></i></a>
        @endif
    </div> 
    <!-- root page End -->


    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
  
            <div class="section-title position-relative text-center mb-2 pb-2 wow fadeInUp" data-wow-delay="0.01s">
                <h4 class="position-relative d-inline text-primary px-4">موظفي الدائرة</h4>
            </div>

            <div class="row justify-content-center g-4" style="direction: rtl">

                @forelse ($ourEmployees as $employee)
                    <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.01s">
                        <a href="{{route('showEmployee',$employee->employee_slug)}}">
                            <div class="team-item text-center rounded overflow-hidden shadow text-dark"  style="min-height: 225px">
                                <div class="rounded-circle overflow-hidden m-4 mb-2 ">
                                    @if ($employee->employee_image)
                                        <img class="img-fluid" style="height: 120px;object-fit: cover;" src="{{asset($employee->employee_image)}}" alt="">
                                    @else
                                        <img class="img-fluid" style="height: 120px;object-fit: cover;"src="{{asset('assets/img/team-1.jpg')}}" alt="">
                                    @endif
                                
                                </div>
                                <h5 class="mb-0">{{$employee->employee_full_name}}</h5>
                                <p class="mb-3">{{$employee->employee_department}} - {{$employee->employee_job}}</p>
                                {{-- <div class="d-flex justify-content-center mt-3">
                                    <a class="btn btn-square btn-primary mx-1" href="{{route('showEmployee',$employee->employee_slug)}}"><i class="fa-solid fa-person-circle-question fa-xl"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fa-solid fa-people-arrows fa-xl"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fa-solid fa-person-circle-xmark fa-xl"></i></a>
                                </div> --}}
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-8 wow fadeInUp" data-wow-delay="0.01s">
                        <div class="team-item text-center rounded overflow-hidden">
                            <h5 class="my-5">لا يوجد موطفين محفوظين</h5>
                            
                        </div>
                    </div>
                    
                @endforelse

            </div>


            
        </div>
    </div>
    <!-- Team End -->

    @if (auth()->user()->profile->employee_department == 'الإدارة' 
    || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
    || auth()->user()->profile->employee_department == 'شعبة الديوان')
        <!-- Full Screen addEmployee Start -->
            <div class="modal fade" id="addEmployee" tabindex="-1">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);height: 100%;">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <!-- Contact Start -->
                                <div class="container-fluid py-1"  style="direction: rtl">
                                    <form  data-toggle="validator" role="form" method="post" action="{{route('storeEmployeeProfile',$ourInstitution->institution_slug)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="position-relative  text-center mb-3 pb-2">
                                                    <h2 class="mt-2 text-light">إضافة موظف</h2>
                                                </div>
                                                <div class="row g-1 mb-1">
                                                    <div class="col-md-3">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_full_name') is-invalid @enderror" id="employee_full_name" name="employee_full_name" placeholder="employee_full_name" required>
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
                                                                    <input type="text" class="form-control @error('employee_father_name') is-invalid @enderror" id="employee_father_name" name="employee_father_name" placeholder="employee_father_name" required>
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
                                                                    <input type="text" class="form-control @error('employee_mother_name') is-invalid @enderror" id="employee_mother_name" name="employee_mother_name" placeholder="employee_mother_name" required>
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
                                                                    <input type="date" class="form-control @error('employee_birth_day') is-invalid @enderror" id="employee_birth_day" name="employee_birth_day" placeholder="employee_birth_day" required>
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
                                                                    <input type="text" class="form-control @error('employee_birth_place') is-invalid @enderror" id="employee_birth_place" name="employee_birth_place" placeholder="employee_birth_place" required >
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
                                                                    <input type="text" class="form-control @error('employee_kid') is-invalid @enderror" id="employee_kid" name="employee_kid" placeholder="employee_kid" required>
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
                                                            <input type="text" class="form-control @error('employee_national_number') is-invalid @enderror" id="employee_national_number" name="employee_national_number" placeholder="employee_national_number" required>
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
                                                            <input type="text" class="form-control @error('employee_phone_number') is-invalid @enderror" id="employee_phone_number" name="employee_phone_number" placeholder="employee_phone_number" required>
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
                                                            <input type="text" class="form-control @error('employee_marital_status') is-invalid @enderror" id="employee_marital_status" name="employee_marital_status" placeholder="employee_marital_status" >
                                                                @error('employee_marital_status')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <div class="help-block with-errors pull-right"></div>
                                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                                            <label for="employee_marital_status">الحالة العائلية (اختياري)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating form-group">
                                                            <input type="text" class="form-control @error('employee_address') is-invalid @enderror" id="employee_address" name="employee_address" placeholder="employee_address" required>
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
                                                            <input type="text" class="form-control @error('employee_speciality_certificate') is-invalid @enderror" id="employee_speciality_certificate" name="employee_speciality_certificate" placeholder="employee_speciality_certificate" required>
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
                                                            <input type="text" class="form-control @error('employee_job_naming') is-invalid @enderror" id="employee_job_naming" name="employee_job_naming" placeholder="employee_job_naming" required>
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
                                                            <select class="form-control text-center @error('employee_categortion') is-invalid @enderror"  name="employee_categortion" id="employee_categortion" placeholder="employee_categortion" required>
                                                                <option ></option>
                                                                <option value="first">أولى</option>
                                                                <option value="second">ثانية</option>
                                                                <option value="third">ثالثة</option>
                                                                <option value="fourth">رابعة</option>
                                                                <option value="fifth">خامسة</option>
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
                                                            <select class="form-control text-center @error('employee_job_status') is-invalid @enderror"  name="employee_job_status" id="employee_job_status" placeholder="employee_job_status" required>
                                                                <option value="standing">دائم</option>
                                                                <option value="temporaling">مؤقت</option>
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
                                                            <input type="text" class="form-control @error('employee_speciality') is-invalid @enderror" id="employee_speciality" name="employee_speciality" placeholder="employee_speciality" required>
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
                                                            <select class="form-control text-center @error('employee_department') is-invalid @enderror"  name="employee_department" id="employee_department" placeholder="employee_department" required>
                                                                <option></option>
                                                                <option value="الإدارة">الإدارة</option>
                                                                <option value="شعبة الصيانة">شعبة الصيانة</option>
                                                                <option value="شعبة الديوان">شعبة الديوان</option>
                                                                <option value="المستودع">المستودع</option>
                                                                <option value="شعبة المناقلات">شعبة المناقلات</option>
                                                                <option value="شعبة الأتمتة">شعبة الأتمتة</option>
                                                                <option value="شعبة الحاسب التعليمي">شعبة الحاسب التعليمي</option>
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
                                                            <input type="text" class="form-control @error('employee_job') is-invalid @enderror" id="employee_job" name="employee_job" placeholder="employee_job" required>
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
                                                            <input type="text" class="form-control @error('employee_self_number') is-invalid @enderror" id="employee_self_number" name="employee_self_number" placeholder="employee_self_number" required>
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
                                                                            <input type="text" class="form-control @error('employee_financial_number') is-invalid @enderror" id="employee_financial_number" name="employee_financial_number" placeholder="employee_financial_number" >
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
                                                                            <input type="text" class="form-control @error('employee_shateb_number') is-invalid @enderror" id="employee_shateb_number" name="employee_shateb_number" placeholder="employee_shateb_number">
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
                                                                            <input type="date" class="form-control @error('employee_join_date') is-invalid @enderror" id="employee_join_date" name="employee_join_date" placeholder="employee_join_date">
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
                                                                            <input type="date" class="form-control @error('employee_job_older') is-invalid @enderror" id="employee_job_older" name="employee_job_older" placeholder="employee_job_older">
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_name') is-invalid @enderror" id="employee_recruitmant_name" name="employee_recruitmant_name" placeholder="employee_recruitmant_name">
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_number') is-invalid @enderror" id="employee_recruitmant_number" name="employee_recruitmant_number" placeholder="employee_recruitmant_number">
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
                                                                            <input type="text" class="form-control @error('employee_recruitmant_backup_number') is-invalid @enderror" id="employee_recruitmant_backup_number" name="employee_recruitmant_backup_number" placeholder="employee_recruitmant_backup_number">
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
                                                            <label for="employee_image">صورة الموظف (اختياري)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <button class="btn btn-primary w-100 py-3" id="submit" type="submit">إضافة</button>
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
        <!-- Full Screen addEmployee End -->
    @endif


@endsection




@section('script')
@endsection
