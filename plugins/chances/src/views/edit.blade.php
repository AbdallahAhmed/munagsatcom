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
                                <input name="closing_date" type="datetime-local"
                                       value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $chance->closing_date)->format("Y-m-d\TH:i") }}"
                                       class="chosen-rtl form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.closing_date") }}">
                            </div>
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.value") }}</label>
                                <input name="value" type="text"
                                       value="{{ @Request::old("value", $chance->value)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.value") }}">
                            </div>
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.file_description") }}</label>
                                <input name="file_description" type="text"
                                       value="{{ @Request::old("file_description", $chance->file_description)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.file_description") }}">
                            </div>
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.file_name") }}</label>
                                <input name="file_name" type="text"
                                       value="{{ @Request::old("file_name", $chance->file_name)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.file_name") }}">
                            </div>
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

                            <div class="form-group meta-rows">
                                @foreach($units_quantity as $uq)
                                    <div class="meta-row">

                                        <select name="units[]"  class="form-control chosen-rtl pull-left custom-field-name">
                                            @foreach($units as $unit)
                                                @if($unit->id == $uq->id)
                                                    <option value="{{$unit->id}}"
                                                            selected="selected">{{$unit->name}}</option>
                                                @else
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <input name="units_quantity[]"
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

                            @if ($sectors)
                                <ul class='tree-views'>
                                    <?php
                                    foreach ($sectors as $sector) {
                                        echo "<li><div class='tree-row checkbox i-checks'>";
                                        echo "<a class='expand' href='javascript:void(0)'>+</a>";
                                        echo "<input type='checkbox' name='sectors[]' value='$sector->id' ";
                                        if (in_array($sector->id, $chances_sectors))
                                            echo "checked=''checked";
                                        echo ">&nbsp;" . $sector->name . " </label></div>";
                                    }
                                    ?>
                                </ul>
                            @else
                                {{ trans("chances::chances.no_records") }}
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-folder"></i>
                            {{ trans("chances::chances.file_download") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <a href="{{route("index")}}/uploads/chances{{$chance->file_path}}"
                                   target="_blank">{{$chance->file_name}}</a>
                            </div>
                        </div>
                    </div>
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
                    '\n' +
                    '                                        <select name="units[]"  class="form-control chosen-rtl pull-left custom-field-name">\n' +
                    '                                            @foreach($units as $unit)\n' +
                    '                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>\n' +
                    '                                            @endforeach\n' +
                    '                                        </select>\n' +
                    '\n' +
                    '                                        <input name="units_quantity[]"\n' +
                    '                                                  class="form-control input-md pull-left custom-field-value"\n' +
                    '                                                  placeholder="{{ trans("chances::chances.attributes.quantity") }}"\n' +
                    '                                                  value="">\n' +
                    '\n' +
                    '                                        <a class="remove-custom-field pull-right" href="javascript:void(0)">\n' +
                    '                                            <i class="fa fa-times text-navy"></i>\n' +
                    '                                        </a>\n' +
                    '\n' +
                    '                                    </div>';

                $(".meta-rows").append(html);


            });

            $("body").on("click", ".remove-custom-field", function () {

                var item = $(this);
                confirm_box("{{ trans("posts::posts.sure_delete_field") }}", function () {
                    item.parents(".meta-row").remove();
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

