@extends('layouts.master')

@section('title',trans('app.chances.chances'))
@section('content')
    <section class="container">
        <div class="row">
            <!-------------- Begin:content -------------->
            <div class="col-md-12 content-details">
                <h2><span>{{trans('app.chances.chance_details')}}</span></h2>

                <div class="card-details">
                    <!-- part 1-->
                    <div class="details-border">
                        <div class="row">
                            <div class="col-md-4"><div class="light-white">
                                    <div class="card-img"><img src="{{asset('/assets')}}/images/monqs-img.png" alt=""></div>
                                    <div class="padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                                    <div class="progress ">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                            <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                        </div>
                                    </div>
                                </div></div>
                            <div class="col-md-8">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title"> أسم الشركة   </div>
                                            <div class="one_xlarg">شركة حمومة المحدوده  </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title"> اسم الفرصه </div>
                                            <div class="one_xlarg"> نظام IP  لمشروع فندقى</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">الرقم المرجعى الداخلى </div>
                                            <div class="one_xlarg"> TAR18090404 </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">تاريخ الاغلاق</div>
                                            <div class="one_xlarg">1440/01/21 - 14:00</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">القطاعات</div>
                                            <div class="one_xlarg">البناء و التشيد</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">قيمة الفرصه</div>
                                            <div class="one_xlarg">من 10.000 الى 50.000 ريال سعودى</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">كراسة الشروط</div>
                                            <div class="one_xlarg"><a class="btn btn-default" href="#"> تحميل كراسه الشروط</a> </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- part 2-->
                    <div class="details-border">
                        <div class="unit-table pad">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">اسم الوحدة</th>
                                    <th scope="col"> الكمية</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <h3> اسم الوحدة المقدمة</h3>
                                        <p>تفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمة</p>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3> اسم الوحدة المقدمة</h3>
                                        <p>تفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمة</p>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3> اسم الوحدة المقدمة</h3>
                                        <p>تفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمة</p>
                                    </td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3> اسم الوحدة المقدمة</h3>
                                        <p>تفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمةتفاصيل الوحدة المقدمة</p>
                                    </td>
                                    <td>50</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="padding-lg fbutcenter btn-mas" data-dismiss="modal" data-target="#myModal"><i class="fa fa-arrow-right"></i> قدم على الفرصه</button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> تقديم على الفرصة </h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>قم بتحميل العرض التفصيلى و ستقوم الشركة بالاطلاع عليه</p>
                                        <form>
                                            <div class="custom-file form-group pad">
                                                <input type="file" class="form-control-file custom-file-input" id="exampleFormControlFile1">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer text-center">
                                        <button type="submit" form="" class="uperc padding-md fbutcenter">تقديم</button>
                                        <button type="submit" class="uperc padding-md fbutcenter1" data-dismiss="modal">الغاء</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-------------- End::content -------------->
        </div>
    </section>
    @push('scripts')
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
            });
            $(document).ready(function () {
                $(".btn-mas").click(function () {
                    $("#myModal").modal('show');
                });
            });
            // $( window ).scroll(function() {
            // if($( window ).scrollTop() > 10){  // scroll down abit and get the action
            $(".progress-bar").each(function () {
                each_bar_width = $(this).attr('aria-valuenow');
                $(this).width(each_bar_width + '%');
            });
            $(".range-example").asRange({
                range: true,
                limit: false,
                //tip: {
//    active: 'onMove'
//    },
                tip: true,
                max: 10000,
                min: 100,
                value: true,
                step: 10,
                keyboard: true,
                replaceFirst: true, // false, 'inherit', {'inherit': 'default'}
                scale: true,
                format(value) {
                    return value;
                }
            });

            $(function () {
                $('#upload').on('submit', function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var file = $('[name="file"]');
                    var formData = new FormData();
                    formData.append('file', file[0].files[0]);
                    //formData.append('chance_id', "{{$chance->id}}")
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "{{route('chances.offers')}}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.success) {
                                $("#myModal").modal('hide');
                                $("#SuccessModal").modal('show');
                            } else {
                                $('.alert-danger').html(data.errors);
                                $('.alert-danger').show();
                            }
                        },
                        error: function () {
                            alert("Internal Server Error")
                        }
                    })
                })
            })
        </script>

    @endpush
@endsection