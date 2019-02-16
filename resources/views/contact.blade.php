@extends('layouts.master')

@section('title',trans('app.contact_us'))
@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
@endpush
@section('content')
    <section class="container">
        <div class="res-box">
            <div class="contacts">
                <div class="feildcont">
                    <form id="form" method="post" action="{{route('contact-us')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-7 contact-form">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input id="name" type="text" class="effect-9 form-control"
                                               placeholder="{{trans('app.fields.name')}}..." name="name">
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="ename"
                                           style="display: none">{{trans('app.name_min')}}</p>
                                    </div>
                                </div>
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-mobile"></i></span>
                                        <input id="tel" type="tel" class="effect-9 form-control"
                                               placeholder="{{trans('app.mobile_number')}}..." name="number">
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="enum"
                                           style="display: none">{{trans('app.tel_min')}}</p>
                                    </div>
                                </div>
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-envelope"></i></span>
                                        <input id="email" type="email" class="effect-9 form-control"
                                               placeholder="{{trans('app.fields.email')}}..." name="email">
                                        <span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <textarea id="message" class="effect-9 form-control"  name="message" rows="5"
                                                  placeholder="{{trans('app.how_to_help')}}"
                                                  style="height:150px;"></textarea>
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="emess"
                                           style="display: none">{{trans('app.message_min')}}</p>
                                    </div>
                                </div>
                                <div class="form-group-lg text-center">
                                    <button type="submit"
                                            class="uperc padding-md fbutcenter">{{trans('app.send_clarification')}}</button>
                                </div>
                            </div>
                            <div class="col-md-5 contact-text">

                                <b> مناقصاتكم المحدوده:</b><br/><br/>
                                <i class="fa fa-map-marker"></i> طريق الامير محمد بن عبدالرحمن
                                <br>
                                الرياض 12665 ص.ب 6597
                                <br>
                                المملكة العربية السعودية <br/>

                                <i class="fa fa-mobile"></i> 920008769<br/>
                                <i class="fa fa-envelope"></i> <a href="mailto:info@munagasatcom.com">info@munagasatcom.com</a><br/>
                                <div class="social">
                                    <ul class="footer-link">
                                        <li><a href=" https://www.facebook.com/munagasatcom"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://www.instagram.com/munagasatcom/"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="https://twitter.com/munagasatcom"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://www.youtube.com/channel/UCRDuD-lLU3KaS1FehTqkxNg"><i
                                                        class="fa fa-youtube"></i></a></li>
                                        <li><a href="https://www.linkedin.com/company/munagasatcom"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="map_container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d71786.46836101105!2d46.7017797!3d24.6162998!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f05decb123a23%3A0x56c42d94306d67c1!2z2LTYsdmD2Kkg2YXZhtin2YLYtdin2KrZg9mF!5e1!3m2!1sen!2seg!4v1549028626732" width="900" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </form>
                    <h1 style="display:none;" id="success">{{trans('app.success_message')}}</h1>
                </div>
            </div>
        </div>
    </section>
    {{--<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>--}}

    @push('scripts')
        <style>
            .social{
            }
        </style>
        <script>
            $(function () {
                $('#form').on('submit', function (e) {
                    $('#ename').hide();
                    $('#enum').hide();
                    $('#emess').hide();
                    var valid = true;

                    if ($('#name').val().length < 3) {
                        e.preventDefault();

                        $('#ename').show();
                        valid = false;

                    }
                    if ($('#tel').val().length < 10) {
                        e.preventDefault();

                        $('#enum').show();
                        valid = false;
                    }
                    if ($('#message').val().length < 10) {
                        e.preventDefault();
                        $('#emess').show();
                        valid = false;
                    }
                    {{--if (valid) {--}}
                        {{--$.ajaxSetup({--}}
                            {{--headers: {--}}
                                {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                            {{--}--}}
                        {{--});--}}
                        {{--$.ajax({--}}
                            {{--type: "post",--}}
                            {{--url: "{{route('contact-us')}}",--}}
                            {{--data: {--}}
                                {{--'name': $('#name').val(),--}}
                                {{--'number': $('#tel').val(),--}}
                                {{--'message': $('#message').val(),--}}
                                {{--'email': $('#email').val()--}}
                            {{--},--}}
                            {{--success: function () {--}}
                                {{--$('#form').hide(400);--}}
                                {{--$('#succes').show()--}}
                            {{--},--}}
                            {{--error: function () {--}}
                                {{--alert("Internal server error")--}}
                            {{--}--}}
                        {{--})--}}
                    {{--}--}}
                    return true;
                })
            })
        </script>
    @endpush
@endsection