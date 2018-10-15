@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-th-large"></i>
                    {{ $sector ? trans("chances::sectors.edit") : trans("chances::sectors.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.sectors.show") }}">{{ trans("chances::sectors.sectors") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $sector ? trans("chances::sectors.edit") : trans("chances::sectors.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($sector)
                    <a href="{{ route("admin.sectors.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                            class="btn-label icon fa fa-plus"></span>
                        {{ trans("chances::sectors.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("chances::sectors.save_sector") }}
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
                                <label for="input-name">{{ trans("chances::sectors.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $sector->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("chances::sectors.attributes.name") }}">
                            </div>


                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("posts::posts.post_status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("posts::posts.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $sector->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
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
        });

    </script>
@stop

