@extends('layouts.master')

@section('title',$company->name." | ".trans('app.chances.chances'))

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                @if(session('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{session('message')}}
                    </div>
                @endif
                <div class="profile-box">

                    <div class="profile-circle">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p>{{trans('app.chances.posted')}}</p>
                                    <div class="num"> {{($company->chances()->whereNotIn('status', [3,5])->count())}} </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p>{{trans('app.chances.provided_offers')}}</p>
                                    <div class="num"> {{$chances_offer_count}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p> {{trans('app.chances.downloads')}} </p>
                                    <div class="num"> {{$chances_downloads_count}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-search">
                            <div class="row">
                                <label class="col-xs-12 col-md-1"> {{trans('app.chances.my_chances')}}</label>
                                <div class="icon-addon col-xs-12 col-md-11">
                                    @if($q)
                                        <input name="search_q" type="text"
                                               placeholder="{{trans('app.chances.search_query')}}..."
                                               class="form-control" value="{{$q}}">
                                    @else
                                        <input name="search_q" type="text"
                                               placeholder="{{trans('app.chances.search_query')}}..."
                                               class="form-control">
                                    @endif
                                    <div class="searh-icn"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-filter">
                            <div class="feildcont">
                                <form id="search">
                                    <div class="form-group-lg clearfix">
                                        @foreach($status as $st)
                                            <div class=" col-md-4">
                                                <input name="status[]" value="{{$st}}" type="checkbox"
                                                       @if(in_array($st, $chosen_status)) checked @endif>
                                                <label> {{trans('app.status_array.'.$st)}} </label>
                                            </div>
                                        @endforeach
                                        <div class=" col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="col-xs-12 col-md-4">{{trans('app.chances.posted_at')}}</label>
                                                <div class="col-xs-12 col-md-8 new-f-group">
                                                    <div class="form-group clearfix">
                                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                                             data-date-format="dd-mm-yyyy">
                                                            <input name="created_date"
                                                                   value="{{$created_at? $created_at : ""}}"
                                                                   data-date-format="dd-mm-yyyy"
                                                                   class="effect-9 form-control" id="date"
                                                                   placeholder="dd-mm-yyyy"
                                                                   type="text">
                                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-lg text-center">
                                        <button type="submit"
                                                class="uperc padding-md fbutcenter">{{trans('app.filter')}}</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                    <div class="profile-item">
                        <div class="unit-table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">{{trans('app.chances.chance_name')}}</th>
                                    <th scope="col"> {{trans('app.chances.downloads')}}</th>
                                    <th scope="col">{{trans('app.chances.provided_offers')}}</th>
                                    <th scope="col">{{trans('app.chances.accepted')}}</th>
                                    <th scope="col"> {{trans('app.chances.created_at')}}</th>
                                    <th scope="col"> {{trans('app.chances.status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($chances as $chance)
                                    <tr>
                                        @if($chance->status!=3&&$chance->status!=5)
                                            <td><a href="{{$chance->path}}"
                                                   title="{{$chance->name}}">{{$chance->name}}</a></td>

                                        @else
                                            <td>{{$chance->name}}</td>
                                        @endif
                                        <td>{{$chance->downloads}}</td>
                                        @if(($count=($chance->offers()->count()))>0)
                                            <td><a href="javascript:void(0)" class="show-offers"
                                                   data-path="{{route('chances.offers.show',['id'=>$company->id,'chance_id'=>$chance->id])}}">{{$count}}</a>
                                            </td>
                                        @else
                                            <td>{{$count}}</td>
                                        @endif
                                        @php
                                            $is_approved= DB::table('chances_offers_files')->where([['chance_id', $chance->id],['approved', 1]])->count()?true:false;
                                        @endphp
                                        <td>{{$is_approved ? trans('app.chances.approved') : trans('app.chances.not_approved')}}</td>
                                        <td>{{$chance->created_at}}</td>
                                        <td>
                                            @if(in_array($chance->status,[2,0])&&!$is_approved)
                                                <a class="text-primary"
                                                   href="{{route('chances.cancel',['id'=>$chance->id,'canceled'=>$chance->status!=2])}}">{{$chance->status==2? trans('app.chances.active') : trans('app.chances.declined')}}</a>
                                            @endif
                                            @if(in_array($chance->status,[3,5])&&!$is_approved)
                                                <i>{{trans('chances::chances.status.'.$chance->status)}}</i>
                                                    <br>
                                                    <a class="text-primary" href="{{route('chances.update',['id'=>$company->id,'chance_id'=>$chance->id])}}">{{trans('app.edit')}}</a>
                                                @endif
                                            @if($is_approved || $chance->status==4)
                                                <i>{{trans('app.chances.approved_done')}}</i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="offers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{trans('app.offers')}}</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#dp3').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
            $('#date').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
            {{--$('#search').on('submit', function (e) {--}}
                    {{--e.preventDefault();--}}
                    {{--var status = [];--}}
                    {{--var search_q = $('[name="search_q"]').val();--}}
                    {{--var created_date = $('#date').datepicker().val();--}}
                    {{--$("input:checkbox[name=status]:checked").each(function () {--}}
                    {{--status.push($(this).val());--}}
                    {{--});--}}
                    {{--var url = "{{route('company.chances', ['id' => $company->id])}}" + "?";--}}
                    {{--url += search_q == !search_q || search_q.length === 0 ||--}}
                    {{--search_q === "" || !/[^\s]/.test(search_q) ||--}}
                    {{--/^\s*$/.test(search_q) || search_q.replace(/\s/g, "") === "" ? "" : "q=" + search_q + "&";--}}
                    {{--url = created_date.length > 0 ? url + "created_at=" + created_date + "&" : url;--}}
                    {{--for (var i = 0; i < status.length; i++) {--}}
                    {{--url += "status[]=" + status[i];--}}
                    {{--url = i != status.length - 1 ? url + "&" : url;--}}
                    {{--}--}}
                    {{--url = url[url.length - 1] == "&" ? url.slice(0, -1) : url;--}}

                    {{--if (url != "{{route('company.chances', ['id' => $company->id])}}" + "?")--}}
                    {{--window.location.href = url;--}}

                    {{--});--}}
                $loading = $('<p class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:30px"></i></p>');
            $('.show-offers').click(function () {
                $modal = $('#offers');
                $modal.find('.modal-body').html($loading);
                $modal.modal('show');
                var path = $(this).data('path');
                $.ajax(path).done(function (res) {
                    $modal.find('.modal-body').html(res);
                });
            });

        })
    </script>
@endpush