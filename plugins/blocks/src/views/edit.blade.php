@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-th-large"></i>
                    {{ $block ? trans("blocks::blocks.edit") : trans("blocks::blocks.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.blocks.show") }}">{{ trans("blocks::blocks.blocks") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $block ? trans("blocks::blocks.edit") : trans("blocks::blocks.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($block)
                    <a href="{{ route("admin.blocks.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                            class="btn-label icon fa fa-plus"></span>
                        {{ trans("blocks::blocks.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("blocks::blocks.save_block") }}
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
                                <label for="input-name">{{ trans("blocks::blocks.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $block->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("blocks::blocks.attributes.name") }}">
                            </div>

                            <div class="form-group">
                                <label for="input-type">{{ trans("blocks::blocks.attributes.type") }}</label>
                                <select id="input-type" class="form-control chosen-select chosen-rtl" name="type">
                                    @foreach(array("post", "tag", "category") as $type)
                                        <option value="{{ $type }}"
                                                @if($block and $block->type == $type) selected="selected" @endif>{{ trans("blocks::blocks.type_" . $type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-limit">{{ trans("blocks::blocks.attributes.limit") }}</label>
                                <input name="limit" min="0" type="number"
                                       value="{{ @Request::old("limit", $block->limit, 0) }}"
                                       class="form-control"
                                       id="input-limit"
                                       placeholder="{{ trans("blocks::blocks.attributes.limit") }}">
                            </div>

                        </div>
                    </div>

                    @foreach(Action::fire("block.form.featured") as $output)
                        {!! $output !!}
                    @endforeach

                </div>
                <div class="col-md-4">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-folder"></i>
                            {{ trans("blocks::blocks.add_category") }}
                        </div>
                        <div class="panel-body">

                            @if(Dot\Categories\Models\Category::count())
                                <ul class='tree-views'>
                                    <?php
                                    echo Dot\Categories\Models\Category::tree(array(
                                        "row" => function ($row, $depth) use ($block, $block_categories) {
                                            $html = "<li><div class='tree-row checkbox i-checks'><a class='expand' href='javascript:void(0)'>+</a> <label><input type='checkbox' ";
                                            if ($block and in_array($row->id, $block_categories->pluck("id")->toArray())) {
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

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tags"></i>
                            {{ trans("blocks::blocks.add_tag") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="position:relative">
                                <input type="hidden" name="tags" id="tags_names"
                                       value="{{ join(",", $block_tags) }}">
                                <ul id="mytags"></ul>
                            </div>
                        </div>
                    </div>

                    @foreach(Action::fire("block.form.sidebar") as $output)
                        {!! $output !!}
                    @endforeach

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

            $("#mytags").tagit({
                singleField: true,
                singleFieldNode: $('#tags_names'),
                allowSpaces: true,
                minLength: 2,
                placeholderText: "",
                removeConfirmation: true,
                tagSource: function (request, response) {
                    $.ajax({
                        url: "{{ route("admin.tags.search") }}",
                        data: {q: request.term},
                        dataType: "json",
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.name,
                                    value: item.name
                                }
                            }));
                        }
                    });
                },
                beforeTagAdded: function (event, ui) {
                    $("#metakeywords").tagit("createTag", ui.tagLabel);
                }
            });


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

