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
                            <label class="col-xs-12 col-md-3">الاسم الاول</label>
                            <div class="col-xs-12 col-md-9">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input name="first_name" type="text" class="effect-9 form-control" placeholder="الاسم الاول">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">الاسم الثانى</label>
                            <div class="col-xs-12 col-md-9">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input name="last_name" type="text" class="effect-9 form-control" placeholder="الاسم الثانى">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">اسم المستخدم </label>
                            <div class="col-xs-12 col-md-9">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input name="name" type="text" class="effect-9 form-control" placeholder="اسم المستخدم ">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">البريد الالكترونى</label>
                            <div class="col-xs-12 col-md-9">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-envelope"></i></span>
                                        <input name="email" type="email" class="effect-9 form-control"
                                               placeholder="البريد الالكترونى">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3">كلمة المرور </label>
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
                            <label class="col-xs-12 col-md-3">تاكيد كلمة المرور</label>
                            <div class="new-f-group col-xs-12 col-md-9">
                                <div class="form-group">
                                    <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                           toggle="#password-field2"></i></span>
                                    <input type="password" class="effect-9 form-control" id="password-field2"
                                           placeholder="***">
                                    <span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg row">
                            <label class="col-xs-12 col-md-3"></label>
                            <div class="col-xs-12 col-md-9">
                                <label class="radio-inline"> فرد</label>
                                <input type="radio" name="user_type" value="1" onclick="show1();">

                                <label class="radio-inline">شركة</label>
                                <input type="radio" name="user_type" value="2" onclick="show2();">
                            </div>
                        </div>
                    </div>
                    <div id="compres" class="hidd">
                        <div class="reg-part">
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> القطاع</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control" name="sector_id">
                                            <option value="0">اختار القطاع</option>
                                          @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">تفاصيل الشركة </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <textarea name="details" class="effect-9 form-control" rows="8"
                                                      placeholder="المزيد عن الشركة ..."></textarea>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">اضافة اللوجو </label>
                                <div class="col-xs-12 col-md-4">
                                    <div class="file-upload" data-input-name="input1"></div>
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <div class="file-upload1">
                                        <label for="upload" class="file-upload__label">تحميل اللوجو</label>
                                        <input id="upload" class="file-upload__input" type="file" name="logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg">
                                <label>مرفقات اواراق الشركة</label>
                                <div class="row">
                                    <label for="upload" class="col-xs-12 col-md-1">مرفق </label>
                                    <input id="" class="col-xs-12 col-md-11" type="file" name="files[]"
                                           placeholder="Choose">
                                </div>

                                <div class="row">
                                    <label for="upload" class="col-xs-12 col-md-1"> مرفق </label>
                                    <input id="" class="col-xs-12 col-md-11" type="file" name="files[]">
                                </div>

                                <a class="add_field_button" role="button" data-toggle="collapse" href="#collapseExample"
                                   aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                    تحميل المزيد من المرفقات</a>

                                <div class="clearfix collapse" id="collapseExample" aria-expanded="true" style="">
                                    <div class="row">
                                        <label for="upload" class="col-xs-12 col-md-1">مرفق </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]">
                                    </div>
                                    <div class="row">
                                        <label for="upload" class="col-xs-12 col-md-1">مرفق </label>
                                        <input id="" class="col-xs-12 col-md-11" type="file" name="files[]">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group-lg text-center">
                        <button type="submit"  class="uperc padding-md fbutcenter"> تسجيل</button>
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

