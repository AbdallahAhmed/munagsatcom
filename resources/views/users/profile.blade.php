@extends('layouts.master')

@section('title',$user->name)

@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    <div class="profile-item">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img"><img src="{{$user->photo ? thumbnail($user->photo->path, 'single_center') : asset('assets/images/avatar.jpg')}}" alt=""></div>
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
                                            <div class="one_xlarg tel">{{$user->phone_number}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.fields.mobile_number')}}</div>
                                            <div class="one_xlarg tel">{{$user->mobile_number}}</div>
                                        </li>

                                    </ul>
                                </div>
                                {{--<div class="text-left">
                                    <div class="form-group-lg">
                                        <button type="submit" form="" class="uperc padding-md fbutcenter"> تحديث
                                            بيانات
                                        </button>
                                    </div>
                                </div>--}}
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
                                                   placeholder="***">
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
                                                   placeholder="***">
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
                                                   placeholder="***">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->any())
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
    @push('scripts')
        <script>
            $(document).ready(function () {
                UnoDropZone.init();
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
@endsection
