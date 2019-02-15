@extends('layouts.master')

@section('title',trans('app.tenders.tenders'))
@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])

            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    <h2 class="text-center">{{trans('app.add_employee')}} </h2>
                    <div class="feildcont">
                        <form action="" method="post">
                            {{csrf_field()}}

                            <div class="form-group-lg row">
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
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.fields.name')}} *</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-user"></i></span>
                                            <input name="name" value="{{Request::old('name')}}" type="text"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.fields.name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}} *</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-envelope"></i></span>
                                            <input name="email" type="email" value="{{Request::old('email')}}"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.fields.email')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.fields.password')}} *</label>
                                <div class="new-f-group col-xs-12 col-md-9">
                                    <div class="form-group">
                                        <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                               toggle="#password-field"></i></span>
                                        <input name="password" type="password" class="effect-9 form-control"
                                               id="password-field"
                                               placeholder="{{trans('app.fields.password')}} ">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.fields.repassword')}} *</label>
                                <div class="new-f-group col-xs-12 col-md-9">
                                    <div class="form-group">
                                    <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                           toggle="#password-field2"></i></span>
                                        <input name="password_confirmation" type="password"
                                               class="effect-9 form-control" id="password-field2"
                                               placeholder="{{trans('app.fields.repassword')}}">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-lg row">
                                <div class="col-md-4">

                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" value="1" {{old('can_pay')==1?'checked':''}} name="can_pay"
                                           class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">{{trans('app.can_pay')}}</label>
                                </div>
                            </div>

                            <div class="form-group-lg row text-center">
                                <button type="submit" class="uperc padding-md fbutcenter">
                                    {{trans('app.add_employee')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
    </script>
@endpush