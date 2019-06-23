@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-money"></i>
                {{ trans("companies::companies.transactions") }}
                @if(isset($user))
                    <small>{{trans('companies::companies.for')}}{{ @$user->first_name.' '.@$user->last_name }}
                        @if($user&&$user->in_company&&count($user->company)!=0)
                            ({{$user->company[0]->name}})
                        @endif
                    </small>
                @endif
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                </li>
                <li>
                    <a href="{{ route("admin.companies.transactions") }}">{{ trans("companies::companies.transactions") }}
                        ({{ $transactions->total() }})</a>
                </li>
            </ol>
        </div>
        @if(isset($user))
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top: 30px;font-size: 20px">
                <div class="row">
                    <div class="col-md-4">
                        <span><span class="fa fa-money"></span> {{trans('companies::companies.current_points')}}:</span>
                        <span
                            class="badge badge-success">{{$user->in_company?$user->company[0]->points:$user->points}} {{trans('app.point')}}</span>
                    </div>
                    <div class="col-md-4">
                        <span></span> {{trans('app.spent_points')}}:</span>
                        <span
                            class="badge badge-success">{{$user->in_company?$user->company[0]->spent_points:$user->spent_points}} {{trans('app.point')}}</span>
                    </div>
                    <div class="col-md-4">
                        <span></span> {{trans('companies::companies.add_points')}}:</span>
                        <span
                            class="badge badge-success">{{$added_points}} {{trans('app.point')}}</span>
                    </div>
                </div>
            </div>
        @endif
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
                                <option value="created_at"
                                        @if($sort == "created_at") selected='selected' @endif>{{ trans("companies::companies.attributes.created_at") }}</option>
                                <option value="points"
                                        @if($sort == "points") selected='selected' @endif>{{ trans("companies::companies.attributes.points") }}</option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option value="DESC"
                                        @if($order == "DESC") selected='selected' @endif>{{ trans("companies::companies.desc") }}</option>
                                <option value="ASC"
                                        @if($order == "ASC") selected='selected' @endif>{{ trans("companies::companies.asc") }}</option>
                            </select>
                            @if(isset($user))
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                            @endif
                            <button type="submit"
                                    class="btn btn-primary">{{ trans("companies::companies.order") }}</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="action" class="form-control chosen-select chosen-rtl">
                                <option value="">{{trans('app.all_actions')}}</option>
                                @foreach(['tenders.buy'=>('app.types.tenders_buy'),
                                'points.buy'=>('app.types.points_buy'),
                                'add.chance'=>('app.types.add_chance'),
                                'center.add'=>('app.types.add_center')] as $key=>$val)
                                    <option
                                        value="{{$key}}" {{$key==request('action')?'selected':''}}>{{trans($val)}}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="btn btn-primary">{{ trans("companies::companies.filter") }}</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">
                            @if(!isset($user))
                                <div class="input-group">
                                    <input name="q" value="{{ Request::get("q") }}" type="text"
                                           class=" form-control"
                                           placeholder="{{ trans("companies::companies.search_companies") }} ...">
                                    <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i> </button>

                        </span>
                                </div>
                            @endif
                            <div class="input-group date datetimepick col-sm-6 pull-left" style="margin-top: 5px">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="from" type="text" value="{{ @Request::get("from") }}"
                                       class="form-control" id="input-from"
                                       placeholder="{{ trans("posts::posts.from") }}">
                            </div>

                            <div class="input-group date datetimepick col-sm-6 pull-left" style="margin-top: 5px">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="to" type="text" value="{{ @Request::get("to") }}"
                                       class="form-control" id="input-to"
                                       placeholder="{{ trans("posts::posts.to") }}">
                            </div>
                            <div class="input-group pull-right">
                                <button type="submit"
                                        class="btn btn-primary">{{ trans("companies::companies.filter") }}</button>
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
                            <i class="fa fa-folder"></i>
                            {{ trans("companies::companies.transactions") }}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        {{--<div class="panel-body">--}}

                        {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                        {{--<div class="chart-container">--}}
                        {{--<div class="chart has-fixed-height" style="width: 1200px" id="line_zoom"></div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        @if(count($transactions))
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                    <select name="action" class="form-control pull-left">
                                        <option value="-1"
                                                selected="selected">{{ trans("companies::companies.bulk_actions") }}</option>
                                    </select>
                                    <button type="submit"
                                            class="btn btn-primary pull-right">{{ trans("companies::companies.apply") }}</button>

                                </div>

                                <div class="col-lg-6 col-md-4 hidden-sm hidden-xs">
                                    <a class="btn  btn-default btn-icon" href="{{Request::fullUrlWithQuery(['exports'=>true])}}" id="print" >
                                        <i class="fa fa-file-archive-o"></i>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <select class="form-control per_page_filter">
                                        <option value="" selected="selected">
                                            -- {{ trans("companies::companies.per_page") }} --
                                        </option>
                                        @foreach (array(10, 50, 100, 150) as $num)
                                            <option value="{{ $num }}"
                                                    @if ($num == $per_page) selected="selected" @endif>{{ $num }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0"
                                       class="table table-striped table-hover" id="printTable">
                                    <thead>
                                    <tr>
                                        <th style="width:35px"><input type="checkbox" class="i-checks check_all"
                                                                      name="ids[]"/></th>
                                        <th>{{ trans("companies::companies.attributes.transaction_id") }}</th>
                                        <th>{{ trans("app.transaction_type") }}</th>
                                        @if(!isset($user)||(isset($user)&&$user->in_company))
                                            <th>{{ trans("companies::companies.attributes.user_trans") }}
                                                @if(!(isset($user)&&$user->in_company))
                                                    ({{ trans("companies::companies.attributes.name")}})
                                                @endif
                                            </th>
                                        @endif
                                        <th>{{ trans("app.before_transaction") }}</th>
                                        <th>{{ trans("app.add_points") }}</th>
                                        <th>{{ trans("app.used_points") }}</th>
                                        <th>{{ trans("app.after_transactions") }}</th>
                                        <th>{{ trans("companies::companies.attributes.created_at") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $totalAdded=0;
                                        $totalSpent=0;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        @php
                                            $totalAdded+=($transaction->before_points < $transaction->after_points)?$transaction->points:0;
                                            $totalSpent+=($transaction->before_points >= $transaction->after_points)?$transaction->points:0;
                                        @endphp
                                        @if($transaction->user)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="i-checks" name="id[]"
                                                           value="{{ $transaction->id }}"/>
                                                </td>

                                                <td>
                                                    <a data-toggle="tooltip" data-placement="bottom"
                                                       class="text-navy" href="javascript:void(0)">
                                                        <strong>{{$transaction->id }}</strong>
                                                    </a>
                                                </td>

                                                <td>
                                                    {{$transaction->type}}
                                                </td>
                                                @if(!isset($user)||(isset($user)&&$user->in_company))
                                                    <td>
                                                        <a href="?user_id={{ @$transaction->user->id }}"
                                                           class="text-navy">
                                                            <small> {{ @$transaction->user->first_name.' '.@$transaction->user->last_name }}</small>
                                                        </a>
                                                        @if(!(isset($user)&&$user->in_company))
                                                            @if($transaction->user&&$transaction->user->in_company&&count($transaction->user->company)!=0)
                                                                ( <a
                                                                    href="?company_id={{$transaction->user->company[0]->id}}">{{$transaction->user->company[0]->name}}</a>
                                                                )
                                                            @endif
                                                        @endif

                                                    </td>
                                                @endif
                                                <td>
                                                    {{$transaction->before_points}}
                                                </td>
                                                <td>
                                                    @if($transaction->before_points < $transaction->after_points)
                                                        <i class="fa fa-arrow-up text-success"></i>
                                                        {{$transaction->points}}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->before_points < $transaction->after_points)
                                                        0
                                                    @else
                                                        {{$transaction->points}}
                                                        <i class="fa fa-arrow-down text-danger"></i>

                                                    @endif
                                                </td>
                                                <td>
                                                    {{$transaction->after_points}}
                                                </td>

                                                <td>
                                                    <small>{{app()->getLocale()=="ar"?arabic_date($transaction->created_at->format('Y-m-d h:i a')):$transaction->created_at->format('Y-m-d h:i a')}}</small>
                                                </td>

                                            </tr>@endif
                                    @endforeach
                                    </tbody>
                                    @if(isset($user))
                                        <tfooter>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @if(!isset($user)||(isset($user)&&$user->in_company))
                                                    <td></td>
                                                @endif
                                                <td></td>
                                                <td>{{trans('app.total')}} {{$totalAdded}}</td>
                                                <td>{{trans('app.total')}} {{$totalSpent}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfooter>
                                    @endif
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    {{ trans("companies::companies.page") }} {{ $transactions->currentPage() }} {{ trans("companies::companies.of") }} {{ $transactions->lastPage() }}
                                </div>
                                <div class="col-lg-12 text-center">
                                    {{ $transactions->appends(Request::all())->render() }}
                                </div>
                            </div>
                        @else
                            {{ trans("companies::companies.transaction_no_records") }}
                        @endif
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section("head")

    <link href="{{ assets('admin::css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script>
    <style>

        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart {
            position: relative;
            display: block;
            width: 100%;
        }

        .has-fixed-height {
            height: 400px;
        }

    </style>

@stop

@push("footer")

    <script type="text/javascript" src="{{ assets('admin::js/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ assets('admin::js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    @if(isset($user))
        <script>
            $('line_zoom').css('width', $('line_zoom').parent().width());
            var used_point = '{{trans("app.used_points")}}';
            var added_point = '{{trans("app.add_points")}}';
            var element_charts = document.getElementById('line_zoom');
            var line_zoom = echarts.init(element_charts);
            line_zoom.setOption({

                // Define colors
                color: ["#a94442", "#3c763d"],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 60,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: [used_point, added_point],
                    itemHeight: 8,
                    itemGap: 20
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    data: ['2017/1/17', '2017/1/18', '2017/1/19', '2017/1/20', '2017/1/23', '2017/1/24', '2017/1/25', '2017/1/26', '2017/2/3', '2017/2/6', '2017/2/7', '2017/2/8', '2017/2/9', '2017/2/10', '2017/2/13', '2017/2/14', '2017/2/15', '2017/2/16', '2017/2/17', '2017/2/20', '2017/2/21', '2017/2/22', '2017/2/23', '2017/2/24', '2017/2/27', '2017/2/28', '2017/3/1分红40万', '2017/3/2', '2017/3/3', '2017/3/6', '2017/3/7']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value} ',
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Zoom control
                dataZoom: [
                    {
                        type: 'inside',
                        start: 30,
                        end: 70
                    },
                    {
                        show: true,
                        type: 'slider',
                        start: 30,
                        end: 70,
                        height: 40,
                        bottom: 0,
                        borderColor: '#ccc',
                        fillerColor: 'rgba(0,0,0,0.05)',
                        handleStyle: {
                            color: '#585f63'
                        }
                    }
                ],

                // Add series
                series: [
                    {
                        name: used_point,
                        type: 'line',
                        smooth: true,
                        symbolSize: 6,
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        },
                        data: [152, 156, 479, 442, 654, 835, 465, 704, 643, 136, 791, 254, 688, 119, 948, 316, 612, 378, 707, 404, 485, 226, 754, 142, 965, 364, 887, 395, 838, 113, 662]
                    },
                    {
                        name: added_point,
                        type: 'line',
                        smooth: true,
                        symbolSize: 6,
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        },
                        data: [677, 907, 663, 137, 952, 408, 976, 772, 514, 102, 165, 343, 374, 744, 237, 662, 875, 462, 409, 259, 396, 744, 359, 618, 127, 596, 161, 574, 107, 914, 708]
                    }
                ]
            });

            var triggerChartResize = function () {
                line_basic_element && line_basic.resize();
                line_stacked_element && line_stacked.resize();
                line_inverted_axes_element && line_inverted_axes.resize();
                line_multiple_element && line_multiple.resize();
                line_values_element && line_values.resize();
                line_zoom_element && line_zoom.resize();
            };

            // On sidebar width change
            $(document).on('click', '.sidebar-control', function () {
                setTimeout(function () {
                    triggerChartResize();
                }, 0);
            });

            // On window resize
            var resizeCharts;
            window.onresize = function () {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            };

        </script>
    @endif

    <script>

        $(document).ready(function () {
            $('.datetimepick').datetimepicker({
                format: 'YYYY-MM-DD',
            });

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
@endpush

