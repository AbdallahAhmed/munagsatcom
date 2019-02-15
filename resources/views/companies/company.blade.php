@extends('layouts.master')

@section('title',$company->slug)

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

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
                            </div>
                        </div>
                    </div>

                    <div class="profile-item profile-attch">
                        <h3>{{trans('app.company_files')}}</h3>

                        <ul>
                            @foreach($company->files as $file)
                                <li><a target="_blank" href="{{uploads_url('').$file->path}}">{{$file->title}}</a></li>
                            @endforeach
                        </ul>
                        @if(empty($company->files))
                            <p>{{trans('app')}}</p>
                        @endif
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