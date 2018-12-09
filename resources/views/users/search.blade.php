@extends('layouts.master')

@section('title')
@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if($companies)
                    <div class="profile-box">
                        <div class="profile-item noborder">
                            <div class="profile-search">
                                <h3>{{trans('app.company_search')}}</h3>
                                <form method="get" action="{{route('user.company.search')}}">
                                    <div class="form-group row">
                                        <label class="col-xs-12 col-md-3">{{trans('app.chances.company_name')}}</label>
                                        <div class="col-xs-12 col-md-7">
                                            <div class="icon-addon">
                                                @if($q)
                                                    <input type="text" name="q" value="{{$q}}"
                                                           placeholder="{{trans('app.company_search_enter')}}...."
                                                           class="form-control">
                                                @else
                                                    <input type="text" name="q"
                                                           placeholder="{{trans('app.company_search_enter')}}...."
                                                           class="form-control">
                                                @endif
                                                <div class="searh-icn"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-lg text-center">
                                        <button type="submit"
                                                class="uperc padding-md fbutcenter"> {{trans('app.search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="profile-item noborder">
                            <div class="unit-table">
                                <form method="post" action="{{route('user.requests.send')}}">
                                    {{csrf_field()}}
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="100px"> {{trans('app.select')}}</th>
                                            <th scope="col"> {{trans('app.chances.company_name')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($companies as $company)
                                            <tr>
                                                <td><input type="checkbox" name="companies[]" value="{{$company->id}}">
                                                </td>
                                                <td>{{$company->name}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <div class="text-center">
                            {{$companies->appends(Request::all())->render()}}
                        </div>

                        <div class="form-group-lg text-center">
                            <button type="submit"
                                    class="uperc padding-md fbutcenter"> {{trans('app.send_request')}}</button>
                        </div>
                        </form>


                    </div>
                @else
                    <div class="text-center">
                        <p>
                            {{trans('app.no_company_found')}}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
