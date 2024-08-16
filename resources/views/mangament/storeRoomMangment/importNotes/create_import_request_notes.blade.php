@extends('layouts.app')

@section('css')



@endsection



@section('content')

    <!-- root page Start -->
    <div class="container-xxl py-2 border fw-bolder" style="height: auto;text-align:right;direction: rtl"> 
        <a href="{{route('home')}}">الصفحة الرئيسية</a> 
        /  
        <a href="{{route('storeRoom')}}">المستودع</a> 
        /
        <a class="text-dark"> إنشاء مذكرة إدخال </a> 
    </div> 
    <!-- root page End -->

    <!-- Contact Start -->
    <div class="container-fluid py-5"  style="min-height: calc(100vh - 95px);direction: rtl">
        <form  data-toggle="validator" role="form" method="post" action="{{route('storeImportRequestNote')}}" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="position-relative text-center mb-1 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-4 text-center">
                                <h5>الجمهورية العربية السورية</h5>
                                <h6>وزارة التربية - مديرية التربية بحلب</h6>
                                <h6><b>دائرة المعلوماتيــــــة</b></h6>
                            </div>
                            <div class="col-4">
                                <h2 class="mt-2">مذكرة إدخال</h2>
                                
                                <div class="form-floating form-group mb-2">
                                    <select class="form-control text-center @error('import_device_source_from_employee') is-invalid @enderror"  name="import_device_source_from_employee" id="import_device_source_from_employee" required>
                                        <option value="else">جهة أخرى</option>
                                        @forelse ($institutions->where('institution_name','<>','دائرة المعلوماتية') as $institution)
                                        @if ($institution->storekeeper)
                                            
                                            <option value="{{$institution->institution_slug}}">أمين مستودع 
                                                {{$institution->institution_name}} : {{$institution->storekeeper->employee_full_name}}</option>
                                        @endif
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('import_device_source_from_employee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="help-block with-errors pull-right"></div>
                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                    <label for="import_device_source_from_employee">الجهة المسلمة:</label>
                                </div>
                            
                                <div class="form-floating form-group">
                                    <input type="text" class="form-control @error('import_device_source') is-invalid @enderror text-center" name="import_device_source" id="import_device_source" placeholder="Subject" >
                                    @error('import_device_source')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="help-block with-errors pull-right"></div>
                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                    <label for="import_device_source">الجهة المسلمة:</label>
                                </div>

                            </div>
                            <div class="col-4 d-block ">
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="number" class="form-control @error('import_request_note_folder') is-invalid @enderror text-center" name="import_request_note_folder" id="import_request_note_folder"  placeholder="الجلد" required>
                                        @error('import_request_note_folder')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    <div class="help-block with-errors pull-right"></div>
                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                    <label for="import_request_note_folder">رقم الجلد:</label>
                                </div>
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="number" class="form-control @error('import_request_note_SN') is-invalid @enderror text-center" name="import_request_note_SN" id="import_request_note_SN"  placeholder="المتسلسل" required>
                                        @error('import_request_note_SN')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    <div class="help-block with-errors pull-right"></div>
                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                    <label for="import_request_note_SN">الرقم المتسلسل:</label>
                                </div>
                                <div class="form-floating form-group mb-1">
                                    <input style="border: unset;height: 35px;" type="date" class="form-control @error('created_at') is-invalid @enderror text-center" max="{{Carbon\Carbon::today()->format('Y-m-d')}}" name="created_at" id="created_at"  placeholder="التاريخ" required>
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
                    <div class="wow fadeInUp" data-wow-delay="0.003s">
                        <div class="table-responsive">
                            <caption><h4 class="fw-bolder">المواد المدخلة:</h4></caption>
                            <table class="table table-hover table-sm  table-striped table-bordered caption-top text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" style="width: 20px">الرقم</th>
                                        <th colspan="2" >التفاصيل</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                <tr id="row">
                                    <th scope="row" style="vertical-align:middle">#</th>
                                    <td colspan="2">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item" style="background-color: unset;border:unset">
                                                <div class="d-flex">
                                                    <div class="row g-2 mb-1">
                                                        <div class="col-md-2">
                                                            <div class="form-floating form-group">
                                                                <input type="text" class="form-control @error('device_name') is-invalid @enderror" id="device_name" name="device_name[]" placeholder="device_name" required>
                                                                    @error('device_name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_name">اسم المادة</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-floating form-group">
                                                                <input type="text" class=" form-control @error('device_number') is-invalid @enderror" id="device_number" name="device_number[]" placeholder="Your device_number" required>
                                                                    @error('device_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right text-xs"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_number">رمز المادة</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" id="">
                                                            <div class="form-floating form-group">
                                                                <textarea class="form-control @error('device_details') is-invalid @enderror" placeholder="device_details" id="device_details" name="device_details[]"></textarea>
                                                                    @error('device_details')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_details">مواصفات المادة</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-floating form-group">
                                                                <select class="form-control @error('device_weight') is-invalid @enderror"  name="device_weight[]" id="device_weight" >
                                                                    <option value="
                                                                    قطعة
                                                                    ">قطعة</option>
                                                                    <option value="
                                                                    مجموعة
                                                                    ">مجموعة</option>
                                                                    <option value="
                                                                    كيلو غرام
                                                                    ">كيلو غرام</option>
                                                                    <option value="
                                                                    متر
                                                                    ">متر</option>
                                                                    
                                                                </select>
                                                                    @error('device_weight')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_weight">الوحدة</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-floating form-group">
                                                                <input type="number" class="form-control @error('device_count') is-invalid @enderror" id="device_count" name="device_count[]"  placeholder="device_count" required>
                                                                    @error('device_count')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_count">الكمية</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-floating form-group">
                                                                <input type="number" class="form-control @error('device_file_card') is-invalid @enderror" id="device_file_card" name="device_file_card[]"  placeholder="device_file_card" required>
                                                                    @error('device_file_card')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_file_card">رقم البطاقة</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-floating form-group">
                                                                <textarea class="form-control @error('device_notes') is-invalid @enderror" placeholder="device_notes" id="device_notes" name="device_notes[]" ></textarea>
                                                                    @error('device_notes')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                <div class="help-block with-errors pull-right"></div>
                                                                <span class="form-control-feedback" aria-hidden="true"></span>
                                                                <label for="device_notes">ملاحظات</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="collapsed btn btn-outline-secondary bg-white fw-bold p-1" style="vertical-align:middle;height: calc(3.5rem + 2px);margin-right: 0.5rem;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        ملحقات
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body px-0 py-1">
                                                        <div class="row g-1">
                                                            <div class="col-md-8">
                                                                <div class="form-floating form-group">
                                                                    <textarea class="form-control @error("device_belongings") is-invalid @enderror" placeholder="device_belongings" id="device_belongings" name="device_belongings[]" ></textarea>
                                                                        @error("device_belongings")
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="device_belongings">ملحقات المادة</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="number" class="form-control @error("device_belongings_count") is-invalid @enderror" id="device_belongings_count" name="device_belongings_count[]" placeholder="device_belongings_count" >
                                                                        @error("device_belongings_count")
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="device_belongings_count">عدد الملحقات</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-floating form-group">
                                                                    <input type="file" class="form-control @error('device_image') is-invalid @enderror text-center" name="device_image[]" id="device_image" placeholder="Subject">
                                                                        @error('device_image')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    <div class="help-block with-errors pull-right"></div>
                                                                    <span class="form-control-feedback" aria-hidden="true"></span>
                                                                    <label for="device_image">صورة عن المادة:</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>

                                </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row"><button class="btn btn-success w-100 py-3" id="button" type="button" onclick="add_Row('row')"><i class="fa-solid fa-plus"></i></button></th>
                                        <td colspan="2">المجموع  <input style="border: unset;height: 35px;width:auto;" type="text" class="text-center px-1" value="" name="count_devices" id="count_devices"  readonly="readonly"> أقلام فقط لاغير</td>

                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row  g-2">
                                <div class="col-4">
                                    <div class="form-floating form-group">
                                        <input type="file" class="form-control @error('import_request_image') is-invalid @enderror text-center" name="import_request_image" id="import_request_image" placeholder="Subject" required>
                                            @error('import_request_image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        <div class="help-block with-errors pull-right"></div>
                                        <span class="form-control-feedback" aria-hidden="true"></span>
                                        <label for="import_request_image">صورة عن المذكرة:</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">حفظ</button>
                                </div>
                            </div>


                        </div>



                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Contact End -->


@endsection




@section('script')

<script>

    document.getElementsByName('device_count[]').oninput = function() {
        var countDevices = document.getElementsByName('device_count').values();
        for (const key in countDevices) {
            if (Object.hasOwnProperty.call(object, key)) {
                const element = object[key];
                document.write('<br>' +element);

            }
        }
    }

    // document.getElementsByName('device_count').onclick = function() {
    //     count_Devices += document.getElementsByName('device_count[]').value() ;
    //     document.getElementById('count_devices').value = count_Devices;
    // }


    var num = '1';
    function add_Row(row){
        ++num
        row+=num;
        num1="'"+num+"'"
        row1 = "'"+row+"'";
        var add_Row = '<tr id="'+row+'">'
                               +' <th scope="row" style="vertical-align:middle">'
                                        +'                            <button class="btn btn-danger fw-bold" style="height: calc(3.5rem + 2px);" type="button" onclick="delete_Row('+row1+') "><i class="fa-solid fa-minus"></i></button> '
                                +'</th> '
                               +' <td colspan="2"> '
                               +' <div class="accordion" id="accordionExample">'
                                +'        <div class="accordion-item" style="background-color: unset;border:unset">'
                                  +'          <div class="d-flex">'
                                   +' <div class="row g-2 mb-1"> '
                                       +' <div class="col-md-2"> '
                                           +' <div class="form-floating form-group"> '
                                               +' <input type="text" class="form-control @error("device_name") is-invalid @enderror" id="device_name'+num+'" name="device_name[]" placeholder="device_name" required> '
                                             +'       @error("device_name") '
                                                   +' <span class="invalid-feedback" role="alert"> '
                                                            +' <strong>{{ $message }}</strong> '
        +'                                                    </span> '
        +'                                                @enderror '
        +'                                                <div class="help-block with-errors pull-right"></div> '
        +'                                                <span class="form-control-feedback" aria-hidden="true"></span> '
        +'                                                <label for="device_name'+num+'">اسم المادة</label> '
        +'                                              </div> '
        +'                                        </div> '
        +'                                        <div class="col-md-1"> '
        +'                                            <div class="form-floating form-group"> '
        +'                                                <input type="text" class=" form-control @error("device_number") is-invalid @enderror" id="device_number'+num+'" name="device_number[]" placeholder="Your device_number" required> '
        +'                                                    @error("device_number") '
        +'                                                        <span class="invalid-feedback" role="alert"> '
        +'                                                            <strong>{{ $message }}</strong> '
        +'                                                        </span> '
        +'                                                 @enderror '
        +'                                                <div class="help-block with-errors pull-right text-xs"></div> '
        +'                                                <span class="form-control-feedback" aria-hidden="true"></span> '
        +'                                                <label for="device_number'+num+'">رمز المادة</label> '
        +'                                            </div> '
        +'                                        </div> '
        +'                                        <div class="col-md-3" > '
        +'                                            <div class="form-floating form-group"> '
        +'                                                <textarea class="position-relative form-control @error("device_details") is-invalid @enderror" placeholder="device_details" id="device_details'+num+'" name="device_details[]"></textarea> '
        +'                                                    @error("device_details") '
        +'                                                        <span class="invalid-feedback" role="alert"> '
        +'                                                          <strong>{{ $message }}</strong> '
        +'                                                      </span> '
        +'                                                  @enderror '
        +'                                              <div class="help-block with-errors pull-right"></div> '
        +'                                              <span class="form-control-feedback" aria-hidden="true"></span> '
            +'                                            <label for="device_details'+num+'">مواصفات المادة</label> '
        +'                                          </div> '
        +'                                      </div> '
        +'                                      <div class="col-md-1"> '
        +'                                          <div class="form-floating form-group"> '
        +'                                                  <select class="form-control @error("device_weight") is-invalid @enderror"  name="device_weight[]" id="device_weight'+num+'" > '
        +'                                                  <option value=" '
        +'                                                  قطعة '
        +'                                                  ">قطعة</option> '
        +'                                                  <option value=" '
        +'                                                  مجموعة '
        +'                                                  ">مجموعة</option> '
        +'                                                  <option value=" '
        +'                                                  كيلو غرام '
        +'                                                  ">كيلو غرام</option> '
        +'                                                  <option value=" '
        +'                                                  متر '
        +'                                                  ">متر</option> '
        +'                                                   '
        +'                                              </select> '
        +'                                              @error("device_weight") '
        +'                                                      <span class="invalid-feedback" role="alert"> '
        +'                                                          <strong>{{ $message }}</strong> '
        +'                                                      </span> '
        +'                                                  @enderror '
            +'                                            <div class="help-block with-errors pull-right"></div> '
            +'                                            <span class="form-control-feedback" aria-hidden="true"></span> '
            +'                                            <label for="device_weight'+num+'">الوحدة</label> '
            +'                                        </div> '
            +'                                    </div> '
            +'                                    <div class="col-md-1"> '
            +'                                       <div class="form-floating form-group"> '
            +'                                            <input type="number" class="form-control @error("device_count") is-invalid @enderror" id="device_count'+num+'" name="device_count[]"  placeholder="device_count" required> '
            +'                                                @error("device_count") '
            +'                                                    <span class="invalid-feedback" role="alert"> '
            +'                                                        <strong>{{ $message }}</strong> '
            +'                                                    </span> '
            +'                                                @enderror '
            +'                                            <div class="help-block with-errors pull-right"></div> '
            +'                                            <span class="form-control-feedback" aria-hidden="true"></span> '
            +'                                            <label for="device_count'+num+'">الكمية</label> '
            +'                                        </div> '
            +'                                  </div> '
            +'                                  <div class="col-md-1"> '
            +'                                      <div class="form-floating form-group"> '
            +'                                          <input type="number" class="form-control @error("device_file_card") is-invalid @enderror" id="device_file_card'+num+'" name="device_file_card[]"  placeholder="device_file_card" required> '
            +'                                              @error("device_file_card") '
            +'                                                  <span class="invalid-feedback" role="alert"> '
                +'                                                    <strong>{{ $message }}</strong> '
            +'                                                  </span> '
            +'                                              @enderror '
            +'                                          <div class="help-block with-errors pull-right"></div> '
            +'                                          <span class="form-control-feedback" aria-hidden="true"></span> '
            +'                                          <label for="device_file_card'+num+'">رقم البطاقة</label> '
            +'                                      </div> '
            +'                                  </div> '
            +'                                  <div class="col-md-3"> '
            +'                                      <div class="form-floating form-group"> '
            +'                                          <textarea class="form-control @error("device_notes") is-invalid @enderror" placeholder="device_notes" id="device_notes'+num+'" name="device_notes[]" ></textarea> '
                +'                                            @error("device_notes") '
                +'                                                <span class="invalid-feedback" role="alert"> '
                +'                                                    <strong>{{ $message }}</strong> '
                +'                                                </span> '
                +'                                            @enderror '
                +'                                        <div class="help-block with-errors pull-right"></div> '
                +'                                        <span class="form-control-feedback" aria-hidden="true"></span> '
                +'                                        <label for="device_notes'+num+'">ملاحظات</label> '
                +'                                    </div> '
                +'                                </div> '
                +'                            </div> '
                +'                                     <h2 class="accordion-header" id="headingTwo'+num+'"><button class="collapsed btn btn-outline-secondary bg-white fw-bold p-1" style="vertical-align:middle;height: calc(3.5rem + 2px);margin-right: 0.5rem;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo'+num+'" aria-expanded="false" aria-controls="collapseTwo'+num+'">ملحقات</button> </h2>'
                +'                            </div> '
                +'                            </div> '
                +'                               <div id="collapseTwo'+num+'" class="accordion-collapse collapse" aria-labelledby="headingTwo'+num+'" data-bs-parent="#accordionExample'+num+'"> '
                +'                                     <div class="accordion-body px-0 py-1">'
                +'                                        <div class="row g-1">'
                                                        +'<div class="col-md-8">'
                                                      +'<div class="form-floating form-group">'
                                                        +'<textarea class="form-control @error("device_belongings") is-invalid @enderror" placeholder="device_belongings" id="device_belongings'+num+'" name="device_belongings[]" ></textarea>'
                                                        +'@error("device_belongings")'
                                                            +'<span class="invalid-feedback" role="alert">'
                                                            +'<strong>{{ $message }}</strong>'
        +'                                                       </span>'
        +'                                                 @enderror'
            +'                                           <div class="help-block with-errors pull-right"></div>'
            +'                                         <span class="form-control-feedback" aria-hidden="true"></span>'
                +'                                       <label for="device_belongings'+num+'">ملحقات المادة</label>'
                +'                                 </div>'
                    +'                           </div>'
                               +'                         <div class="col-md-2">'
                                 +'                           <div class="form-floating form-group">'
                                   +'                             <input type="number" class="form-control @error("device_belongings_count") is-invalid @enderror" id="device_belongings_count'+num+'" name="device_belongings_count[]" placeholder="device_belongings_count" >'
                                     +'                               @error("device_belongings_count")'
                                       +'                                 <span class="invalid-feedback" role="alert">'
                                         +'                                   <strong>{{ $message }}</strong>'
                                           +'                             </span>'
                                             +'                       @enderror'
                                              +'                  <div class="help-block with-errors pull-right"></div>'
                                                +'                <span class="form-control-feedback" aria-hidden="true"></span>'
                                                  +'              <label for="device_belongings_count'+num+'">عدد الملحقات</label>'
                                                    +'        </div>'
                                                   +'     </div>'
                                                   +' <div class="col-md-2"> '
                                                    +'        <div class="form-floating form-group"> '
                                                        +'             <input type="file" class="form-control @error("device_image") is-invalid @enderror text-center" name="device_image[]" id="device_image'+num+'" placeholder="Subject"> '
                                                        +'                 @error("device_image") '
                                                        +'                     <span class="invalid-feedback" role="alert"> '
                                                            +'                         <strong>{{ $message }}</strong> '
                                                            +'                      </span> '
                                                            +'                  @enderror '
                                                            +'             <div class="help-block with-errors pull-right"></div> '
                                                            +'             <span class="form-control-feedback" aria-hidden="true"></span> '
                                                            +'              <label for="device_image'+num+'">صورة عن المادة:</label> '
                                                            +'           </div> '
                                                            +'        </div> '
                                                            +'                                              </div>'
                                                            +'                                                    </div>'
        +'                                        </div>'
            +'                            </div> '

            +'                            </div> '
            +'                        </td> '

            +'                   </tr> ';
            document.getElementById("table_body").innerHTML += add_Row;
    }

    function delete_Row(rowId) {
        --num
        var row = document.getElementById(rowId);
        row.remove();
    }
</script>

@endsection
