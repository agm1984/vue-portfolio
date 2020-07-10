<html>
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>
        <script>
            'use strict';

            // if VS Code IDE lights up a warning here, it is caused by mixing languages in this template file:
            // https://github.com/microsoft/vscode/issues/100613

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
