@extends('layouts.master')

@section('title')
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center">{{trans('app.add_chance')}}</h2>
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
                                <label class="col-xs-12 col-md-3"> {{trans('app.chances.chance_name')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{@Request::old("name")}}" name="name"
                                                   class="effect-9 form-control" placeholder=" {{trans('app.chances.chance_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.chances.internal_number')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="number" value="{{@Request::old("number")}}" type="text"
                                                   placeholder="{{trans('app.chances.internal_number')}}" class="effect-9 form-control">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.chances.chance_value')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="chance_value" value="{{@Request::old("chance_value")}}"
                                                   type="text"
                                                   placeholder="{{trans('app.chances.chance_value_example')}}"
                                                   class="effect-9 form-control">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.chances.closing_date')}}</label>
                                <div class="col-xs-12 col-md-6 new-f-group">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                             data-date-format="dd-mm-yyyy">
                                            <input name="closing_date" data-date-format="dd-mm-yyyy"
                                                   class="effect-9 form-control" id="date" placeholder="dd-mm-yyyy"
                                                   type="text">
                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.sectors.sector')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="sector_id" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.sectors.choose_sector')}}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.file_name')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="file_name" value="{{@Request::old("file_name")}}" type="text"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.file_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.file_description')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="file_description" value="{{@Request::old("file_description")}}"
                                                   type="text" class="effect-9 form-control"
                                                   placeholder="{{trans('app.file_description')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg ">
                                <label for="upload" class="col-xs-12 col-md-3">{{trans('app.add_file')}}</label>
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
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="units_name[]" class="effect-9 form-control"
                                                   placeholder="{{trans('app.unit_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="units[]" type="text" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.units.unit')}}</option>

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
                                                   placeholder="{{trans('app.quantity')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="add_field_button" role="button" data-toggle="collapse" id="units"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                {{trans('app.add_new_units')}}
                            </a>
                            <a id="others" class="add_field_button" style="margin-right: 20px" role="button" data-toggle="collapse"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                {{trans('app.add_other_units')}}
                            </a>
                        </div>
                        <div class="form-group-lg text-center">
                            <button type="submit" class="uperc padding-md fbutcenter">{{trans('app.chances.publish')}}</button>
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
            });
            $('#others').on('click', function () {
                $('                            <div class="form-group-lg row">\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="others_name[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.unit_name')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4 new-f-group">\n' +
                    '                                    <div class="form-group clearfix">\n' +
                    '                                        <input type="text" name="others_units[]" class="effect-9 form-control"\n' +
                    '                                               placeholder="{{trans('app.the_unit')}}">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="others_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n').insertBefore('#units')
            })
            $('#units').on('click',function () {
                $(' <div class="form-group-lg row">\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="units_name[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.unit_name')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4 new-f-group">\n' +
                    '                                    <div class="form-group clearfix">\n' +
                    '                                        <select name="units[]" type="text" class="effect-9 form-control">\n' +
                    '                                            <option value="{{null}}">{{trans('app.units.unit')}}</option>\n' +
                    '                                            @foreach($units as $unit)\n' +
                    '                                                <option value="{{$unit->id}}">{{$unit->name}}</option>\n' +
                    '                                            @endforeach\n' +
                    '                                        </select><span class="focus-border"><i></i></span>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="units_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>').insertBefore('#units')
            })
        </script>
    @endpush
@endsection
