@extends('layouts.master')

@section('title',trans('app.centers.centers'))
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center"> {{trans('app.centers.add_center')}} </h2>
            <div class="feildcont">
                @if (!session('status'))
                    <form method="post" action="{{route('centers.create', ['id' => $company->id])}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="reg-part">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="alert-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2"> {{trans('app.centers.center_name')}} </label>
                                <div class="col-xs-12 col-md-10">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input value="{{@Request::old('name')}}" type="text" name="name" class="effect-9 form-control"
                                                   placeholder="{{trans('app.centers.center_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2">{{trans('app.address')}} </label>
                                <div class="col-xs-12 col-md-10">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                        <textarea  name="address" class="effect-9 form-control" rows="5"
                                                  placeholder=" {{trans('app.address')}}">{{@Request::old('address')}}</textarea>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2">{{trans('app.add_logo')}}</label>
                                <div class="col-xs-12 col-md-4">
                                    <div class="file-upload" data-input-name="logo">
                                        <div class="file-input"><input name="logo" type="file" accept="image/*"></div>
                                        <div class="drop-click-zone">
                                            <div class="filethumbnail"></div>
                                        </div>
                                        <div class="info"></div>
                                        <div class="message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2"> {{trans('app.sectors.sector')}}</label>
                                <div class="col-xs-12 col-md-8 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="sector_id" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.sectors.choose_sector')}}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}">{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <h3>{{trans('app.services.services')}}</h3>
                            <div class="form-group-lg row">
                                <div class="col-xs-12 col-md-8 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="services[]" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.services.choose_service')}} </option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>

                            <a class="add_field_button" role="button" data-toggle="collapse" href="#collapseExample"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i> اضافة
                                المزيد
                                من الخدمات</a>
                            <div class="clearfix collapse" id="collapseExample" aria-expanded="true" style="">
                                <div class="form-group-lg row">
                                    <div class="col-xs-12 col-md-8 new-f-group">
                                        <div class="form-group clearfix">
                                            <select type="text" name="services[]" class="effect-9 form-control">
                                                <option value="{{null}}">{{trans('app.services.choose_service')}} </option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <div class="col-xs-12 col-md-8 new-f-group">
                                        <div class="form-group clearfix">
                                            <select type="text" name="services[]" class="effect-9 form-control">
                                                <option value="{{null}}">{{trans('app.services.choose_service')}} </option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.phone_number')}} </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-phone"></i></span>
                                            <input name="phone_number" type="tel" class="effect-9 form-control"
                                                   placeholder="000 0000 0000">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.mobile_number')}} </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-mobile"></i></span>
                                            <input name="mobile_number" type="tel" class="effect-9 form-control"
                                                   placeholder="000 0000 0000">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-envelope"></i></span>
                                            <input name="email" type="email" class="effect-9 form-control"
                                                   placeholder="{{trans('app.fields.email')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-group-lg text-center">
                            <button type="submit" class="uperc padding-md fbutcenter">{{trans('app.centers.add_center')}} </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

    </section>
    @push('scripts')
        <script>
            $(document).ready(function () {
                UnoDropZone.init();
            });
        </script>
    @endpush
@endsection