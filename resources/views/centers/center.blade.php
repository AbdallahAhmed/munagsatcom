@extends('layouts.master')
@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
@endpush
@section('title',trans('app.centers.centers').' | '.$center->name)
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12 content-details">
                <h2><span>{{trans('app.centers.details')}} </span></h2>

                <div class="card-details">
                    <!-- part 1-->
                    <div class="details">
                        <div class="row">
                            <div class="col-md-3 center">

                                <div class="">
                                    <img src="{{$center->image?thumbnail($center->image->path, 'single_center'):asset('images/default-image.png')}}"
                                         alt="{{$center->name}}">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.centers.name')}}</div>
                                            <div class="one_xlarg">{{$center->name}} </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">  {{trans('app.sectors.sector')}} </div>
                                            <div class="one_xlarg">{{$center->sector->name}}</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.services.services')}}</div>
                                            <div class="one_xlarg tab-marakz">
                                                <ul>
                                                    @foreach($center->services as $service)
                                                        <li>{{$service->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">{{trans('app.centers.rate')}}</div>
                                            <div class="one_xlarg">
                                                @for($i = $center->rate; $i > 0; $i--)
                                                    <span class="fa fa-star checked"></span>
                                                @endfor
                                                @for($i = (5 - $center->rate); $i > 0; $i--)
                                                    <span class="fa fa-star"></span>
                                                @endfor
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- part 2-->
                    <div class="details-border">
                        <div class="unit-table pad">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col" style="min-width: 100px;">{{trans('app.services.name')}}</th>
                                    <th scope="col">{{trans('app.details')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($center->services as $service)
                                    <tr>
                                        <td style="    min-width: 100px;"><h3>{{$service->name}}</h3></td>
                                        <td>
                                            <p class="break">{{strlen(trim($service->details))!=0?$service->details:'---'}}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- part 3-->
                    <div class="details-border">
                        <div class="details-item">
                            <ul>
                                <li class="clearfix">
                                    <div class="one_xsmall title">{{trans('app.phone_number')}}</div>
                                    <div class="one_xlarg tel"> {{$center->phone_number or '---'}}</div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title">{{trans('app.mobile_number')}}</div>
                                    <div class="one_xlarg tel"> {{$center->mobile_number or '---'}}</div>
                                </li>
                                <li class="clearfix">
                                    <div class="one_xsmall title"> {{trans('app.address')}}</div>
                                    <div class="one_xlarg">{{$center->address}}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="map_container">
                        <div id="map" style="height: 500px"></div>
                    </div>
                    <!-- part 4-->
                    <div class="details-border">
                        <div class="form-marakz">
                            <h3 class=""> {{trans('app.centers.contact')}}</h3>
                            <div class="feildcont">
                                <div class="alert alert-success" id="message_sent" style="display: none">
                                    <p>{{trans('app.centers.message_sent')}}</p>
                                </div>
                                <form id="contact" >
                                    <div class="form-group-lg row">
                                        <label class="col-xs-12 col-md-3">{{trans('app.fields.name')}}</label>
                                        <div class="col-xs-12 col-md-9">
                                            <div class="new-f-group">
                                                <div class="form-group clearfix">
                                                    <input id="name" type="text" class="effect-9 form-control"
                                                           placeholder="{{trans('app.fields.name')}}">
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
                                                    <input id="email" type="email" class="effect-9 form-control"
                                                           placeholder="{{trans('app.fields.email')}}">
                                                    <span class="focus-border"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-lg row">
                                        <label class="col-xs-12 col-md-3"
                                               for="your_message">{{trans('app.fields.your_message')}}</label>
                                        <div class="col-xs-12 col-md-9">
                                            <div class="new-f-group">
                                                <div class="form-group clearfix">
                                                    <textarea id="your_message"
                                                              class="effect-9 form-control" rows="5"
                                                              placeholder="{{trans('app.fields.your_message')}}..."></textarea>
                                                    <span class="focus-border"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-errors">
                                    </div>
                                    <div class="form-group-lg text-center">
                                        <button type="submit" id="submit-button"
                                                class="uperc padding-md fbutcenter"> {{trans('app.centers.contact')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    @push('scripts')
        <style>
            .break {

                word-break: break-all;

            }
        </style>
        <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

        <script>
            $(function () {
                $('#contact').on('submit', function (e) {
                    e.preventDefault();
                    $('.form-errors').fadeOut(300).html(' ').fadeIn(300)
                    var $html=$('#submit-button').html();
                    $('#submit-button').html('<i class="fa fa-spinner fa-spin"></i>')
                    $('#submit-button').attr('disabled',true);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "{{route('centers.contact',['id'=>$center->id])}}",
                        data: {message: $('#your_message').val(), email: $('#email').val(), name: $('#name').val()},
                        success: function (res) {
                            $('#submit-button').removeAttr('disabled',true);
                            if (res.status) {
                                $('#contact').fadeOut();
                                $('#message_sent').fadeIn(300)
                            } else {
                                $('#submit-button').html($html);
                                $('.form-errors').html('<div class="alert alert-danger"><ul>' + res.errors.map(function (error) {
                                    return '<li>' + error + '</li>';
                                }).join('') + '</ul></div>')
                            }

                        },
                        error: function () {
                            alert("Internal server error");
                        }
                    })
                    return false;
                })
            })
            var lat = "{{$center->lat}}";
            var lng = "{{$center->lng}}";
            var map = L.map('map').setView(L.latLng(lat, lng), 10);
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
                    var address = '';
                    if (data.address.road) {
                        address = data.address.road + ', ';
                    }
                    address += data.address.city + ', ' + data.address.country;
                    $("input[name='location']").val(address);
                });
            });
        </script>
    @endpush
@endsection
