@extends('layouts.master')

@section('title',trans('app.centers.centers'))
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="side-box">
                    <h2>ابحث فى المراكز الخدمية</h2>
                    <div class="feildcont">
                        <form id="search">
                            <div class="form-group clearfix">
                                <div class="search-bar">
                                    <div class="icon-addon">
                                        <input type="text" placeholder="بحث فى مراكز الخدمة ..." class="form-control">
                                        <div class="searh-icn" rel="tooltip"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> القطاع</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option>اختار القطاع</option>
                                            <option>القطاع</option>
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> الخدمات</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option> اختار الخدمات</option>
                                            <option> الخدمات</option>
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> السعر </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="range">
                                        <input class="example" type="range" min="100" max="10000" value="100"
                                               name="points" step="10">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group text-center">
                                <button type="submit"  class="uperc padding-md fbutcenter"> بحث</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 content">
                <h2>مراكز خدمية</h2>
                @foreach($centers as $center)
                    <div class="card row markaz">
                        <div class="col-md-9">
                            <div class="item clearfix">
                                <div class="one_small title-small">{{trans('app.centers.center_name')}}</div>
                                <div class="one_larg"><a href="marakz-details.html">{{$center->name}}</a></div>
                            </div>
                            <div class="item clearfix">
                                <div class="one_small title-small"> {{trans('app.sectors.sector')}} </div>
                                <div class="one_larg">{{$center->sector->name}}</div>
                            </div>
                            <div class="item clearfix">
                                <div class="one_small title-small"> {{trans('app.services.services')}} </div>
                                <div class="one_larg title-larg">
                                    <ul>
                                        @foreach($center->services as $service)
                                        <li class=""><a href="#" title="تفاصيل السعر" data-toggle="popover"
                                                        data-trigger="hover" data-placement="bottom"
                                                        data-content="من 100 ريال : 1000 ريال"> {{$service->name}} </a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-img"><a href="marakz-details.html"><img src="{{assets('assets')}}/images/mr1.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center">
                    {{$centers->appends(Request::all())->render()}}
                </div>
                <!---->
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(function () {
               $('#search').on('submit',function (e) {
                   e.preventDefault();
                   alert()
               })
            });
            $(".example").asRange({
                range: true,
                limit: false,
                // tip: {
                //    active: 'onMove'
                //    },
                namespace: 'asRange',
                max: 10000,
                min: 100,
                value: true,
                step: 10,
                direction: 'h', // 'v' or 'h'
                keyboard: true,
                replaceFirst: true, // false, 'inherit', {'inherit': 'default'}
                scale: true,
                format(value) {
                    return value;
                }
            });
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover({trigger: "hover | focus", html: "true"});
            });
        </script>
    @endpush
@endsection
