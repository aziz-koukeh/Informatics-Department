@extends('layouts.app')

@section('css')
@endsection



@section('content')
    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a>  
        / 
        <a class="text-dark">المدارس</a> 
        @if (
        auth()->user()->profile->employee_department == 'شعبة الحاسب التعليمي'
        || auth()->user()->profile->employee_department == 'شعبة المناقلات' 
        || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
        || auth()->user()->profile->employee_department == 'المستودع' 
        )
        - 
            <a class="btn btn-primary rounded-pill px-4 py-1"  data-bs-toggle="modal" data-bs-target="#createNew">جديد</a>
        @endif
    </div> 
    <!-- root page End -->


    <!-- Portfolio Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container px-lg-5">
            @if (count($institutions)>0)
            @php
                $firsts=null;
                $seconds=null;
                $thirds_pub=null;
                $thirds_pro=null;
                $colleges=null;
                $compounds=null;
                $circles_pri=null;
                $circles_sec=null;
                foreach ($institutions as $kind){
                    if ($kind->institution_kind == 'first'){
                        $firsts = 'first';
                    }elseif ($kind->institution_kind == 'second') {
                        $seconds = 'second';
                    }elseif ($kind->institution_kind == 'third_pub') {
                        $thirds_pub = 'third_pub';
                    }elseif ($kind->institution_kind == 'third_pro') {
                        $thirds_pro = 'third_pro';
                    }elseif ($kind->institution_kind == 'college') {
                        $colleges = 'college';
                    }elseif ($kind->institution_kind == 'compound') {
                        $compounds = 'compound';
                    }elseif ($kind->institution_kind == 'circle_pri') {
                        $circles_pri = 'circle_pri';
                    }elseif ($kind->institution_kind == 'circle_sec') {
                        $circles_sec = 'circle_sec';
                    }

                }
            @endphp
                <div class="row mt-n2 wow fadeInUp"  style="direction: ltr">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="btn px-3 pe-4 active" data-filter="*">الكل</li>
                            @if ($firsts)
                                <li class="btn px-3 pe-4" data-filter=".{{$firsts}}">الأساسية</li>
                            @endif
                            @if ($seconds)
                                <li class="btn px-3 pe-4" data-filter=".{{$seconds}}">الإعدادية</li>
                            @endif
                            @if ($thirds_pub)
                                <li class="btn px-3 pe-4" data-filter=".{{$thirds_pub}}">الثانوية العامة</li>
                            @endif
                            @if ($thirds_pro)
                                <li class="btn px-3 pe-4" data-filter=".{{$thirds_pro}}">الثانوية المهنية</li>
                            @endif
                            @if ($colleges)
                                <li class="btn px-3 pe-4" data-filter=".{{$colleges}}">المعاهد</li>
                            @endif
                            @if ($compounds)
                                <li class="btn px-3 pe-4" data-filter=".{{$compounds}}">المجمعات</li>
                            @endif
                            @if ($circles_pri)
                                <li class="btn px-3 pe-4" data-filter=".{{$circles_pri}}">الدوائر العامة</li>
                            @endif
                            @if ($circles_sec)
                                <li class="btn px-3 pe-4" data-filter=".{{$circles_sec}}">الدوائر الفرعية</li>
                            @endif
                            
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row g-4 mb-4 portfolio-container">
                @forelse ($institutions->where('institution_name','<>','دائرة المعلوماتية') as $institution)
                    <div class="col-lg-3 col-md-6 wow zoomIn  portfolio-item {{$institution->institution_kind}}" >
                        <a href="{{route('showInstitution',$institution->institution_slug)}}">
                            <div class="service-item d-flex flex-column justify-content-center fw-bolder text-center rounded">
                                @if ($institution->institution_image)
                                    <div class="rounded-circle  m-2" >
                                        <img class="img-fluid" style="height: 150px;object-fit: cover;" src="{{asset($institution->institution_image)}}" alt="">
                                    </div>
                                @else
                                    <div class="service-icon flex-shrink-0">
                                        {{-- <img class="img-fluid "style="max-height: 150px;object-fit: cover;"  src="{{asset('assets/img/about.png')}}"> --}}
                                        <i class="fa-solid fa-school-flag fa-2xl"></i>
                                    </div>
                                @endif
                                
                                <p class="mb-1 text-xs">
                                    @if ($institution->institution_kind == 'first')
                                        تعليم أساسي
                                    @elseif ($institution->institution_kind == 'second')
                                        مدرسة إعدادية
                                    @elseif ($institution->institution_kind == 'third_pub')
                                        ثانوية عامة
                                    @elseif ($institution->institution_kind == 'third_pro')
                                        ثانوية مهنية
                                    @elseif ($institution->institution_kind == 'college')
                                        معهد
                                    @elseif ($institution->institution_kind == 'compound')
                                        مجمع
                                    @elseif ($institution->institution_kind == 'circle_pri')
                                        دائرة عامة
                                    @elseif ($institution->institution_kind == 'circle_sec')
                                        دائرة فرعية
                                    @endif
                                </p>
                                <h5 class="mb-1">{{$institution->institution_name}}</h5>
                                @if ($institution->institution_kind != 'circle_pri')
                                    @if ($institution->manager)
                                        <p class="mb-1 text-xs">المدير : {{$institution->manager->employee_full_name}}</p>
                                    @endif
                                    @if ($institution->manager_first)
                                        <p class="mb-1 text-xs">المدير : {{$institution->manager_first->employee_full_name}}</p>
                                    @endif
                                @else
                                    <p class="mb-1 text-xs">عدد الموظفين : {{count($institution->employees)}}</p>
                                @endif
                                <p class="mb-1 text-xs">عدد الأجهزة المستلمة : {{count($institution->institution_devices)}}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-lg-12 col-md-6 wow zoomIn  portfolio-item" >
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3">لا يوجد منشآت مسجلة بعد</h5>
                            @if (
                                auth()->user()->profile->employee_department != 'شعبة الديوان'
                                || auth()->user()->profile->employee_department != 'شعبة الصيانة'  
                                )
                                <a class="btn px-3 mt-auto mx-auto"  data-bs-toggle="modal" data-bs-target="#createNew">إضافة منشأة</a>
                            @endif
                        </div>
                    </div>
                

                @endforelse


            </div>
        </div>
    </div>
    <!-- Portfolio End -->
    @if (
        auth()->user()->profile->employee_department != 'شعبة الديوان'
        || auth()->user()->profile->employee_department != 'شعبة الصيانة' 
        )
        <!-- Full Screen createNew Start -->
        <div class="modal fade" id="createNew" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                    <div class="modal-header border-0" style="direction:rtl">
                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <!-- Contact Start -->
                            <div class="container-fluid my-5  py-5"  style="min-height: calc(100vh - 95px);direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{route('storeInstitution')}}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="row g-1 mb-1">
                                                <div class="col-md-8">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('institution_name') is-invalid @enderror" id="institution_name" name="institution_name" placeholder="institution_name" required>
                                                            @error('institution_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_name">اسم المنشأة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating form-group">
                                                        <select class="form-control text-center @error('institution_kind') is-invalid @enderror"  name="institution_kind" id="institution_kind" required>
                                                            <option value="">اختيار</option>
                                                            <option value="first" >أساسي</option>
                                                            <option value="second">إعدادي</option>
                                                            <option value="third_pub">ثانوي عام</option>
                                                            <option value="third_pro">ثانوي مهني</option>
                                                            <option value="college">معهد</option>
                                                            <option value="compound">مجمع</option>
                                                            <option value="circle_pri">دائرة عامة</option>
                                                            <option value="circle_sec">دائرة فرعية</option>
                                                        </select>
                                                            @error('institution_kind')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_kind">نوع المنشأة</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row g-1 mb-1">
                                                <div class="col-md-8">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('institution_map') is-invalid @enderror" id="institution_map" name="institution_map" placeholder="institution_map">
                                                            @error('institution_map')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_map">موقع المنشأة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating form-group">
                                                        <input type="tel" class="form-control @error('institution_phone') is-invalid @enderror" id="institution_phone" name="institution_phone" placeholder="institution_phone" required>
                                                            @error('institution_phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_phone">رقم هاتف المنشأة</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row g-1 mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('institution_bio') is-invalid @enderror" id="institution_bio" name="institution_bio" placeholder="institution_bio">
                                                            @error('institution_bio')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_bio">حول المنشأة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <input type="file" class="form-control @error('institution_image') is-invalid @enderror" id="institution_image" name="institution_image" placeholder="institution_image">
                                                            @error('institution_image')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_image">صورة المنشأة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('institution_address') is-invalid @enderror" id="institution_address" name="institution_address" placeholder="institution_address">
                                                            @error('institution_address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="institution_address">عنوان المنشأة</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">حفظ</button>
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
        <!-- Full Screen createNew End -->
    @endif

@endsection




@section('script')
@endsection
