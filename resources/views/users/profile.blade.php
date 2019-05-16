@extends('layouts.master')

@section('title',$user->name)

@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

                    @if(!fauth()->user()->in_company)
                        <div class="profile-circle">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="circle-item">
                                        <p>{{trans('app.current_points')}}</p>
                                        <div class="num">{{$user->points}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="circle-item">
                                        <p>{{trans('app.spent_points')}}</p>
                                        <div class="num"> {{$user->spent_points}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="profile-item">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img"><img
                                            src="{{$user->photo ? thumbnail($user->photo->path, 'single_center') : asset('assets/images/default-avater.jpeg')}}"
                                            alt=""></div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.fields.name')}}</div>
                                            <div class="one_xlarg">{{$user->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.fields.username')}}</div>
                                            <div class="one_xlarg">{{$user->username}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.fields.phone_number')}}</div>
                                            <div class="one_xlarg tel">{{$user->phone_number or '--'}}</div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="text-left">
                                    <div class="form-group-lg">
                                        <button type="button" data-toggle="modal"
                                                data-target="#profile_updates" class="uperc padding-md fbutcenter">
                                            {{trans('app.profile_update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="feildcont">
                            <form name="password" method="post"
                                  action="{{route('user.update')}}">
                                {{csrf_field()}}
                                <h3>{{trans('app.update_password')}}</h3>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.current_password')}}</label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field3"></i></span>
                                            <input name="current_password" type="password" class="effect-9 form-control"
                                                   id="password-field3"
                                                   placeholder="{{trans('app.current_password')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.new_password')}}</label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field"></i></span>
                                            <input name="password" type="password" class="effect-9 form-control"
                                                   id="password-field"
                                                   placeholder="{{trans('app.new_password')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.confirm_password')}}</label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field2"></i></span>
                                            <input name="password_confirmation" type="password"
                                                   class="effect-9 form-control" id="password-field2"
                                                   placeholder="{{trans('app.confirm_password')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->any() && !Request::old('first_name'))
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
                                <div class="text-left">
                                    <div class="form-group-lg">
                                        <button type="submit" class="uperc padding-md fbutcenter">
                                            {{trans('app.update_password')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                <form action="{{route('user.profile.update')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{csrf_field()}}

                        <div class="">

                            <div class="feildcont">
                                <div class="form-group-lg row">
                                    @if ($errors->any()&&Request::old('first_name',null))
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
                                    <label class="col-xs-12 col-md-3">{{trans('app.fields.first_name')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <span class="icony"><i class="fa fa-user"></i></span>
                                                <input name="first_name"
                                                       value="{{Request::old('first_name',$user->first_name)}}"
                                                       type="text"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.fields.first_name')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.fields.last_name')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <span class="icony"><i class="fa fa-user"></i></span>
                                                <input name="last_name"
                                                       value="{{Request::old('last_name',$user->last_name)}}"
                                                       type="text"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.fields.last_name')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}}</label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <span class="icony"><i class="fa fa-user"></i></span>
                                                <input name="email"
                                                       value="{{Request::old('email',$user->email)}}"
                                                       type="text"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.fields.email')}}">
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
                                                <span class="icony"><i class="fa fa-mobile"></i></span>
                                                <input name="phone_number" type="text"
                                                       value="{{Request::old('phone_number',$user->phone_number)}}"
                                                       class="effect-9 form-control"
                                                       placeholder="{{trans('app.phone_number')}}">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.add_logo_new')}} </label>
                                    <div class="new-f-group col-xs-12 col-md-5">
                                        <div class="form-group"
                                             @if($user->photo)
                                             style="background: url({{thumbnail($user->photo->path, 'single_center')}})  no-repeat  center"
                                                @endif
                                        >
                                            <div class=" file-upload" data-input-name="logo"
                                                 data-unodz-callback="callback()">
                                            </div>
                                            <p id="logo_error" style="display: none"
                                               class="text-danger">{{trans('app.logo_error')}}</p>
                                        </div>
                                    </div>
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


            @if ($errors->any()&&Request::old('first_name',null))
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
