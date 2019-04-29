@extends('layouts.master')

@section('title',trans('app.notifications'))

@section('content')
    <section class="container">
        <div class='row'  style="min-height: 300px;">
            <div class='col-md-2'></div>
            <div class='col-md-8' style="background: #FFF;padding: 18px;direction: ltr; text-align: center">
                @if(count($notifications))
                    @foreach($notifications as $notification)
                        <div class="row border-bottom">
                            <div class="col-md-8">
                                {{$notification->body['message']}}
                            </div>
                            <div class="col-md-4">
                                <span class="badge">{{$notification->updated_at->diffForHumans()}}</span>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p>{{trans('app.no_notifications')}}</p>
                @endif
            </div>
            <div class='col-md-2'></div>
            {{$notifications->appends(Request::all())->render()}}
            <div class="text-center">
            </div>
        </div>
    </section>
@endsection

@push('scripts')

@endpush