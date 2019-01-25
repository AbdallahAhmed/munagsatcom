<div class="col-xs-12 col-md-3">
    <div class="side-box">
        <div class="profile-side">
            <ul>
                <li @if (\Route::current()->getName() == 'user.show') class="active" @endif><a class="" href="{{route('user.show')}}">{{trans('app.user_details')}} </a></li>
{{--                <li @if (\Route::current()->getName() == 'user.requests') class="active" @endif><a href="{{route('user.requests')}}">{{trans('app.requests')}}</a></li>--}}
{{--                <li @if (\Route::current()->getName() == 'user.company.search') class="active" @endif><a href="{{route('user.company.search')}}">{{trans('app.company_search')}}</a></li>--}}
                {{--<li class="not-active"><a href="javascript:void(0)" disabled>الرسائل</a></li>--}}
                <li  @if (\Route::current()->getName() == 'user.centers') class="active" @endif><a href="{{route('user.centers')}}">{{trans('app.centers.user_added')}}</a></li>
                <li @if (\Route::current()->getName() == 'user.points') class="active" @endif><a href="{{route('user.points')}}">{{trans('app.used_points')}}</a></li>
            </ul>
        </div>
    </div>
</div>