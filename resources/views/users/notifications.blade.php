@extends('layouts.master')

@section('title',trans('app.notifications'))

@section('content')
    <section class="container">
        <div class='row'>
            <div class='col-md-4'></div>
            <script>

            </script>
            <div class='col-md-4' style="background: #FFF;padding: 18px;direction: ltr; text-align: center">
                @if(count($notifications))
                    @foreach($notifications as $notification)

                        {{--@switch($notification->key)
                            @case('user.register')
                            <p>{{$notification->body['message']}}</p>
                            @break
                            @case('password.reset')
                            <p>{{$notification->body['message']}}</p>
                            @break
                            @case('tender.bought')
                            <p>{{$notification->body['message']}}</p>
                            @break
                            @case('to.company.tender.bought')
                            <p>{{$notification->body['message']}}</p>
                            @break
                        @endswitch--}}
                        <p>{{$notification->body['message']}}</p>
                    @endforeach
                @else
                    <p>{{trans('app.no_notifications')}}</p>
                @endif
            </div>
            <div class='col-md-4'></div>
            {{$notifications->appends(Request::all())->render()}}
            <div class="text-center">
            </div>
        </div>
    </section>
@endsection

@push('scripts')

@endpush