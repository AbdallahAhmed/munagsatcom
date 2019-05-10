@extends('layouts.master')

@section('title',trans('app.centers.centers'))
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="side-box">
                    <h2>{{trans('app.centers.search_centers')}}</h2>
                    <div class="feildcont">
                        <form id="search">
                            <div class="form-group clearfix">
                                <div class="search-bar">
                                    <div class="icon-addon">
                                        @if($q)
                                            <input name="search_q" type="text"
                                                   placeholder="{{trans('app.centers.search_query')}}..."
                                                   class="form-control" value="{{$q}}">
                                        @else
                                            <input name="search_q" type="text"
                                                   placeholder="{{trans('app.centers.search_query')}}..."
                                                   class="form-control">
                                        @endif
                                        <div class="searh-icn" rel="tooltip"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.sectors.sector')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control" name="sector_id">
                                            <option value="">{{trans('app.sectors.choose_sector')}}</option>
                                            @foreach($sectors as $sector)
                                                @if($sector_id == $sector->id)
                                                    <option value="{{$sector->id}}"
                                                            selected="selected">{{$sector->name}}</option>
                                                @else
                                                    <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                @endif
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.services.services')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control" name="service_id">
                                            <option value="0">{{trans('app.services.choose_services')}}</option>
                                            @foreach($services as $service)
                                                @if($service_id == $service->id)
                                                    <option value="{{$service->id}}"
                                                            selected="selected">{{$service->name}}</option>
                                                @else
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endif
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit"
                                        class="uperc padding-md fbutcenter"> {{trans('app.search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 content">
                @if(count($centers)==0)
                    <p class="col-md-12 not-found">{{trans('app.centers.not_found')}}</p>
                @else
                    <h2>{{trans('app.centers.centers')}}</h2>
                @endif
                @foreach($centers as $center)
                    <div class="card row markaz">
                        <div class="col-md-9">
                            <div class="item clearfix">
                                <div class="one_small title-small">{{trans('app.centers.center_name')}}</div>
                                <div class="one_larg">
                                    <a href="{{$center->path}}">{{$center->name}}</a>
                                    @if($center->can_edit && !$center->approved)
                                        <a href="{{route('centers.update', ['id' => $center->company_id, 'center_id' => $center->id])}}"><button class="btn btn-primary small"><i class="fa fa-edit"></i></button></a>
                                    @endif
                                </div>

                            </div>
                            <div class="item clearfix">
                                <div class="one_small title-small"> {{trans('app.sectors.sector')}} </div>
                                <div class="one_larg">{{@$center->sector->name}}</div>
                            </div>
                            <div class="item clearfix">
                                <div class="one_small title-small"> {{trans('app.services.services')}} </div>
                                <div class="one_larg title-larg">
                                    <ul>
                                        @foreach($center->services as $service)
                                            <li class="">
                                                {{--<a href="#" title="{{trans('app.sectors.price_detail')}}"
                                                   data-toggle="popover"
                                                   data-trigger="hover" data-placement="bottom"
                                                   data-content="{{trans('app.from').$service->price_from.trans("app.reyal")." : ".trans('app.to').$service->price_to.trans("app.reyal")}}">
                                                    {{$service->name}}
                                                </a>--}}
                                                <a href="#" title="{{trans('app.sectors.price_detail')}}"
                                                   data-toggle="popover"
                                                   data-trigger="hover" data-placement="bottom"
                                                   data-content="{{$service->price_to.trans("app.reyal")}}">
                                                    {{$service->name}}
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-img"><a href="{{$center->path}}">
                                    <img src="{{$center->image?@thumbnail($center->image->path, 'single_center'):asset('images/default-image.png')}}"
                                         alt="{{$center->name}}">
                                </a>
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
                {{--$('#search').on('submit', function (e) {--}}
                {{--e.preventDefault();--}}
                {{--var search_q = $('[name="search_q"]').val();--}}
                {{--var service_id = $('[name="service_id"]').val();--}}
                {{--var sector_id = $('[name="sector_id"]').val();--}}
                {{--var url = "{{route("centers")}}" + "?";--}}
                {{--url += search_q == !search_q || search_q.length === 0 ||--}}
                {{--search_q === "" || !/[^\s]/.test(search_q) ||--}}
                {{--/^\s*$/.test(search_q) || search_q.replace(/\s/g, "") === "" ? "" : "q=" + search_q + "&";--}}
                {{--url += sector_id == 0 ? "" : "sector_id=" + sector_id + "&";--}}
                {{--url += service_id == 0 ? "" : "service_id=" + service_id;--}}

                {{--if (url != "{{route('centers')}}" + "?")--}}
                {{--window.location.href = url;--}}

                {{--})--}}
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
