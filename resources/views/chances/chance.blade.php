@extends('layouts.master')

@section('title',trans('app.chances.chances')." | ".$chance->slug)
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12 content-details">
                <h2><span>{{trans('app.chances.chance_details')}}</span></h2>
                <div class="card-details">
                    <div class="details-border">
                        <div class="row">
                            @if(($chance->image || $chance->progress<100))
                                <div class="col-md-4">
                                    <div class="light-white">
                                        @if($chance->image)
                                            <div class="card-img">
                                                <img src="{{thumbnail($chance->image->path, 'single_center')}}"
                                                     alt="{{$chance->name}}">
                                            </div>
                                        @endif
                                        @if($chance->progress<100)
                                            <div class="padt">{{trans('app.chances.remaining_date')}}</div>
                                            <div class="progress ">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="{{$chance->progress}}"
                                                     aria-valuemin="0" aria-valuemax="0" style="">
                                            <span class="popOver" data-toggle="tooltip" data-placement="top"
                                                  title="{{\Carbon\Carbon::parse($chance->closing_date)->diffForHumans(\Carbon\Carbon::now())}}"> </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="{{($chance->image || $chance->progress<100)?'col-md-8':'col-md-12'}} ">
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
                                            <div class="one_xlarg"> {{$chance->number}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.closing_date')}}</div>
                                            <div class="one_xlarg">{{$chance->closing_date->format('d-m-Y')}}</div>
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
                                       {{-- <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.chance_value')}}</div>
                                            <div class="one_xlarg">{{$chance->value}}</div>
                                        </li>--}}
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.rules_book')}}</div>
                                            <div class="one_xlarg"><a class="btn btn-default" target="_blank"
                                                                      href="{{route('chances.download',['id'=>$chance->id])}}"> {{trans('app.chances.rules_book_download')}}</a>
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
                                    <th scope="col">{{trans('app.units.unit')}}</th>
                                    <th scope="col"> {{trans('app.quantity')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($chance->units as $unit)
                                    <tr>
                                        <td>
                                            <h3 style="text-align: center;">{{$unit->name }}</h3>
                                            <p>{{$unit->details}}</p>
                                        </td>
                                        <td>
                                            {{$unit->pivot->name}}
                                        </td>
                                        <td>{{$unit->pivot->quantity}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        @if(!fauth()->check())
                            <div class="download-box">
                                <p>{{trans('app.register_chance_apply')}}<a
                                            href="{{route('register')}}"> {{trans('app.register_now')}} </a></p>
                                <p>{{trans('app.login_chance_apply')}}<a
                                            href="{{route('login',['lang'=>app()->getLocale()])}}"> {{trans('app.login')}} </a>
                                </p>
                            </div>
                        @else
                            @if($chance->closing_date>Carbon\Carbon::now())
                                <button type="button" class="padding-lg fbutcenter btn-mas" data-dismiss="modal"
                                        data-target="#myModal"><i
                                            class="fa fa-arrow-right"></i>{{trans('app.chances.apply_chance')}}
                                </button>
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title"> {{trans('app.chances.apply')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{trans('app.chances.upload_request')}}</p>
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
                                                <button type="submit" id="formApply" form="upload"
                                                        class="uperc padding-md fbutcenter">{{trans('app.chances.apply_done')}}
                                                </button>
                                                <button type="submit" class="uperc padding-md fbutcenter1"
                                                        data-dismiss="modal">
                                                    {{trans('app.cancel')}}
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal fade" id="SuccessModal" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title"> {{trans('app.chances.apply_chance')}} </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{trans('app.chances.success')}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <style>
        .progress {
            overflow: visible;
            height: 5px;
            margin: 40px 5px 6px;
        }
    </style>
@endsection
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
        $(".progress-bar").each(function () {
            each_bar_width = $(this).attr('aria-valuenow');
            $(this).width(each_bar_width + '%');
        });
        $(".range-example").asRange({
            range: true,
            limit: false,
            tip: true,
            max: 10000,
            min: 100,
            value: true,
            step: 10,
            keyboard: true,
            replaceFirst: true,
            scale: true,
            format(value) {
                return value;
            }
        });

        $(function () {
            $('#upload').on('submit', function (e) {
                e.preventDefault();
                $('#formApply').hide();
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
                            $('#formApply').show();
                            $("#SuccessModal").modal('show');
                        } else {
                            $('.alert-danger').html(data.errors);
                            $('.alert-danger').show();
                            $('#formApply').show();
                        }
                    },
                    error: function () {
                        $('#formApply').show();
                        alert("Internal Server Error")
                    }
                })
            })
        })
    </script>

@endpush
