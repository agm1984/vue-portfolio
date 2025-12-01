@php
    $config = [
        'appName' => config('app.name'),
        'github' => [
            'client_id' => config('services.github.client_id'),
            'callback_url' => config('services.github.callback_url'),
            'provider_name' => config('services.github.provider_name'),
        ],
        'twitter' => [
            'client_id' => config('services.twitter.client_id'),
            'callback_url' => config('services.twitter.callback_url'),
            'provider_name' => config('services.twitter.provider_name'),
        ],
    ];

    $siteTitle = "Adam Mackintosh's Portfolio";
    $siteUrl = config('app.url', url('/'));
    $siteDescription = 'Adam Mackintosh is a Nanaimo-based senior software developer focused on functional programming, TypeScript, and lean delivery. Explore his portfolio and connect for collaboration.';
    $siteImage = sprintf('%s/adam.png', rtrim($siteUrl, '/'));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>
            Adam Mackintosh's portfolio @yield('title')
        </title>

        <link rel="canonical" href="{{ $siteUrl }}">
        <meta name="author" content="Adam Mackintosh">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#006666">
        <meta name="msapplication-TileColor" content="#006666">
        <meta name="theme-color" content="#ffffff">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300"> -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300"> -->
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,900;1,400&display=swap" rel="stylesheet">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="theme-color" content="#000000">
        <meta name="robots" content="index, follow">
        <meta name="description" content="{{ $siteDescription }}">
        <meta name="keywords" content="Adam Mackintosh, software developer, Vue, Laravel, Nanaimo, TypeScript, functional programming, consulting">

        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $siteTitle }}">
        <meta property="og:description" content="{{ $siteDescription }}">
        <meta property="og:url" content="{{ $siteUrl }}">
        <meta property="og:site_name" content="adammackintosh.net">
        <meta property="og:image" content="{{ $siteImage }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $siteTitle }}">
        <meta property="og:locale" content="en_CA">
        <meta property="fb:app_id" content="1160271080719333">
        <meta property="fb:admins" content="568188506708923">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@agm1984">
        <meta name="twitter:creator" content="@agm1984">
        <meta name="twitter:title" content="{{ $siteTitle }}">
        <meta name="twitter:description" content="{{ $siteDescription }}">
        <meta name="twitter:image" content="{{ $siteImage }}">
        <meta name="twitter:image:alt" content="{{ $siteTitle }}">

        <meta itemprop="name" content="{{ $siteTitle }}">
        <meta itemprop="description" content="{{ $siteDescription }}">
        <meta itemprop="image" content="{{ $siteImage }}">
        <meta itemprop="author" content="Adam Mackintosh">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="application/ld+json">
            {
                "@@context": "http://schema.org",
                "@@type": "Person",
                "name": "Adam Mackintosh",
                "sameAs": [
                    "https://www.linkedin.com/in/adam-mackintosh-1540b874",
                    "https://twitter.com/agm1984",
                    "https://www.medium.com/@agm1984",
                    "https://github.com/agm1984",
                    "https://stackoverflow.com/users/6141025/agm1984"
                ],
                "jobTitle": "Software Developer",
                "birthDate": "1984-08-14",
                "birthPlace": "Nanaimo, BC",
                "nationality": "Canadian",
                "additionalName": "agm1984",
                "url": "{{ $siteUrl }}",
                "description": "{{ $siteDescription }}",
                "image": "{{ $siteImage }}",
                "address": {
                    "@@type": "PostalAddress",
                    "addressLocality": "Nanaimo",
                    "addressRegion": "British Columbia"
                },
                "worksFor": {
                    "@@type": "Organization",
                    "name": "Adam Mackintosh Consulting"
                }
            }
        </script>
    </head>

    <body class="antialiased">
        <noscript>
            You need to enable JavaScript to sample this portfolio.
        </noscript>

        <div id="app"></div>

        <script>
            'use strict';

            window.config = @json($config);

            const c1 = 'color:#1B85B8';
            const c2 = 'color:#826F8B';
            const c3 = 'color:#559E83';
            const c4 = 'color:#AE5A41';
            const c5 = 'color:#929292';
            const c6 = 'color:#F25C05';

            console.log(
                "\n" +
                "\r\n%c      db%c      `7MM^^^Yb.%c      db%c      `7MMM.     ,MMF'" +
                "\r\n%c     ;MM:%c       MM    `Yb.%c   ;MM:%c       MMMb    dPMM  " +
                "\r\n%c    ,V^MM.%c      MM     `Mb%c  ,V^MM.%c      M YM   ,M MM  " +
                "\r\n%c   ,M  `MM%c      MM      MM%c ,M  `MM%c      M  Mb  M' MM  " +
                "\r\n%c   AbmmmqMA%c     MM     ,MP%c AbmmmqMA%c     M  YM.P'  MM  " +
                "\r\n%c  A'     VML%c    MM    ,dP'%cA'     VML%c    M  `YM'   MM  " +
                "\r\n%c.AMA.   .AMMA.%c.JMMmmmdP'%c.AMA.   .AMMA.%c.JML. `'  .JMML." +
                "\r\n" +
                "%cHey! I see you are an F12 Button Enthusiast :)\n" +
                "This ain't your grandpa's JavaScript." +
                "\n\n" +
                "%c                               adam@adammackintosh.net" +
                "\n\n",
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c1, c2, c3, c4,
                c5,
                c6
            );
        </script>

        @routes

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </body>
</html>
