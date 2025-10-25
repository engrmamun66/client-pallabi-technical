<footer class="footer-4 footer-wrap">
    <div class="footer-widgets">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4 col-xl-3 col-12 pr-xl-4">
                    <div class="single-footer-wid site_footer_widget">
                        <iframe
                            src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100094295540608&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                            width="340" height="130" style="border:none;overflow:hidden" scrolling="no"
                            frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div> <!-- /.col-lg-3 - single-footer-wid -->
                <div class="col-md-4 col-xl-2 col-12">
                    <div class="single-footer-wid">
                        <div class="wid-title">
                            <h4>Navigation</h4>
                        </div>
                        <ul>
                            <li><a href="{{ url('about-page') }}">About Institute</a></li>
                            <li><a href="{{ url('director-page') }}">Director Statement</a></li>
                            <li><a href="{{ url('admission') }}">Admission</a></li>
                            <li><a href="{{ url('certificate-page') }}">Download</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-xl-2 col-12">
                    <div class="single-footer-wid">
                        <div class="wid-title">

                        </div>
                        <ul>
                            <li><a href="{{ url('notice-page') }}">Notice</a></li>
                            <li><a href="{{ url('events-page') }}">Events</a></li>
                            <li><a href="{{ url('gallery-page') }}">Gallery</a></li>
                            <li><a href="{{ url('contact-us') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container text-center">
            <div class="footer-bottom-content">
                © {{ date('Y') }} <a href="https://musamalab.com/">Developed by Musama Lab</a>.

            </div>
        </div>
    </div>
</footer>

<!--  ALl JS Plugins
====================================== -->
<script src="{{ asset('/frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/jquery.easing.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/imageload.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/scrollUp.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/easypiechart.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/counterup.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/metismenu.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/timeline.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/ajax-mail.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/aos.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/active.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
