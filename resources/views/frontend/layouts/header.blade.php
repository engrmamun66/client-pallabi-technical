<header class="header-wrap header-5">
    <div class="top-header d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="header-cta">
                        <ul>
                            <li><a href="#"><i class="icon-location-dot"></i>P#30,R#14,B#Ta,Mirpur-12,Dhaka-1216</a>
                            </li>
                            <li><a href="mailto:pallabitechnical@gmail.com"><i
                                        class="fal fa-envelope"></i>pallabitechnical@gmail.com</a></li>
                            <li><a href="tel:+8801786721718"><i class="fal fa-phone"></i>01786721718</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="header-right-cta d-flex justify-content-end">
                        <div class="social-profile">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                        |

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-header-wraper">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="header-logo">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('frontend/assets/img/pallabi.jpeg') }}" style="height: 100px"
                                alt="pallabi_technical_institute">
                        </a>
                    </div>
                </div>
                <div class="header-menu d-none d-xl-block">
                    <div class="main-menu">
                        <ul>
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li><a href="#">About<i class="fas fa-angle-down"></i></a></a>

                                <ul class="sub-menu">
                                    <li><a href="{{ route('director.page') }}">Director's statement</a></li>
                                    <li><a href="{{ route('about.page') }}">About Institute</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Courses<i class="fas fa-angle-down"></i></a></a>

                                <ul class="sub-menu">
                                    @php
                                        $courses = \App\Models\Course::all();
                                    @endphp
                                    @foreach ($courses as $course)
                                        <li><a
                                                href="{{ route('course.page', ['id' => $course->id]) }}">{{ $course->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('admission.page') }}">Admission</a></li>
                            <li><a href="{{ route('certificate.page') }}">Download</a></li>
                            <li><a href="#">Notice & Events<i class="fas fa-angle-down"></i></a></a>

                                <ul class="sub-menu">
                                    <li><a href="{{ route('notice.page') }}">Notice</a></li>
                                    <!-- <li><a href="{{ route('events.page') }}">Events</a></li> -->
                                    <li><a href="{{ route('gallery.page') }}">Gallery</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('contact.page') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="header-right d-flex align-items-center">
                    <div class="header-btn-cta">

                        <a href="{{ url('/login') }}" class="theme-btn">Login <i class="icon-arrow-right-1"></i></a>
                    </div>
                    <div class="mobile-nav-bar d-block ml-3 ml-sm-4 d-xl-none">
                        <div class="mobile-nav-wrap">
                            <div id="hamburger">
                                <i class="fal fa-bars"></i>
                            </div>
                            <!-- mobile menu - responsive menu  -->
                            <div class="mobile-nav">
                                <button type="button" class="close-nav">
                                    <i class="fal fa-times-circle"></i>
                                </button>
                                <nav class="sidebar-nav">
                                    <ul class="metismenu" id="mobile-menu">
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li><a href="{{ route('director.page') }}">Director's statement</a></li>
                                        <li><a href="{{ route('about.page') }}">About Institute</a></li>
                                        <li><a href="#">Courses</a></li>
                                        <li><a href="#">Admission</a></li>
                                        <li><a href="{{ route('certificate.page') }}">Download</a></li>
                                        <li><a href="{{ route('notice.page') }}">Notice</a></li>
                                        <li><a href="{{ route('events.page') }}">Events</a></li>
                                        <li><a href="{{ route('contact.page') }}">Contact</a></li>
                                    </ul>
                                </nav>

                                <div class="action-bar">
                                    <a href="#"><i
                                            class="icon-location-dot"></i>P#30,R#14,B#Ta,Mirpur-12,Dhaka-1216</a>
                                    <a href="mailto:pallabitechnical@gmail.com"><i
                                            class="fal fa-envelope-open-text"></i>pallabitechnical@gmail.com</a>
                                    <a href="tel:+8801786721718"><i class="fal fa-phone"></i>01786721718</a>
                                    <a href="{{ url('/login') }}" class="d-btn theme-btn black">Login <i
                                            class="icon-arrow-right-1"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
