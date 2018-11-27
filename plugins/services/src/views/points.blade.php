@extends("admin::layouts.master")

@section("content")

    <form method="post">

        <div class="row wrapper border-bottom white-bg page-heading">

            <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">
                <h2>
                    <i class="fa fa-cogs"></i>
                    {{ trans("services::points.points") }}
                </h2>
                <ol class="breadcrumb ">
                    <li>
                        <a href="{{ route("admin.points") }}">{{ trans("services::points.points") }}</a>
                    </li>
                    <li class="active">
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="row">

                <div class="col-md-8">
                    <div class="panel ">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="options_main" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="site_name">{{trans("services::points.rules_book_percentage")}}</label>
                                        <input name="option[rules_book_percentage]" type="number" required="required" min="0" max="100" value="{{$rules_book_percentage}}" class="form-control" id="rules_book_percentage" placeholder="{{trans("services::points.rules_book_percentage")}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="site_name">{{trans("services::points.rules_book_add")}}</label>
                                        <input name="option[rules_book_add]" type="text" required="required" value="{{$rules_book_add}}" class="form-control" id="rules_book_add" placeholder="{{trans("services::points.rules_book_add")}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="site_name">{{trans("services::points.service_center_add")}}</label>
                                        <input name="option[service_center_add]" type="text" required="required" value="{{$service_center_add}}" class="form-control" id="service_center_add" placeholder="{{trans("services::points.service_center_add")}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="site_name">{{trans("services::points.point_per_reyal")}}</label>
                                        <input name="option[point_per_reyal]" type="text" required="required" value="{{$point_per_reyal}}" class="form-control" id="point_per_reyal" placeholder="{{trans("services::points.point_per_reyal")}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div style="clear:both"></div>

            <div>
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="submit" class="pull-left btn btn-flat btn-primary"
                               value="{{ trans("options::options.save_options") }}"/>
                    </div>
                </div>
            </div>

        </div>

    </form>

@stop
