@extends('layouts.master')

@section('title',trans('app.tenders.tenders'))
@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])

            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    <div class="profile-item">
                        <div class="profile-filter">
                            <div class="feildcont">
                                <form method="get" action="">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="icon-addon">
                                                <input type="text" placeholder=" {{trans('app.tenders.id')}} ..."
                                                       name="number" class="form-control"
                                                       value="{{\Request::get('number')}}">
                                                <div class="searh-icn"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="icon-addon">
                                                <input type="text" placeholder=" {{trans('app.tenders.tenders')}} ..."
                                                       name="q" value="{{\Request::get('q')}}"
                                                       class="form-control">
                                                <div class="searh-icn"><i class="fa fa-search"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <select name="org_id" class="effect-9 form-control">
                                                <option value>{{trans('app.tenders.choose_org')}}</option>
                                                @foreach(\Dot\Tenders\Models\TenderOrg::where('status',1)->get() as $org)
                                                    <option value="{{$org->id}}" {{old('org_id',Request::get('org_id'))==$org->id?' selected ':''}}>{{$org->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="activity_id" class="effect-9 form-control">
                                                <option value>{{trans('app.tenders.choose_activity')}}</option>
                                                @foreach(\Dot\Tenders\Models\TenderActivity::where('status',1)->get() as $activtiy)
                                                    <option value="{{$activtiy->id}}" {{old('activity_id',Request::get('activity_id'))==$activtiy->id?' selected ':''}}>{{$activtiy->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group-lg text-center">
                                        <button type="submit"
                                                class="uperc padding-md fbutcenter">{{trans('app.search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="unit-table">
                            @if(count($tenders)>0)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{trans('app.tenders.id')}}</th>
                                        <th scope="col">{{trans('app.tenders.name')}}</th>
                                        <th scope="col"> {{trans('app.tenders.org')}}</th>
                                        <th scope="col">{{trans('app.tenders.last_get_offer_at')}}</th>
                                        <th scope="col"> {{trans('app.tenders.created')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tenders as $tender)
                                        <tr>
                                            <td><a href="{{$tender->path}}" class="text-primary">{{$tender->number}}</a>
                                            </td>
                                            <td>{{$tender->name}}</td>
                                            <td>{{$tender->org->name}}</td>
                                            <td>{{hijri_date($tender->last_get_offer_at)}}</td>
                                            <td>{{hijri_date($tender->published_at)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="col-md-12 not-found">{{trans('app.tenders.not_found')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        {{$tenders->appends(Request::all())->render()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
    </script>
@endpush