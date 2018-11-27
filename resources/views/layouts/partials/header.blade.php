
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
            <a class="navbar-brand" href="#"><img src="{{asset('/assets')}}/images/logo.jpg" alt=""></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="navbar-form navbar-left nav navbar-nav menu">
                <li><a href="#"> الرئيسية<span class="sr-only">(current)</span></a></li>
                <li><a href="#">حول البوابه</a></li>
                <li><a href="#">الأنظمة و اللوائح</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <button class="fbutcenter" type="button" onclick="location.href = 'registration.html';"> تسجيل
                    </button>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="{{asset('/assets')}}/images/avatar.jpg" alt="">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">اعدادت</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج </a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!--Begin:header-->
<header>
    <div class="header"><div class="container">
            <ul class="nav nav-pills nav-justified tab">
                <li><a href="monaasat.html">مناقصات حكومية</a> </li>
                <li><a href="marakz.html">مراكز خدمية</a></li>
                <li><a href="foras.html">فرص استثماريه</a></li>
            </ul>
        </div></div>
</header>
<!--End:header-->