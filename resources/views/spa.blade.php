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
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>
            Adam Mackintosh's portfolio @yield('title')
        </title>

        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="theme-color" content="#000000">
        <meta name="ROBOTS" content="INDEX, FOLLOW">
        <meta name="description" content="Specialized in Functional Programming and lean agile approaches to business development, Adam Mackintosh is a web and mobile software developer from Nanaimo, BC, Canada ... Check out his portfolio to contact him.">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@agm1984">
        <meta name="twitter:creator" content="@agm1984">
        <meta name="twitter:title" content="Adam Mackintosh's Portfolio">
        <meta name="twitter:description" content="With over 15 years workforce experience, Adam is a web and mobile software developer specialized in node.js and React development.">
        <meta name="twitter:image" content="https://adammackintosh.net/adam.png">
        <meta name="twitter:image:alt" content="Adam Mackintosh">
        <meta property="og:image" content="http://adammackintosh.net/adam.png">
        <meta property="og:title" content="Adam Mackintosh's Portfolio">
        <meta property="og:url" content="http://adammackintosh.net">
        <meta property="og:site_name" content="adammackintosh.net">
        <meta property="og:description" content="Specialized in Functional Programming and lean agile approaches to business development, Adam Mackintosh is a web and mobile software developer from Nanaimo, BC, Canada ... Check out his portfolio to contact him.">
        <meta property="og:type" content="Website">
        <meta property="og:determiner" content="the">
        <meta property="og:locale" content="en_CA">
        <meta property="fb:app_id" content="1160271080719333">
        <meta property="fb:admins" content="568188506708923">
        <meta itemprop="name" content="Adam Mackintosh's portfolio">
        <meta itemprop="description" content="Specialized in functional programming and lean agile approaches to business development, Adam Mackintosh is a web and mobile software developer from Nanaimo, BC, Canada ... Check out his portfolio to contact him and stay ahead of your competition.">
        <meta itemprop="image" url="https://adammackintosh.net/adam.png">
        <meta itemprop="author" content="Adam Mackintosh">

        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "Person",
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
                "url": "https://adammackintosh.net",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Nanaimo",
                    "addressRegion": "British Columbia"
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

        <script src="{{ mix('dist/js/app.js') }}"></script>
    </body>

</html>
