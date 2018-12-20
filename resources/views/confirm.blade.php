@extends('layouts.master')

@section('title',trans('app.register'))

@section('content')
    <section class="container">
        <div class="signin row">

            <div class="feildcont">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="post" action="{{route('user.verify')}}">
                    {{csrf_field()}}
                                    <input name="email" type="hidden" class="effect-9 form-control"
                                           value="{{$email}}">

                    <input name="password" type="hidden" class="effect-9 form-control"
                                           value="{{$password}}">

                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.code')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-text-height"></i></span>
                                    <input name="code" type="text" class="effect-9 form-control"
                                           placeholder="{{trans('app.fields.code')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($errors->any())
                        <div class="text-center">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><p>{{ $error }}</p></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group-lg text-center">
                        <button type="submit" class="padding-md fbutcenter width"> {{trans('app.enter')}}</button>
                    </div>
                    <div class="form-group text-center">
                        <a style="text-decoration: none;" href="{{route('forget-password')}}">
                            <button class="padding-md fbutcenter width"> {{trans('app.resend_code')}}</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection