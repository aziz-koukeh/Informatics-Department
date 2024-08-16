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
        @if ($institution->main_institution)
        <a href="{{route('showInstitution',$institution->main_institution->institution_slug)}} ">{{$institution->main_institution->institution_name}}</a> 
        /
        @endif
        <a href="{{route('showInstitution',$institution->institution_slug)}} ">{{$institution->institution_name}}</a> 
        /
        <a class="text-dark">موقع {{$institution->institution_name}}</a>  
    </div> 
    <!-- root page End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer wow fadeIn" style="min-height: calc(100vh - 95px);direction: rtl" data-wow-delay="0.1s">
        <div class="py-5 px-lg-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-white mb-4">معلومات المنشأة</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>العنوان :{{$institution->institution_address}}</p>
                    <p><i class="fa fa-phone-alt me-3"></i>الرقم :{{$institution->institution_phone}}</p>
                    <p><i class="fa fa-envelope me-3"></i>البريد الإلكتروني</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8">
                    <div class="card img-fluid" style="min-height: 60vh">
                        {!! $institution->institution_map !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->








@endsection




@section('script')
@endsection
