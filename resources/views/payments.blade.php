@extends('layouts.master')

@section('title',trans('app.payments'))

@section('content')
    <section class="container">
        <div class="payment-container">
            <div class="feildcont">
                <h4>الدفع عن طريق</h4>
                <div class="form-group">
                    <label><input type="radio" name="optradio">  الدفع الالكترونى</label>
                </div>
                <div class="form-group">
                    <select class="forme-control">
                        <option>Visa / Master Card </option>
                        <option>Visa / Master Card </option>
                        <option>Visa / Master Card </option>
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-md-6"><select class="forme-control">
                            <option>Bank Name</option>
                            <option>Bank Name</option>
                            <option>Bank Name</option>
                            <option>Bank Name</option>
                        </select>
                    </div>
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="Enter Card Number"></div>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="uperc padding-md fbutcenter">اشترى</button>
                </div>
                <hr>
                <div class="form-group">
                    <label><input type="radio" name="optradio"> نظام السداد   </label>
                </div>
                <div class="form-group">
                    <label>الرصيد المتاح فى سداد </label>
                    <input type="text" class="form-control" disabled placeholder="1000 ريال">
                </div>
                <div class="form-group">
                    <label>المبلغ المراد خصمة</label>
                    <input type="text" class="form-control" disabled placeholder="500 ريال">
                </div>
                <div class="form-group text-center">
                    <button type="button" class="uperc padding-md fbutcenter"> خصم</button>
                </div>
            </div>
        </div>
    </section>
@endsection