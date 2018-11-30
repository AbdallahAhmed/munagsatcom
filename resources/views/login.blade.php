@extends('layouts.master')

@section('title',trans('app.register'))

@section('content')
    <section class="container">
        <div class="signin row">
            <div class="signin-img">
                <i class="fa fa-5x fa-fw fa-user-circle"></i>
            </div>
            <div class="feildcont">
                <form method="post" action="{{route('login')}}">
                    {{csrf_field()}}
                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.username')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-user"></i></span>
                                    <input name="username" type="text" class="effect-9 form-control" placeholder="{{trans('app.fields.username')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.password')}}</label>
                        <div class="new-f-group col-xs-12 col-md-9">
                            <div class="form-group">
                                <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                       toggle="#password-field"></i></span>
                                <input name="password" type="password" class="effect-9 form-control" id="password-field"
                                       placeholder="***">
                                <span class="focus-border"><i></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3"></label>
                        <div class="col-xs-12 col-md-9">
                            <label class="radio-inline"> {{trans('app.personal')}}</label>
                            <input type="radio" name="user_type" value="1" onclick="show1();">

                            <label class="radio-inline">{{trans('app.company')}}</label>
                            <input type="radio" name="user_type" value="2" onclick="show2();">
                        </div>
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <div class="form-group-lg text-center">
                        <button type="submit" class="padding-md fbutcenter width"> دخول</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @push('scripts')
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
        </script>
    @endpush
@endsection