<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome - Login</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

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



        <!-- Login Start -->
        <div class="container-fluid bg-primary text-light footer " style="min-height: 100vh;">
            <div class="container py-5 px-md-4 px-lg-5">
                <div class="row align-items-center justify-content-center my-5">

                    <div class="col-md-12 col-lg-8">

                        <div class="card border-light mt-5 mb-3" style="background:unset;vertical-align: middle;">
                            <div class="card-header text-center text-light d-inline-flex w-100 ">
                                <h4 class=" w-100 text-light">تسجيل الدخول</h4>
                                <a href="{{url('/')}}" style="float:right" type="button" class="btn bg-white"><i class="fa fa-home text-primary"></a>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="row justify-content-center" style="direction: rtl">

                                        <div class="col-md-8 mb-3">
                                            <div class="form-floating">
                                                <input class="form-control text-center @error('user_name') is-invalid @enderror" id="user_name" name="user_name" type="text"  value="" required autocomplete="user_name" placeholder="Your Name" autofocus />
                                                     @error('user_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                <label class="text-dark" for="user_name">اسم الحساب:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <div class="form-floating">
                                                <input class="form-control text-center @error('password') is-invalid @enderror" id="password" type="password" name="password" required  placeholder="password" autocomplete="current-password"  />
                                                     @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                <label class="text-dark" for="password">كلمة المرور:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-8 text-center">
                                            <button type="submit" class="btn btn-outline-light rounded-pill fw-bolder w-100 py-3">
                                                تسجيل الدخول
                                            </button>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->


    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>


</html>
