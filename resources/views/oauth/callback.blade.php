<html>
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>
        <script>
            'use strict';

            window.opener.postMessage(
                {
                    user: {!! $user !!},
                },
                "{{ url('/') }}"
            );

            window.close();
        </script>
    </head>

    <body>
    </body>

</html>
