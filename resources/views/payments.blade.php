@extends('layouts.master')

@section('title',trans('app.payments'))

@section('content')
    <section class="container">
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4' style="background: #FFF;padding: 18px;">
                <form accept-charset="UTF-8" method="post" action="{{route('user.recharge')}}">

                    {{csrf_field()}}
                    <small class="text-info">{{option('point_per_reyal')}} {{trans('app.point_per_sar')}} </small>

                    <div class='form-row'>
                        <div class='col-xs-6 form-group required'>
                            <label class='control-label'>{{trans('app.points_wanted')}}</label>
                            <input class='form-control' min="0" id="input-points" placeholder="{{trans('app.points')}}"
                                   name="points" type='number' value="{{old('points')}}">
                        </div>
                        <div class='col-xs-6 form-group required'>
                            <label class='control-label' for="input-price">{!! trans('app.the_price')!!}</label>
                            <input class='form-control' id="input-price"
                                   placeholder="{!!  strip_tags(trans('app.the_price'))!!}"
                                   type='number' name="price" value="{{old('price')}}" readonly>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label' for="input-brand">{{trans('app.card')}}</label>
                            <select class="form-control" name="brand" id="input-brand">
                                <option value="MASTER" {{old('brand')=='MASTER'?'selected':''}}>Master</option>
                                <option value="VISA" {{old('brand')=='VISA'?'selected':''}}>Visa</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>{{trans('app.name_on_card')}}</label>
                            <input class='form-control' name="name_on_card" value="{{old('name_on_card')}}"
                                   placeholder="{{trans('app.name_on_card')}}" type='text'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='col-xs-12 form-group card-number required'>
                            <label class='control-label'>{{trans('app.card_number')}}</label>
                            <input autocomplete='off' placeholder="{{trans('app.card_number')}}"
                                   class='form-control card-number' value="{{old('card_number')}}" name="card_number"
                                   size='20' type='text'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' name="cvc" value="{{old('cvc')}}" class='form-control card-cvc'
                                   placeholder='ex. 311' type='text'>
                        </div>
                        <div class='col-xs-4 form-group expiration required'>
                            <label class='control-label'>{{trans('app.expiration')}}</label>
                            <select class='form-control card-expiry-month' name="month">
                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $month)
                                    <option value="{{$month}}">{{$month}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-xs-4 form-group expiration required'>
                            <label class='control-label'> </label>
                            <input class='form-control card-expiry-year' placeholder='YYYY' name="year"
                                   value="{{old('year')}}" size='4' type='text'>
                        </div>
                    </div>


                    <div class='form-row'>
                        <div class='col-md-12 form-group'>
                            <button class='form-control btn btn-primary submit-button'
                                    type='submit'>{{trans('app.pay')}} »
                            </button>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-md-12 error form-group {{count($errors)==0?'hide':'show'}}'>
                            <div class='alert-danger alert'>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class='col-md-4'></div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#input-points').keyup(function (e) {
                let rate ={{option('point_per_reyal')}};
                $('#input-price').val(Math.ceil($(this).val() / rate))

            })
        })
    </script>
@endpush