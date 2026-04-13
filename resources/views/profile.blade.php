<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') &mdash; Shany</title>
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

        <div class="site-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-4 mr-auto">
                        <h2 class="line-bottom">
                            We Are Leader In The Construction World
                        </h2>
                    </div>
                    <div class="col-md-8 text-right">
                        <nav class="custom-tab nav" role="tablist" class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a href="#nav-one" class="nav-item nav-link active" data-toggle="tab" role="tab"
                                aria-controls="nav-one" aria-selected="true">Technology</a>
                            <a href="#nav-two" class="nav-item nav-link" data-toggle="tab" role="tab"
                                aria-controls="nav-two" aria-selected="false">Quality</a>
                            <a href="#nav-three" class="nav-item nav-link" data-toggle="tab" role="tab"
                                aria-controls="nav-three" aria-selected="false">Staff</a>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-one" role="tabpanel"
                                aria-labelledby="nav-one-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        <img src="images/hero_1.jpg" alt="Image" class="img-fluid" />
                                    </div>
                                    <div class="col-md-4 ml-auto">
                                        <h2 class="line-bottom">Technology</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Quasi impedit quaerat doloribus magni quisquam
                                            amet ipsum? Dolores, vitae, eveniet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        <img src="images/hero_2.jpg" alt="Image" class="img-fluid" />
                                    </div>
                                    <div class="col-md-4 ml-auto">
                                        <h2 class="line-bottom">Quality</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Praesentium assumenda illum voluptatibus voluptas
                                            ratione error explicabo inventore obcaecati incidunt.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-three" role="tabpanel" aria-labelledby="nav-three-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        <img src="images/hero_3.jpg" alt="Image" class="img-fluid" />
                                    </div>
                                    <div class="col-md-4 ml-auto">
                                        <h2 class="line-bottom">Staff</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eos quibusdam voluptatum, nesciunt nulla
                                            laudantium corporis necessitatibus explicabo nobis
                                            sapiente!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- our tools -->
        @yield('tools')
        <!-- end our tools -->

        {{-- Footer --}}
        @include('template/profile/footer')
        {{-- End Footer --}}
    </div>

    @include('template/assets/profile/footer')

</body>

</html>
