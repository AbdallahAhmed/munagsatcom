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
                                    <input name="status" id="first_status" value="0" type="checkbox"
                                           @if(in_array(0, $chosen_status)) checked @endif>
                                    <label for="first_status">{{trans('app.status_array.0')}}</label>
                                </div>
                                <div class="checkbox">
                                    <input name="status" id="sec_status" value="1" type="checkbox"
                                           @if(in_array(1, $chosen_status)) checked @endif>
                                    <label for="sec_status">  {{trans('app.status_array.1')}} </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-4">{{trans('app.chances.posted_at')}}</label>
                                <div class="col-xs-12 col-md-8 new-f-group">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="{{date('m-d-Y')}}"
                                             data-date-format="dd-mm-yyyy">
                                            <input name="created_date" value="{{$created_at? $created_at : ""}}"
                                                   data-date-format="dd-mm-yyyy" class="effect-9 form-control" id="date"
                                                   placeholder="dd-mm-yyyy"
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

            @if(count($chances)==0)
                <p class="col-md-8 not-found">{{trans('app.chances.not_found')}}</p
            @else
                <div class="col-md-8 content">
                    <h2>{{trans('app.chances.chances_est')}}</h2>
                    <!-------------- Begin:Card -------------->
                    @foreach($chances as $chance)

                        <div class="card foras">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-2">
                                        @if($chance->image)
                                            <div class="card-img"><a href="{{$chance->path}}"><img
                                                            src="{{thumbnail($chance->image->path)}}"
                                                            alt="{{$chance->name}}"></a></div>
                                        @endif
                                    </div>
                                    <div class="col-md-10">
                                        <div class="title">
                                            <p> {{trans('app.chances.chance')}}<span><a
                                                            href="{{$chance->path}}">{{$chance->name}}</a></span></p>
                                            <p>{{trans('app.the_company')}}
                                                <span>{{$chance->company?$chance->company->name:'--'}}</span></p>
                en                        </div>
                                    </div>
                                </div>
                                <div class="card-share">
                                    <div class="hideshare-wrap" style="width:40px; height:40px;">
                                        <a class="share hideshare-btn" href="#">
                                            <i class="fa fa-share-alt"></i>
                                        </a>
                                        <ul class="hideshare-list shown" style="width: 80px; left: 50px; right: -50px;">
                                            <li>
                                                <a class="shareBtn" data-title="{{$chance->name}}"
                                                   data-sharer="facebook" href="{{$chance->path}}">
                                                    <i class="fa fa-facebook fa-2x"></i>
                                                    <span>Facebook</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="shareBtn" data-title="{{$chance->name}}" data-sharer="twitter"
                                                   href="{{$chance->path}}">
                                                    <i class="fa fa-twitter-square fa-2x"></i>
                                                    <span>Twitter</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-date clearfix">
                                <div class="item one_thrd">
                                    <div class="progress ">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{$chance->progress}}"
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
                                <div class="light-white one_half padt">{{trans('app.chances.value')}}:
                                    <span class="text-blue"> {{$chance->value}}</span>
                                </div>
                            </div>
                        </div>
                @endforeach

                <!-------------- End:Card -------------->
                    <!-------------- Begin:pagination -------------->
                    <div class="text-center">
                        {{$chances->appends(Request::all())->render()}}
                    </div>
                    <!-------------- End:pagination -------------->
                </div>
        @endif

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
                    url = created_date.length > 0 ? url + "created_at=" + created_date + "&" : url;
                    for (var i = 0; i < status.length; i++) {
                        url += "status[]=" + status[i];
                        url = i != status.length - 1 ? url + "&" : url;
                    }
                    url = url[url.length - 1] == "&" ? url.slice(0, -1) : url;

                    if (url != "{{route('chances')}}" + "?")
                        window.location.href = url;

                })
                /*  $(function () {
                      $('#upload').on('submit', function (e) {
                          e.preventDefault();
                          var form = $(this);
                          var chance_id =
                          var file = $('[name="file"]');
                          var formData = new FormData();
                          formData.append('file', file[0].files[0]);
                          formData.append('chance_id', chance_id)
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });
                          $.ajax({
                              type: "post",
                              url: "{{route('chances.offers')}}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (data.success) {
                                    $("#myModal").modal('hide');
                                    $("#SuccessModal").modal('show');
                                }else{
                                    $('.alert-danger').html(data.errors);
                                    $('.alert-danger').show();
                                }
                            },
                            error: function () {
                                alert("Internal Server Error")
                            }
                        })
                    })
                })*/
                $("body").on("click", ".shareBtn", function (e) {
                    e.preventDefault
                    var base = $(this);

                    url = base.attr('href');
                    title = base.data('title');

                    if (base.data("sharer") == "facebook") {
                        link = "https://www.facebook.com/sharer/sharer.php?u=" + url;
                    }

                    if (base.data("sharer") == "twitter") {
                        link = "https://twitter.com/intent/tweet?url=" + url + "&via=monaasat&text=" + title.replace('#', '');
                    }

                    var winWidth = 650;
                    var winHeight = 350;
                    var winTop = (screen.height / 2) - (winHeight / 2);
                    var winLeft = (screen.width / 2) - (winWidth / 2);

                    window.open(link, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);

                    return false;

                });
            })
        </script>
    @endpush
@endsection