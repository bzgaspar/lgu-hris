<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HRIS | @yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/DA-logo.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('customCSS')
    <style>
        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 22cm;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
                -webkit-print-color-adjust: exact;
            }
        }

        @page {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="fs-6">
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>

</html>
