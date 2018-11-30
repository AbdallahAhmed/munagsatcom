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
                            <div class="col-md-4">
                                <div class="light-white">
                                    <div class="card-img"><img
                                                src="{{thumbnail($chance->image->path, 'single_center')}}" alt=""></div>
                                    <div class="padt">{{trans('app.chances.remaining_date')}}</div>
                                    <div class="progress ">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{100-((\Carbon\Carbon::parse($chance->closing_date)->diffInMinutes(\Carbon\Carbon::now())/\Carbon\Carbon::parse($chance->closing_date)->diffInMinutes($chance->created_at))*100)}}"
                                             aria-valuemin="0" aria-valuemax="0" style="">
                                            <span class="popOver" data-toggle="tooltip" data-placement="top"
                                                  title="{{\Carbon\Carbon::parse($chance->closing_date)->diffForHumans(\Carbon\Carbon::now())}}"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.company_name')}}</div>
                                            <div class="one_xlarg">{{$chance->company->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.chance_name')}}</div>
                                            <div class="one_xlarg">{{$chance->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.internal_number')}}</div>
                                            <div class="one_xlarg"> TAR18090404</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.closing_date')}}</div>
                                            <div class="one_xlarg">{{$chance->closing_date}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.sectors')}}</div>
                                            <div class="one_xlarg">
                                                <?php $x = 0;?>
                                                @foreach($chance->sectors as $sector)
                                                    {{$x != 0 ? " | " : "" }}{{$sector->name}}
                                                    <?php $x++?>
                                                @endforeach
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.chance_value')}}</div>
                                            <div class="one_xlarg">{{$chance->value}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.rules_book')}}</div>
                                            <div class="one_xlarg"><a class="btn btn-default" target="_blank"
                                                                      href="{{uploads_url().$chance->media->path}}"> {{trans('app.chances.rules_book_download')}}</a>
                                            </div>
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
                                    <th scope="col">{{trans('app.sectors.sector_name')}}</th>
                                    <th scope="col"> {{trans('app.quantity')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($chance->units as $unit)
                                    <tr>
                                        <td>
                                            <h3>{{$unit->name}}</h3>
                                            <p>{{$unit->details}}</p>
                                        </td>
                                        <td>{{$unit->pivot->quantity}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="padding-lg fbutcenter btn-mas" data-dismiss="modal"
                                data-target="#myModal"><i class="fa fa-arrow-right"></i> قدم على الفرصه
                        </button>
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
                                        <form id="upload" name="upload" enctype="multipart/form-data">
                                            <div class="custom-file form-group pad">
                                                <input name="file" type="file"
                                                       class="form-control-file custom-file-input"
                                                       id="exampleFormControlFile1">
                                                <input type="hidden" name="chance_id" value="{{$chance->id}}">
                                            </div>
                                            <p class="alert-danger" style="display: none"></p>
                                        </form>
                                    </div>
                                    <div class="modal-footer text-center">
                                        <button type="submit" form="upload" class="uperc padding-md fbutcenter">تقديم
                                        </button>
                                        <button type="submit" class="uperc padding-md fbutcenter1" data-dismiss="modal">
                                            الغاء
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal fade" id="SuccessModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> تقديم على الفرصة </h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>تم ارسال الطلب بنجاح و ستقوم الشركة بالاطلاع عليه</p>
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
                    formData.append('chance_id', "{{$chance->id}}")
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
                            }else{
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