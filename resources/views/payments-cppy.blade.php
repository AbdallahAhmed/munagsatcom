@extends('layouts.master')

@section('title',trans('app.payments'))

@section('content')
    <section class="container" style="height: 300px">
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4' style="background: #FFF;padding: 18px;">
                <form accept-charset="UTF-8" method="post" action="{{route('user.recharge')}}">

                    {{csrf_field()}}
                    <small class="text-info">{{option('point_per_reyal')}} {{trans('app.point_per_sar')}} </small>

                    <div class='form-row'>
                        <div class='col-xs-6 form-group required'>
                            <label class='control-label'>{{trans('app.points_wanted')}}</label>
                            {{--<input class='form-control' min="0" id="input-points" placeholder="{{trans('app.points')}}"--}}
                                   {{--name="points" type='number' value="{{old('points')}}">--}}
                            <select name="points" class="form-control" id="input-points">
                            @foreach([1000,2000,3000,4000,5000,10000,15000] as $price)
                                <option value="{{$price}}">{{$price}} {{trans('app.point')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-xs-6 form-group required'>
                            <label class='control-label' for="input-price">{!! trans('app.the_price')!!}</label>
                            <input class='form-control' id="input-price"
                                   placeholder="{!!  strip_tags(trans('app.the_price'))!!}"
                                   type='number' name="price" value="{{old('price')}}" readonly>
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
            $('#input-points').change(function (e) {
                let rate ={{option('point_per_reyal')}};
                $('#input-price').val(Math.ceil($(this).val() / rate))

            })
            $('#input-points').trigger('change')
        })
    </script>
@endpush