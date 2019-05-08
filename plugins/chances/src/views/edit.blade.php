@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm" enctype="multipart/form-data">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-align-left"></i>
                    {{ $chance ? trans("chances::chances.edit") : trans("chances::chances.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.chances.show") }}">{{ trans("chances::chances.chances") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ trans("chances::chances.edit") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">


                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("chances::chances.save_chance") }}
                </button>

            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="input-name">{{ trans("app.company_name") }}</label>
                                <input name="company_name" type="text"
                                       value="{{ @Request::old("company_name", $chance->company->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("app.company_name") }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="input-name">{{ trans("chances::chances.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $chance->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.name") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-number">{{ trans("chances::chances.attributes.number") }}</label>
                                <input name="number" type="text"
                                       value="{{ @Request::old("number", $chance->number) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.number") }}">
                            </div>
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.closing_date") }}</label>
                                <input name="closing_date" type="date" data-format="YYYY-mm-dd"
                                       value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $chance->closing_date)->format("Y-m-d") }}"
                                       class="chosen-rtl form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.closing_date") }}">
                            </div>
                            {{--<div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.value") }}</label>
                                <input name="value" type="text"
                                       value="{{ @Request::old("value", $chance->value)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.value") }}">
                            </div>--}}
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.files") }}</label>
                                <br>
                                <br>
                                @foreach($chance->files as $file)
                                    <div class="form-group">
                                        <div class="col-md-6">
                                        </div>
                                        <a href="{{uploads_url().$file->path}}"
                                           target="_blank">{{trans("chances::chances.file_download")}}</a>
                                    </div>
                                    <br>
                                @endforeach
                            </div>
                            {{-- <div class="form-group">
                                 <label
                                         for="input-number">{{ trans("chances::chances.attributes.file_name") }}</label>
                                 <input name="file_name" type="text"
                                        value="{{ @Request::old("file_name", $chance->file_name)}}"
                                        class="form-control" id="input-name"
                                        placeholder="{{ trans("chances::chances.attributes.file_name") }}">
                             </div>--}}
                        </div>
                    </div>
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-balance-scale"></i>
                            {{ trans("chances::chances.attributes.units") }}
                            <a class="add-custom-field pull-right" href="javascript:void(0)">
                                <i class="fa fa-plus text-navy"></i>
                            </a>

                        </div>

                        <div class="panel-body">

                            <div class="form-group meta-rows xx">
                                @foreach($units_quantity as $uq)
                                    <div class="meta-row">

                                        <input style="width: 30%" name="units_names[]"
                                               class="form-control input-md pull-left custom-field-value"
                                               placeholder="{{ trans("chances::units.attributes.name") }}"
                                               value="{{$uq->pivot->name}}">

                                        <select style="width: 40%" name="units[]"
                                                class="form-control chosen-rtl pull-left custom-field-name">
                                            @foreach($units as $unit)
                                                @if($unit->id == $uq->id)
                                                    <option value="{{$unit->id}}"
                                                            selected="selected">{{$unit->name}}</option>
                                                @else
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <input style="width: 20%" name="units_quantity[]"
                                               class="form-control input-md pull-left custom-field-value"
                                               placeholder="{{ trans("chances::chances.attributes.quantity") }}"
                                               value="{{$uq->pivot->quantity}}">

                                        <a class="remove-custom-field pull-right" href="javascript:void(0)">
                                            <i class="fa fa-times text-navy"></i>
                                        </a>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    @if(count($other_units) > 0)
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <i class="fa fa-balance-scale"></i>
                                {{ trans("app.other_units") }}
                            </div>

                            <div class="panel-body">

                                <div class="form-group meta-rows">
                                    @foreach($other_units as $unit)
                                        <div class="meta-row">

                                            <input style="width: 30%" name="[]"
                                                   class="form-control input-md pull-left custom-field-value"
                                                   placeholder="{{ trans("chances::units.attributes.name") }}"
                                                   value="{{$unit->name}}">
                                            <input style="width: 30%" name="[]"
                                                   class="form-control input-md pull-left custom-field-value"
                                                   placeholder="{{ trans("chances::units.attributes.name") }}"
                                                   value="{{$unit->unit}}">

                                            <input style="width: 20%" name="[]"
                                                   class="form-control input-md pull-left custom-field-value"
                                                   placeholder="{{ trans("chances::chances.attributes.quantity") }}"
                                                   value="{{$unit->quantity}}">

                                            <a class="custom-field pull-right" data-title="{{$unit->unit}}"
                                               data-name="{{$unit->name}}"
                                               data-quantity="{{$unit->quantity}}"
                                               href="javascript:void(0)">
                                                {{trans('app.create_new')}}<i class="fa fa-plus text-navy"></i>
                                            </a>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("chances::chances.approve") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="approved" class="form-control chosen-select chosen-rtl">
                                    @if($chance->approved == 0)
                                        <option value="0"
                                                selected="selected">{{trans("chances::chances.reject")}}</option>
                                        <option value="1">{{trans("chances::chances.approve")}}</option>
                                    @else
                                        <option value="1"
                                                selected="selected">{{trans("chances::chances.approve")}}</option>
                                        <option value="0">{{trans("chances::chances.reject")}}</option>
                                    @endif
                                </select>
                                <div id="reason"
                                     style="display: @if($chance->approved == 1) none @else block @endif; margin-top: 20px">
                                    <label
                                            for="input-number">{{ trans("chances::chances.attributes.reason") }}</label>
                                    <input name="reason" type="text"
                                           value="{{$chance->reason}}"
                                           class="form-control" id="input-name"
                                           placeholder="{{ trans("chances::chances.attributes.reason") }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("chances::chances.attributes.status_name") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="status" class="form-control chosen-select chosen-rtl">
                                    @foreach($status as $st)
                                        @if($chance->status == $st)
                                            <option value="{{$st}}"
                                                    selected="selected">{{trans("chances::chances.status.$st")}}</option>
                                        @else
                                            <option value="{{$st}}">{{trans("chances::chances.status.$st")}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa fa-th-large"></i>
                            {{ trans("chances::chances.add_sector") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="sector_id" class="form-control chosen-select chosen-rtl">
                                    @foreach(\Dot\Chances\Models\Sector::all() as $sector)
                                        <option
                                                value="{{$sector->id}}" {{ old('sector_id',$sector->id)==$chance->sector_id?'selected':'' }}> {{$sector->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="panel panel-default">
                         <div class="panel-heading">
                             <i class="fa fa-folder"></i>
                             {{ trans("chances::chances.file_download") }}
                         </div>
                         <div class="panel-body">
                             <div class="form-group">
                                 <a href="{{uploads_url().$chance->media->path}}"
                                    target="_blank">{{$chance->file_name}}</a>
                             </div>
                         </div>
                     </div>--}}
                </div>
            </div>
        </div>


    </form>

@stop

@section("head")
    <link href="{{ assets("admin::tagit") }}/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ assets("admin::tagit") }}/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">

    <style>
        .custom-field-name {
            width: 40%;
            margin: 5px;
        }

        .custom-field-value {
            width: 50%;
            margin: 5px;
        }

        .remove-custom-field {
            margin: 10px;
        }

        .custom-field {
            margin: 10px;
        }

        .meta-rows {

        }

        .meta-row {
            background: #f1f1f1;
            overflow: hidden;
            margin-top: 4px;
        }

    </style>
@stop

@section("footer")
    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>

    <script>
        $(document).ready(function () {

            $(".add-custom-field").click(function () {

                var html = '    <div class="meta-row">\n' +
                    '<input style="width: 30%" name="units_names[]"\n' +
                    '                                               class="form-control input-md pull-left custom-field-value"\n' +
                    '                                               placeholder="{{ trans("chances::units.attributes.name") }}"\n >' +
                    '\n' +
                    '                                        <select style="width: 40%" name="units[]"  class="form-control chosen-rtl pull-left custom-field-name">\n' +
                    '                                            @foreach($units as $unit)\n' +
                    '                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>\n' +
                    '                                            @endforeach\n' +
                    '                                        </select>\n' +
                    '\n' +
                    '                                        <input style="width: 20%" name="units_quantity[]"\n' +
                    '                                                  class="form-control input-md pull-left custom-field-value"\n' +
                    '                                                  placeholder="{{ trans("chances::chances.attributes.quantity") }}"\n' +
                    '                                                  value="">\n' +
                    '\n' +
                    '                                        <a class="remove-custom-field pull-right" href="javascript:void(0)">\n' +
                    '                                            <i class="fa fa-times text-navy"></i>\n' +
                    '                                        </a>\n' +
                    '\n' +
                    '                                    </div>';

                $(".xx").append(html);


            });

            $("body").on("click", ".remove-custom-field", function () {

                var item = $(this);
                confirm_box("{{ trans("posts::posts.sure_delete_field") }}", function () {
                    item.parents(".meta-row").remove();
                });

            });

            $("body").on("click", ".custom-field", function () {
                $('.dd').remove();
                var item = $(this);
                var text = "{{ trans("chances::chances.sure_create_unit") }}".replace(':unit', item.data('title'));
                confirm_box(text, function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('admin.chances.edit',['chance_id' => $chance->id])}}",
                        data: {
                            'chance_id': "{{$chance->id}}",
                            'quantity': item.data('quantity'),
                            'name': item.data('name'),
                            'unit_name': item.data('title')
                        },
                        success: function (data) {
                            if (data.success) {
                                item.remove();
                                var html = '    <div class="meta-row">\n' +
                                    '<input style="width: 30%" name="units_names[]"\n' +
                                    '                                               class="form-control input-md pull-left custom-field-value" value="' + item.data('name') + '" \n' +
                                    '                                               placeholder="{{ trans("chances::units.attributes.name") }}"\n >' +
                                    '\n' +
                                    '                                       <input style="width: 20%" name="[]" ' +
                                    '                                       class="form-control input-md pull-left custom-field-value" ' +
                                    '                                       placeholder="{{ trans("chances::units.attributes.unit") }}" ' +
                                    '                                       value="' + item.data('title') + '">' +
                                    '\n' +
                                    '                                        <input style="width: 20%" name="units_quantity[]" value="' + item.data('quantity') + '" \n' +
                                    '                                                  class="form-control input-md pull-left custom-field-value"\n' +
                                    '                                                  placeholder="{{ trans("chances::chances.attributes.quantity") }}"\n' +
                                    '                                                  value="">\n' +
                                    '\n' +
                                    '                                        <a class="remove-custom-field pull-right" href="javascript:void(0)">\n' +
                                    '                                            <i class="fa fa-times text-navy"></i>\n' +
                                    '                                        </a>\n' +
                                    '\n' +
                                    '                                    </div>';

                                $(".xx").append(html);
                            } else {
                                for (var k in data.errors) {
                                    $("<p class='text-danger dd'>" + data.errors["" + k + ""][0] + "</p>").insertAfter(item.parents(".meta-row"))
                                }
                            }
                        }
                    })
                });

            });

            $('[name=approved]').change(function () {
                if (this.value == 0)
                    $("#reason").css('display', 'block');
                else
                    $("#reason").css('display', 'none');
            })

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.tree-views input[type=checkbox]').on('ifChecked', function () {
                var checkbox = $(this).closest('ul').parent("li").find("input[type=checkbox]").first();
                checkbox.iCheck('check');
                checkbox.change();
            });
            $('.tree-views input[type=checkbox]').on('ifUnchecked', function () {
                var checkbox = $(this).closest('ul').parent("li").find("input[type=checkbox]").first();
                checkbox.iCheck('uncheck');
                checkbox.change();
            });
            $(".expand").each(function (index, element) {
                var base = $(this);
                if (base.parents("li").find("ul").first().length > 0) {
                    base.text("+");
                } else {
                    base.text("-");
                }
            });

            $("body").on("click", ".expand", function () {
                var base = $(this);
                if (base.text() == "+") {
                    if (base.closest("li").find("ul").length > 0) {
                        base.closest("li").find("ul").first().slideDown("fast");
                        base.text("-");
                    }
                    base.closest("li").find(".expand").last().text("-");
                } else {
                    if (base.closest("li").find("ul").length > 0) {
                        base.closest("li").find("ul").first().slideUp("fast");
                        base.text("+");
                    }
                }
                return false;
            });

        });

    </script>
@stop

