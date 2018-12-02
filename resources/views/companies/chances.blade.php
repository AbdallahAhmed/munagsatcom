@extends('layouts.master')

@section('title',$company->name)

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

                    <div class="profile-circle">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p>{{trans('app.chances.posted')}}</p>
                                    <p> {{count($company->chances->where('status', 0))}} </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p>فرص تم المساهمة فيها</p>
                                    <p> 1 </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="circle-item">
                                    <p> مجمل المبلغ التى تم تجميعها </p>
                                    <p> 5000 </p>
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
                                            <input name="status" value="{{$st}}" type="checkbox" @if(in_array($st, $chosen_status)) checked @endif>
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
                                                            <input name="created_date" value="{{$created_at? $created_at : ""}}"
                                                                   data-date-format="dd-mm-yyyy" class="effect-9 form-control" id="date"
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
                                        <button type="submit" class="uperc padding-md fbutcenter">{{trans('app.filter')}}</button>
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
                                    <th scope="col"> {{trans('app.chances.details')}}</th>
                                    <th scope="col"> {{trans('app.chances.declined')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($chances as $chance)
                                    <tr>
                                        <td>{{$chance->name}}</td>
                                        <td></td>
                                        <td>{{count($chance->offers)}}</td>
                                        <td>{{$chance->approved ? trans('app.chances.approved') : trans('app.chances.not_approved')}}</td>
                                        <td>{{$chance->file_description}}</td>
                                        <td>{{$chance->approved ? trans('app.chances.not_approved') : trans('app.chances.declined')}}</td>
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
    @push('scripts')
        <script>
            $('#dp3').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
            $('#date').datepicker({
                dateFormat: "yyyy-mm-dd"
            });
        </script>
        <script>
            $(function () {
                $('#search').on('submit', function (e) {
                    e.preventDefault();
                    var status = [];
                    var search_q = $('[name="search_q"]').val();
                    var created_date = $('#date').datepicker().val();
                    $("input:checkbox[name=status]:checked").each(function () {
                        status.push($(this).val());
                    });
                    var url = "{{route('company.chances', ['id' => $company->id])}}" + "?";
                    url += search_q == !search_q || search_q.length === 0 ||
                    search_q === "" || !/[^\s]/.test(search_q) ||
                    /^\s*$/.test(search_q) || search_q.replace(/\s/g, "") === "" ? "" : "q=" + search_q + "&";
                    url = created_date.length > 0 ? url + "created_at=" + created_date + "&" : url;
                    for (var i = 0; i < status.length; i++) {
                        url += "status[]=" + status[i];
                        url = i != status.length - 1 ? url + "&" : url;
                    }
                    url = url[url.length - 1] == "&" ? url.slice(0, -1) : url;

                    if (url != "{{route('company.chances', ['id' => $company->id])}}" + "?")
                        window.location.href = url;

                })

            })
        </script>
    @endpush
@endsection