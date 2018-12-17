@extends('layouts.master')


@section('title',""/*$tender->name*/)

@section('content')
    <section class="container">
        <div class="row">
            <!-------------- Begin:content -------------->
            <div class="col-md-12 content-details">
                <h2><span>{{trans('app.tenders.details')}} </span></h2>
                <div class="card-details">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img"><img src="{{asset('/assets')}}/images/monqs-img.png" alt=""></div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item ">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">رقم المناقصه  </div>
                                            <div class="one_xlarg"> 2018/217/33    </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title"> إسم المناقصه   </div>
                                            <div class="one_xlarg"> مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية
                                                بالعاصمة المقدسه </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">  نشاط المناقصه   </div>
                                            <div class="one_xlarg">صناعة</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">الغايه من المناقصه  </div>
                                            <div class="one_xlarg">تطوير للبينية التحتية للسلامه بالمدينة الطيبيه</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">مجال التصنيف</div>
                                            <div class="one_xlarg">انظمة نكافحة الحرق- صيانة المبانى</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">النوع</div>
                                            <div class="one_xlarg">عام</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">الجهة الحكومية   </div>
                                            <div class="one_xlarg"> مكة المكرمة - إدارة العقود و المشتريات </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-price clearfix">
                        <div class="one_half"><em>*</em>  قيمة الكراسة الفعلى  <span> 10.000  ريال سعودى  </span></div>
                        <div class="one_half"><em>*</em>  قيمة تحميل الكراسة  <span> 10.000  ريال سعودى  </span></div>
                    </div>

                    <div class="card-cont"><div class="row">
                            <div class="col-md-5 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                            <div class="col-md-6"><div class="progress ">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                        <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                    </div>
                                </div></div>
                        </div></div>

                    <div class="card-date clearfix">
                        <h3 class="text-center"><span> تواريخ المناقصه </span></h3>
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>
                    </div>

                    <div class="details-box">
                        <div class="details-item ">
                            <ul>
                                <li class="clearfix">
                                    <div class="one_xsmall title">  مكان فتح المظاريف </div>
                                    <div class="one_xlarg">تقدم العروض لدى إدارة العقود المشتريات بمدينة الملك عبدالله الطيبية بالعاصمة المقدسه- مبنى المستودعات </div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title"> مكان التنفيذ    </div>
                                    <div class="one_xlarg"> إدارة العقود المشتريات بمدينة الملك عبدالله الطيبية بالعاصمة المقدسه- مبنى المستودعات </div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title"> مكان تقديم العروض </div>
                                    <div class="one_xlarg">داخل المملكة</div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title">المناطق</div>
                                    <div class="one_xlarg area">
                                        <ul>
                                            <li> منطقة مكة المكرمة  </li>
                                            <li>   جده </li>
                                            <li> الرياض  </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="download-box">
                        <h3 class="text-center"><span>تحميل الملفات</span></h3>
                        @if(!fauth()->check())
                            <p>{{trans('app.register_purchase_tender')}}<a
                                        href="{{route('register')}}"> {{trans('app.register_now')}} </a></p>
                            <p>{{trans('app.account_register')}}<a
                                        href="{{route('login',['lang'=>app()->getLocale()])}}"> {{trans('app.login')}} </a>
                            </p>
                        @endif
                    </div>
                </div>
                {{--<div class="card-details">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img">
                                    <img src="{{thumbnail($tender->org->logo->path)}}"
                                         alt="{{$tender->org->name}}" title="{{$tender->org->name}}">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item ">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.id')}}</div>
                                            <div class="one_xlarg"> {{$tender->id}}</div>
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
                                            <div class="one_xsmall title">{{trans('app.tenders.category')}}</div>
                                            <div class="one_xlarg">
                                                @foreach($tender->categories as $category)
                                                    {{$category->name}}
                                                    @if(!$loop->last)
                                                        -
                                                    @endif
                                                @endforeach
                                                @if(count($tender->categories)==0)
                                                    --
                                                @endif
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.type')}}</div>
                                            <div class="one_xlarg">{{$tender->type->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.tenders.org')}}</div>
                                            <div class="one_xlarg">{{$tender->org->name}}</div>
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

                    <div class="card-cont">
                        <div class="row">
                            <div class="col-md-5 padt">{{trans('app.tenders.remaining_hours')}}</div>
                            <div class="col-md-6">
                                <div class="progress ">
                                    <div class="progress-bar" role="progressbar"
                                         aria-valuenow="{{($tender->published_at->getTimestamp()/$tender->files_opened_at->getTimestamp())*100}}"
                                         aria-valuemin="0"
                                         aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top"
                                          title=" {{$tender->files_opened_at->diffForHumans(\Carbon\Carbon::now())}}"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-date clearfix">
                        <h3 class="text-center"><span>{{trans('app.tenders.dates')}}</span></h3>
                        <div class="item one_thrd">
                            <p>{{trans('app.tenders.files_opened_at')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{$tender->files_opened_at->format('Y/m/d')}}</span>-<span
                                        class="text-grey">{{$tender->files_opened_at->format('H:s')}}</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>{{trans('app.tenders.last_get_offer_at')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{$tender->last_get_offer_at->format('Y/m/d')}}</span>-<span
                                        class="text-grey">{{$tender->last_get_offer_at->format('H:s')}}</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>{{trans('app.tenders.created')}}</p>
                            <p><i class="fa fa-calendar"></i> <span
                                        class="text-grey">{{$tender->published_at->format('Y/m/d')}} </span></p>
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

                    <div class="download-box">
                        <h3 class="text-center"><span>{{trans('app.tenders.upload_files')}}</span></h3>
                        @if(!fauth()->check())
                            <p>{{trans('app.register_purchase_tender')}}<a
                                        href="{{route('register')}}"> {{trans('app.register_now')}} </a></p>
                            <p>{{trans('app.account_register')}}<a
                                        href="{{route('login',['lang'=>app()->getLocale()])}}"> {{trans('app.login')}} </a>
                            </p>
                        @endif
                    </div>
                </div>--}}

            </div>
            <!-------------- End::content -------------->
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
        });

        $(".progress-bar").each(function () {
            each_bar_width = $(this).attr('aria-valuenow');
            $(this).width(each_bar_width + '%');
        });
    </script>
    <script>
        $('#dp3',).datepicker();
        $('#date',).datepicker();
    </script>
    <script>
        $(".range-example").asRange({
            range: true,
            limit: false,
            //tip: {
//    active: 'onMove'
//    },
            tip: true,
            max: 10000,
            min: 100,
            value: true,
            step: 10,
            keyboard: true,
            replaceFirst: true, // false, 'inherit', {'inherit': 'default'}
            scale: true,
            format(value) {
                return value;
            }
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

@endpush