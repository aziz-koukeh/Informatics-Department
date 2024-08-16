<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Google Web Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> --}}

    <!-- Icon Font Stylesheet -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link href="{{asset('assets/css/all.css')}}" rel="stylesheet">

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"> --}}

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

    @yield('css')
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('assets/css/bootstrap.rtl.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/dosis-font.css')}}" rel="stylesheet"> --}}

    <!-- styles for dataTables -->
    <link href="{{asset('assets/lib/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">


    <!-- Template Stylesheet -->
    <script src="{{asset('assets/js/jQuery-3-7-1.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.js')}}"></script>
</head>
<body  id="page-top" data-spy="scroll" data-target=".side-menu">
   
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        @php
            $current_page =Route::currentRouteName();
        @endphp
         {{-- <nav class="side-menu" >
            <ul>
                <li>
                    <a href="{{route('home')}}" class="page-scroll">
                        <span class="dot"></span>
                        <span class="menu-title
                            @if ($current_page == 'home')
                            active
                            @endif
                        ">الرئيسية</span>
                    </a>
                </li>
                @if (auth()->user()->profile->employee_department == 'الإدارة' 
                || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                || auth()->user()->profile->employee_department == 'المستودع')
                    <li>
                        <a href="{{route('storeRoom')}}" class="page-scroll">
                            <span class="dot"></span>
                            <span class="menu-title
                                @if ($current_page == 'storeRoom')
                                    active
                                @endif
                            ">قسم المستودع</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->profile->employee_department == 'الإدارة' 
                || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                || auth()->user()->profile->employee_department == 'شعبة المناقلات')
                    <li>
                        <a href="{{route('redirectDevicesNotesLog')}}" class="page-scroll">
                            <span class="dot"></span>
                            <span class="menu-title
                                @if ($current_page == 'redirectDevicesNotesLog')
                                    active
                                @endif
                            ">سجل المناقلات</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->profile->employee_department == 'الإدارة' 
                || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                || auth()->user()->profile->employee_department == 'شعبة الديوان')
                    <li>
                        <a href="{{route('allEmployees')}}" class="page-scroll">
                            <span class="dot"></span>
                            <span class="menu-title
                                @if ($current_page == 'allEmployees')
                                    active
                                @endif
                            ">قسم الموظفين</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->profile->employee_department == 'الإدارة')
                    <li>
                        <a href="{{route('allUsers')}}" class="page-scroll">
                            <span class="dot"></span>
                            <span class="menu-title
                                @if ($current_page == 'allUsers')
                                    active
                                @endif
                            ">قسم المستخدمين</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->profile->employee_department != 'شعبة الديوان')
                    <li>
                        <a href="{{route('allInstitutions')}}" class="page-scroll">
                            <span class="dot"></span>
                            <span class="menu-title
                                @if ($current_page == 'allInstitutions')
                                    active
                                @endif
                            ">قسم المنشآت</span>
                        </a>
                    </li>
                @endif
               
            </ul>
        </nav> --}}
        <div class="container-xxl position-relative p-0" >
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 w-100 d-flex" style="direction: rtl;justify-content:space-between">
                <a href="{{url('/')}}" class="navbar-brand p-0">
                    <h1 class="m-0" >دائرة المعلوماتية</h1>
                    {{-- <p class="m-0 text-xs text-info" >{{auth()->user()->full_name}}</p> --}}
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                @auth
                    {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">--}}
                        <div class="navbar-nav ms-auto py-0"> 
                            
                            <a href="{{route('home')}}" class="nav-item nav-link
                            @if ($current_page == 'home')
                            active
                            @endif
                            ">الرئيسية</a>
                            
                            @if (auth()->user()->profile->employee_department == 'الإدارة' 
                            || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                            || auth()->user()->profile->employee_department == 'المستودع')
                                <a href="{{route('storeRoom')}}" class="nav-item nav-link
                                @if ($current_page == 'storeRoom')
                                    active
                                @endif
                                ">قسم المستودع</a>
                            @endif

                            @if (auth()->user()->profile->employee_department == 'الإدارة' 
                            || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                            || auth()->user()->profile->employee_department == 'شعبة المناقلات')
                                <a href="{{route('redirectDevicesNotesLog')}}" class="nav-item nav-link
                                @if ($current_page == 'redirectDevicesNotesLog')
                                    active
                                @endif
                                ">سجل المناقلات</a>
                            @endif

                            @if (auth()->user()->profile->employee_department == 'الإدارة' 
                            || auth()->user()->profile->employee_department == 'شعبة الأتمتة' 
                            || auth()->user()->profile->employee_department == 'شعبة الديوان')
                                <a href="{{route('allEmployees')}}" class="nav-item nav-link
                                @if ($current_page == 'allEmployees')
                                    active
                                @endif
                                ">قسم الموظفين</a>
                            @endif

                            @if (auth()->user()->profile->employee_department == 'الإدارة' )
                                <a href="{{route('allUsers')}}" class="nav-item nav-link
                                @if ($current_page == 'allUsers')
                                    active
                                @endif
                                ">قسم المستخدمين</a>
                            @endif

                            @if ( auth()->user()->profile->employee_department != 'شعبة الديوان')
                                <a href="{{route('allInstitutions')}}" class="nav-item nav-link
                                @if ($current_page == 'allInstitutions')
                                    active
                                @endif
                                ">قسم المنشآت</a>
                            @endif

                         </div>
                   {{-- </div> --}}
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="team.html" class="dropdown-item">Our Team</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div> --}}
                    {{-- <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
                    <div class="d-inline-flex" style="float: right;height: 62px;direction: ltr">

                        <div class="dropdown nav-item"  style="height: 100%;">
                            <a class="btn1 btn-light text-primary mx-0 py-2" style="height: 100%;direction:ltr;border-radius: 50rem 0 0 50rem ; border: 0.5px solid #6d86af;" type="button" id="dropdownMenuClickableOutside1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" data-bs-auto-close="outside" >
                                <img class="rounded-circle " style="box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 1)" height="45" width="45" src="{{asset(auth()->user()->profile->employee_image)}}">
                                <p class="d-none d-sm-inline">{{auth()->user()->profile->employee_full_name}}</p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-sm-start " style="direction:rtl; text-align:right;" aria-labelledby="dropdownMenuClickableOutside1">
    
                                <li><a class="dropdown-item" href=""><i class="fa-solid fa-person-circle-question fa-lg text-info"></i>   الصفحة الشخصية</a></li>
                                <hr class="divider w-100 mx-0 mt-0 mb-1" />
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutUser">
                                                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg text-danger"></i> تسجيل الخروج
                                    </a>
    
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown nav-item"  style="height: 100%;vertical-align: middle">
                            {{-- <button type="button" class="btn1 btn-light text-primary mx-1"  data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button> --}}
                            <a class="btn1 btn-light text-primary mx-0 py-3" style="height: 100%; direction:ltr;border-radius:0 50rem 50rem 0; border: 0.5px solid #0758dc;" type="button" id="dropdownMenuClickableOutside2" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static" data-bs-auto-close="inside" >
                                <i class="fa fa-search"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-start p-0" style="direction:ltr; text-align:right; width: 200px;left:-160px" aria-labelledby="dropdownMenuClickableOutside2">
    
                                <li>
                                    <form action="{{route('searchPage')}}">
                                        <div class="input-group" >
                                            <input class="form-control bg-transparent border-light p-3 m-1" style="text-align: center;direction: ltr" type="search" name="keyword" value="{{ old('keyword',request()->keyword) }}"  placeholder="... ابحث عن">
                                        </div>
                                    </form>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    {{-- data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" data-bs-auto-close="outside" --}}
                @else
                    <a href="{{route ('login')}}" style="float:left" class="btn btn-success text-light rounded-pill ms-3 fw-bolder">تسجيل الدخول</a>
                @endauth
            </nav>

            {{--  --}}

        </div>
        <!-- Navbar & Hero End -->

        <!-- Full Screen Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(63, 63, 63, 0.945);backdrop-filter: blur(5px);">
                    <div class="modal-header border-0" style="direction:rtl">
                        <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <form action="{{route('searchPage')}}">
                            <div class="input-group" style="max-width: 600px;">
                                <input type="text" name="keyword" value="{{ old('keyword',request()->keyword) }}" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                                <button class="btn btn-light px-4 text-primary" type="submit"><i class="fa fa-search text-primary"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->

        @auth
            <!-- Modal logoutUser -->
                <div class="modal fade" id="logoutUser" tabindex="-1">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">
                            <div class="modal-header border-0" style="direction:rtl">
                                <button type="button" style="float: right; margin: unset" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex align-items-center justify-content-center" style="direction:ltr">
                                <!-- Contact Start -->
                                <div class="container-fluid"  style="direction: rtl">
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="row g-1 mb-1">
                                                <div class="col-md-12">
                                                <h5 class="text-center text-light">هل أنت متأكد  <i class="fa-solid fa-circle-info fa-xl"></i></h5>
                                                </div>

                                            </div>
                                            
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <a class="btn btn-primary w-100 py-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg text-danger"></i>
                                                        تأكيد
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Contact End -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            <!-- Modal logoutUser -->
        @endauth
        <main>
            <div class="d-none d-lg-block" style="height: 95px"></div>
            <div > @include('partial.flash') </div>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- JavaScript Libraries -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script src="{{asset('assets/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/lib/lightbox/js/lightbox.min.js')}}"></script>
    <script src="{{asset('assets/lib/scrolling-nav/scrolling-nav.js')}}"></script>
    <script src="{{asset('assets/lib/validator/validator.js')}}"></script>

    <!-- plugins datatables -->
    <script src="{{asset('assets/lib/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- custom scripts datatables -->
    <script src="{{asset('assets/lib/datatables/demo/datatables-demo.js')}}"></script>

    @yield('script')
    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
</body>


</html>
