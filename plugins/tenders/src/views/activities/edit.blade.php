@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-newspaper-o"></i>
                    {{ $activity->id ? trans("tenders::activities.edit") : trans("tenders::activities.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.tenders.activities.show") }}">{{ trans("tenders::activities.activities") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $activity->id ? trans("tenders::activities.edit") : trans("tenders::activities.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($activity->id)
                    <a href="{{ route("admin.tenders.activities.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("tenders::activities.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("tenders::activities.save_activity") }}
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

                                <label>{{ trans("tenders::activities.attributes.name") }}</label>

                                <input type="text" class="form-control"
                                       id="input-name"
                                       name="name"
                                       value="{{ @Request::old('name', $activity->name) }}"
                                       placeholder="{{ trans("tenders::activities.attributes.name") }}">
                            </div>

                            
                        </div>
                    </div>

                    @foreach(Action::fire("tender.activity.form.featured", $activity) as $output)
                        {!!  $output !!}
                    @endforeach

                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("tenders::activities.activity_status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("tenders::activities.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $activity->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>

                            <div class="form-group format-area event-format-area">
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="published_at" type="text"
                                           value="{{ (!$activity->id) ? date("Y-m-d H:i:s") : @Request::old('published_at', $activity->published_at) }}"
                                           class="form-control" id="input-published_at"
                                           placeholder="{{ trans("tenders::activities.attributes.published_at") }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach(Action::fire("tender.activity.form.sidebar") as $output)
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
        });


    </script>

@stop
