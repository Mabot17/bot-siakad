

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Bot | Siakad</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}">

        <link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
    </head>
    <body class="  ">
        <!-- loader Start -->
        <div id="loading">
            <div id="loading-center">
            </div>
        </div>
        <!-- loader END -->
        <!-- Wrapper Start -->
        <div class="wrapper">
            @include('layout.sidebar')
            @include('layout.header')

            <div class="content-page">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- Wrapper End-->
        @include('layout.modal_list')
        @include('layout.footer')

        <script src="{{ asset('js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('js/table-treeview.js') }}"></script>
        <script src="{{ asset('js/customizer.js') }}"></script>
        <script src="{{ asset('js/chart-custom.js') }}"></script>
        <script src="{{ asset('js/slider.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('vendor/moment.min.js') }}"></script>

    </body>
</html>
