@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-th-large"></i>
                {{ trans("chances::sectors.sectors") }}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                </li>
                <li>
                    <a href="{{ route("admin.sectors.show") }}">{{ trans("chances::sectors.sectors") }}
                        ({{ $sectors->total() }})</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{ route("admin.sectors.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> {{ trans("chances::sectors.add_new") }}</a>
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
                                    value="name"
                                    @if ($sort == "name")  selected='selected' @endif>{{ ucfirst(trans("chances::sectors.attributes.name")) }}</option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option
                                    value="DESC"
                                    @if (Request::get("order") == "DESC") selected='selected' @endif>{{ trans("chances::sectors.desc") }}</option>
                                <option
                                    value="ASC"
                                    @if (Request::get("order") == "ASC") selected='selected' @endif>{{ trans("chances::sectors.asc") }}</option>
                            </select>
                            <button type="submit"
                                    class="btn btn-primary">{{ trans("chances::sectors.order") }}</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">

                    </div>
                    <div class="col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">

                            <div class="input-group">
                                <div class="autocomplete_area">
                                    <input type="text" name="q" value="{{ Request::get("q") }}"
                                           autocomplete="off"
                                           placeholder="{{ trans("chances::sectors.search_sectors") }} ..."
                                           class="form-control linked-text">

                                    <div class="autocomplete_result">
                                        <div class="result_body"></div>
                                    </div>

                                </div>

                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </span>

                            </div>

                        </form>
                    </div>
                </div>
            </form>
            <form action="" method="post" class="action_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-blocks"></i>
                            {{ trans("chances::sectors.sectors") }}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @if (count($sectors))
                            <div class="row">

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">
                                    <select name="action" class="form-control pull-left">
                                        <option value="-1"
                                                selected="selected">{{ trans("chances::sectors.bulk_actions") }}</option>
                                        <option value="delete">{{ trans("chances::sectors.delete") }}</option>
                                    </select>
                                    <button type="submit"
                                            class="btn btn-primary pull-right">{{ trans("chances::sectors.apply") }}</button>
                                </div>

                                <div class="col-lg-6 col-md-4 hidden-sm hidden-xs"></div>

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <select class="form-control per_page_filter">
                                        <option value="" selected="selected">
                                            -- {{ trans("chances::sectors.per_page") }}--
                                        </option>
                                        @foreach (array(10, 20, 30, 40, 60, 80, 100, 150) as $num)
                                            <option
                                                value="{{ $num }}"
                                                @if ($num == $per_page) selected="selected" @endif>{{ $num }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0"
                                       class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width:35px"><input type="checkbox" class="i-checks check_all"
                                                                      name="ids[]"/>
                                        </th>
                                        <th>{{ trans("chances::sectors.attributes.name") }}</th>
                                        <th>{{ trans("chances::units.attributes.status") }}</th>

                                        <th>{{ trans("chances::sectors.actions") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($sectors as $sector)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="i-checks" name="id[]"
                                                       value="{{ $sector->id }}"/>
                                            </td>


                                            <td>
                                                <a data-toggle="tooltip" data-placement="bottom" class="text-navy"
                                                   title="{{ trans("chances::sectors.edit") }}"
                                                   href="{{ route("admin.sectors.edit", array("id" => $sector->id)) }}">
                                                    <strong>{{ $sector->name }}</strong>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($sector->status)
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       title="{{ trans("chances::sectors.activated") }}" class="ask"
                                                       message="{{ trans('chances::sectors.sure_deactivate') }}"
                                                       href="{{ URL::route("admin.sectors.status", array("id" => $sector->id, "status" => 0)) }}">
                                                        <i class="fa fa-toggle-on text-success"></i>
                                                    </a>
                                                @else
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       title="{{ trans("chances::sectors.deactivated") }}" class="ask"
                                                       message="{{ trans('chances::sectors.sure_activate') }}"
                                                       href="{{ URL::route("admin.sectors.status", array("id" => $sector->id, "status" => 1)) }}">
                                                        <i class="fa fa-toggle-off text-danger"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="center">
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{ trans("chances::sectors.edit") }}"
                                                   href="{{ route("admin.sectors.edit", array("id" => $sector->id)) }}">
                                                    <i class="fa fa-pencil text-navy"></i>
                                                </a>
                                                <a <?php /* data-toggle="tooltip" data-placement="bottom" */ ?>
                                                   title="{{ trans("chances::sectors.delete") }}"
                                                   class="ask delete_block"
                                                   data-block-id="{{ $sector->id }}"
                                                   message="{{ trans("chances::sectors.sure_delete") }}"
                                                   href="{{ URL::route("admin.sectors.delete", array("id" => $sector->id)) }}">
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
                                    {{ trans("chances::sectors.page") }}
                                    {{ $sectors->currentPage() }}
                                    {{ trans("chances::sectors.of") }}
                                    {{ $sectors->lastPage() }}
                                </div>
                                <div class="col-lg-12 text-center">
                                    {{ $sectors->appends(Request::all())->render() }}
                                </div>
                            </div>
                        @else
                            {{ trans("chances::sectors.no_records") }}
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

