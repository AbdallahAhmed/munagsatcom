@extends('layouts.master')

@section('title',fauth()->user()->first_name.' '.fauth()->user()->last_name)

@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    <div class="profile-item">
                        <div class="profile-filter">
                            <div class="feildcont">
                                <form>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="icon-addon">
                                                @if($q)
                                                    <input name="q" type="text"
                                                           placeholder="{{trans('app.centers.search_query')}}..."
                                                           class="form-control" value="{{$q}}">
                                                @else
                                                    <input name="q" type="text"
                                                           placeholder="{{trans('app.centers.search_query')}}..."
                                                           class="form-control">
                                                @endif
                                                <div class="searh-icn"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select type="text" class="effect-9 form-control" name="sector_id">
                                                <option value="0">{{trans('app.sectors.choose_sector')}}</option>
                                                @foreach($sectors as $sector)
                                                    @if($sector_id == $sector->id)
                                                        <option value="{{$sector->id}}"
                                                                selected="selected">{{$sector->name}}</option>
                                                    @else
                                                        <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select type="text" class="effect-9 form-control" name="service_id">
                                                <option value="0">{{trans('app.services.choose_services')}}</option>
                                                @foreach($services as $service)
                                                    @if($service_id == $service->id)
                                                        <option value="{{$service->id}}"
                                                                selected="selected">{{$service->name}}</option>
                                                    @else
                                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="uperc padding-md fbutcenter">
                                                {{trans('app.filter')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="unit-table">
                            @if(count($centers)>0)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{trans('app.services.name')}}</th>
                                        <th scope="col">{{trans('app.sectors.sector')}}</th>
                                        <th scope="col"> {{trans('app.services.services')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($centers as $center)
                                        <tr>
                                            <td>{{$center->name}}</td>
                                            <td> {{$center->sector->name}}</td>
                                            <td>
                                                <div class=" title-larg">
                                                    <ul>
                                                        @foreach($center->services as $service)
                                                            <li>{{$service->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="not-found">{{trans('app.centers.not_found')}}</p>
                            @endif
                        </div>
                    </div>
                    <!---->
                    <div class="text-center">
                        {{$centers->appends(Request::all())->render()}}
                    </div>
                    <!---->
                </div>
            </div>
        </div>
    </section>
@endsection