@extends('layouts.master')


@section('title',trans('app.tenders.tenders'))



@section('content')
    <section class="container"><div class="row">
            <!-------------- Begin:right side -------------->
            <div class="col-md-4">
                <div class="side-box">
                    <h2>ابحث فى المناقصات</h2>
                    <div class="feildcont">
                        <form>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">النشاط</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option>النشاط</option>
                                            <option>النشاط</option>
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">المناطق</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option>المناطق</option>
                                            <option>المناطق</option>
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">الجهة الحكوميه</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option>الجهة الحكوميه</option>
                                            <option>الجهة الحكوميه</option>
                                        </select>
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3"> التصنيف</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" class="effect-9 form-control">
                                            <option>التصنيف</option>
                                            <option>التصنيف</option>
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg clearfix">
                                <label class="">أظهار المناقصات المنتهيه
                                    <input type="radio" name="radio">
                                </label>
                            </div>
                            <div class="form-group-lg clearfix">
                                <label class="col-xs-12 col-md-3">السعر </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="range">
                                        <input class="range-example" type="text" min="100" max="10000" value="" name="points" step="10">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-5"> أخر ميعاد لإستلام العروض </label>
                                <div class="col-xs-12 col-md-7">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                            <input class="effect-9 form-control" id="date" placeholder="mm/dd/yyyy" type="text">
                                            <span class="add-on"><i class="fa  fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg text-center">
                                <button type="submit" form="" class="uperc padding-md fbutcenter"> بحث </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-------------- End:right side -------------->
            <!-------------- Begin:left side -------------->
            <div class="col-md-8 content">
                <h2>مناقصات حكومية</h2>
                <!-------------- Begin:Card -------------->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card-img"><a href="{{route('tenders.details', ['id' => 2])}}"><img src="{{assets('/assets')}}/images/pic1.png" alt=""></a></div>
                            </div>
                            <div class="col-md-10">
                                <div class="title">
                                    <a href="{{route('tenders.details', ['id' => 2])}}"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
                                    <p>مدينة الملك عبدالله الطبيه بالعاصمة المقدسة- إدارة العقود و المشتريات</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-share">
                            <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-date clearfix">
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>

                    </div>
                    <div class="card-cont row">
                        <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                        <div class="col-md-6"><div class="progress ">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                </div>
                            </div></div>
                    </div>
                    <div class="card-price clearfix">
                        <div class="priceshadow one_half">  قيمة الكراسه  <span class="text-blue">10.000 ريال سعودى </span></div>
                        <div class="light-white one_half">  رقم المناقصه  <span class="text-blue">2018/217/33 </span></div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card-img"><a href="{{route('tenders.details', ['id' => 2])}}"><img src="{{assets('/assets')}}/images/pic1.png" alt=""></a></div>
                            </div>
                            <div class="col-md-10">
                                <div class="title">
                                    <a href="{{route('tenders.details', ['id' => 2])}}"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
                                    <p>مدينة الملك عبدالله الطبيه بالعاصمة المقدسة- إدارة العقود و المشتريات</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-share">
                            <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-date clearfix">
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>

                    </div>
                    <div class="card-cont row">
                        <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                        <div class="col-md-6"><div class="progress ">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                </div>
                            </div></div>
                    </div>
                    <div class="card-price clearfix">
                        <div class="priceshadow one_half">  قيمة الكراسه  <span class="text-blue">10.000 ريال سعودى </span></div>
                        <div class="light-white one_half">  رقم المناقصه  <span class="text-blue">2018/217/33 </span></div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card-img"><a href="{{route('tenders.details', ['id' => 2])}}"><img src="{{assets('/assets')}}/images/pic1.png" alt=""></a></div>
                            </div>
                            <div class="col-md-10">
                                <div class="title">
                                    <a href="{{route('tenders.details', ['id' => 2])}}"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
                                    <p>مدينة الملك عبدالله الطبيه بالعاصمة المقدسة- إدارة العقود و المشتريات</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-share">
                            <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-date clearfix">
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>

                    </div>
                    <div class="card-cont row">
                        <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                        <div class="col-md-6"><div class="progress ">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                </div>
                            </div></div>
                    </div>
                    <div class="card-price clearfix">
                        <div class="priceshadow one_half">  قيمة الكراسه  <span class="text-blue">10.000 ريال سعودى </span></div>
                        <div class="light-white one_half">  رقم المناقصه  <span class="text-blue">2018/217/33 </span></div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card-img"><a href="{{route('tenders.details', ['id' => 2])}}"><img src="{{assets('/assets')}}/images/pic1.png" alt=""></a></div>
                            </div>
                            <div class="col-md-10">
                                <div class="title">
                                    <a href="{{route('tenders.details', ['id' => 2])}}"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
                                    <p>مدينة الملك عبدالله الطبيه بالعاصمة المقدسة- إدارة العقود و المشتريات</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-share">
                            <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-date clearfix">
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>

                    </div>
                    <div class="card-cont row">
                        <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                        <div class="col-md-6"><div class="progress ">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                </div>
                            </div></div>
                    </div>
                    <div class="card-price clearfix">
                        <div class="priceshadow one_half">  قيمة الكراسه  <span class="text-blue">10.000 ريال سعودى </span></div>
                        <div class="light-white one_half">  رقم المناقصه  <span class="text-blue">2018/217/33 </span></div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card-img"><a href="{{route('tenders.details', ['id' => 2])}}"><img src="{{assets('/assets')}}/images/pic1.png" alt=""></a></div>
                            </div>
                            <div class="col-md-10">
                                <div class="title">
                                    <a href="{{route('tenders.details', ['id' => 2])}}"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة بمدينة الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
                                    <p>مدينة الملك عبدالله الطبيه بالعاصمة المقدسة- إدارة العقود و المشتريات</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-share">
                            <a class="share" href="#"><i class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-date clearfix">
                        <div class="item one_thrd">
                            <p>تاريخ و وقت فتح المظاريف</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>اخر موعد إاستلام العروض</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span class="text-grey">14:00</span></p>
                        </div>
                        <div class="item one_thrd">
                            <p>تاريخ نشر المنافسة إلكترونيا</p>
                            <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                        </div>

                    </div>
                    <div class="card-cont row">
                        <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه </div>
                        <div class="col-md-6"><div class="progress ">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top" title=" 5 ايام و 10 ساعات"> </span>
                                </div>
                            </div></div>
                    </div>
                    <div class="card-price clearfix">
                        <div class="priceshadow one_half">  قيمة الكراسه  <span class="text-blue">10.000 ريال سعودى </span></div>
                        <div class="light-white one_half">  رقم المناقصه  <span class="text-blue">2018/217/33 </span></div>
                    </div>

                </div>
                <!---------------- End:Card ---------------->
                <!-------------- Begin:pagination -------------->
                <div class="text-center">
                    <ul class="pagination"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul>
                </div>
                <!---------------- End:pagination ---------------->
            </div>
            <!-------------- End::left side -------------->
        </div></section>
    <!--Begin:content-->
    {{--<section class="container">
        <div class="row">
            <!-------------- Begin:right side -------------->
            <div class="col-md-4">
                <div class="side-box">
                    <h2>{{trans('app.tenders.search')}}</h2>
                    <div class="feildcont">
                        <form>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.activity')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="activity_id" class="effect-9 form-control">
                                            <option  value>{{trans('app.tenders.choose_activity')}}</option>
                                        @foreach(\Dot\Tenders\Models\TenderActivity::where('status',1)->get() as $activtiy)
                                                <option value="{{$activtiy->id}}" {{old('activity_id',Request::get('activity_id'))==$activtiy->id?' selected ':''}}>{{$activtiy->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.places')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">

                                        <select name="place_id" class="effect-9 form-control">
                                            <option  value>{{trans('app.tenders.choose_place')}}</option>
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
                                            <option  value>{{trans('app.tenders.choose_org')}}</option>
                                        @foreach(\Dot\Tenders\Models\TenderOrg::where('status',1)->get() as $org)
                                                <option value="{{$org->id}}" {{old('org_id',Request::get('org_id'))==$org->id?' selected ':''}}>{{$org->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.category')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="catgory_id" class="effect-9 form-control">
                                            <option  value>{{trans('app.tenders.choose_category')}}</option>
                                        @foreach(\Dot\Categories\Models\Category::all() as $catgory)
                                                <option value="{{$catgory->id}}" {{old('catgory_id',Request::get('catgory_id'))==$org->id?' selected ':''}}>{{$catgory->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg clearfix">
                                <label>
                                    {{trans('app.tenders.expired_at')}}
                                    <input type="checkbox" value="1" name="show_expired">
                                </label>
                            </div>
                            <div class="form-group-lg clearfix">
                                <label class="col-xs-12 col-md-3">{{trans('app.tenders.price')}} </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="range">
                                        <input class="range-example" type="text" min="100" max="10000"
                                               value="{{Request::get('price')}}"
                                               name="price" step="10">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-5"> {{trans('app.tenders.offers_expired')}} </label>
                                <div class="col-xs-12 col-md-7">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                             data-date-format="dd-mm-yyyy">
                                            <input class="effect-9 form-control" id="date" placeholder="mm/dd/yyyy"
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
                                        <div class="card-img"><a href="monaasat-details.html">
                                                <img src="{{thumbnail($tender->org->logo->path)}}"
                                                     alt="{{$tender->org->name}}"></a>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="title">
                                            <a href="{{$tender->path}}" title="{{$tender->name}}">
                                                <h2>{{$tender->name}}</h2>
                                            </a>
                                            <p>{{$tender->objective}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-share">
                                    <a class="share" href="javascript:void(0)"><i class="fa fa-share-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-date clearfix">
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.files_opened_at')}}</p>
                                    <p><i class="fa  fa-calendar"></i> <span
                                                class="text-grey">{{$tender->files_opened_at->format('Y/m/d')}}</span>-<span
                                                class="text-grey">{{$tender->files_opened_at->format('H:s')}}</span></p>
                                </div>
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.last_get_offer_at')}}</p>
                                    <p><i class="fa  fa-calendar"></i> <span
                                                class="text-grey">{{$tender->last_get_offer_at->format('Y/m/d')}}</span>-<span
                                                class="text-grey">{{$tender->last_get_offer_at->format('H:s')}}</span>
                                    </p>
                                </div>
                                <div class="item one_thrd">
                                    <p>{{trans('app.tenders.created')}}</p>
                                    <p><i class="fa  fa-calendar"></i> <span
                                                class="text-grey">{{$tender->published_at->format('Y/m/d')}}</span></p>
                                </div>

                            </div>
                            <div class="card-cont row">
                                <div class="col-md-6 padt">{{trans('app.tenders.remaining_hours')}}</div>
                                <div class="col-md-6">
                                    <div class="progress ">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{($tender->published_at->getTimestamp()/$tender->files_opened_at->getTimestamp())*100}}"
                                             aria-valuemin="0" aria-valuemax="0" style="">
                                            <span class="popOver" data-toggle="tooltip" data-placement="top"
                                                  title="{{$tender->files_opened_at->diffForHumans(\Carbon\Carbon::now())}}"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-price clearfix">
                                <div class="priceshadow one_half"> {{trans('app.tenders.cb')}} <span
                                            class="text-blue">{{$tender->cb_real_price}} {{trans('app.$')}} </span>
                                </div>
                                <div class="light-white one_half">{{trans('app.tenders.id')}} <span
                                            class="text-blue">{{$tender->id}}</span>
                                </div>
                            </div>
                        </div>
                @endforeach
            @endif

            <!-------------- Begin:pagination -------------->
                <div class="text-center">
                    {{$tenders->appends(Request::all())->render()}}
                </div>
                <!---------------- End:pagination ---------------->
            </div>
            <!-------------- End::left side -------------->
        </div>
    </section>--}}
    <!--End:content-->

@endsection

@push('scripts')
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