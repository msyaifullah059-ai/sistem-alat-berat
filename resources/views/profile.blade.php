<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') &mdash; CV Lisan</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @include('template/assets/profile/header')

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        {{-- Header --}}
        @include('template/profile/header')
        {{-- End Header --}}

        {{-- home --}}
        @yield('home')
        {{-- End Home --}}

        <!-- about us -->
        @yield('about')
        <!-- end about us -->

        <!-- our service -->
        @yield('service')
        <!-- end our service -->
        
        <!-- our tools -->
        @yield('tools')
        <!-- end our tools -->

        <!-- our service -->
        @yield('pricing')
        <!-- end our service -->

        <!-- our kontak -->
        @yield('kontak')
        <!-- end our kontak -->

        {{-- Footer --}}
        @include('template/profile/footer')
        {{-- End Footer --}}
    </div>

    @include('template/assets/profile/footer')

</body>

</html>
