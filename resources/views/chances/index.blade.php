@extends('layouts.master')

@section('title',trans('app.chances.chances'))
@section('content')
    <section class="container">
        <div class="row">
            <!-------------- Begin:right side -------------->
            <div class="col-md-4">
                <div class="side-box">
                    <h2>{{trans('app.chances.search_chances')}}</h2>
                    <div class="feildcont">
                        <form id="search">
                            <div class="form-group clearfix">
                                <div class="search-bar">
                                    <div class="icon-addon">
                                        @if($q)
                                            <input name="search_q" type="text"
                                                   placeholder="{{trans('app.chances.search_query')}}..."
                                                   class="form-control" value="{{$q}}">
                                        @else
                                            <input name="search_q" type="text"
                                                   placeholder="{{trans('app.chances.search_query')}}..."
                                                   class="form-control">
                                        @endif
                                        <div class="searh-icn" rel="tooltip"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg clearfix">
                                <p>{{trans('app.fields.status')}}:</p>
                                <div class="checkbox">
                                    <input name="status" value="0" type="checkbox">
                                    <label>{{trans('app.status_array.0')}}</label>
                                </div>
                                <div class="checkbox">
                                    <input name="status" value="1" type="checkbox">
                                    <label>  {{trans('app.status_array.1')}} </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-4">{{trans('app.chances.posted_at')}}</label>
                                <div class="col-xs-12 col-md-8 new-f-group">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                             data-date-format="dd-mm-yyyy">
                                            <input name="created_date" value="{{$created_at? $created_at : ""}}" data-date-format="dd-mm-yyyy" class="effect-9 form-control" id="date" placeholder="dd-mm-yyyy"
                                                   type="text">
                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg text-center">
                                <button type="submit"
                                        class="uperc padding-md fbutcenter">{{trans('app.filter')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-------------- End:right side -------------->
            <!-------------- Begin:left side -------------->
            @foreach($chances as $chance)
                <div class="col-md-8 content">
                    <h2>{{trans('app.chances.chances_est')}}</h2>
                    <!-------------- Begin:Card -------------->
                    <div class="card foras">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card-img"><a href="{{$chance->path}}"><img
                                                    src="{{thumbnail($chance->image->path)}}"
                                                    alt=""></a></div>
                                </div>
                                <div class="col-md-10">
                                    <div class="title">
                                        <p> {{trans('app.chances.chance')}}<span><a
                                                        href="{{$chance->path}}">{{$chance->name}}</a></span></p>
                                        <p>{{trans('app.the_company')}} <span>{{$chance->company->name}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-share">
                                <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                            </div>
                        </div>
                        <div class="card-date clearfix">
                            <div class="item one_thrd">
                                <div class="progress ">
                                    <div class="progress-bar" role="progressbar"
                                         aria-valuenow="{{100-((\Carbon\Carbon::parse($chance->closing_date)->diffInMinutes(\Carbon\Carbon::now())/\Carbon\Carbon::parse($chance->closing_date)->diffInMinutes($chance->created_at))*100)}}"
                                         aria-valuemin="0" aria-valuemax="0" style="">
                                        <span class="popOver" data-toggle="tooltip" data-placement="top"
                                              title="{{\Carbon\Carbon::parse($chance->closing_date)->diffForHumans(\Carbon\Carbon::now())}}"> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="item one_thrd">
                                <p>{{trans('app.chances.due_date')}}</p>
                                <p><i class="fa fa-calendar"></i> <span
                                            class="text-grey">{{$chance->closing_date}}</span></p>
                            </div>
                            <div class="item one_thrd">
                                <p>{{trans('app.chances.created_at')}}</p>
                                <p><i class="fa fa-calendar"></i> <span
                                            class="text-grey">{{\Carbon\Carbon::parse($chance->created_at)->toDateString()}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="card-price clearfix">
                            <div class="priceshadow one_half">
                                <button type="button" class="uperc padding-md fbutcenter btn-mas" data-dismiss="modal"
                                        data-target="#myModal">{{trans('app.chances.apply')}}</button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title"> تقديم على الفرصة </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>غير مؤهل للتسجيل فى هذه الفرصه</p>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button type="submit" form="" class="uperc padding-md fbutcenter">
                                                    تقديم
                                                </button>
                                                <button type="submit" class="uperc padding-md fbutcenter1"
                                                        data-dismiss="modal">الغاء
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="light-white one_half padt">{{trans('app.chances.value')}}: <span
                                        class="text-blue"> {{$chance->value}}</span></div>
                        </div>
                    </div>
                    <!-------------- End:Card -------------->
                    <!-------------- Begin:pagination -------------->
                    <div class="text-center">
                        {{$chances->appends(Request::all())->render()}}
                    </div>
                    <!-------------- End:pagination -------------->
                </div>
        @endforeach
        <!-------------- End:left side -------------->
        </div>
    </section>
    @push('scripts')
        <script>
            $('#dp3').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
            $('#date').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
            });
            // $( window ).scroll(function() {
            // if($( window ).scrollTop() > 10){  // scroll down abit and get the action
            $(".progress-bar").each(function () {
                each_bar_width = $(this).attr('aria-valuenow');
                $(this).width(each_bar_width + '%');
            });
            //  }
            // });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".btn-mas").click(function () {
                    $("#myModal").modal('show');
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".share").hideshare({
                    link: "",           // Link to URL defaults to document.URL
                    title: "",          // Title for social post defaults to document.title
                    media: "",          // Link to image file defaults to null
                    facebook: true,     // Turns on Facebook sharing
                    twitter: true,      // Turns on Twitter sharing
                    pinterest: true,    // Turns on Pinterest sharing
                    googleplus: false,   // Turns on Google Plus sharing
                    linkedin: false,     // Turns on LinkedIn sharing
                    position: "right", // Options: Top, Bottom, Left, Right
                    speed: 150           // Speed of transition
                });
            });
        </script>
        <script>
            $(function () {
                $('#search').on('submit', function (e) {
                    e.preventDefault();
                    var status = [];
                    var search_q = $('[name="search_q"]').val();
                    var created_date = $('#date').datepicker().val();
                    $("input:checkbox[name=status]:checked").each(function () {
                        status.push($(this).val());
                    });
                    var url = "{{route('chances')}}" + "?";
                    url += search_q == !search_q || search_q.length === 0 ||
                    search_q === "" || !/[^\s]/.test(search_q) ||
                    /^\s*$/.test(search_q) || search_q.replace(/\s/g, "") === "" ? "" : "q=" + search_q + "&";
                    url = created_date.length > 0 ? url+"created_at="+created_date+"&" : url ;
                    for (var i = 0; i < status.length; i++) {
                        url += "status[]=" + status[i];
                        url = i != status.length - 1 ? url + "&" : url;
                    }
                    url = url[url.length-1] == "&" ? url.slice(0, -1): url;

                    if (url != "{{route('chances')}}" + "?")
                        window.location.href = url;

                })
            })
        </script>
    @endpush
@endsection