@extends('layouts.master')
@push("head")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
@endpush
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
                                    <li class="alert-info">
                                        {{trans("services::points.service_center_add")}}
                                        ({{option('service_center_add',0)}})
                                        {{trans('app.point')}}
                                    </li>
                            </ul>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2"> {{trans('app.centers.center_name')}}<span
                                            class="text-danger">*</span></label>
                                <div class="col-xs-12 col-md-10">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input value="{{@Request::old('name')}}" type="text" name="name"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.centers.center_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="lat" value="{{ @Request::old("lat") }}">
                            <input type="hidden" name="lng" value="{{ @Request::old("lng") }}">
                            <input type="hidden" name="address" value="{{ @Request::old("address") }}">
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2">{{trans('app.address')}}<span
                                            class="text-danger">*</span></label>
                                <div class="col-xs-12 col-md-10">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <div class="map_container">
                                                <div id="map" style="height: 200px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2"> {{trans('app.sectors.sector')}}<span
                                            class="text-danger">*</span></label>
                                <div class="col-xs-12 col-md-10 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="sector_id" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.sectors.choose_sector')}}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}" {{old('sector_id')==$sector->id?'selected':''}}>{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <div class="form-group clearfix ">
                                    <label class="col-xs-12 col-md-2">{{trans('app.services.services')}}<span
                                                class="text-danger">*</span></label>
                                    <div class="col-xs-12 col-md-10 new-f-group">
                                        <div class="form-group clearfix">
                                            <select name="services[]" multiple
                                                    class="effect-9 form-control select2">
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}" {{in_array($service->id,old('services',[]))?'selected':''}}>{{$service->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
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
                        </div>
                        <div class="reg-part">
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.phone_number')}} </label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <span class="icony"><i class="fa fa-phone"></i></span>
                                            <input name="phone_number" type="tel" class="effect-9 form-control"
                                                   placeholder="000 0000 0000" value="{{old('phone_number')}}">
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
                                                   placeholder="000 0000 0000" value="{{old('mobile_number')}}">
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
                                                   placeholder="{{trans('app.fields.email')}}" value="{{old('email')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group-lg text-center">
                            <button type="submit" class="uperc padding-md fbutcenter">{{trans('app.centers.add_center')}}</button>
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
@endsection

@push('scripts')

    <script src="{{asset('/js/select2.min.js')}}" defer></script>
    <link href="{{asset('')}}/css/select2.min.css" rel="stylesheet">
    <style>
        .select2 {
            width: 100%;
        }
    </style>
    <script>
        $(function () {
            $('.select2').select2({
                placeholder: "{{trans('app.services.choose_services')}}",
            });
        });</script>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <script>

        $(document).ready(function () {
            UnoDropZone.init();
        });
        var lat = "{{ @Request::old('lat',30)  }}";
        var lng = "{{ @Request::old('lng',31)   }}";
        var map = L.map('map').setView(L.latLng(lat, lng), 13);

        var marker=L.marker(L.latLng(lat, lng)).addTo(map);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        navigator.geolocation.getCurrentPosition(function (location) {
            var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(latlng).addTo(map);
            $("input[name='lat']").val(latlng.lat);
            $("input[name='lng']").val(latlng.lng)
            map.setView(latlng);
            $.get('https://nominatim.openstreetmap.org/reverse?accept-language={{app()->getLocale()}}&format=jsonv2&lat=' + latlng.lat + '&lon=' + latlng.lng, function (data) {
                $("input[name='address']").val(data.display_name);
            });
        });
        map.on('click',
            function (e) {
                $("input[name='lat']").val(e.latlng.lat);
                $("input[name='lng']").val(e.latlng.lng);
                $.get('https://nominatim.openstreetmap.org/reverse?accept-language={{app()->getLocale()}}&format=jsonv2&lat=' + e.latlng.lat + '&lon=' + e.latlng.lng, function (data) {
                    $("input[name='address']").val(data.display_name);
                });
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
            });
    </script>
@endpush
