@extends('layouts.master')


@section('title',trans('app.tenders.tenders'))



@section('content')
    <!--Begin:content-->
    <section class="container">
        <div class="row">
            <!-------------- Begin:right side -------------->
            <div class="col-md-4" id="filter-search">
                <div class="side-box">
                    <h2>{{trans('app.tenders.search')}}</h2>
                    <div class="feildcont">
                        <form>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app._search')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group  clearfix">
                                        <input type="search" class="form-control" placeholder="{{trans('app._search')}}"
                                               name="q" value="{{\Request::get('q')}}">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.activity')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="activity_id" class="effect-9 form-control">
                                            <option value>{{trans('app.tenders.choose_activity')}}</option>
                                            @foreach(\Dot\Tenders\Models\TenderActivity::where('status',1)->get() as $activtiy)
                                                <option value="{{$activtiy->id}}" {{old('activity_id',Request::get('activity_id'))==$activtiy->id?' selected ':''}}>{{$activtiy->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.places')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">

                                        <select name="place_id" class="effect-9 form-control">
                                            <option value>{{trans('app.tenders.choose_place')}}</option>
                                            @foreach(Dot\I18n\Models\Place::where('status',1)->get() as $place)
                                                <option value="{{$place->id}}" {{old('place_id',Request::get('place_id'))==$place->id?' selected ':''}}>{{($place->t_name)}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.org')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="org_id" class="effect-9 form-control">
                                            <option value>{{trans('app.tenders.choose_org')}}</option>
                                            @foreach(\Dot\Tenders\Models\TenderOrg::where('status',1)->get() as $org)
                                                <option value="{{$org->id}}" {{old('org_id',Request::get('org_id'))==$org->id?' selected ':''}}>{{$org->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg clearfix">
                                <label>
                                    {{trans('app.tenders.expired_at')}}
                                    <input type="checkbox" value="1"
                                           {{Request::get('show_expired')==1?'checked':''}} name="show_expired">
                                </label>
                            </div>

                            <div class="form-group-lg clearfix">
                                <label class="col-xs-12 col-md-12">{{trans('app.tenders.cb_downloaded_price')}} </label>
                                <div class="col-xs-12 col-md-12">
                                    <div class="range">
                                        <input class="range-example" type="text" min="1"
                                               max="{{(int)$cb_downloaded_price_max}}"
                                               value="{{Request::get('cb_downloaded_price')}}"
                                               name="cb_downloaded_price"
                                               step="{{(int)($cb_downloaded_price_max/100)+1}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-12"> {{trans('app.tenders.offers_expired')}} </label>
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="{{date('m-d-Y')}}"
                                             autocomplete="false"
                                             data-date-format="dd-mm-yyyy">
                                            <input class="effect-9 form-control" placeholder="mm/dd/yyyy"
                                                   type="text" name="offer_expired"
                                                   value="{{old('offer_expired',Request::get('offer_expired'))}}">
                                            <span class="add-on"><i class="fa  fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg text-center">
                                <button type="submit"
                                        class="uperc padding-md fbutcenter"> {{trans('app.search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 content">

                @if(count($tenders)==0)
                    <p class="col-md-8 not-found">{{trans('app.tenders.not_found')}}</p>
                @endif
                @if(count($tenders)!=0)
                    <h2>{{trans('app.tenders.tenders')}}</h2>
                    @foreach($tenders as $tender)
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="card-img"><a href="{{$tender->path}}">
                                                <img src="{{@thumbnail($tender->org->logo->path)}}"
                                                     alt="{{$tender->org->name}}"></a>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="title">
                                            <a href="{{$tender->path}}" title="{{$tender->name}}">
                                                <h2>{{$tender->name}}</h2>
                                            </a>
                                            <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 500px;">
                                                {{$tender->objective}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-share">
                                    <a class="share" data-title="{{$tender->title}}" data-desc="{{$tender->excerpt}}"
                                       data-link="{{$tender->path}}" href="javascript:void(0)"><i
                                                class="fa fa-share-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-date clearfix">
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.files_opened_at')}}</p>
                                    <p><i class="fa  fa-calendar"></i>
                                        <span class="text-grey">{{hijri_date($tender->files_opened_at)}}</span>-<span class="text-grey">{{$tender->files_opened_at->format('H:s')}}</span>
                                        <small class="text-grey">{{($tender->files_opened_at)->format('Y/m/d')}}</small>
                                    </p>
                                </div>
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.last_get_offer_at')}}</p>
                                    <p><i class="fa  fa-calendar"></i> <span
                                                class="text-grey">{{hijri_date($tender->last_get_offer_at)}}</span>-<span
                                                class="text-grey">{{$tender->last_get_offer_at->format('H:s')}}</span>
                                        <small class="text-grey">{{($tender->last_get_offer_at)->format('Y/m/d')}}</small>
                                    </p>
                                </div>
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.created')}}</p>
                                    <p><i class="fa  fa-calendar"></i>
                                        <span class="text-grey">{{hijri_date($tender->published_at)}}</span>
                                        <br><small class="text-grey">{{($tender->published_at)->format('Y/m/d')}}</small>

                                    </p>
                                </div>

                            </div>
                            @if($tender->progress<100)
                                <div class="card-cont row">
                                    <div class="col-md-4 padt">{{trans('app.tenders.remaining_hours')}}</div>
                                    <div class="col-md-8">
                                        <div class="progress ">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{{$tender->progress}}"
                                                 aria-valuemin="0" aria-valuemax="100" style="">
                                            <span class="popOver" data-toggle="tooltip" data-placement="top"
                                                  title="{{$tender->last_get_offer_at->diffInDays(\Carbon\Carbon::now())}} {{trans('app.day')}}"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="card-price clearfix">
                                <div class="priceshadow one_thrd"> {{trans('app.tenders.cb')}}<br> <span
                                            class="text-blue">{{$tender->cb_real_price}} {{trans('app.$')}} </span>
                                </div>
                                <div class="priceshadow one_thrd"> {{trans('app.tenders.cb_downloaded_price')}}
                                    <br>
                                    @if($tender->cb_downloaded_price!=0)
                                        <span class="text-blue">{{$tender->cb_downloaded_price}} {{trans('app.$')}} </span>
                                    @else
                                        <span class="text-blue">{{trans('app.free')}}</span>
                                    @endif
                                </div>
                                <div class="light-white one_thrd">{{trans('app.tenders.id')}} <br><span
                                            class="text-blue">{{$tender->number}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="text-center">
                    {{$tenders->appends(Request::all())->render()}}
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
            $(".progress-bar").each(function () {
                each_bar_width = $(this).attr('aria-valuenow');
                $(this).width(each_bar_width + '%');
            });
            var date = new Date();
            // date.setDate(date.getDate());

            $('#dp3',).datepicker({
                minDate: date,
            });
            $('#date',).datepicker({
                minDate: date,
            });
            $(".range-example").asRange({
                range: true,
                limit: false,
                //tip: {
//    active: 'onMove'
//    },
                tip: true,
                min: 100,
                value: true,
                keyboard: true,
                replaceFirst: true, // false, 'inherit', {'inherit': 'default'}
                scale: true,
                format(value) {
                    return value;
                }
            });
            $(".share").hideshare({
                link: "",           // Link to URL defaults to document.URL
                title: "",          // Title for social post defaults to document.title
                media: "",          // Link to image file defaults to null
                facebook: true,     // Turns on Facebook sharing
                twitter: true,      // Turns on Twitter sharing
                pinterest: false,    // Turns on Pinterest sharing
                googleplus: false,   // Turns on Google Plus sharing
                linkedin: false,     // Turns on LinkedIn sharing
                position: "right", // Options: Top, Bottom, Left, Right
                speed: 150           // Speed of transition
            });

            if (screen.width >= 991) {
                var cardClass='.content .card';
                var listCardClass='.content';
                $('#filter-search > div').width($('#filter-search').width());
                $(window).scroll(function (e) {
                    var $list = $(listCardClass);
                    var $filterSearch = $('#filter-search');
                    if ($list.length == 0 || $(cardClass).last().length == 0) {
                        return;
                    }
                    if (($(this).scrollTop() + 70) > $list.offset().top) {
                        if (!$filterSearch.hasClass('static-filter')) {
                            $filterSearch.addClass('static-filter')
                        }
                        if ((($(this).scrollTop()+$(cardClass).last().height()) >= $(cardClass).last().offset().top+10)) {
                            $('.static-filter > div').css({
                                'position': 'absolute',
                                'top': $(cardClass).last().offset().top - ($('.static-filter > div').height()-28 ) + 'px'
                            })
                        } else {
                            $('.static-filter > div').css({
                                'position': 'fixed',
                                'top': '62px'
                            })
                        }
                    } else {
                        $('.static-filter > div').css({
                            'position': 'inherit',
                            'top': 'unset'
                        })
                        if ($filterSearch.hasClass('static-filter')) {
                            $filterSearch.removeClass('static-filter')
                        }
                    }

                });
            }

        });
    </script>

    <style>
        .static-filter > div {
            position: fixed;
            top: 62px;
            /*width: 18%;*/
        }
    </style>
@endpush
