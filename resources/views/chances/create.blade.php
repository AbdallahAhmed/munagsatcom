@extends('layouts.master')

@section('title')
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center"> اضافة فرصة </h2>
            <div class="feildcont">
                @if (!session('status'))
                    <form method="post" action="{{route('chances.create', ['id' => $company->id])}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="reg-part">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="alert-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> اسم الفرصه </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{@Request::old("name")}}" name="name"
                                                   class="effect-9 form-control" placeholder="اسم الفرصه  ">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> الرقم المرجعى الداخلى </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="number" value="{{@Request::old("number")}}" type="text"
                                                   class="effect-9 form-control">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> قيمة الفرصة </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="chance_value" value="{{@Request::old("chance_value")}}"
                                                   type="text"
                                                   class="effect-9 form-control">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> تاريخ الاغلاق </label>
                                <div class="col-xs-12 col-md-6 new-f-group">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                             data-date-format="dd-mm-yyyy">
                                            <input name="closing_date" data-date-format="dd-mm-yyyy"
                                                   class="effect-9 form-control" id="date" placeholder="dd/mm/yyyy"
                                                   type="text">
                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-xs-12 col-md-3"> صباحا/مساءا </label>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> القطاع</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="sector_id" class="effect-9 form-control">
                                            <option value="{{null}}">اختار القطاع</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> اسم الملف </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="file_name" value="{{@Request::old("file_name")}}" type="text"
                                                   class="effect-9 form-control"
                                                   placeholder="اسم الفرصه  ">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> تفاصيل الملف </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="file_description" value="{{@Request::old("file_description")}}"
                                                   type="text" class="effect-9 form-control"
                                                   placeholder="">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg ">
                                <label for="upload" class="col-xs-12 col-md-3"> اضافة مرفق </label>
                                <input id="" class="col-xs-12 col-md-9" type="file" name="file">
                            </div>
                            {{--
                            <a class="add_field_button" role="button" data-toggle="collapse" href="#collapseExample"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i> اضافة المزيد
                                من الملفات</a>
                            <div class="clearfix collapse" id="collapseExample" aria-expanded="true" style="">
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3"> اسم الملف </label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input type="text" class="effect-9 form-control" placeholder="اسم الفرصه  ">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3"> تفاصيل الملف </label>
                                    <div class="col-xs-12 col-md-9">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input type="text" class="effect-9 form-control" placeholder="">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg ">
                                    <label for="upload" class="col-xs-12 col-md-3"> اضافة مرفق </label>
                                    <input id="" class="col-xs-12 col-md-9" type="file" name="file-upload1">
                                </div>
                            </div>--}}
                        </div>
                        <div class="reg-part">
                            <h3> الوحدات </h3>
                            <div class="form-group-lg row">

                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="units[]" type="text" class="effect-9 form-control">
                                            <option value="{{null}}">وحدة القياس</option>

                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="units_quantity[]" class="effect-9 form-control"
                                                   placeholder="الكمية">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="units[]" type="text" class="effect-9 form-control">
                                            <option value="{{null}}">وحدة القياس</option>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="units_quantity[]" class="effect-9 form-control"
                                                   placeholder="الكمية">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="add_field_button" role="button" data-toggle="collapse" href="#collapseExample2"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i> اضافة
                                المزيد
                                من الوحدات</a>
                            <div class="clearfix collapse" id="collapseExample2" aria-expanded="true" style="">
                                <div class="form-group-lg row">

                                    <div class="col-xs-12 col-md-4 new-f-group">
                                        <div class="form-group clearfix">
                                            <select type="text" name="units[]" class="effect-9 form-control">
                                                <option value="{{null}}">وحدة القياس</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input type="text" name="units_quantity[]" class="effect-9 form-control"
                                                       placeholder="الكمية">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <div class="col-xs-12 col-md-4 new-f-group">
                                        <div class="form-group clearfix">
                                            <select type="text" name="units[]" class="effect-9 form-control">
                                                <option value="{{null}}">وحدة القياس</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="new-f-group">
                                            <div class="form-group clearfix">
                                                <input type="text" name="units_quantity[]" class="effect-9 form-control"
                                                       placeholder="الكمية">
                                                <span class="focus-border"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-lg text-center">
                            <button type="submit" class="uperc padding-md fbutcenter"> نشر الفرصه</button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

    </section>
    @push('scripts')
        <script>
            $('#dp3').datepicker({
                dateFormat: "dd-mm-yyy"
            });
            $('#date').datepicker({
                dateFormat: "dd-mm-yyy"
            });        </script>
    @endpush
@endsection
