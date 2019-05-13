@extends('layouts.master')

@section('title',trans('app.used_points'))

@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

                    <div class="profile-circle">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="circle-item">
                                    <p>{{fauth()->user()->in_company?trans('app.available_points'):trans('app.current_points')}}</p>
                                    <div class="num">{{fauth()->user()->in_company?fauth()->user()->company[0]->points:$user->points}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="circle-item">
                                    <p>{{trans('app.spent_points')}}</p>
                                    <div class="num">
                                        {{fauth()->user()->in_company?fauth()->user()->company[0]->spent_points:$user->spent_points}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-box">
                    <div class="profile-item noborder">
                        <div class="profile-search">
                            <form method="get">
                                <div class="row">
                                    <label class="col-xs-12 col-md-2">{{trans('app.choose_month')}}</label>
                                    <div class="col-xs-12 col-md-7">
                                        <div class="form-group">
                                            <select class="form-control" name="month">
                                                @foreach(["Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس",
                                                            "Apr" => "أبريل","May" => "مايو","Jun" => "يونيو", "Jul" => "يوليو",
                                                            "Aug" => "أغسطس","Sep" => "سبتمبر", "Oct" => "أكتوبر",
                                                            "Nov" => "نوفمبر",  "Dec" => "ديسمبر"] as $key => $value)

                                                    <option value="{{$loop->index}}" {{Carbon\Carbon::now()->month-1==$loop->index||Request::get('month')==$loop->index?'selected':''}}>{{app()->getLocale()=="en"?$key:$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <button type="submit" class="uperc fbutcenter"> {{trans('app.search')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="profile-item noborder">
                        <div class="unit-table">
                            @if($transactions->count()!=0)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{trans('app.transaction_type')}} </th>
                                        <th scope="col">{{trans('app.before_transaction')}}</th>
                                        <th scope="col"> {{trans('app.add_points')}}</th>
                                        <th scope="col"> {{trans('app.used_points')}}</th>
                                        <th scope="col"> {{trans('app.after_transactions')}}</th>
                                        <th scope="col"> {{trans('app.date_transactions')}}</th>
                                        <th scope="col"> {{trans('app.print_invoice')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td><a href="{{$transaction->path}}"
                                                   class="text-primary">{{$transaction->type}}</a></td>
                                            <td>{{$transaction->before_points}}</td>
                                            <td>{{$transaction->before_points<$transaction->after_points?$transaction->points:0}}</td>
                                            <td>{{$transaction->before_points>=$transaction->after_points?$transaction->points:0}}</td>
                                            <td>{{$transaction->after_points}}</td>
                                            <td>{{ $transaction->created_at->format('Y/m/d')}}</td>
                                            <td>
                                                <a {{!in_array($transaction->action, ['tenders.buy', 'add.chance', 'center.add'])?"disabled":''}} href="{{$transaction->invoice_path}}"
                                                   target="_blank" class="btn btn-link" title="{{trans('app.print')}}"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <div class="text-center">
                                @if($transactions->count()==0)
                                    <p style="text-align: center">{{trans('app.no_transactions')}}</p>
                                @endif
                            </div>
                            <div class="text-center">
                                {{$transactions->appends(Request::all())->render()}}
                            </div>
                        </div>
                    </div>
                </div>

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
