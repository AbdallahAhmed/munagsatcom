@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">

        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-map-marker"></i>
                {{trans("i18n::places.places")}}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route("admin")}}">{{trans("admin::common.admin")}}</a>
                </li>
                <li>
                    <a href="{{ route("admin.places.show") }}">
                        {{trans("i18n::places.places")}}
                        ({{ $places->total() }})
                    </a>
                </li>
                @if($country)
                    <li>
                        <a href="{{ route("admin.places.show", ["parent" => $country->id]) }}">
                            {{ $country->name }}
                        </a>
                    </li>
                @endif

            </ol>
        </div>

        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{ @route("admin.places.create", ["parent" => $country->id])}}" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> &nbsp; {{ trans("i18n::places.add_new") }}</a>
        </div>

    </div>

    <div class="wrapper wrapper-content fadeInRight">

        <div id="content-wrapper">

            @include("admin::partials.messages")

            <form action="" method="get" class="filter-form">
                <input type="hidden" name="per_page" value="{{ Request::get('per_page') }}"/>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="sort" class="form-control chosen-select chosen-rtl">
                                <option
                                    value="name" {{($sort == "name")?"selected='selected'":''}}>{{ucfirst(trans("i18n::places.attributes.name"))}}</option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option
                                    value="DESC" {{$order == "DESC"?"selected='selected'":''}}>{{ trans("i18n::places.desc") }}</option>
                                <option
                                    value="ASC" {{($order == "ASC")? "selected='selected'":''}} >{{trans("i18n::places.asc") }}</option>
                            </select>
                            <button type="submit" class="btn btn-primary">{{trans("i18n::places.order")}}</button>
                        </div>
                    </div>
                    <div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">
                            <div class="input-group">
                                <input name="q" value="{{ Request::get("q")}}" type="text" class=" form-control"
                                       placeholder="{{trans("i18n::places.search_places") }} ...">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                            </div>

                        </form>
                    </div>
                </div>
            </form>

            <form action="" method="post" class="action_form">
                {{csrf_field()}}
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-file-text-o"></i>
                            {{trans("i18n::places.places")}}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @if(count($places))
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                    <select name="action" class="form-control pull-left">
                                        <option value="-1"
                                                selected="selected">{{trans("i18n::places.bulk_actions")}}</option>
                                        <option value="delete">{{trans("i18n::places.delete")}}</option>
                                    </select>

                                    <button type="submit"
                                            class="btn btn-primary pull-right">{{trans("i18n::places.apply")}}</button>

                                </div>

                                <div class="col-lg-6 col-md-4 hidden-sm hidden-xs"></div>

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <select name="post_status" id="post_status"
                                            class="form-control per_page_filter">
                                        <option value="" selected="selected">-- {{ trans("i18n::places.per_page") }}
                                            --
                                        </option>
                                        @foreach ([10, 20, 30, 40] as $num)
                                            <option
                                                value="{{$num}}" {{$num==$per_page?'selected="selected"':""}}>{{$num}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width:35px">
                                            <input type="checkbox" class="i-checks check_all" name="keys[]"/>
                                        </th>
                                        <th>{{trans("i18n::places.attributes.name")}}</th>
                                        <th>{{trans("i18n::places.attributes.code")}}</th>
                                        <th>{{ trans("i18n::places.attributes.status") }}</th>
                                        <th>{{trans("i18n::places.actions")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($places as $place)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="i-checks" name="id[]"
                                                       value="{{$place->id }}"/>
                                            </td>

                                            <td>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{trans("i18n::places.show_cities")}}" class="text-navy"
                                                   href="{{route("admin.places.show", array("parent" => $place->id))}}">
                                                    <strong>{{$place->name }}</strong>
                                                </a>
                                            </td>

                                            <td>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{trans("i18n::places.edit")}}" class="text-navy"
                                                   href="{{route("admin.places.edit", array("id" => $place->id))}}">
                                                    <strong>{{$place->code }}</strong>
                                                </a>
                                            </td>

                                            <td>
                                                @if ($place->status)
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       title="{{ trans("i18n::places.activated") }}" class="ask"
                                                       message="{{ trans('i18n::places.sure_deactivate') }}"
                                                       href="{{ URL::route("admin.places.status", array("id" => $place->id, "status" => 0)) }}">
                                                        <i class="fa fa-toggle-on text-success"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       title="{{ trans("i18n::places.deactivated") }}" class="ask"
                                                       message="{{ trans('i18n::places.sure_activate') }}"
                                                       href="{{ URL::route("admin.places.status", array("id" => $place->id, "status" => 1)) }}">
                                                        <i class="fa fa-toggle-off text-danger"></i>
                                                    </a>
                                                @endif
                                            </td>

                                            <td class="center">
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{trans("i18n::places.edit")}}"
                                                   href="{{ @route("admin.places.edit", array("id" => $place->id, "parent" => $country->id))}}">
                                                    <i class="fa fa-pencil text-navy"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{trans("i18n::places.delete")}}" class="delete_user ask"
                                                   message="{{trans("i18n::places.sure_delete")}}"
                                                   href="{{URL::route("admin.places.delete", array("id" => $place->id ))}}">
                                                    <i class="fa fa-times text-navy"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    {{trans("i18n::places.page")}}
                                    {{ $places->currentPage() }}
                                    {{trans("i18n::places.of")}}
                                    {{ $places->lastPage()}}

                                </div>
                                <div class="col-lg-12 text-center">
                                    {{ $places->appends(Request::all())->render()}}
                                </div>

                            </div>
                        @else
                            {{trans("i18n::places.no_records")}}
                        @endif
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop

@section("footer")

    <script>

        $(document).ready(function () {


            $('[data-toggle="tooltip"]').tooltip();

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.check_all').on('ifChecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('check');
                    $(this).change();
                });
            });

            $('.check_all').on('ifUnchecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('uncheck');
                    $(this).change();
                });
            });

            $(".filter-form input[name=per_page]").val($(".per_page_filter").val());

            $(".per_page_filter").change(function () {
                var base = $(this);
                var per_page = base.val();
                $(".filter-form input[name=per_page]").val(per_page);
                $(".filter-form").submit();
            });

        });
    </script>
@stop
