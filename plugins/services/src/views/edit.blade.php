@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-th-large"></i>
                    {{ $service ? trans("services::services.edit") : trans("services::services.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.services.show") }}">{{ trans("services::services.services") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $service ? trans("services::services.edit") : trans("services::services.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($service)
                    <a href="{{ route("admin.services.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("services::services.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("services::services.save_service") }}
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
                                <label for="input-name">{{ trans("services::services.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $service->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::services.attributes.name") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-name">{{ trans("app.details") }}</label>
                                <textarea name="details" rows="4"
                                          class="form-control" id="input-name"
                                          placeholder="{{ trans("app.details") }}">{{ @Request::old("details", $service->details) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="input-name">{{ trans("services::services.attributes.price_from") }}</label>
                                <input name="price_from" type="number" min="1"
                                       value="{{ @Request::old("price_from", $service->price_from) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::services.attributes.price_from") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-name">{{ trans("services::services.attributes.price_to") }}</label>
                                <input name="price_to" type="number" min="1" max="2147483647"
                                       value="{{ @Request::old("price_to", $service->price_to) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::services.attributes.price_to") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("services::services.attributes.status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("services::services.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $service->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                @foreach(Action::fire("service.form.featured") as $output)
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
            var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {size: 'small'});
            });

        });

    </script>
@stop

