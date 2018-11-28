@extends('layouts.master')

@section('title',trans('app.register'))

@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center">{{trans('app.register')}}</h2>
            <div class="feildcont">
                <form method="POST" action="{{route('register')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="reg-part">
                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">{{trans('app.fields.first_name')}}</label>
                            <div class="col-xs-12 col-md-9">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input name="first_name" type="text" class="effect-9 form-control" placeholder="{{trans('app.fields.first_name')}}">
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
                                        <input name="last_name" type="text" class="effect-9 form-control" placeholder="{{trans('app.fields.last_name')}}">
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
                                        <span class="icony"><i class="fa fa-envelope"></i></span>
                                        <input name="email" type="email" class="effect-9 form-control"
                                               placeholder="{{trans('app.fields.email')}}">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">{{trans('app.fields.password')}} </label>
                            <div class="new-f-group col-xs-12 col-md-9">
                                <div class="form-group">
                                    <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye" toggle="#password-field"></i></span>
                                    <input name="password" type="password" class="effect-9 form-control" id="password-field"
                                           placeholder="{{trans('app.fields.password')}} ">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">{{trans('app.fields.repassword')}}</label>
                            <div class="new-f-group col-xs-12 col-md-9">
                                <div class="form-group">
                                    <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye" toggle="#password-field2"></i></span>
                                    <input type="password" class="effect-9 form-control" id="password-field2"
                                           placeholder="{{trans('app.fields.repassword')}}">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3"></label>
                            <div class="col-xs-12 col-md-9">
                                <label class="radio-inline"> {{trans('app.personal')}}</label>
                                <input type="radio" name="user_type" value="1" onclick="show1();" checked>

                                <label class="radio-inline"> {{trans('app.company')}}</label>
                                <input type="radio" name="user_type" value="2" onclick="show2();">
                            </div>
                        </div>
                    </div>
                    <div id="compres" class="hidd">
                        <div class="reg-part">
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.sectors.sector')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control" name="sector_id">
                                            <option value="0">{{trans('app.sectors.select')}}</option>
                                          @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
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
                                                      placeholder="{{trans('app.company_more')}} ..."></textarea>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.add_logo')}} </label>
                                <div class="col-xs-12 col-md-4">
                                    <div class="file-upload" data-input-name="input1"></div>
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <div class="file-upload1">
                                        <label for="upload" class="file-upload__label">{{trans('app.upload_logo')}}</label>
                                        <input id="upload" class="file-upload__input" type="file" name="logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg">
                                <label>{{trans('app.attachments_company')}}</label>
                                <div class="row">
                                    <label for="upload" class="col-xs-12 col-md-1">{{trans('app.file')}} </label>
                                    <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"
                                           placeholder="{{trans('app.choose_file')}}">
                                </div>

                                <div class="row">
                                    <label for="upload" class="col-xs-12 col-md-1"> {{trans('app.file')}} </label>
                                    <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"  placeholder="{{trans('app.choose_file')}}">
                                </div>

                                <a class="add_field_button" role="button" data-toggle="collapse" href="#collapseExample"
                                   aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                    تحميل المزيد من المرفقات</a>

                                <div class="clearfix collapse" id="collapseExample" aria-expanded="true" style="">
                                    <div class="row">
                                        <label for="upload" class="col-xs-12 col-md-1">{{trans('app.file')}} </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"  placeholder="{{trans('app.choose_file')}}" >
                                    </div>
                                    <div class="row">
                                        <label for="upload" class="col-xs-12 col-md-1">{{trans('app.file')}} </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"  placeholder="{{trans('app.choose_file')}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg text-center">
                        <button type="submit"  class="uperc padding-md fbutcenter">{{trans('app.register')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

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
    </script>

    <script>
        function show1() {
            document.getElementById('compres').style.display = 'none';
        }

        function show2() {
            document.getElementById('compres').style.display = 'block';
        }
    </script>
@endpush

