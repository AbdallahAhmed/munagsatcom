@extends('layouts.master')

@section('title',trans('app.add_chance'))
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center">{{trans('chances.edit')}}</h2>
            <div class="feildcont">
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="post" id="form-submit"
                      action="{{route('chances.update', ['id' => $company->id, 'center_id' => $chance->id])}}"
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
                                        <input type="text" value="{{@Request::old("name", $chance->name)}}"
                                               name="name"
                                               class="effect-9 form-control">
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
                                        <input name="number" value="{{@Request::old("number", $chance->number)}}"
                                               type="text"
                                               placeholder="{{trans('app.chances.internal_number')}}"
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
                                               class="effect-9 form-control" id="date"
                                               placeholder="dd-mm-yyyy"
                                               type="text"
                                               value="{{DateTime::createFromFormat('Y-m-d H:i:s', $chance->closing_date)->format("Y-m-d")}}">
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
                                            <option value="{{$sector->id}}" {{(old('sector_id')==$sector->id || $chance->sector_id == $sector->id)?'selected':''}}>{{$sector->name}}</option>
                                        @endforeach
                                    </select><span class="focus-border"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reg-part">
                        <h3>    {{trans('chances.attributes.files')}}</h3>
                        @foreach($files as $file)
                            <div class="form-group-lg row" id="row{{$file->pivot->file_name}}">
                                <div class="col-xs-8 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <p>
                                                {{$file->pivot->file_name}}
                                            </p>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <a href="{{uploads_url().$file->path}}"
                                               target="_blank">{{$file->title}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <p data-name="{{$file->pivot->file_name}}" data-id="{{$file->id}}"
                                               id="removefile" class="btn btn-danger"
                                               style="cursor: pointer"><i class="fa fa-remove"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <input id="deleted_files" name="deleted_files[]" style="display: none" type="text">
                        <a class="add_field_button" role="button" data-toggle="collapse" id="filess"
                           aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                            {{trans('app.add_file')}}
                        </a>
                    </div>
                    <div class="reg-part">
                        <h3>    {{trans('app.units.units')}}</h3>
                        @foreach($chance->units as $unit)
                            <div class="form-group-lg row" id="unit{{$unit->pivot->id}}">
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input value="{{$unit->pivot->name}}" type="text" name="units_name[]"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.unit_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="units[]" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.units.unit')}}</option>

                                            @foreach($units as $un)
                                                <option {{$un->id == $unit->id ? 'selected' : ''}} value="{{$un->id}}">{{$un->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input value="{{$unit->pivot->quantity}}" type="text"
                                                   name="units_quantity[]"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.quantity')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <p data-id="{{$unit->pivot->id}}"
                                               id="removeUnit" class="btn btn-danger"
                                               style="cursor: pointer"><i class="fa fa-remove"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($otherUnits as $unit)
                            <div class="form-group-lg row" id="unit{{$unit->id}}">
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="others_name[]" class="effect-9 form-control"
                                                   placeholder="{{trans('app.unit_name')}}" value="{{$unit->name}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <input type="text" name="others_units[]" class="effect-9 form-control"
                                               placeholder="{{trans('app.the_unit')}}" value="{{$unit->unit}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="others_quantity[]" class="effect-9 form-control"
                                                   placeholder="{{trans('app.quantity')}}" value="{{$unit->quantity}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <p data-id="{{$unit->id}}" id="removeUnit" class="btn btn-danger"
                                               style="cursor: pointer"><i class="fa fa-remove"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <a class="add_field_button" role="button" data-toggle="collapse" id="units"
                           aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                            {{trans('app.add_new_units')}}
                        </a>
                        <a id="others" class="add_field_button" style="margin-right: 20px" role="button"
                           data-toggle="collapse"
                           aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                            {{trans('app.add_other_units')}}
                        </a>
                    </div>
                    <div class="form-group-lg text-center">
                        <button type="submit"
                                class="uperc padding-md fbutcenter">{{trans('chances.edit')}}</button>
                    </div>
                </form>
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
            unitId = "{{\Illuminate\Support\Facades\DB::table('chances_units')->get()->last()->id}}"
            $('#others').on('click', function () {
                unitId++;
                $('                            <div class="form-group-lg row" id="unit' + unitId + '">\n' +
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
                    '                                <div class="col-xs-12 col-md-2">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="others_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-2">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <p data-id="' + unitId + '"\n' +
                    '                                                id="removeUnit" class="btn btn-danger"\n' +
                    '                                                style="cursor: pointer"><i class="fa fa-remove"></i></p>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n').insertBefore('#units')
            })
            $('#units').on('click', function () {
                unitId++;
                $(' <div class="form-group-lg row" id="unit' + unitId + '">\n' +
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
                    '                                <div class="col-xs-12 col-md-2">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="units_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                               <div class="col-xs-12 col-md-2">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <p data-id="' + unitId + '"\n' +
                    '                                                id="removeUnit" class="btn btn-danger"\n' +
                    '                                                style="cursor: pointer"><i class="fa fa-remove"></i></p>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>').insertBefore('#units')
            })
            id = "{{\Dot\Media\Models\Media::orderBy('created_at', 'DESC')->first()->id}}"
            $('#filess').on('click', function () {
                id++;
                $('  <div class="form-group-lg row" id="row' + id + '">\n' +
                    '                                    <div class="col-xs-8 col-md-4">\n' +
                    '                                        <div class="new-f-group">\n' +
                    '                                            <div class="form-group clearfix">\n' +
                    '                                                <input id="name' + id + '" type="text"\n' +
                    '                                                        name="new_names[]"\n' +
                    '                                                       class="effect-9 form-control"\n' +
                    '                                                       placeholder="{{trans('app.file_data')}}">\n' +
                    '                                                <span class="focus-border"><i></i></span>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                    <input style="display: none" name="new_files[]" type="file" id="file' + id + '">\n' +
                    '                                    <div class="col-xs-8 col-md-2">\n' +
                    '                                        <div class="new-f-group">\n' +
                    '                                            <div class="form-group clearfix">\n' +
                    '                                                <a id="target' + id + '"\n' +
                    '                                                   target="_blank"></a>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="col-xs-6 col-md-4">\n' +
                    '                                        <div class="new-f-group">\n' +
                    '                                            <div class="form-group clearfix">\n' +
                    '                                                <p id="change' + id + '" data-id="' + id + '"\n' +
                    '                                                   class="btn btn-primary change"\n' +
                    '                                                   style="cursor: pointer">{{trans('chances.add_file')}}<i\n' +
                    '                                                            class="fa fa-edit"></i></p>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="col-xs-4 col-md-2">\n' +
                    '                                        <div class="new-f-group">\n' +
                    '                                            <div class="form-group clearfix">\n' +
                    '                                                <p data-name="" data-id="' + id + '" id="removefile" class="btn btn-danger"\n' +
                    '                                                   style="cursor: pointer"><i class="fa fa-remove"></i></p>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>').insertBefore('#filess')
            })
            $(document).on('click', '#removefile', function () {
                if ($(this).data('name')) {
                    $('<input name="deleted_files[]" style="display: none" value="' + $(this).data('name') + '" type="text">').insertBefore($('#deleted_files'));
                    $('<input name="deleted_media[]" style="display: none" value="' + $(this).data('id') + '" type="text">').insertBefore($('#deleted_files'));
                    $('#row' + $(this).data('name')).remove();
                } else
                    $('#row' + $(this).data('id')).remove();

            })
            $(document).on('click', '#removeUnit', function () {
                $('#unit' + $(this).data('id')).remove();

            })
            let fileId = 1;
            $(document).on('click', '.change', function () {
                fileId = $(this).data('id');
                $('#file' + fileId).trigger('click');
            })

            $(document).on('change', '[id^=file]', function () {
                file = this.files[0];
                $('#target' + fileId).html(file.name);
                $('#change' + fileId).html("{{trans('chances.change_file')}}" + '<i class="fa fa-edit"></i>');
            })
        </script>
    @endpush
@endsection
