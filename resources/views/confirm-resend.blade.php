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
                <form method="post" action="{{route('user.confirm-resend')}}">
                    {{csrf_field()}}
                    <div class="form-group-lg row">
                        <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}} </label>
                        <div class="col-xs-12 col-md-9">
                            <div class="new-f-group">
                                <div class="form-group clearfix">
                                    <span class="icony"><i class="fa fa-user"></i></span>
                                    <input name="email" type="email" class="effect-9 form-control"
                                           placeholder="{{trans('app.fields.email')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($errors->any())
                        <div class="text-center">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><p >{{ $error }}</p></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group-lg text-center">
                        <button type="submit" class="padding-md fbutcenter width"> {{trans('app.send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection