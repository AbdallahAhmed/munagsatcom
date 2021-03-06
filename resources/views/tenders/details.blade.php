@extends('layouts.master')


@section('title',$tender->name)

@section('meta')
    <meta name="title" content="{{$tender->name}}">
    <meta name="description" content="<?= str_limit($tender->excerpt, 150)?>">
    <meta property="og:locale" content="{{app()->getLocale()}}"/>
    <meta property="og:title" content="{{$tender->name}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{$tender->path}}"/>
    <meta property="og:site_name" content="{{$tender->name}}"/>
    <meta property="og:description"
          content="تفخر مناقصاتكم بكونها الموقع الاول في السعودية الذي يقدم خدمة فريدة من نوعها من خلال طرح  كراسات الشروط والمناقصات للمشاريع الحكومية وفق اعلى معايير الشفافية">
    <meta property="og:image" content="{{@uploads_url($tender->org->logo->path)}}">
    <meta name="twitter:title" content="{{$tender->name}}">
    <meta name="twitter:description"
          content="تفخر مناقصاتكم بكونها الموقع الاول في السعودية الذي يقدم خدمة فريدة من نوعها من خلال طرح  كراسات الشروط والمناقصات للمشاريع الحكومية وفق اعلى معايير الشفافية">
    <meta name="twitter:image" content="{{@uploads_url($tender->org->logo->path)}}">

    <meta name="twitter:url" content="{{$tender->path}}">
@endsection

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12 content-details">
                <h2><span>{{trans('app.tenders.details')}} </span></h2>

                <div class="card-details">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img">
                                    <a href="{{@uploads_url($tender->org->logo->path)}}" class="open-image"> <img
                                                src="{{@uploads_url($tender->org->logo->path)}}"
                                                alt="{{@$tender->org->name}}" title="{{@$tender->org->name}}"></a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item ">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.id')}}</div>
                                            <div class="one_xlarg"> {{$tender->number}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.name')}}</div>
                                            <div class="one_xlarg">{{$tender->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.tender_activity')}}</div>
                                            <div class="one_xlarg">{{$tender->activity->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.objective')}}</div>
                                            <div class="one_xlarg">{{$tender->objective}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.org')}}</div>
                                            <div class="one_xlarg">{{@$tender->org->name}}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-price clearfix">
                        <div class="one_half"><em>*</em> {{trans('app.tenders.cb_real_price')}}
                            <span> {{$tender->cb_real_price}} {{trans('app.$')}} </span>
                        </div>
                        <div class="one_half"><em>*</em> {{trans('app.tenders.cb_downloaded_price')}}
                            <span> {{$tender->cb_downloaded_price}} {{trans('app.$')}} </span>
                        </div>
                    </div>

                    @if($tender->progress<100)
                        <div class="card-cont">
                            <div class="row">
                                <div class="col-md-5 padt">{{trans('app.tenders.remaining_hours')}}</div>
                                <div class="col-md-6">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{$tender->progress}}"
                                             aria-valuemin="0"
                                             aria-valuemax="100" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top"
                                          title=" {{$tender->last_get_offer_at->diffInDays(\Carbon\Carbon::now())}} {{trans('app.day')}}"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card-date clearfix">
                        <h3 class="text-center"><span>{{trans('app.tenders.dates')}}</span></h3>
                        <div class="item one_four">
                            <p>{{trans('app.tenders.files_opened_at')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{hijri_date($tender->files_opened_at)}}</span>-<span
                                        class="text-grey">{{$tender->files_opened_at->format('H:s')}}</span>

                                <small class="text-grey block">{{($tender->files_opened_at)->format('Y/m/d')}}</small>
                            </p>
                        </div>
                        <div class="item one_four">
                            <p>{{trans('app.tenders.last_get_offer_at')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{hijri_date($tender->last_get_offer_at)}}</span>-<span
                                        class="text-grey">{{$tender->last_get_offer_at->format('H:s')}}</span>
                                <small class="text-grey block">{{($tender->last_get_offer_at)->format('Y/m/d')}}</small>

                            </p>
                        </div>

                        <div class="item one_four">
                            <p>{{trans('app.tenders.created')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{hijri_date($tender->published_at)}} </span>

                                <br>
                                <small class="text-grey block">{{($tender->published_at)->format('Y/m/d')}}</small>
                            </p>
                        </div>
                        <div class="item one_four">
                            <p>{{trans('app.tenders.last_queries_at')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{hijri_date($tender->last_queries_at)}}</span>
                                <br>
                                <small class="text-grey block">{{($tender->last_queries_at)->format('Y/m/d')}}</small>
                            </p>
                        </div>
                    </div>

                    <div class="details-box">
                        <div class="details-item ">
                            <ul>
                                <li class="clearfix">
                                    <div class="one_xsmall title"> {{trans('app.tenders.address_files_open')}}</div>
                                    <div class="one_xlarg">{{$tender->address_files_open or '--'}} </div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title"> {{trans('app.tenders.address_execute')}}</div>
                                    <div class="one_xlarg">{{$tender->address_execute or '--'}}</div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title">{{trans('app.tenders.address_get_offer')}}</div>
                                    <div class="one_xlarg">{{$tender->address_get_offer or '--'}}</div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title">{{trans('app.tenders.places')}}</div>
                                    <div class="one_xlarg area">
                                        <ul>
                                            @foreach($tender->places as $place)
                                                <li>{{$place->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if(count($tender->files)>0)
                        <div class="download-box">
                            <h3 class="text-center"><span>{{trans('app.tenders.upload_files')}}</span></h3>
                            @foreach($tender->files  as $file)
                                <a href="{{uploads_url($file->path)}}" target="_blank"
                                   class="btn btn-default">{{$file->title}}.pdf</a>
                            @endforeach
                        </div>
                    @endif


                    <div class="download-box">
                        <h3 class="text-center"><span>{{trans('app.tenders.download')}}</span></h3>
                        @if(!fauth()->check())
                            <p>{{trans('app.register_purchase_tender')}}<a
                                        href="{{route('register')}}"> {{trans('app.register_now')}} </a></p>
                            <p>{{trans('app.account_register')}}<a
                                        href="{{route('login',['lang'=>app()->getLocale()])}}"> {{trans('app.login')}} </a>
                            </p>
                        @else

                            <div class="row">
                                <div class="col" style="text-align: center">
                                    @if($tender->is_bought)
                                        <a type="button"
                                           href="{{route('tenders.download', ['id' => $tender->id, 'lang' => app()->getLocale()])}}"
                                           class="btn btn-default">
                                            {{trans('app.tenders.download')}}
                                        </a>
                                    @else
                                        @if(fauth()->user()->can_buy)
                                            <a type="button" class="btn btn-primary" data-toggle="modal"
                                               data-target="#buycb">
                                                {{trans('app.tenders.buy')}}
                                            </a>
                                        @else
                                            <div class="alert alert-warning">
                                                {{trans('app.you_cannot_buy')}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </section>
    @if(fauth()->check()&&!$tender->is_bought)
        <style>
            .modal-header .close {
                margin-top: -24px;
            }
        </style>
        <div class="modal fade" id="buycb" tabindex="-1" role="dialog" aria-labelledby="buycb" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"> {{trans('app.tenders.buy')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @php
                        $user=fauth()->user()->in_company?fauth()->user()->company[0]:fauth()->user();
                        $points=tax($tender->points,false);
                    @endphp
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">{{ trans('app.cb_price') }}
                                :  {{ $tender->points }} {{trans('app.point')}}</div>

                            <div class="col-md-6">{{ trans('app.tax') }}
                                : {{ tax($tender->points) }} {{trans('app.point')}}</div>
                        </div>
                        <hr>
                        <p>{{ trans('app.current_points') }}
                            : {{ $user->points }} {{trans('app.point')}}</p>
                        <hr>
                        <p class="{{$user->points - $tender->points<=0?'text-danger':''}}"> {{ trans('app.points_after_buy') }}
                            : {{ $user->points - $tender->points }} {{trans('app.point')}}</p>
                        <hr>
                        @if($user->points - $points>=0)
                            <p class="fieldset" style="margin: 0;">
                                <input type="checkbox" name="terms" id="accept-terms">
                                <label for="accept-terms">{{trans('app.accept_with')}} <a target="_blank"
                                                                                          href="{{route('page.show', ['slug' => 'الشروط والأحكام'])}}"
                                                                                          class="text-primary">{{trans('app.terms')}}</a></label>
                            </p>
                        @endif
                        <a href="{{route('user.recharge')}}"
                           class="text-danger">{{$user->points - $points<0?trans('app.please_recharge'):''}}</a>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('tenders.buy',['id'=>$tender->id,'lang'=>app()->getLocale()])}}"
                              method="post">
                            {{csrf_field()}}
                            <button type="submit"
                                    class="btn btn-primary"
                                    id="{{$user->points - $points<0?'':'can-buy'}}"
                                    disabled>{{trans('app.tenders.buy')}}</button>
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{trans('app.close')}}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection



@push('scripts')
    <script>
        $(function () {
            @if(session('download'))
            setTimeout(function () {
                window.location.href = "{{session('download')}}";
            })
            @endif
            $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
        });

        $('#accept-terms').change(function (e) {
            var $base = $('#can-buy');
            if ($base.length && e.target.checked) {
                $base.removeAttr('disabled')
            } else {
                $base.attr('disabled', true)
            }
        });
        $(".progress-bar").each(function () {
            each_bar_width = $(this).attr('aria-valuenow');
            $(this).width(each_bar_width + '%');
        });
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


@endpush