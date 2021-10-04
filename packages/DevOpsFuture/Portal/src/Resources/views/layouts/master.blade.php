<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <title>@yield('page_title')</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">

    <link rel="icon" sizes="16x16" href="{{ devopsfuture_asset('images/favicon.ico') }}" />

    @yield('head')

    @section('seo')

    @show

    @stack('css')

    <style>

    </style>

</head>


<body class="rtl" style="scroll-behavior: smooth;">

    <div id="app">
        <flash-wrapper ref='flashes'></flash-wrapper>

        <div class="main-container-wrapper">

            @include('portal::layouts.header.index')

            @yield('slider')

            <main class="content-container">

                @yield('content-wrapper')

            </main>

        </div>

        @include('portal::layouts.footer.footer')

        <overlay-loader :is-open="show_loader"></overlay-loader>
    </div>

    <script type="text/javascript">
        window.flashMessages = [];

        @if ($success = session('success'))
            window.flashMessages = [{'type': 'alert-success', 'message': "{{ $success }}" }];
        @elseif ($warning = session('warning'))
            window.flashMessages = [{'type': 'alert-warning', 'message': "{{ $warning }}" }];
        @elseif ($error = session('error'))
            window.flashMessages = [{'type': 'alert-error', 'message': "{{ $error }}" }];
        @elseif ($info = session('info'))
            window.flashMessages = [{'type': 'alert-info', 'message': "{{ $info }}" }];
        @endif

        window.serverErrors = [];

        @if (isset($errors))
            @if (count($errors))
                window.serverErrors = @json($errors->getMessages());
            @endif
        @endif
    </script>

    <script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

    @stack('scripts')

    <div class="modal-overlay"></div>

    <script>

    </script>

</body>

</html>
