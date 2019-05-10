@if (Auth::user()->can("companies.transactions"))
    <div class="row  border-bottom white-bg dashboard-header" style="margin:0">

        <div class="col-sm-3">

            <span class="label label-primary pull-right"><?php echo \App\Models\Transaction::count(); ?></span>
            <?php echo trans("companies::companies.transactions"); ?>
            <ul class="list-group clear-list m-t">
                @foreach(['tenders.buy'=>('app.types.tenders_buy'),
                                    'points.buy'=>('app.types.points_buy'),
                                    'add.chance'=>('app.types.add_chance'),
                                    'center.add'=>('app.types.add_center')] as $key=>$val)
                    <li class="list-group-item">
                <span class="label label-primary pull-right">
                    {{\App\Models\Transaction::where('action', $key)->count()}}
                </span>
                        {{trans($val)}}
                    </li>

                @endforeach
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="chart-container">
                        <div class="chart has-fixed-height"  id="line_zoom"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('head')
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

        <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script>
    @endpush
    @push("footer")
        <script>
            $(function () {
                $('#line_zoom').css('width', $('#line_zoom').parent().width());
                var used_point = '{{trans("app.used_points")}}';
                var added_point = '{{trans("app.add_points")}}';
                var element_charts = document.getElementById('line_zoom');
                var line_zoom = line_zoom_element = echarts.init(element_charts);
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
                        data: {!! json_encode($dates) !!}
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
                            data: {!! json_encode($spent_points) !!}
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
                            data: {!! json_encode($add_points) !!}
                        }
                    ]
                });

                var triggerChartResize = function () {
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

            })

        </script>

    @endpush

@endif
