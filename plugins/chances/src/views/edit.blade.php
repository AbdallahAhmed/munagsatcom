@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm" enctype="multipart/form-data">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-th-large"></i>
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
                            {{ $chance ? trans("chances::chances.edit") : trans("chances::chances.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($chance)
                    <a href="{{ route("admin.chances.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("chances::chances.add_new") }}</a>
                @endif

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
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="input-name">{{ trans("chances::chances.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $chance->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.name") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="input-number">{{ trans("chances::chances.attributes.number") }}</label>
                                <input name="number" type="text"
                                       value="{{ @Request::old("number", $chance->number) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.number") }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.closing_date") }}</label>
                                <input name="closing_date" type="datetime-local"
                                       value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $chance->closing_date)->format("Y-m-d\TH:i") }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.closing_date") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.value") }}</label>
                                <input name="value" type="text"
                                       value="{{ @Request::old("value", $chance->value)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.value") }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-folder"></i>
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
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.file") }}</label>
                                <a href="{{route("index")}}/uploads/chances{{$chance->file_path}}" target="_blank">{{$chance->file_name}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label
                                        for="input-number">{{ trans("chances::chances.attributes.file_description") }}</label>
                                <input name="file_description" type="text"
                                       value="{{ @Request::old("file_description", $chance->file_description)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.file_description") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
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
                </div>
            </div>
            @if($units)
                @foreach($units_quantity as $uq)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label
                                                for="input-number">{{ trans("chances::chances.attributes.units") }}</label>
                                        <select name="units[]" class="form-control chosen-select chosen-rtl">
                                            @foreach($units as $unit)
                                                @if($unit->id == $uq->id)
                                                    <option value="{{$unit->id}}" selected="selected">{{$unit->name}}</option>
                                                @else
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label
                                                for="input-number">{{ trans("chances::chances.attributes.quantity") }}</label>
                                        <input name="units_names[]" type="text"
                                               value="{{$uq->pivot->quantity}}"
                                               class="form-control" id="input-name"
                                               placeholder="{{ trans("chances::chances.attributes.quantity") }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </form>

@stop

@section("head")
    <link href="{{ assets("admin::tagit") }}/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ assets("admin::tagit") }}/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@stop

@section("footer")
    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#add-unit', function (e) {
                e.preventDefault();
                $(this).hide();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route("admin.chances.addUnitUI")}}",
                    success: function (data) {
                        $(data.view).insertAfter($("#add-unit"))
                        $(this).remove();
                    }
                })
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

