@extends('layouts.app')

@section('css')
@endsection



@section('content')

    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        <a class="text-dark">المستخدمين</a> 
        @if (count($ourEmployees)>0)
            @if (auth()->user()->profile->employee_department == 'الإدارة' )            
                / 
                <a class="btn btn-primary rounded-pill px-4 py-1"  data-bs-toggle="modal" data-bs-target="#addUser"><i class="fa-solid fa-user-plus"></i></a>
            @endif
        @endif
    </div> 
    <!-- root page End -->

    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3" style="min-height: calc(100vh - 140px);direction: rtl">
        <div class="container">
            <div class="section-title position-relative text-center mb-2 pb-2 wow fadeInUp" data-wow-delay="0.01s">
                <h4 class="position-relative d-inline text-primary px-4">المستخدمين</h4>
            </div>
            <div class="row justify-content-center g-4">
                @foreach ($users as $user)
                    
                    <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.01s">
                        {{-- <a class="" href="{{route('showUser', $user->user_slug)}}"> --}}
                            <div class="team-item text-center rounded  overflow-hidden shadow text-dark" style="min-height: 235px">
                                <div class="rounded-circle overflow-hidden m-4 mb-2">
                                    <img class="img-fluid" style="height: 120px;object-fit: cover;" src="{{asset($user->profile->employee_image)}}" alt="">
                                </div>
                                <h5 class="mb-0">{{$user->profile->employee_full_name}}</h5>
                                <p class="mb-0">{{$user->user_name}}</p>
                                @if ($user->level == 'مدير')
                                    <p class="text-warning d-inline m-0 text-xs">مدير <i class="fa-solid fa-user-lock"></i></p>
                                @elseif ($user->level == 'مشرف')
                                    <p class="text-success d-inline m-0 text-xs">مشرف قسم {{$user->profile->employee_department}}<i class="fa-solid fa-user-shield"></i></p>
                                @elseif ($user->level == 'مستخدم')
                                    <p class="text-info d-inline m-0 text-xs">مستخدم <i class="fa-solid fa-user-tie"></i></p>
                                @endif
                                
                                <div class="d-flex justify-content-center mt-3" style="direction: ltr">
                                    <a class="btn btn-square btn-primary mx-1" href="{{route('showUser', $user->user_slug)}}"><i class="fa-solid fa-user-gear fa-xl"></i></a>
                                    {{-- <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a> --}}
                                    @if (auth()->user()->level == 'مدير' && $user->level != 'مدير' )
                                        @if (count($users)> 1)
                                            <a class="btn btn-square btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#deleteUser{{$user->user_slug}}"><i class="fa-solid fa-user-xmark fa-xl"></i></a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if (auth()->user()->level == 'مدير' && $user->level != 'مدير' )
                                @if (count($users)> 1)
                                    <!-- Modal deleteUser -->
                                        <div class="modal fade" id="deleteUser{{$user->user_slug}}" tabindex="-1">
                                            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">
                                                    <div class="modal-header border-0" style="direction:rtl">
                                                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body d-flex align-items-center justify-content-center" style="direction:ltr">
                                                        <!-- Contact Start -->
                                                        <div class="container-fluid"  style="direction: rtl">
                                                            <form  data-toggle="validator" role="form" method="post" action="#">
                                                                @csrf
                                                                <div class="row justify-content-center">
                                                                    <div class="col-lg-8">
                                                                        <div class="row g-1 mb-1">
                                                                            <div class="col-md-12">
                                                                            <h5 class="text-center text-light">أنت على وشك حذف حساب الموظف {{$user->profile->employee_full_name}} <i class="fa-solid fa-circle-info fa-xl"></i></h5>
                                                                            </div>

                                                                        </div>
                                                                        
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <a class="btn btn-primary w-100 py-3" href="{{route('destroyUser',$user->user_slug)}}" type="submit">حذف الحساب</a>
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
                                    <!-- Modal deleteUser -->
                                @endif
                            @endif
                        {{-- </a> --}}
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Team End -->
    @if (auth()->user()->profile->employee_department == 'الإدارة' ) 
        <!-- Full Screen addUser Start -->
            <div class="modal fade" id="addUser" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">
                        <div class="modal-header border-0" style="direction:rtl">
                            <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center" style="direction:ltr">
                            <!-- Contact Start -->
                            <div class="container-fluid"  style="direction: rtl">
                                <form  data-toggle="validator" role="form" method="post" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="row g-1 mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <select class="form-control text-center @error('employee_slug') is-invalid @enderror"  name="employee_slug" id="employee_slug" placeholder="employee_slug" required autofocus>
                                                            <option></option>
                                                            @foreach ($ourEmployees as $ourEmployee)
                                                                <option value="{{$ourEmployee->employee_slug}}">{{$ourEmployee->employee_full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                            @error('employee_slug')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="help-block with-errors pull-right"></div>
                                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                                        <label for="employee_slug">اسم المستخدم</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ old('user_name') }}" placeholder="user_name" required>
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
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" minlength="6" placeholder="password" autocomplete="new-password" required>
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
                                                <div class="col-md-6">
                                                    <div class="form-floating form-group">
                                                        <input type="password" class="form-control @error('password-confirm') is-invalid @enderror" id="password-confirm" minlength="6" name="password_confirmation" placeholder="password-confirm" autocomplete="new-password" required>
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
                                                <div class="col-md-12">
                                                    <div class="form-floating form-group">
                                                        <select class="form-control text-center @error('level') is-invalid @enderror"  name="level" id="level" required>
                                                            {{-- <option></option> --}}
                                                            {{-- <option value="مدير">مدير</option> --}}
                                                            <option value="مشرف">مشرف</option>
                                                            <option value="مستخدم">مستخدم</option>
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

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">إنشاء الحساب</button>
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
        <!-- Full Screen addUser End -->
    @endif



@endsection




@section('script')
@endsection
