@extends('layouts.master')

@section('title',$company->name." | ".trans('app.centers.centers'))

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    <div class="profile-item">
                        <div class="profile-filter">
                            <div class="feildcont">
                                <form action="{{route('company.centers', ['id' => $company->id])}}" method="get">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="icon-addon">
                                                @if($q)
                                                    <input type="text" name="q" value="{{$q}}"
                                                           placeholder="{{trans('app.centers.center_name')}}...."
                                                           class="form-control">
                                                @else
                                                    <input type="text" name="q"
                                                           placeholder="{{trans('app.centers.center_name')}}...."
                                                           class="form-control">
                                                @endif
                                                <div class="searh-icn"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select type="text" name="selected_sector" class="form-control">
                                                <option value="0" @if($selected_sector) selected="selected" @endif>
                                                    {{trans('app.sectors.choose_sector')}}
                                                </option>
                                                @foreach($sectors as $sector)
                                                    @if($selected_sector)
                                                        <option value="{{$sector->id}}"
                                                                @if($selected_sector == $sector->id) selected="selected" @endif>
                                                            {{$sector->name}}
                                                        </option>
                                                    @else
                                                        <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select type="text" name="selected_service" class="form-control">
                                                <option value="0" @if($selected_service) selected="selected" @endif>
                                                    {{trans('app.services.choose_service')}}
                                                </option>
                                                @foreach($services as $service)
                                                    @if($selected_service)
                                                        <option value="{{$service->id}}"
                                                                @if($selected_service == $service->id) selected="selected" @endif>
                                                            {{$service->name}}
                                                        </option>
                                                    @else
                                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            {{--<div class="row mar-top20">--}}
                                                {{--<label class="col-xs-12 col-md-2"> {{trans('app.price')}} </label>--}}
                                                {{--<div class="col-xs-12 col-md-10">--}}
                                                    {{--<div class="range">--}}
                                                        {{--<input class="example" type="range" min="100" max="10000"--}}
                                                               {{--value="100" name="points" step="10">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit"
                                                    class="uperc padding-md fbutcenter">{{trans('app.filter')}}
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
                                        <th scope="col">{{trans('app.centers.center_name')}}</th>
                                        <th scope="col"> {{trans('app.sectors.sector')}}</th>
                                        <th scope="col"> {{trans('app.services.services')}}</th>
                                        <th scope="col"> {{trans('app.centers.created_at')}}</th>
                                        <th scope="col"> {{trans('app.edit')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($centers as $center)
                                        <tr>
                                            <td>
                                                <a href="{{$center?$center->path:'javascript:void(0)'}}"
                                                   class="text-primary">{{$center->name}}</a>
                                                <br>
                                                <span class="badge badge-success">{{$center->status==1?trans('app.centers.published'):trans('app.centers.under_review')}}</span>
                                            </td>
                                            <td>{{$center->sector->name}}</td>
                                            <td>
                                                <div class=" title-larg">
                                                    <ul>
                                                        @foreach($center->services as $sect)
                                                            <li> {{$sect->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{app()->getLocale()=="ar"?arabic_date($center->created_at->toDayDateTimeString()):$center->created_at->toDayDateTimeString()}}</td>
                                            <td><a class="text-primary"
                                                   href="{{route('centers.update',['id'=>$company->id,'center_id'=>$center->id])}}">{{trans('app.edit')}}</a>
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
    @push('scripts')
        <script>
            $(".example").asRange({
                range: true,
                limit: false,
                // tip: {
//    active: 'onMove'
//    },
                namespace: 'asRange',
                max: 10000,
                min: 100,
                value: true,
                step: 10,
                direction: 'h', // 'v' or 'h'
                keyboard: true,
                replaceFirst: true, // false, 'inherit', {'inherit': 'default'}
                scale: true,
                format(value) {
                    return value;
                }
            });
        </script>
    @endpush
@endsection