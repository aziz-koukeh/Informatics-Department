
<div style="position: fixed; bottom: 60px; left: 20px;direction:ltr;z-index: 99999;text-align:right;width: 300px;">

    {{-- رسالة تنويه عن التكرار --}}
    @if (session('FastAlertMessage'))
        <div class="toast shadow" role="alert" id="FastAlertMessage" aria-live="assertive" aria-atomic="true" data-animation="true">
            <div class="toast-header text-{{session('alert_type_A')}}">
                <img src="{{asset('assets/img/logo.ico')}}" alt="logo" height="25px">
                <strong class="mx-auto text-gray-900" style="direction:rtl">{{session('MainFastAlertMessage')}}</strong>
                <small class="text-muted">الآن</small>
            </div>
            <div class="toast-body text-gray-800" style="direction: rtl;text-align: right">
                <b>{!!session('FastAlertMessage')!!}</b>
            </div>
        </div>
    @endif
    {{-- رسالة تنويه عن التكرار --}}
    
    {{-- رسالة تنويه عن التكرار --}}
    @if (session('SlowAlertMessage'))
        <div class="toast shadow" role="alert" id="SlowAlertMessage" aria-live="assertive" aria-atomic="true" data-animation="true">
            <div class="toast-header text-{{session('alert_type_A')}}">
                <img src="{{asset('assets/img/logo.ico')}}" alt="logo" height="25px">
                <strong class="mx-auto text-gray-900" style="direction:rtl">{{session('MainSlowAlertMessage')}}</strong>
                <small class="text-muted">الآن</small>
            </div>
            <div class="toast-body text-gray-800" style="direction: rtl;text-align: right">
                <b>{!!session('SlowAlertMessage')!!}</b>
            </div>
        </div>
    @endif
    {{-- رسالة تنويه عن التكرار --}}


</div>

{{-- 

return redirect()->back()->with([
    'MainFastAlertMessage' =>    'تم التحديث بنجاح',
    'FastAlertMessage'     =>    'تم تحديث بيانات الموظف '.$employee->employee_full_name . '  بنجاح .',
    'alert_type_A'         =>    'success'
]);
 
--}}

{{-- 

return redirect()->back()->with([
    'MainSlowAlertMessage' =>    'تم التحديث بنجاح',
    'SlowAlertMessage'     =>    'تم تحديث بيانات الموظف '.$employee->employee_full_name . '  بنجاح .',
    'alert_type_A'         =>    'success'
]);

--}}