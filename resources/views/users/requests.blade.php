@extends('layouts.master')

@section('title',trans('app.company_requests'))

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
                @if($requests->total())
                <div class="profile-box">
                    <form name="form" id="form" method="post" action="{{route('user.requests.update')}}">
                        {{csrf_field()}}
                        <div class="profile-item">
                            <div class="unit-table">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{trans('app.chances.company_name')}}</th>
                                        <th scope="col"> {{trans('app.fields.email')}}</th>
                                        <th scope="col"> {{trans('app.accept')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($requests as $company)
                                        <tr>
                                            <td>{{$company->name}}</td>
                                            <td>{{$company->email}}</td>
                                            <td>
                                                <div class="radio"><input type="radio" value="{{$company->id}}"
                                                                          name="accepted"></div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <p>{{trans('app.accept_company_request')}}</p>
                        </div>
                        <div class="text-center">
                            {{$requests->appends(Request::all())->render()}}
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"> {{trans('app.sure_accept')}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{trans('app.sure_accept_ask')}}</p>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <button type="submit" form="form" class="uperc padding-md fbutcenter">
                                                {{trans('app.yes')}}
                                            </button>
                                            <button type="" class="uperc padding-md fbutcenter1"
                                                    data-dismiss="modal">
                                                {{trans('app.no')}}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg text-center">
                            <button type="submit" name="save" class="uperc padding-md fbutcenter"> {{trans('app.save')}}</button>
                        </div>
                    </form>
                </div>
                    @else
                    <div class="text-center">
                        <p>{{trans('app.no_requests_found')}}</p>
                    </div>
                    @endif
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('[name="save"]').on('click', function (e) {
                e.preventDefault();
                if ($('[name="accepted"]:checked').length > 0)
                    $("#myModal").modal('show');

            })
        </script>
    @endpush
@endsection