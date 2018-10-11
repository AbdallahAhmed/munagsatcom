@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm">

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
            </div>
            <div class="row">
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
                                       value="{{ @Request::old("closing_date", $chance->closing_date)}}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::chances.attributes.closing_date") }}">
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
                            {{ trans("posts::posts.add_category") }}
                        </div>
                        <div class="panel-body">

                            @if (Dot\Categories\Models\Category::count())
                                <ul class='tree-views'>
                                    <?php
                                    echo Dot\Categories\Models\Category::tree(array(
                                        "row" => function ($row, $depth) use ($post, $post_categories) {
                                            $html = "<li><div class='tree-row checkbox i-checks'><a class='expand' href='javascript:void(0)'>+</a> <label><input type='checkbox' ";
                                            if ($post and in_array($row->id, $post_categories->pluck("id")->toArray())) {
                                                $html .= 'checked="checked"';
                                            }
                                            $html .= "name='categories[]' value='" . $row->id . "'> &nbsp;" . $row->name . "</label></div>";
                                            return $html;
                                        }
                                    ));
                                    ?>
                                </ul>
                            @else
                                {{ trans("categories::categories.no_records") }}
                            @endif
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
@stop

@section("footer")
    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>

    <script>
        $(document).ready(function () {


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

