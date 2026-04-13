<footer class="site-footer pt-4">
    <div class="container">
        <div class="row">
            @foreach ($abouts as $about)
                <div class="col-lg-6">
                    <h2 class="footer-heading mb-4">About Us</h2>
                    <p>
                        {{ $about->deskripsi }}
                    </p>
                </div>
            @endforeach
            <div class="col-lg-6 ml-auto">
                <div class="row">
                    <div class="col-lg-3">
                        <h2 class="footer-heading mb-4">Quick Links</h2>
                        <ul class="list-unstyled">
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#service">Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-1 text-center">
            <div class="col-md-12">
                <div class="border-top pt-3">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All rights reserved
                        <i class="icon-heart text-danger" aria-hidden="true"></i>
                        <a href="https://colorlib.com" target="_blank">Shany</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
