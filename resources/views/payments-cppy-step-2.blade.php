@extends('layouts.master')

@section('title',trans('app.payments'))

@section('content')
    <section class="container">
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4' style="background: #FFF;padding: 18px;">
                <form accept-charset="UTF-8" class="paymentWidgets" data-brands="VISA MASTER"
                      action="{{route('user.checkout')}}">
                    {{csrf_field()}}
                </form>
            </div>
            <div class='col-md-4'></div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{$base_url}}/paymentWidgets.js?checkoutId={{$result->id}}"></script>
    <script>
        $(function () {
            $('#input-points').keyup(function (e) {
                let rate ={{option('point_per_reyal')}};
                $('#input-price').val(Math.ceil($(this).val() / rate))

            })
        })
    </script>
@endpush