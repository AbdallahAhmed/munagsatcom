@extends("admin::layouts.master")

@section("content")

    <form action="" method="post" class="BlocksForm">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-th-large"></i>
                    {{ $center ? trans("services::centers.edit") : trans("services::centers.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.centers.show") }}">{{ trans("services::centers.centers") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $center ? trans("services::centers.edit") : trans("services::centers.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($center)
                    <a href="{{ route("admin.centers.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("services::centers.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("services::centers.save_center") }}
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
                                <label for="input-name">{{ trans("services::centers.attributes.name") }}</label>
                                <input name="name" type="text"
                                       value="{{ @Request::old("name", $center->name) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::centers.attributes.name") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-name">{{ trans("services::centers.attributes.address") }}</label>
                                <input name="address" type="text"
                                       value="{{ @Request::old("address", $center->address) }}"
                                       class="form-control" id="input-address"
                                       placeholder="{{ trans("services::centers.attributes.address") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-mobile-number">{{ trans("services::centers.attributes.mobile_number") }}</label>
                                <input name="mobile_number" type="text"
                                       value="{{ @Request::old("mobile_number", $center->mobile_number) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::centers.attributes.mobile_number") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-phone-number">{{ trans("services::centers.attributes.phone_number") }}</label>
                                <input name="phone-number" type="text"
                                       value="{{ @Request::old("phone_number", $center->phone_number) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::centers.attributes.phone_number") }}">
                            </div>
                            <div class="form-group">
                                <label for="input-email">{{ trans("services::centers.attributes.email") }}</label>
                                <input name="email" type="text"
                                       value="{{ @Request::old("email", $center->email_address) }}"
                                       class="form-control" id="input-name"
                                       placeholder="{{ trans("services::centers.attributes.email") }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("services::centers.attributes.status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("services::centers.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $center->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("services::centers.approve") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="approved" class="form-control chosen-select chosen-rtl">
                                    @if($center && $center->approved == 0)
                                        <option value="0"
                                                selected="selected">{{trans("services::centers.reject")}}</option>
                                        <option value="1">{{trans("services::centers.approve")}}</option>
                                    @else
                                        <option value="1"
                                                selected="selected">{{trans("services::centers.approve")}}</option>
                                        <option value="0">{{trans("services::centers.reject")}}</option>
                                    @endif
                                </select>
                                <div id="reason"
                                     style="display: @if(($center && $center->approved == 1) || !$center) none @else block @endif; margin-top: 20px">
                                    <label
                                            for="input-number">{{ trans("services::centers.attributes.reason") }}</label>
                                    <input name="reason" type="text"
                                           value="{{ $center ? $center->reason : ''}}"
                                           class="form-control" id="input-name"
                                           placeholder="{{ trans("services::centers.attributes.reason") }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-large"></i>
                            {{ trans("chances::sectors.sector") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="sector_id" class="form-control chosen-select chosen-rtl">
                                    @foreach($sectors as $sector)
                                        @if($center )
                                            @if($center->sector->id == $sector->id)
                                                <option value="{{$sector->id}}"
                                                        selected="selected">{{$sector->name}}</option>
                                            @else
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
                                            @endif
                                        @else
                                            <option value="{{$sector->id}}">{{$sector->name}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa fa-th-large"></i>
                            {{ trans("services::services.services") }}
                        </div>
                        <div class="panel-body">

                            @if ($services)
                                <ul class='tree-views'>
                                    <?php
                                    foreach ($services as $service) {
                                        echo "<li><div class='tree-row checkbox i-checks'>";
                                        echo "<input type='checkbox' name='centers_services[]' value='$service->id' ";
                                        if (in_array($service->id, $centers_services))
                                            echo "checked=''checked";
                                        echo ">&nbsp;" . $service->name . " </label></div>";
                                    }
                                    ?>
                                </ul>
                            @else
                                {{ trans("chances::chances.no_records") }}
                            @endif
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

            $('[name=approved]').change(function () {
                if (this.value == 0)
                    $("#reason").css('display', 'block');
                else
                    $("#reason").css('display', 'none');
            })

            var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {size: 'small'});
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

        });

    </script>
@stop

