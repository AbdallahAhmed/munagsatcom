@extends("admin::layouts.master")

@section("content")

    <form action="{{route("chance.store")}}" method="post" class="BlocksForm" enctype="multipart/form-data">
        <button class="btn btn-primary btn-labeled btn-main">Add New</button>

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
                                       value=""
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
                                       value=""
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
                                       value=""
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
                                       value=""
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

                                        @foreach ($sectors as $sector)
                                            <li><div class='tree-row checkbox i-checks'>
                                            <a class='expand' href='javascript:void(0)'>+</a>
                                            <input type='checkbox' name='sectors[]' value='{{$sector->id}}'>&nbsp;{{$sector->name}}</div>
                                       @endforeach
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
                                <input name="file" type="file"
                                       value="{{ @Request::old("value", $chance->file_path)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.file") }}">
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
                                       value="{{ @Request::old("value", $chance->value)}}"
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
                                       value="{{ @Request::old("value", $chance->value)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.file_name") }}">
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
                                        for="input-number">{{ trans("chances::chances.attributes.units") }}</label>
                                <select name="units[]" class="form-control chosen-select chosen-rtl">
                                    @if($units)
                                        @foreach($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="">{{ trans("chances::units.no_records") }}</option>
                                    @endif
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
                                       value=""
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.quantity") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <button id="add-unit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
            </div>
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

