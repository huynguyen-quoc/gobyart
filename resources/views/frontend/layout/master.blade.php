<!DOCTYPE html>
<html lang="en" class="is-not-touch">
    <head>
        <meta charset="utf-8">

        @yield('meta')
        <meta name="robots" content="all">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale = 1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="/assets/bower_components/iCheck/skins/all.css" rel="stylesheet">
        <link href="/assets/bower_components/kendo-ui/styles/kendo.common.min.css" rel="stylesheet">
        <link href="/assets/bower_components/kendo-ui/styles/kendo.default.min.css" rel="stylesheet">
        <link href="/assets/bower_components/kendo-ui/styles/kendo.silver.min.css" rel="stylesheet">
        <link href="/assets/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet">

        <link href="/assets/frontend/css/app{{ env('APP_ENV') == 'production' ? '.min':'' }}.css" rel="stylesheet">
        @yield('styles')

         <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                    document,'script','https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '293125094392412');
            fbq('track', "PageView");</script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=293125094392412&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->
    </head>

    <body class="page">

        @include('frontend.partials.header')


        @yield('content')

        </div>
        <div class="shadow"></div>
        @include('frontend.partials.footer')
        @include('frontend.partials.image-popover')


        <script  type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/ev-emitter/ev-emitter.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/eventEmitter/EventEmitter.min.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/jquery.fitvids/jquery.fitvids.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/jquery-hoverintent/jquery.hoverIntent.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/jquery-infinite-scroll/jquery.infinitescroll.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/jquery_lazyload/jquery.lazyload.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/masonry/dist/masonry.pkgd.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/slick-carousel/slick/slick.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/iCheck/icheck.min.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script  type="text/javascript" src="/assets/bower_components/kendo-ui/js/kendo.web.min.js"></script>
        <script  type="text/javascript" src="/assets/frontend/js/all{{ env('APP_ENV') == 'production' ? '.min':'' }}.js?v=1.0.1"></script>

        @yield('scripts')

    </body>
</html>