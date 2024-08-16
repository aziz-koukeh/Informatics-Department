@extends('layouts.app')

@section('css')
@endsection



@section('content')
    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        / 
        <a class="text-dark"> قسم المستودع </a> 
        @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' )
            / 
            <a class="btn btn-primary rounded-pill px-4 py-1" href="{{route('createImportRequestNote')}}" >إدخال مواد إلى المستودع</a>
        @endif
    </div> 
    <!-- root page End -->
    <div style="min-height: calc(100vh - 95px);direction: rtl">



        <!-- Service Start -->
        <div class="container-xxl py-2" >
            <div class="px-lg-2">
                <div class="section-title position-relative text-center mb-2 pb-2 wow fadeInUp" data-wow-delay="0.01s">
                    <h6 class="position-relative d-inline text-primary px-4">الخدمات</h6>
                    <h2 class="mt-2">قسم المستودع</h2>
                </div>
                @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->profile->employee_department == 'شعبة الأتمتة' || auth()->user()->level == 'مدير')
                    <div class="row g-4 fw-bolde justify-content-center">
                        {{-- <div class="col-lg-3 col-md-4 wow fadeInRight" data-wow-delay="0.001s">
                            <a  href="{{route('searchPage')}}">
                                <div class="service-item d-flex flex-column justify-content-center text-center rounded"  style="max-height: 236px">
                                    <div class="service-icon flex-shrink-0">
                                        <i class="fa fa-home fa-2x"></i>
                                    </div>
                                    <h6 class="mb-3">البحث عن مادة</h6>
                                </div>
                            </a>
                        </div> --}}
                        <div class="col-lg-3 col-md-4 wow fadeInRight" data-wow-delay="0.001s">
                            {{-- <a href="{{route('importRequestNotesLog')}}"> --}}
                                <div class="service-item d-flex flex-column justify-content-center text-center rounded"  style="max-height: 236px">
                                    <div class="service-icon flex-shrink-0">
                                        <i class="fa-solid fa-download fa-2x"></i>
                                    </div>
                                    <h4 class="mb-3">مذكرات إدخال</h4>
                                    <div class="d-inline-flex text-center">
                                        
                                        <a  class="btn me-2" href="{{ route('importRequestNotesLog') }}" onclick="event.preventDefault(); document.getElementById('importRequestNotesLogCurrentYear').submit();">
                                           السنة الحالية
                                        </a>
                                        <form id="importRequestNotesLogCurrentYear" action="{{ route('importRequestNotesLog') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="currentYear" value="currentYear">
                                        </form>
                                        <a  class="btn me-2" href="{{ route('importRequestNotesLog') }}" onclick="event.preventDefault(); document.getElementById('importRequestNotesLogAll').submit();">
                                            الكل
                                        </a>
                                        <form id="importRequestNotesLogAll" action="{{ route('importRequestNotesLog') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="all" value="all">
                                        </form>
                                        <a class="btn dropdown-toggle" data-bs-toggle="dropdown" style="display: unset">تاريخ</a>
                                        <div class="dropdown-menu dropdown-menu-end mx-5" style="min-width: auto">
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#importRequestNotesLogbyYear">
                                                اختر سنة
                                            </a>
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#importRequestNotesLogbyMonth">
                                                اختر شهر
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {{-- </a> --}}
                        </div>
                        <div class="col-lg-3 col-md-4 wow fadeInLeft" data-wow-delay="0.003s">
                            {{-- <a href="{{route('exportRequestNotesLog')}}"> --}}
                                <div class="service-item d-flex flex-column justify-content-center text-center rounded"  style="max-height: 236px">
                                    <div class="service-icon flex-shrink-0">
                                        <i class="fa-solid fa-upload fa-2x"></i>
                                    </div>
                                    <h4 class="mb-3">مذكرات تسليم</h4>
                                    <div class="d-inline-flex text-center">
                                        
                                        <a  class="btn me-2" href="{{ route('exportRequestNotesLog') }}" onclick="event.preventDefault(); document.getElementById('exportRequestNotesLogCurrentYear').submit();">
                                           السنة الحالية
                                        </a>
                                        <form id="exportRequestNotesLogCurrentYear" action="{{ route('exportRequestNotesLog') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="currentYear" value="currentYear">
                                        </form>
                                        <a  class="btn me-2" href="{{ route('exportRequestNotesLog') }}" onclick="event.preventDefault(); document.getElementById('exportRequestNotesLogAll').submit();">
                                            الكل
                                        </a>
                                        <form id="exportRequestNotesLogAll" action="{{ route('exportRequestNotesLog') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="all" value="all">
                                        </form>
                                        <a class="btn dropdown-toggle" data-bs-toggle="dropdown" style="display: unset">تاريخ</a>
                                        <div class="dropdown-menu dropdown-menu-end mx-5" style="min-width: auto">
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exportRequestNotesLogbyYear">
                                                اختر سنة
                                            </a>
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exportRequestNotesLogbyMonth">
                                                اختر شهر
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {{-- </a> --}}
                        </div>
                        @if (auth()->user()->profile->employee_department == 'المستودع' || auth()->user()->level == 'مدير')
                            <div class="col-lg-3 col-md-4 wow fadeInLeft" data-wow-delay="0.006s">
                                <div class="service-item d-flex flex-column justify-content-center text-center rounded"  style="max-height: 236px">
                                    <div class="service-icon flex-shrink-0">
                                        <i class="fa-solid fa-file-signature fa-2x"></i>
                                    </div>
                                    <h4 class="mb-3">جرد المستودع</h4>
                                    <div class="d-inline-flex text-center">
                                        
                                        <a  class="btn me-2" href="{{ route('stockingDevices') }}" onclick="event.preventDefault(); document.getElementById('stockingDevicesCurrentYear').submit();">
                                           السنة الحالية
                                        </a>
                                        <form id="stockingDevicesCurrentYear" action="{{ route('stockingDevices') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="currentYear" value="currentYear">
                                        </form>
                                        <a  class="btn me-2" href="{{ route('stockingDevices') }}" onclick="event.preventDefault(); document.getElementById('stockingDevicesAll').submit();">
                                            الكل
                                        </a>
                                        <form id="stockingDevicesAll" action="{{ route('stockingDevices') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="hidden" name="all" value="all">
                                        </form>
                                        <a class="btn dropdown-toggle" data-bs-toggle="dropdown" style="display: unset">تاريخ</a>
                                        <div class="dropdown-menu dropdown-menu-end mx-5" style="min-width: auto">
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#stockingDevicesbyYear">
                                                اختر سنة
                                            </a>
                                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#stockingDevicesbyMonth">
                                                اختر شهر
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <!-- Service End -->

        <!-- Facts Start -->
        <div class="container-xxl bg-primary fact mt-5 pb-1 wow fadeInUp" data-wow-delay="0.1s">
            <div class="py-4 px-lg-2">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                        <i class="fa fa-certificate fa-3x text-warning mb-3"></i>
                        @php
                            $exportRequestNotes = collect($exportRequestNotes)->unique('institution_id');
                        @endphp
                        <h1 class="text-white mb-2" data-toggle="counter-up">{{count($exportRequestNotes)}}</h1>
                        <p class="text-white mb-0">عدد الجهات المستلمة</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                        <i class="fa fa-users-cog fa-3x text-warning mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">{{count($devices->whereNotNull('institution_id'))}}</h1>
                        <p class="text-white mb-0">عدد الأجهزة المسلمة</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-users fa-3x text-warning mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">{{count($devices->whereNull('institution_id'))}}</h1>
                        <p class="text-white mb-0">عدد الأجهزة الموجودة</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                        <i class="fa fa-check fa-3x text-warning mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">{{count($devices)}}</h1>
                        <p class="text-white mb-0">عدد كل الأجهزة</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facts End -->

    </div>




    <!-- date Year modal -->
    <div class="modal fade" id="stockingDevicesbyYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="mystockingDevicesFormYear" method="POST" action="{{ route('stockingDevices') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                @php
                                    $years=[];

                                    foreach ($importRequestNotes as $importRequestNote) {
                                        $years[]= Carbon\Carbon::parse($importRequestNote->created_at)->format('Y') ;
                                    }
                                    $currentYears =collect($years)->unique();
                                @endphp
                                <select class="form-control text-center" name="year" id="mystockingDevicesYear">
                                    <option></option>
                                    @foreach ($currentYears as $currentYear)
                                        
                                        <option value="{{$currentYear}}">{{$currentYear}}</option>
                                    @endforeach
                                </select> 
                                <label>السنة :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('mystockingDevicesYear').oninput = function() {
                                document.getElementById('mystockingDevicesFormYear').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date Year end modal -->

    <!-- date Month modal -->
    <div class="modal fade" id="stockingDevicesbyMonth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="mystockingDevicesFormMonth" method="POST" action="{{ route('stockingDevices') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                <input id="mystockingDevicesMonth" name="month" class="form-control" type="month" min="{{Carbon\Carbon::parse($importRequestNotes->first()->created_at)->format('Y-m')}}" max="{{Carbon\Carbon::today()->format('Y-m')}}" >
                                
                                <label>الشهر :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('mystockingDevicesMonth').oninput = function() {
                                document.getElementById('mystockingDevicesFormMonth').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date Year end modal -->



    <!-- date exportRequestNotesLogYear modal -->
    <div class="modal fade" id="exportRequestNotesLogbyYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="myExportRequestNotesLogFormYear" method="POST" action="{{ route('exportRequestNotesLog') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                @php
                                    // $importRequestNotes = collect($importRequestNotes)->unique(Carbon\Carbon::parse('created_at')->format('Y'));
                                    $years1=[];

                                    foreach ($exportRequestNotes as $exportRequestNote) {
                                        $years1[]= Carbon\Carbon::parse($exportRequestNote->created_at)->format('Y') ;
                                    }
                                    $currentYears1 =collect($years1)->unique();
                                @endphp
                                <select class="form-control text-center" name="year" id="myExportRequestNotesLogYear">
                                    <option></option>
                                    @foreach ($currentYears1 as $currentYear1)
                                        
                                        <option value="{{$currentYear1}}">{{$currentYear1}}</option>
                                    @endforeach
                                </select> 
                                <label>السنة :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('myExportRequestNotesLogYear').oninput = function() {
                                document.getElementById('myExportRequestNotesLogFormYear').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date exportRequestNotesLogYear end modal -->

    <!-- date exportRequestNotesLogMonth modal -->
    <div class="modal fade" id="exportRequestNotesLogbyMonth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="myExportRequestNotesLogFormMonth" method="POST" action="{{ route('exportRequestNotesLog') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                <input id="myExportRequestNotesLogMonth" name="month" class="form-control" type="month" min="{{Carbon\Carbon::parse($exportRequestNotes->first()->created_at)->format('Y-m')}}" max="{{Carbon\Carbon::parse($exportRequestNotes->last()->created_at)->format('Y-m')}}" >
                                
                                <label>الشهر :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('myExportRequestNotesLogMonth').oninput = function() {
                                document.getElementById('myExportRequestNotesLogFormMonth').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date exportRequestNotesLogYear end modal -->

    


    <!-- date importRequestNotesLogYear modal -->
    <div class="modal fade" id="importRequestNotesLogbyYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="myimportRequestNotesLogFormYear" method="POST" action="{{ route('importRequestNotesLog') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                <select class="form-control text-center" name="year" id="myimportRequestNotesLogYear">
                                    <option></option>
                                    @foreach ($currentYears as $currentYear)
                                        
                                        <option value="{{$currentYear}}">{{$currentYear}}</option>
                                    @endforeach
                                </select> 
                                <label>السنة :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('myimportRequestNotesLogYear').oninput = function() {
                                document.getElementById('myimportRequestNotesLogFormYear').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date importRequestNotesLogYear end modal -->

    <!-- date importRequestNotesLogMonth modal -->
    <div class="modal fade" id="importRequestNotesLogbyMonth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content" style="background: rgba(150, 150, 150, 0.632);backdrop-filter: blur(5px);">

                <div class="modal-body">
                    <form id="myimportRequestNotesLogFormMonth" method="POST" action="{{ route('importRequestNotesLog') }}" style="direction: rtl">
                        @csrf
                        <div class="row text-centet">
                            <div class="form-floating col-sm-12">
                                <input id="myimportRequestNotesLogMonth" name="month" class="form-control" type="month" min="{{Carbon\Carbon::parse($importRequestNotes->first()->created_at)->format('Y-m')}}" max="{{Carbon\Carbon::parse($importRequestNotes->last()->created_at)->format('Y-m')}}" >
                                
                                <label>الشهر :</label>
                            </div>
                        </div>
                        <script>
                            document.getElementById('myimportRequestNotesLogMonth').oninput = function() {
                                document.getElementById('myimportRequestNotesLogFormMonth').submit(); // يقوم بعملية submit عند تغيير القيمة
                            };
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div><!-- date importRequestNotesLogYear end modal -->


@endsection




@section('script')
@endsection
