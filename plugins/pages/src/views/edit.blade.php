@extends("admin::layouts.master")

@section("content")

    <form method="post">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-file-text-o"></i>
                    {{ $page->id ? trans("pages::pages.edit") : trans("pages::pages.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.pages.show") }}">{{ trans("pages::pages.pages") }}</a>
                    </li>
                    <li class=" active">
                        <strong>
                            {{ $page->id ? trans("pages::pages.edit") : trans("pages::pages.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($page->id)
                    <a href="{{ route("admin.pages.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                            class="btn-label icon fa fa-plus"></span> {{ trans("pages::pages.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("pages::pages.save_page") }}
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
                            <textarea name="title" class="form-control input-lg" rows="1" id="post_title"
                                      placeholder="{{ trans("pages::pages.attributes.title") }}">{{ @Request::old("title", $page->title) }}</textarea>
                            </div>

                            <div class="form-group">
                            <textarea name="slug" class="form-control input-lg" rows="1" id="post_slug"
                                      placeholder="{{ trans("pages::pages.attributes.slug") }}">{{ @Request::old("slug", $page->slug) }}</textarea>
                            </div>

                            <div class="form-group">
                            <textarea name="excerpt" class="form-control" id="post_excerpt"
                                      placeholder="{{ trans("pages::pages.attributes.excerpt") }}">{{ @Request::old("excerpt", $page->excerpt) }}</textarea>
                            </div>

                            <div class="form-group">
                                @include("admin::partials.editor", ["name" => "content", "id" => "pagecontent", "value" => @$page->content])
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("pages::pages.page_status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("pages::pages.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $page->status)) checked="checked"
                                           @endif type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-picture-o"></i>
                            {{ trans("pages::pages.add_image") }}
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-image-block">
                                <input type="hidden" name="image_id" class="post-image-id"
                                       value="{{ ($page->image) ? $page->image->id : 0 }}">
                                <a class="change-post-image label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    {{ trans("pages::pages.change_image") }}
                                </a>
                                <a class="post-image-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="post-image"
                                         src="{{ ($page and @$page->image) ?  thumbnail(@$page->image->path) : assets("admin::default/image.png") }}">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tags"></i>
                            {{ trans("pages::pages.add_tag") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="position:relative">
                                <input type="hidden" name="tags" id="tags_names"
                                       value="{{ join(",", $page_tags) }}">
                                <ul id="mytags"></ul>
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
@stop

@section("footer")

    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>
    <script type="text/javascript" src="{{ assets('admin::ckeditor/ckeditor.js') }}"></script>
    <script>
        var baseURL = '{!! admin_url() !!}/';
        var postURL = '{!! url(' / details / ') !!}/{!!$page->slug!!}';
        var baseURL2 = '{!! url("") !!}/';
        var post_id = "{!!$page->id!!}";

        $(document).ready(function () {

            var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {size: 'small'});
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $(".change-post-image").filemanager({
                panel: "media",
                types: "image",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        base.parents(".post-image-block").find(".post-image-id").first().val(file.id);
                        base.parents(".post-image-block").find(".post-image").first().attr("src", file.thumbnail);
                    }
                },
                error: function (media_path) {
                    alert("{{ trans("pages::pages.not_allowed_file") }}");
                }
            });
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

        });

        $(window).load(function () {

            $('.edit_slug').click(function (e) {
                e.preventDefault();
                $('.edit_slug').hide();
                $('#permalink_ok').show();
                $('#permalink_cancel').show();
                $('#slug_name').hide();
                $('#new-post-slug').show();
            });

            $('#permalink_cancel').click(function (e) {
                e.preventDefault();
                $(this).hide();
                $('#permalink_ok').hide();
                $('.edit_slug').show();
                $('#new-post-slug').hide();
            });

            $('#permalink_ok').click(function (e) {
                e.preventDefault();
                ajaxData = {
                    slug: $("#new-post-slug").val(),
                    id: post_id
                };
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: baseURL + "pages/newSlug",
                    data: ajaxData,
                    beforeSend: function (res) {

                    },
                    success: function (res) {
                        $("#slug_name").html(res);
                        $("#editable-post-name-full").html(res);
                        $("#new-post-slug").val(res).hide();
                        $('#permalink_ok').hide();
                        $('#permalink_cancel').hide();
                        $('.edit_slug').show();
                        postURL = baseURL2 + "/details/" + res;
                        amtUpdateURL();
                    },
                    complete: function () {

                    }
                });
            });
        });


    </script>

@stop


