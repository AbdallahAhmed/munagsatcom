@extends('layouts.master')

@section('title',$company->slug)

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

                    <div class="profile-circle">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="circle-item">
                                    <p>{{trans('app.current_points')}}</p>
                                    <div class="num">{{$company->points}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="circle-item">
                                    <p>{{trans('app.spent_points')}}</p>
                                    <div class="num"> {{$company->spent_points}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><a class="btn btn-primary" href="{{route('user.recharge')}}" style="width: 100%;">{{trans('app.recharge')}}</a></div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="profile-item">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img">
                                    <img src="{{$company->image ? thumbnail($company->image->path, 'single_center') : asset('assets/images/default-avater.jpeg')}}"
                                         alt="{{$company->name}}"></div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.chances.company_name')}}</div>
                                            <div class="one_xlarg">{{$company->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.phone_number')}}</div>
                                            <div class="one_xlarg tel">{{$company->phone_number or '--'}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.mobile_number')}}</div>
                                            <div class="one_xlarg tel">{{$company->mobile_number or '--' }}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.address')}}</div>
                                            <div class="one_xlarg">{{$company->address or '--'}}</div>
                                        </li>
                                    </ul>
                                </div>

                                @if(fauth()->user()->is_owner)
                                    <div class="text-left">
                                        <div class="form-group-lg">
                                            <button type="button" data-toggle="modal"
                                                    data-target="#profile_updates" class="uperc padding-md fbutcenter">
                                                {{trans('app.profile_update')}}
                                            </button>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="feildcont">
                                <h3>{{trans('app.about_company')}}</h3>
                                <div class="form-group-lg"><p>{{$company->details or '--'}}</p></div>
                        </div>
                    </div>
                    <div class="profile-item profile-attch">
                        <h3>{{trans('app.company_files')}}</h3>

                        <ul>
                            @foreach($company->files as $file)
                                <li><a target="_blank" href="{{uploads_url('').$file->path}}">{{$file->title}}</a></li>
                            @endforeach
                        </ul>
                        @if(count($company->files)==0)
                            <p>{{trans('app.not_attachments')}}</p>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="profile_updates" tabindex="-1" role="dialog" aria-labelledby="profile_updates"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> {{trans('app.profile_update')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('company.updates',['id'=>$company->id])}}" method="post"
                      enctype="multipart/form-data">
                    <div class="modal-body">
                        {{csrf_field()}}

                        <div class="">

                            <div class="feildcont">
                                <div class="form-group-lg row">
                                    @if ($errors->any()&&Request::old('name',null))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                &times;
                                            </button>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.fields.name')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input name="name"
                                                       value="{{Request::old('name',$company->name)}}"
                                                       type="text"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.fields.name')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.address')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input name="address" value="{{old('address',$company->address)}}"
                                                       type="text"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.address')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.phone_number')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input name="phone_number" type="text"
                                                       value="{{Request::old('phone_number',$company->phone_number)}}"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.phone_number')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xs-12 col-md-3"> {{trans('app.sectors.sector')}}</label>
                                    <div class="col-xs-12 col-md-9 new-f-group">
                                        <div class="form-group clearfix">
                                            <select type="text" class="effect-9 form-control" name="sector_id">
                                                <option value="0">{{trans('app.sectors.select')}}</option>
                                                @foreach($sectors as $sector)
                                                    <option value="{{$sector->id}}" {{old('sector_id',$company->sector_id) == $sector->id ? 'selected' : ""}}>{{$sector->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.company_details')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                <textarea name="details" class="effect-9 form-control" rows="8"
                                          placeholder="{{trans('app.company_more')}}...">{{old('details',$company->details)}}</textarea>
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.add_logo_new')}} </label>
                                    <div class="new-f-group col-xs-12 col-md-5">
                                        <div class="form-group"
                                             @if($company->image)
                                             style="background: url({{thumbnail($company->image->path, 'single_center')}})  no-repeat  center"
                                                @endif>
                                            <div class=" file-upload" data-input-name="logo"
                                                 data-unodz-callback="callback()">
                                            </div>
                                            <p id="logo_error" style="display: none"
                                               class="text-danger">{{trans('app.logo_error')}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg">
                                    <label>{{trans('app.attachments_company_add')}}</label>
                                    <div class="row">
                                        <label for="upload"
                                               class="col-xs-12 col-md-1">{{trans('app.file')}} </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"
                                               placeholder="{{trans('app.choose_file')}}">
                                    </div>

                                    <div class="row">
                                        <label for="upload"
                                               class="col-xs-12 col-md-1"> {{trans('app.file')}} </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"
                                               placeholder="{{trans('app.choose_file')}}">
                                    </div>
                                    <div class="append"></div>

                                    <a class="add_field_button" id="addmore" role="button"
                                       aria-expanded="false" aria-controls="collapseExample"><i
                                                class="fa fa-plus"></i>{{trans('app.upload_more_files')}}</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary">{{trans('app.profile_update')}}</button>
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{trans('app.close')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <style>
        .form-group {
            position: relative;
        }

        .file-upload:hover .message {
            color: whitesmoke;
            display: none;
        }

        .file-upload .drop-click-zone {
            width: 98%;
            height: 165px;
            position: absolute;
            z-index: 90;
        }
    </style>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            UnoDropZone.init();
            $('#addmore').on('click', function () {
                $("<div class=\"row\">\n" +
                    "                                        <label for=\"upload\" class=\"col-xs-12 col-md-1\">{{trans('app.file')}} </label>\n" +
                    "                                        <input id=\"\" class=\"col-xs-12 col-md-11\" type=\"file\" name=\"files[]\"\n" +
                    "                                               placeholder=\"{{trans('app.choose_file')}}\">\n" +
                    "                                    </div>").insertBefore('.append');
            })
            @if ($errors->any()&&Request::old('name',null))
            $('#profile_updates').modal('toggle')
            @endif
        });
    </script>

    <script>
        $(".toggle-password").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password2").click(function () {
            $(this).toggleClass("fa-eye fa-eye  fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password3").click(function () {
            $(this).toggleClass("fa-eye fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush