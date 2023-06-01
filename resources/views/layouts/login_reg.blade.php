<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HRIS | @yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/DA-logo.png') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/css/card.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/css/loading.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/css/pdsTable.css') }}" rel="stylesheet">
    @if (!Request::is('/'))
        <link href="{{ asset('storage/css/navbar.css') }}" rel="stylesheet">
    @endif
    <style>
        .bg_login_reg {
            content: "";
            width: 100%;
            height: 100%;
            background-size: cover !important;
            background-position: center;
            background-repeat: no-repeat !important;
            background:
                /* top, transparent red, faked with gradient */
                linear-gradient(rgba(46, 139, 86, 0.786),
                    rgba(17, 146, 73, 0.786)),
                /* bottom, image */
                url('../images/MH-da.jpg');
        }

        .banner-text{
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }

        @media screen and (max-width: 992px) {
            .bg_login_reg {
                display: hidden;
            }

        }
    </style>
    @yield('customCSS')
</head>

<body class="bg-white">
    <div id="app">
        <div class="d-flex position-absolute" style="z-index:9999;right: 2%; margin-top: 1rem">
            @if (Session::has('alert'))
                <div class="alert alert-{{ explode('|', Session::get('alert'))[0] ?? 'info' }} alert-dismissible show"
                    role="alert">
                    <i class="fa fa-exclamation-triangle text-dark me-1" aria-hidden="true"></i>
                    <strong>{{ explode('|', Session::get('alert'))[1] }} !</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <main>
            <div class="row" style="height: 100vh">
                <div class="col-0 col-md-8 bg_login_reg text-center">
                    <div class="banner-text text-white">
                        <img src="{{ asset('images/DA-logo.png') }}" alt="" width="200px" height="200px">
                        <h2 class="display-3 text-uppercase">Human Resource Information System</h2>
                        <p class="h1">LGU - Delfin Albano, Isabela</p>
                        <a href="{{ route('publication') }}" class="btn btn-light text-success fw-bold">Check Publications</a>
                    </div>
                </div>
                <div class="col align-middle"style="position:relative;">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('customJS')
    <script src="{{ asset('storage/js/modal.js') }}"></script>
</body>

</html>
