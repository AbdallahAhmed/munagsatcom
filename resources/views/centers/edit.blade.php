@extends('layouts.master')
@push("head")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
@endpush
@section('title',trans('app.centers.centers'))
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center"> {{trans('app.centers.edit_center')}} </h2>
            <div class="feildcont">
                @if (!session('status'))
                    <form method="post" action="{{route('centers.update', ['id' => $company->id, 'center_id' => $center->id])}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="reg-part">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="alert-danger">{{ $error }}</li>
                                @endforeach
                            {{--    <li class="alert-info">
                                    {{trans("services::points.service_center_add")}}
                                    ({{option('service_center_add',0)}})
                                    {{trans('app.point')}}
                                </li>--}}
                            </ul>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2"> {{trans('app.centers.center_name')}}<span
                                            class="text-danger">*</span></label>
                                <div class="col-xs-12 col-md-10">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input value="{{@Request::old('name', $center->name)}}" type="text"
                                                   name="name"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.centers.center_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="lat" value="{{ @Request::old("lat", $center->lat) }}">
                            <input type="hidden" name="lng" value="{{ @Request::old("lng", $center->lng) }}">
                            <input type="hidden" name="address"
                                   value="{{ @Request::old("address", $center->address) }}">
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
                                                <option value="{{$sector->id}}" {{(old('sector_id')==$sector->id || $center->sector->id == $sector->id)?'selected':''}}>{{$sector->name}}</option>
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
                                                    <option value="{{$service->id}}" {{in_array($service->id,old('services',$centers_services))?'selected':''}}>{{$service->name}}</option>
                                                @endforeach
                                            </select><span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-2">{{trans('app.centers.add_logo')}}</label>
                                <div class="col-xs-12 col-md-4">
                                    @if($center->image)
                                        <div class="">
                                            <input type="hidden" value="{{$center->image_id}}" id="media_id"
                                                   name="image_id">
                                            <input name="logo" id="logo" type="file" accept="image/*" style="display: none">
                                            <img style="cursor: pointer" id="change"
                                                 src="{{thumbnail($center->image->path, 'single_center')}}">
                                        </div>
                                    @else
                                        <div class="file-upload" data-input-name="logo">
                                            <div class="file-input"><input name="logo" type="file" accept="image/*">
                                            </div>
                                            <div class="drop-click-zone">
                                                <div class="filethumbnail">
                                                </div>
                                            </div>
                                            <div class="info"></div>
                                            <div class="message"></div>
                                        </div>
                                    @endif
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
                                                   placeholder="000 0000 0000"
                                                   value="{{old('phone_number', $center->phone_number)}}">
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
                                                   placeholder="000 0000 0000"
                                                   value="{{old('mobile_number', $center->mobile_number)}}">
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
                                                   placeholder="{{trans('app.fields.email')}}"
                                                   value="{{old('email', $center->email_address)}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                            .modal-header .close {
                                margin-top: -24px;
                            }
                        </style>
                        <div class="modal fade" id="add_center" tabindex="-1" role="dialog" aria-labelledby="add_center"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="exampleModalCenterTitle"> {{trans('app.centers.add_center')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @php
                                        $user=fauth()->user()->in_company?fauth()->user()->company[0]:fauth()->user();
                                        $points=option('service_center_add',0);
                                    @endphp
                                    <div class="modal-body">
                                        <p> {{trans('app.cb_price')}} : {{$points }} {{trans('app.point')}}</p>
                                        <hr>
                                        <p> {{ trans('app.current_points') }}
                                            : {{ $user->points }} {{trans('app.point')}}</p>
                                        <hr>
                                        <p class="{{$user->points -$points<=0?'text-danger':''}}"> {{ trans('app.points_after_buy') }}
                                            : {{ $user->points - $points }} {{trans('app.point')}}</p>
                                        <hr>
                                        @if($user->points -$points>=0)
                                            <p class="fieldset" style="margin: 0;">
                                                <input type="checkbox" name="terms" id="accept-terms">
                                                <label for="accept-terms">{{trans('app.accept_with')}} <a
                                                            target="_blank"
                                                            href="{{route('page.show', ['slug' => 'الشروط والأحكام'])}}"
                                                            class="text-primary">{{trans('app.terms')}}</a></label>
                                            </p>
                                        @endif
                                        <p class="text-danger">{{$user->points - $points<0?trans('app.please_recharge'):''}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="{{$user->points - $points<0?'':'can-buy'}}"
                                                disabled>{{trans('app.centers.add_center')}}</button>
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{trans('app.close')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg text-center">
                            <button type="submit" {{--data-toggle="modal"--}}
                            {{-- data-target="#add_center"--}}
                            class="uperc padding-md fbutcenter"> {{trans('app.centers.edit_center')}}</button>
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
            $('#accept-terms').change(function (e) {
                var $base = $('#can-buy');
                if ($base.length && e.target.checked) {
                    $base.removeAttr('disabled')
                } else {
                    $base.attr('disabled', true)
                }
            });
        });</script>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <script>
        $('#change').on('click', function (e) {
            $('#logo').trigger('click', function () {
            })

        })
        $('#logo').change(function () {
            image = this;
            var file = image.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, validImageTypes) > 0) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#change').attr('src', e.target.result);
                }
                reader.readAsDataURL(image.files[0]);
                $('#media_id').remove();
            }
        });
        $(document).ready(function () {
            UnoDropZone.init();
        });
        var lat = "{{ @Request::old('lat',30)  }}";
        var lng = "{{ @Request::old('lng',31)   }}";
        var map = L.map('map').setView(L.latLng(lat, lng), 13);

        var marker = L.marker(L.latLng(lat, lng)).addTo(map);
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
