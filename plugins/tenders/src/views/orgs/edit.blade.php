@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-newspaper-o"></i>
                    {{ $org->id ? trans("tenders::orgs.edit") : trans("tenders::orgs.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.tenders.orgs.show") }}">{{ trans("tenders::orgs.orgs") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $org->id ? trans("tenders::orgs.edit") : trans("tenders::orgs.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($org->id)
                    <a href="{{ route("admin.tenders.orgs.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("tenders::orgs.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("tenders::orgs.save_org") }}
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

                                <label>{{ trans("tenders::orgs.attributes.name") }}</label>

                                <input type="text" class="form-control"
                                       id="input-name"
                                       name="name"
                                       value="{{ @Request::old('name', $org->name) }}"
                                       placeholder="{{ trans("tenders::orgs.attributes.name") }}">
                            </div>

                            
                        </div>
                    </div>

                    @foreach(Action::fire("tender.type.form.featured", $org) as $output)
                        {!!  $output !!}
                    @endforeach

                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("tenders::orgs.org_status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("tenders::orgs.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $org->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>

                            <div class="form-group format-area event-format-area">
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="published_at" type="text"
                                           value="{{ (!$org->id) ? date("Y-m-d H:i:s") : @Request::old('published_at', $org->published_at) }}"
                                           class="form-control" id="input-published_at"
                                           placeholder="{{ trans("tenders::orgs.attributes.published_at") }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-camera"></i>
                            {{ trans("tenders::orgs.attributes.logo_id") }}
                            <a class="remove-post-image pull-right" href="javascript:void(0)">
                                <i class="fa fa-times text-navy"></i>
                            </a>
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-image-block">
                                <input type="hidden" name="logo_id" class="post-image-id"
                                       value="{{ ($org->logo) ? $org->logo->id : 0 }}">

                                <a class="change-post-image label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    {{ trans("posts::posts.change_image") }}
                                </a>

                                <a class="post-media-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="post-image"
                                         src="{{ ($org and @$org->logo) ? thumbnail($org->logo->path) : assets("admin::default/image.png") }}">
                                </a>
                            </div>
                        </div>
                    </div>


                    @foreach(Action::fire("tender.type.form.sidebar") as $output)
                        {!! $output !!}
                    @endforeach
                </div>
            </div>
        </div>
    </form>

@stop



@section("footer")

    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>
    <script type="text/javascript" src="{{ assets('admin::js/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ assets('admin::js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script>

        $(document).ready(function () {


            $("[name=format]").on('ifChecked', function () {
                $(this).iCheck('check');
                $(this).change();
                switch_format($(this));
            });

            switch_format($("[name=format]:checked"));

            function switch_format(radio) {

                var format = radio.val();

                $(".format-area").hide();
                $("." + format + "-format-area").show();
            }


            var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {size: 'small'});
            });

            $(".change-post-image").filemanager({
                types: "image",
                panel: "media",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        base.parents(".post-image-block").find(".post-image-id").first().val(file.id);
                        base.parents(".post-image-block").find(".post-image").first().attr("src", file.thumbnail);
                    }
                },
                error: function (media_path) {
                    alert_box("{{ trans("posts::posts.not_image_file") }}");
                }
            });
            $(".remove-post-image").click(function () {
                var base = $(this);
                $(".post-image-id").first().val(0);
                $(".post-image").attr("src", "{{ assets("admin::default/post.png") }}");
            });
        });


    </script>

@stop
