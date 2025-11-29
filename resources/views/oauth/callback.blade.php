<html>

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <script>
        'use strict';

        // if VS Code IDE lights up a warning here, it is caused by mixing languages in this template file:
        // https://github.com/microsoft/vscode/issues/100613

        @if(isset($error))
            alert('{{ $error }}');
            window.close();
        @else
            window.opener.postMessage(
                {
                    user: @json($user ?? null),
                    linked: @json($linked ?? false),
                },
                "{{ url('/') }}"
            );

            window.close();
        @endif
    </script>
</head>

<body>
</body>

</html>