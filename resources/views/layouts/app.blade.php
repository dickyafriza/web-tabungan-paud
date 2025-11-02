<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ asset('logo-paud.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo-paud.png') }}" />
    <title>{{ $sitename }} | @yield('page-name')</title>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&subset=latin-ext">

    <!-- CSS -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/charts-c3/plugin.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datepicker/datepicker.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    @yield('css')
</head>

<body class="">
    <div class="page" style="display: block;">
        <div class="header py-4">
            <div class="d-flex justify-content-between align-items-center w-100 px-5">

                <!-- Kiri (Logo dan Sitename) -->
                <div class="d-flex align-items-center">
                    <img src="{{ asset('logo-paud.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                    <a class="header-brand" href="{{ route('web.index') }}">
                        <h3 class="mt-2 mb-0">{{ $sitename }}</h3>
                    </a>
                </div>

                <!-- Kanan (User Menu) -->
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                            <span class="avatar" style="background-image: url({{ asset('user.png') }})"></span>
                            <span class="ml-2 d-none d-lg-block">
                                <span class="text-default">{{ Auth::user()->name }}</span>
                                <small class="text-muted d-block mt-1">{{ Auth::user()->role }}</small>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ route('user.edit', Auth::user()->id) }}">
                                <i class="dropdown-icon fe fe-user"></i> Ubah Profil
                            </a>
                            <a class="dropdown-item" href="{{ route('pengaturan.index') }}">
                                <i class="dropdown-icon fe fe-settings"></i> Pengaturan
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="dropdown-icon fe fe-log-out"></i> Keluar
                            </a>
                        </div>
                    </div>

                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                        data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar bg-light">
                @include('shared.sidebar')
            </div>

            <!-- Main Content -->
            <div class="content flex-fill">
                <div class="my-3 my-md-5 mx-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('assets/js/core.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/selectize.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.tablesorter.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery-jvectormap-de-merc.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/daterangepicker.min.js') }}"></script>

    @yield('js')
</body>

</html>
