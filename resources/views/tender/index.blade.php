@extends('layouts.master')


@section('title',trans('app.tenders.tenders'))



@section('content')
    <!--Begin:content-->
    <section class="container">
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
                                            @foreach(Dot\I18n\Models\Place::where('status',1)->get() as $place)
                                                <option value="{{$place->id}}" {{old('place_id',Request::get('place_id'))==$place->id?' selected ':''}}>{{$place->name}}</option>
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
                                            @foreach(\Dot\Tenders\Models\TenderOrg::where('status',1)->get() as $org)
                                                <option value="{{$org->id}}" {{old('org_id',Request::get('org_id'))==$org->id?' selected ':''}}>{{$org->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-xs-12 col-md-3">{{app('app.tenders.category')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="catgory_id" class="effect-9 form-control">
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
                                    <input type="radio" value="1" name="show_expired">
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
                                <button type="submit" form=""
                                        class="uperc padding-md fbutcenter"> {{trans('app.search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-------------- End:right side -------------->
            <!-------------- Begin:left side -------------->
            <div class="col-md-8 content">
                <h2>{{trans('app.tenders.tenders')}}</h2>
                @foreach($tenders as $tender)
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card-img"><a href="monaasat-details.html"><img src="images/pic1.png"
                                                                                               alt=""></a>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="title">
                                        <a href="monaasat-details.html"><h2>مناقصة نظام مكافحة الحريق بمركز اورام جدة
                                                بمدينة
                                                الملك عبدالله الطبية بالعاصمة المقدسه</h2></a>
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
                                <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/22</span>-<span
                                            class="text-grey">14:00</span></p>
                            </div>
                            <div class="item one_thrd">
                                <p>اخر موعد إاستلام العروض</p>
                                <p><i class="fa  fa-calendar"></i> <span class="text-grey">1440/01/21</span>-<span
                                            class="text-grey">14:00</span></p>
                            </div>
                            <div class="item one_thrd">
                                <p>تاريخ نشر المنافسة إلكترونيا</p>
                                <p><i class="fa  fa-calendar"></i> <span class="text-grey">1439/12/04 </span></p>
                            </div>

                        </div>
                        <div class="card-cont row">
                            <div class="col-md-6 padt"> الايام الباقية / الساعات اذا كان اقل من 24 ساعه</div>
                            <div class="col-md-6">
                                <div class="progress ">
                                    <div cl0ass="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                         aria-valuemax="0" style="">
                                    <span class="popOver" data-toggle="tooltip" data-placement="top"
                                          title=" 5 ايام و 10 ساعات"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-price clearfix">
                            <div class="priceshadow one_half"> قيمة الكراسه <span
                                        class="text-blue">10.000 ريال سعودى </span></div>
                            <div class="light-white one_half"> رقم المناقصه <span class="text-blue">2018/217/33 </span>
                            </div>
                        </div>
                    </div>
            @endforeach

            <!-------------- Begin:pagination -------------->
                <div class="text-center">
                    <ul class="pagination">
                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
                        </li>
                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                    </ul>
                </div>
                <!---------------- End:pagination ---------------->
            </div>
            <!-------------- End::left side -------------->
        </div>
    </section>
    <!--End:content-->

@endsection