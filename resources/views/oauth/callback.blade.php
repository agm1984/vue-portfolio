<html>
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>
        <script>
            window.opener.postMessage(
                {
                    user: "{{ $user }}",
                    token: "{{ $token }}",
                },
                "{{ url('/') }}"
            );

            window.close();
        </script>
    </head>

    <body>
    </body>

</html>
