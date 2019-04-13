<!doctype html>
<!--[if IE 8 ]>
<html dir="{{app()->getLocale()==" en"?"ltr":"rtl"}}" lang="en-US" class="no-js ie9 oldie ie"> <![endif]-->
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{trans('app.name')}} | @yield("title")</title>
    @if(app()->getLocale() != 'en')
        <link href="{{asset('/assets')}}/css/maincss.css" rel="stylesheet">
    @else
        <link href="{{asset('/assets')}}/css/maincss-en.css" rel="stylesheet">
    @endif
    <link href="{{asset('/')}}/css/developer.css?1234567899" rel="stylesheet">
    <script src="{{asset('/')}}/js/pace.js"></script>

    <meta name="google-site-verification" content="hplfhLZkgG1T6CxTh29XyFyZU-Wp6hn1jcDt___zIdA" />
    <meta name="copyright" content="munagasatcom">
    <meta name="language" content="{{app()->getLocale()}}">
    @section('meta')
        <meta name="title" content="<?=  option('site_title')?>">
        <meta name="description" content="<?= str_limit(option('site_description'), 150)?>">
        <meta name="keywords" content="<?=option('site_keywords')?>">
        <meta name="author" content="<?=option('site_author')?>">
        <meta property="og:locale" content="{{app()->getLocale()}}"/>
        <meta property="og:title" content="<?=  option('site_title')?>"/>
        <meta property="og:site_name" content="{{option('site_name')}}"/>
        <meta property="og:description" content="<?= str_limit(option('site_description'), 150)?>">
        <meta property="og:image" content="{{asset('assets')}}/images/logo.png">
        <meta name="twitter:title" content="<?= option('site_title')?>">
        <meta name="twitter:description" content="<?= str_limit(option('site_description'), 150)?>">
        <meta name="twitter:image" content="{{asset('assets')}}/images/logo.png">
        <meta name="twitter:url" content="{{asset('/')}}">
    @show
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets')}}/images/fav_icon.jpg">

    <script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "{{asset('/')}}",
    "logo": "{{asset('assets')}}/images/logo.jpg"
    }


    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133172600-1"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());


        gtag('config', 'UA-133172600-1');

    </script>

@stack('head')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="{{app()->getLocale()}}">


@include('layouts.partials.header')
<section class="container">
    @include('layouts.partials.messages')
</section>

@yield('content')

@include('layouts.partials.footer')


<script src="{{asset('/assets')}}/js/main.js"></script>
<script src="{{asset('/assets')}}/js/jquery.js"></script>
<script src="{{asset('/assets')}}/js/bootstrap.min.js"></script>
<script src="{{asset('/assets')}}/js/bootstrap-datepicker.js"></script>
<script src="{{asset('/assets')}}/js/jquery-asRange.min.js"></script>
<script src="{{asset('/assets')}}/js/hideshare.js"></script>
<script src="{{asset('/assets')}}/js/function.js"></script>
<script src="{{asset('/assets')}}/js/UnoDropZone.js"></script>
<script src="{{asset('/')}}js/popup.js"></script>
@if(!is_mobile())
    <script>
        $('.open-image').magnificPopup({type: 'image'});
    </script>
@endif
@stack('scripts')
</body>
</html>