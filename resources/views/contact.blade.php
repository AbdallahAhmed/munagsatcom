@extends('layouts.master')

@section('title',trans('app.contact_us'))

@section('content')
    <section class="container">
        <div class="res-box">
            <div class="contacts">
                <div class="feildcont">
                    <form id="form">
                        <div class="row">
                            <div class="col-md-7 contact-form">
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-user"></i></span>
                                        <input id="name" type="text" class="effect-9 form-control"
                                               placeholder="{{trans('app.fields.name')}}...">
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="ename" style="display: none">{{trans('app.name_min')}}</p>
                                    </div>
                                </div>
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <span class="icony"><i class="fa fa-mobile"></i></span>
                                        <input id="tel" type="tel" class="effect-9 form-control"
                                               placeholder="{{trans('app.mobile_number')}}...">
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="enum" style="display: none">{{trans('app.tel_min')}}</p>
                                    </div>
                                </div>
                                <div class="new-f-group">
                                    <div class="form-group clearfix">
                                        <textarea id="message" class="effect-9 form-control" rows="5"
                                                  placeholder="{{trans('app.how_to_help')}}"
                                                  style="height:150px;"></textarea>
                                        <span class="focus-border"><i></i></span>
                                        <p class="text-danger" id="emess" style="display: none">{{trans('app.message_min')}}</p>
                                    </div>
                                </div>
                                <div class="form-group-lg text-center">
                                    <button type="submit"
                                            class="uperc padding-md fbutcenter">{{trans('app.send_clarification')}}</button>
                                </div>
                            </div>
                            <div class="col-md-5 contact-text">

                                <b> مناقصاتكم المحدوده:</b><br/><br/>
                                <i class="fa fa-map-marker"></i> شارع الملك عبد العزيز, <br/>
                                الرياض<br/>
                                المملكة العربية السعودية<br/><br/>
                                <i class="fa fa-mobile"></i> +0 000 0000 0000<br/>
                                <i class="fa fa-envelope"></i> <a href="mailto:support@mysite.com">
                                    support@mysite.com</a><br/>
                                <i class="fa fa-envelope"></i> <a href="mailto:usa@mysite.com"> usa@mysite.com</a><br/>


                            </div>
                        </div>
                        <div class="contact-map">
                            <iframe width="100%" height="400" frameborder="0" style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDBb9ccsaixjZiG0wH0LxWbaVlt-BAvhKg&#10;    &amp;q=record+stores+in+Seattle"
                                    allowfullscreen="">
                            </iframe>
                        </div>
                    </form>
                    <h1 style="display:none;" id="success">{{trans('app.success_message')}}</h1>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(function () {
                $('#form').on('submit', function (e) {
                    e.preventDefault();
                    $('#ename').hide();
                    $('#enum').hide();
                    $('#emess').hide();
                    var valid = true;

                    if($('#name').val().length < 3) {
                        $('#ename').show();
                        valid = false;

                    }
                    if($('#tel').val().length < 10){
                        $('#enum').show();
                        valid = false;
                    }
                    if($('#message').val().length < 10){
                        $('#emess').show();
                        valid = false;
                    }
                    if(valid){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "post",
                            url: "{{route('contact-us')}}",
                            data: {
                                'name' : $('#name').val(),
                                'number': $('#tel').val(),
                                'message':$('#message').val()
                            },
                            success: function () {
                                $('#form').hide(400);
                                $('#succes').show()
                            },
                            error:function () {
                                alert("Internal server error")
                            }
                        })
                    }
                })
            })
        </script>
    @endpush
@endsection