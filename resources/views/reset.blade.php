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
                <form method="post" action="{{route('reset-password')}}">
                    {{csrf_field()}}
                    <div class="form-group-lg row" style="display: {{!Request::filled('key')?'block':'none'}}">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-user"></i></span>
                                    <input name="email" type="{{!Request::filled('key')?'email':'hidden'}}"
                                           class="effect-9 form-control"
                                           placeholder="{{trans('app.fields.email')}}"
                                           value="{{Request::filled('key')?  \Crypt::decryptString(urldecode(Request::get('key'))) : session()->get('email')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg row"  style="display: {{!Request::filled('code')?'block':'none'}}">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.code')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-text-height"></i></span>
                                    <input name="code" type="text" class="effect-9 form-control"
                                           placeholder="{{trans('app.fields.code')}}" value="{{Request::get('code')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.password')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-eye"></i></span>
                                    <input name="password" type="text" class="effect-9 form-control"
                                           placeholder="{{trans('app.fields.password')}}">
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
                </form>
                    <div class="form-group text-center">
                        <a style="text-decoration: none;" href="{{route('forget-password')}}">
                            <button class="padding-md fbutcenter width"> {{trans('app.resend_code')}}</button>
                        </a>
                    </div>
            </div>
        </div>
    </section>
@endsection
