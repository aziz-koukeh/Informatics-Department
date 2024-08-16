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
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link href="{{asset('assets/css/all.css')}}" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('assets/css/bootstrap.rtl.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>

    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        {{-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> --}}
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0"  style="max-height: 100vh">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 w-100 d-flex" style="direction: rtl;justify-content:space-between">
                <a href="{{route('home')}}" class="navbar-brand p-0">
                    <h1 class="m-0" >دائرة المعلوماتية</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                @auth
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0">
                            <a href="{{route('home')}}" class="nav-item nav-link active">الرئيسية</a>
                            {{-- <a href="about.html" class="nav-item nav-link">About</a>
                            <a href="service.html" class="nav-item nav-link">Service</a>
                            <a href="project.html" class="nav-item nav-link">Project</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0">
                                    <a href="team.html" class="dropdown-item">Our Team</a>
                                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                    <a href="404.html" class="dropdown-item">404 Page</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
                        </div>
                        <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
                    </div>
                @else
                    <a href="{{route ('login')}}" style="float:left" class="btn btn-success text-light rounded-pill ms-3 fw-bolder">تسجيل الدخول</a>
                @endauth
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">All in one SEO tool need to grow your business rapidly</h1>
                            <p class="text-white pb-3 animated zoomIn">Tempor rebum no at dolore lorem clita rebum rebum ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo amet ipsum vero ipsum clita lorem</p>
                            {{-- <a href="" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Free Quote</a>
                            <a href="" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact Us</a> --}}
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-arrow-right-to-bracket fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-person-through-window fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-sliders fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-plus fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-regular fa-pen-to-square fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-trash fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-trash-can fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-regular fa-trash-can fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-gears fa-xl"></i>
                                <i class="fa-solid fa-gear fa-xl"></i>
                                <i class="fa-solid fa-screwdriver-wrench fa-xl"></i>
                                <i class="fa-solid fa-wrench fa-xl"></i>
                                <i class="fa-solid fa-lock fa-xl"></i>
                                <i class="fa-solid fa-shield-halved fa-xl"></i>
                                <i class="fa-solid fa-hourglass-half fa-xl"></i>
                                <i class="fa-regular fa-hourglass-half fa-xl"></i>

                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-person-circle-minus fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-school fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-building-user fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-hotel fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-building fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-building-shield fa-xl"></i>
                                <i class="fa-solid fa-building-circle-xmark fa-xl"></i>
                                <i class="fa-solid fa-building-circle-exclamation fa-xl"></i>
                                <i class="fa-solid fa-building-circle-check fa-xl"></i>
                                <i class="fa-solid fa-building-lock fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-city fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-school-flag fa-xl"></i>
                                <i class="fa-solid fa-place-of-worship fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-school-circle-check fa-xl"></i>
                                <i class="fa-solid fa-school-circle-exclamation fa-xl"></i>
                                <i class="fa-solid fa-school-circle-xmark fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-user-tie fa-xl"></i>
                                <i class="fa-regular fa-user fa-xl"></i>
                                <i class="fa-solid fa-user-plus fa-xl"></i>
                                <i class="fa-solid fa-user-minus fa-xl"></i>
                                <i class="fa-solid fa-user-xmark fa-xl"></i>
                                <i class="fa-solid fa-user-lock fa-xl"></i>
                                <i class="fa-solid fa-user-gear fa-xl"></i>
                                <i class="fa-solid fa-user-shield fa-xl"></i>
                                <i class="fa-solid fa-user-check fa-xl"></i>
                                <i class="fa-solid fa-user-clock fa-xl"></i>
                                <i class="fa-solid fa-users-gear fa-xl"></i>
                                <i class="fa-solid fa-users fa-xl"></i>
                                <i class="fa-solid fa-users-line fa-xl"></i>
                                <i class="fa-solid fa-users-between-lines fa-xl"></i>
                                <i class="fa-solid fa-users-rectangle fa-xl"></i>

                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-address-card fa-xl"></i>
                                <i class="fa-solid fa-id-badge fa-xl"></i>
                                <i class="fa-regular fa-id-card fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-file-signature fa-xl"></i>
                                <i class="fa-solid fa-file-export fa-xl"></i>
                                <i class="fa-solid fa-file-import fa-xl"></i>
                                <i class="fa-solid fa-file-csv fa-xl"></i>
                                <i class="fa-solid fa-folder-tree fa-xl"></i>
                                <i class="fa-regular fa-folder-open fa-xl"></i>
                                <i class="fa-solid fa-download fa-xl"></i>
                                <i class="fa-solid fa-upload fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-person fa-xl"></i>
                                <i class="fa-solid fa-people-arrows fa-xl"></i>
                                <i class="fa-solid fa-person-circle-xmark fa-xl"></i>
                                <i class="fa-solid fa-person-circle-question fa-xl"></i>
                                <i class="fa-solid fa-person-circle-plus fa-xl"></i>
                                <i class="fa-solid fa-person-circle-minus fa-xl"></i>
                                <i class="fa-solid fa-person-circle-exclamation fa-xl"></i>
                                <i class="fa-solid fa-person-circle-check fa-xl"></i>
                                <i class="fa-solid fa-people-group fa-xl"></i>
                                <i class="fa-solid fa-people-roof fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-brands fa-searchengin fa-xl"></i>
                                <i class="fa-solid fa-magnifying-glass-location fa-xl"></i>
                                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                                <i class="fa-solid fa-filter fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                                <i class="fa-solid fa-location-dot fa-xl"></i>
                                <i class="fa-solid fa-street-view fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-computer fa-xl"></i>
                                <i class="fa-solid fa-laptop fa-xl"></i>
                                <i class="fa-solid fa-desktop fa-xl"></i>
                                <i class="fa-solid fa-tablet-screen-button fa-xl"></i>
                                <i class="fa-regular fa-keyboard fa-xl"></i>
                                <i class="fa-solid fa-computer-mouse fa-xl"></i>
                                <i class="fa-solid fa-compact-disc fa-xl"></i>
                                <i class="fa-solid fa-tachograph-digital fa-xl"></i>
                                <i class="fa-solid fa-print fa-xl"></i>
                                <i class="fa-solid fa-network-wired fa-xl"></i>
                                <i class="fa-solid fa-wifi fa-xl"></i>
                                <i class="fa-solid fa-diagram-project fa-xl"></i>
                                <i class="fa-solid fa-globe fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-sitemap fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-regular fa-lightbulb fa-xl"></i>
                                <i class="fa-regular fa-hand-pointer fa-xl"></i>
                                <i class="fa-solid fa-check fa-xl"></i>
                                <i class="fa-solid fa-info fa-xl"></i>
                                <i class="fa-solid fa-circle-info fa-xl"></i>
                                <i class="fa-solid fa-circle-question fa-xl"></i>
                                <i class="fa-regular fa-circle-question fa-xl"></i>
                            </a>
                            <a href="" class="btn btn-outline-light  py-sm-3 px-sm-5 rounded-pill animated slideInRight">
                                <i class="fa-solid fa-arrow-left fa-xl"></i>
                                <i class="fa-solid fa-chevron-left fa-xl"></i>
                                <i class="fa-solid fa-left-long fa-xl"></i>
                                <i class="fa-solid fa-circle-left fa-xl"></i>
                                <i class="fa-solid fa-circle-arrow-left fa-xl"></i>
                                <i class="fa-solid fa-circle-chevron-left fa-xl"></i>


                                <i class="fa-solid fa-retweet fa-xl"></i>
                                <i class="fa-solid fa-repeat fa-xl"></i>
                                <i class="fa-solid fa-rotate-right fa-xl"></i>

                                <i class="fa-solid fa-arrow-right fa-xl"></i>
                                <i class="fa-solid fa-circle-right fa-xl"></i>
                                <i class="fa-solid fa-arrow-right-long fa-xl"></i>
                                <i class="fa-solid fa-chevron-right fa-xl"></i>
                            </a>


                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid " src="{{asset('assets/img/about.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" >
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);" >
                    <div class="modal-header border-0" style="direction: ltr">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                            <button class="btn btn-light px-4"><i class="bi bi-search fa-xl"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->
        <!-- Navbar & Hero End -->
    </div>


            <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/lib/lightbox/js/lightbox.min.js')}}"></script>
    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    </body>
</html>
