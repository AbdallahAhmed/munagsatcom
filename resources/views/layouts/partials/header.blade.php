<!--Begin:navbar-->
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{asset(app()->getLocale())}}"><img src="{{asset('/assets')}}/images/logo.jpg"
                                                                              alt="{{trans('app.name')}}"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="navbar-form navbar-left nav navbar-nav menu">
                <li><a href="{{route('index')}}"> {{trans('app.home')}}<span class="sr-only">(current)</span></a></li>
                <li>
                    <a href="{{route('page.show', ['slug' => app()->getLocale() == "ar" ? 'حول البوابة' : 'about-us'])}}"> {{trans('app.about_website')}}</a>
                </li>
                <li>
                    <a href="{{route('page.show', ['slug' => app()->getLocale() == "ar" ? 'الشروط والأحكام' : 'terms'])}}">{{trans('app.terms_conditions')}}</a>
                </li>
                <li><a href="{{route('contact-us')}}">{{trans('app.contact_us')}}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(!fauth()->check())
                    @if(\Request::route()->getName()=="login")
                        <li>
                            <button class="fbutcenter" type="button"
                                    onclick="location.href = '{{route('register')}}';"> {{trans('app.register')}}</button>
                        </li>
                    @else
                        <li>
                            <button class="fbutcenter" type="button"
                                    onclick="location.href = '{{route('login')}}';"> {{trans('app.login')}}</button>
                        </li>
                    @endif
                @else
                    <?php
                    $notifications = App\Models\Notifications::where(
                        [
                            ['user_id', fauth()->id()],
                            ['isRead', 0]
                        ])->get();
                    ?>
                    <script>
                        notif_count = "{{count($notifications)}}"
                        setInterval(function () {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "post",
                                url: "{{route('notifications.check')}}",
                                success: function (data) {
                                    if (data.notifications) {
                                        notif_count++;
                                        $('.notify').html(notif_count);
                                    }
                                },
                                error: function () {
                                    alert("Internal Server Error")
                                }
                            })
                        }, 30000)
                    </script>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            <img src="{{fauth()->user()->photo ? thumbnail(fauth()->user()->photo->path, 'avatar') : asset('assets/images/avatar.jpg')}}" alt="{{fauth()->user()->first_name. ' '.fauth()->user()->last_name}}">
                        <i class="notify  badge badge-primary">{{count($notifications) > 0 ? count($notifications) : ''}}</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a>{{fauth()->user()->first_name. ' '.fauth()->user()->last_name}}</a></li>
                            <li role="separator" class="divider"></li>

                            <?php
                            $employee = [];
                            if (fauth()->check()) {
                                $employee = App\Models\Companies_empolyees::where([
                                    ['employee_id', fauth()->user()->id],
                                    ['accepted', 1],
                                    ['status', 1]
                                ])->get();
                            }
                            ?>
                            @if(count($employee) > 0)
                                <li>
                                    <a href="{{route('company.show', ['slug' => \App\Models\Company::find($employee[0]->company_id)->slug])}}">{{trans('app.the_company')}}</a>
                                </li>
                                <li role="separator" class="divider"></li>
                            @endif
                            <li><a href="{{route('user.points')}}">{{trans('app.points')}}</a></li>
                            <li role="separator" class="divider"></li>

                            <li><a href="{{route('user.notifications')}}">{{trans('app.notifications')}}<i class="notify badge badge-primary">{{count($notifications) > 0 ? count($notifications) : ''}}</i></a></li>
                            <li role="separator" class="divider"></li>

                            <li><a href="{{route('user.show')}}">{{trans('app.setting')}}</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('user.recharge')}}">{{trans('app.payments')}}</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('flogout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    {{trans('app.logout')}}
                                </a>

                                <form id="logout-form" action="{{ route('flogout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<header>
    <div class="header">
        <div class="container">
            <ul class="nav nav-pills nav-justified tab">
                <li class="{{\Request::route()->getName()=="index"?'active':''}}"><a
                            href="{{route('index',['lang'=>app()->getLocale()])}}">{{trans('app.government_tenders')}}</a>
                </li>
                <li class="{{\Request::route()->getName()=="centers"?'active':''}}"><a
                            href="{{route('centers')}}">{{trans('app.service_centers')}}</a></li>
                <li class="{{\Request::route()->getName()=="chances"?'active':''}}"><a
                            href="{{route('chances')}}">{{trans('app.investment_opportunities')}}</a></li>
            </ul>
        </div>
    </div>
</header>
