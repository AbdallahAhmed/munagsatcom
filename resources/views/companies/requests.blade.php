@extends('layouts.master')

@section('title',trans('app.company_requests'))
@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company_id])
            <div class="col-xs-12 col-md-9">
                @if($requests->total())
                    <div class="profile-box">
                        <div class="profile-item">
                            <div class="unit-table">
                                <form method="post" action="{{route('company.requests', ['id' => $company_id])}}">
                                    {{csrf_field()}}
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{trans('app.employee_name')}}</th>
                                            <th scope="col">{{trans('app.fields.email')}}</th>
                                            <th scope="col"> {{trans('app.reject')}}</th>
                                            <th scope="col">{{trans('app.accept')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($requests as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    <div class="checkbox"><input type="checkbox"
                                                                                 id="checked{{$user->id}}"
                                                                                 value="{{$user->id}}" name="rejected[]"
                                                                                 checked></div>
                                                </td>
                                                <td>
                                                    <div class="checkbox"><input type="checkbox"
                                                                                 id="checked{{$user->id}}"
                                                                                 value="{{$user->id}}"
                                                                                 name="accepted[]"></div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <div class="text-center">
                            {{$requests->appends(Request::all())->render()}}
                        </div>

                        <div class="form-group-lg text-center">
                            <button type="submit" class="uperc padding-md fbutcenter"> {{trans('app.save')}}</button>
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
            $('[id^=checked]').on('click', function (e) {
                id = $(this).attr('id').split('d')[1];
                if ($(this).attr('name') == 'rejected[]') {
                    $('#checked' + id + '[name="accepted[]"]').prop('checked', false);
                    $('#checked' + id + '[name="rejected[]"]').prop('checked', true);
                } else {
                    $('#checked' + id + '[name="rejected[]"]').prop('checked', false);
                    $('#checked' + id + '[name="accepted[]"]').prop('checked', true);
                }
            })
        </script>
    @endpush
@endsection