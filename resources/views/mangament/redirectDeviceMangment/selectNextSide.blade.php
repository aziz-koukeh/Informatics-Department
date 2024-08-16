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
        @if ($current_institution->main_institution)
        <a href="{{route('showInstitution',$current_institution->main_institution->institution_slug)}} ">{{$current_institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a href="{{route('showInstitution',$current_institution->institution_slug)}}">{{$current_institution->institution_name}}</a>  
        / 
        <a class="text-dark"> مناقلة من جهة</a> 
    </div> 
    <!-- root page End -->

    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
        <div class="container">
            <form  data-toggle="validator" role="form" method="post" action="{{route('storeRedirectDevice')}}" enctype="multipart/form-data">
                @csrf
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
                                    <h2 class="mt-2">طلب مناقلة</h2>
                                        @php
                                            $kind=null;
                                            if ($current_institution->institution_kind == 'first'){
                                                $kind = 'المدرسة الإبتدائية';
                                            }elseif ($current_institution->institution_kind == 'second') {
                                                $kind = 'المدرسة الإعدادية';
                                            }elseif ($current_institution->institution_kind == 'third_pub') {
                                                $kind = 'الثانوية العامة';
                                            }elseif ($current_institution->institution_kind == 'circle_pri') {
                                                $kind = 'عهدة شخصية';
                                            }
                                        @endphp
                                    <p class="mb-1">من {{$kind}} </p>
                                    <p class="mb-1">
                                        {{$current_institution->institution_name}}
                                    </p>
                                    <div class="form-floating form-group mb-1">
                                        @if ($current_institution->institution_kind != 'circle_pri' )
                                            <select class="form-control text-center @error('device_from_side_by_employee') is-invalid @enderror mb-2"  name="device_from_side_by_employee" id="device_from_side_by_employee" required>
                                                @if (count($current_institution->employees)>0)
                                                    @foreach ($current_institution->employees as $employee)
                                                        <option value="{{$employee->employee_full_name}}">{{$employee->employee_job}} : {{$employee->employee_full_name}}</option>
                                                    @endforeach
                                                @endif
                                                <option value="else">موظف آخر</option>
                                            </select>
                                            <input  type="hidden" name="device_from_side_institution_slug" value="{{$current_institution->institution_slug}}">
                                            @error('device_from_side_by_employee')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        <div class="help-block with-errors pull-right"></div>
                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                        <label for="device_from_side_by_employee">اسم الموظف :</label>
                                        @endif
                                    </div>
                                    @if ($current_institution->institution_kind != 'circle_pri'  )
                                        <div class="form-floating form-group mb-1">
                                            <input  type="text" class="form-control @error('device_from_side_by_employee_else') is-invalid @enderror text-center" name="device_from_side_by_employee_else" id="device_from_side_by_employee_else"  placeholder="الموكل" >
                                                @error('device_from_side_by_employee_else')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            <div class="help-block with-errors pull-right"></div>
                                            <span class="form-control-feedback" aria-hidden="true"></span>
                                            <label for="device_from_side_by_employee_else">الموظف الموكل :</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-4 d-block ">
                                    <div class="form-floating form-group mb-2">
                                        <input style="border: unset;" type="text" class="form-control @error('redirect_note_number') is-invalid @enderror text-center" name="redirect_note_number" id="redirect_note_number"  placeholder="رقم المذكرة" required>
                                            @error('redirect_note_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        <div class="help-block with-errors pull-right"></div>
                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                        <label for="redirect_note_number">الرقم :</label>
                                    </div>
                                    
                                    <div class="form-floating form-group mb-1">
                                        <input style="border: unset;" type="date" class="form-control @error('created_at') is-invalid @enderror text-center" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="created_at"  placeholder="التاريخ" required>
                                            @error('created_at')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        <div class="help-block with-errors pull-right"></div>
                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                        <label for="created_at">التاريخ:</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if (count($devices)>0)
                        
                    
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
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
                                                        <td colspan="7" class="text-center">لايوجد أثاث للتسليم</td>
        
                                                    </tr>
                                                @endforelse
        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Portfolio Start -->
                        <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 95px);direction: rtl">
                            <div class="container px-lg-5">
                                <div class="text-center mb-1 pb-1 wow fadeInUp" >
                                    <h2 class="mt-2">إختيار جهة التالية</h2>
                    
                                </div>
                                @if (count($institutions)>0)
                                @php
                                    $firsts=null;
                                    $seconds=null;
                                    $thirds_pub=null;
                                    $circles_pri=null;
                                    foreach ($institutions as $kind){
                                        if ($kind->institution_kind == 'first'){
                                            $firsts = 'first';
                                        }elseif ($kind->institution_kind == 'second') {
                                            $seconds = 'second';
                                        }elseif ($kind->institution_kind == 'third_pub') {
                                            $thirds_pub = 'third_pub';
                                        }elseif ($kind->institution_kind == 'circle_pri') {
                                            $circles_pri = 'circle_pri';
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
                                                @if ($circles_pri)
                                                    <li class="btn px-3 pe-4" data-filter=".{{$circles_pri}}">الدوائر العامة</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="row g-4 mb-4 portfolio-container">
                                    @forelse ($institutions as $institution)
                                    <div class="col-lg-3 col-md-6 wow zoomIn  portfolio-item {{$institution->institution_kind}}" >
                                        <div class="service-item d-flex flex-column justify-content-center fw-bolder text-center rounded shadow" style="height: 415px">
                                        @if ($institution->institution_image)
                                            <div class="rounded-circle  m-2" >
                                                <img class="img-fluid" style="height: 150px;object-fit: contain;" src="{{asset($institution->institution_image)}}" alt="">
                                            </div>
                                        @else
                                            <div class="rounded-circle  m-2" >
                                                <img class="img-fluid "style="height: 150px;object-fit: contain;"  src="{{asset('assets/img/about.png')}}">
                                                {{-- <i class="fa-solid fa-school-flag fa-2xl" ></i> --}}
                                            </div>
                                        @endif
                                            
                                            <p class="mb-1">
                                                @if ($institution->institution_kind == 'first')
                                                    تعليم أساسي
                                                @elseif ($institution->institution_kind == 'second')
                                                    مدرسة إعدادية
                                                @elseif ($institution->institution_kind == 'third_pub')
                                                    ثانوية عامة
                                                @elseif ($institution->institution_kind == 'circle_pri')
                                                    موظفي الدائرة العامة
                                                @endif
                                            </p>
                                            <h5 class="mb-1">{{$institution->institution_name}}</h5>

                                            @if ($institution->institution_kind == 'circle_pri')
                                                <p class="mb-1">عدد الموظفين : {{count($institution->employees)}}</p>
                                            @endif


                                            <div class="form-floating form-group mb-1">
                                                @if ($institution->institution_kind == 'circle_pri')
                                                    <select class="form-control text-center @error('redirect_to_employee_side') is-invalid @enderror mb-2"  name="redirect_to_employee_side[]" id="redirect_to_employee_side" >
                                                        <option></option>
                                                        @forelse ($institution->employees as $employee)
                                                            <option value="{{$employee->employee_slug}}">{{$employee->employee_full_name}}</option>
                                                        @empty
                                                            <option> لا يوجد موظفين في هذه المنشأة .. تفقد الأمر </option>
                                                        @endforelse
                                                    </select>
                                                    @error('redirect_to_employee_side')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="help-block with-errors pull-right"></div>
                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                    <label for="redirect_to_employee_side">حدد موظف :</label>
                                                @elseif ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub' )
                                                    <select class="form-control text-center @error('redirect_to_institution_side') is-invalid @enderror mb-2"  name="redirect_to_institution_side[]" id="redirect_to_institution_side" >
                                                        <option></option>
                                                        @if (count($institution->employees)>0)
                                                            @foreach ($institution->employees as $employee)
                                                                <option value="{{$employee->employee_full_name}}">{{$employee->employee_full_name}}</option>
                                                            @endforeach
                                                        @endif
                                                        <option value="else_person">موظف آخر</option>
                                                    </select>
                                                    <input type="hidden" name="redirect_to_side_institution_slug[]" value="{{$institution->institution_slug}}">
                                                    @error('redirect_to_institution_side')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="help-block with-errors pull-right"></div>
                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                    <label for="redirect_to_institution_side">حدد موظف :</label>
                                                @endif
                                            </div>
                                            @if ($institution->institution_kind == 'first' || $institution->institution_kind == 'second' || $institution->institution_kind == 'third_pub'  )
                                                <div class="form-floating form-group mb-1">
                                                    <input  type="text" class="form-control @error('redirect_to_institution_side_else_person') is-invalid @enderror text-center" name="redirect_to_institution_side_else_person[]" id="redirect_to_institution_side_else_person"  placeholder="الموكل" >
                                                        @error('redirect_to_institution_side_else_person')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    <div class="help-block with-errors pull-right"></div>
                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                    <label for="redirect_to_institution_side_else_person">الموظف الموكل :</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-lg-12 col-md-6 wow zoomIn  portfolio-item" >
                                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                            <div class="service-icon flex-shrink-0">
                                                <i class="fa fa-home fa-2x"></i>
                                            </div>
                                            <h5 class="mb-3">لا يوجد مدارس مسجلة بعد</h5>
                                        </div>
                                    </div>
                    
                                    @endforelse
                    
                    
                                </div>
                            </div>
                        </div>
                        <!-- Portfolio End -->
                        <hr>
                        <div class="col-4">
                            <div class="form-floating form-group">
                                <input type="file" class="form-control @error('redirect_note_image') is-invalid @enderror text-center" name="redirect_note_image" id="redirect_note_image" placeholder="Subject" required>
                                    @error('redirect_note_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                <div class="help-block with-errors pull-right"></div>
                                <span class="form-control-feedback" aria-hidden="true"></span>
                                <label for="redirect_note_image">صورة عن المناقلة:</label>
                            </div>
                        </div>
                        <div class="col-8">
                            <button class="btn btn-primary w-100 py-3" id="submit" type="submit">إنجاز المناقلة</button>
                        </div>
                    @else
                        <div class="card shadow mb-4  wow fadeInUp" data-wow-delay="0.1s"  style="direction: rtl">
                            <div class=" my-5 w-100">
                                <h3 class="m-0 font-weight-bold text-center text-danger">لا يوجد أجهزة تابعة لهذه الجهة !!</h3>
                            </div>
                        </div>
                        
                    @endif
                </div>
            </form>
        </div>
    </div>
    <!-- Team End -->






@endsection




@section('script')
@endsection
