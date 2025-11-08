@extends('frontend.layouts.front')
@section('title', 'Home Page')

@section('content')
    @include('frontend.layouts.slider')
    <div class="content-area">

        <section class="about-us-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 pr-xl-5">
                        <div class="section-title mb-30">
                            <p>About Institute</p>
                            <h1>Pallabi Technical Institute empowering individuals with professional skill and knowledge.
                            </h1>
                        </div>

                        <p class="pr-md-5">In 2022, Pallabi Technical started their venture at Mirpur, North zone of Capital
                            city with four (04) professionals bearing similar thoughts. It started vocational courses on
                            Welding and Plumbing & Pipe Fitting. And, right now it has introduced several vocational courses
                            running fully with more than ten (10) employees. Our trained students can able to </p>

                        <div class="about-check-list d-flex">
                            <div class="banner bg-cover" style="background-image: url(' {{ asset('frontend/assets/img/about_list.jpg') }} ');background-position: center; background-size: cover; background-repeat: no-repeat;">
                                
                            </div>

                            <ul class="checked-list">
                                <li>Think critically</li>
                                <li>Solve real world problems</li>
                                <li>Adaptable to any situation</li>
                                <li>Hard working</li>
                            </ul>
                        </div>

                    </div>

                    <div class="col-xl-6 col-md-10 col-lg-6 pl-xl-5 col-12 mt-5 mt-xl-0">
                        <div class="about-thum">
                            <div class="item top-image text-right">
                                <img src="{{ asset('frontend/assets/img/plumbing.jpg') }}" alt="rrdevs" style="width: 400px;transform: translate(0px, 80px);">
                            </div>
                            <div class="item bottom-image">
                                <img src="{{ asset('frontend/assets/img/welding.jpg') }}" alt="rrdevs" style="width: 410px;transform: translate(8px, 50px);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="features-wrapper features-2 section-padding">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-6">
                        <div class="row mtm-30">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-monitor"></i>
                                    </div>
                                    <h4><a href="services-details.html">Development</a></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-pyramid"></i>
                                    </div>
                                    <h4><a href="services-details.html">Engineering</a></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-diagram"></i>
                                    </div>
                                    <h4><a href="services-details.html">IT Marketing</a></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-diagram-1"></i>
                                    </div>
                                    <h4><a href="services-details.html">UX Strategy</a></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-meeting"></i>
                                    </div>
                                    <h4><a href="services-details.html">Consultancy</a></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="icon-box">
                                    <div class="icon">
                                        <i class="flaticon flaticon-stats"></i>
                                    </div>
                                    <h4><a href="services-details.html">Apps Design</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5 offset-xl-1 mt-5 mt-xl-0">
                        <div class="section-title">
                            <p>Courses information</p>
                            <h1>Our professional vocational courses</h1>
                        </div>
                        <p class="mt-20">We integrate cutting-edge technology into our training, encouraging innovation and
                            preparing students to think critically and develop real-world solutions. Committed to making
                            education accessible, we support underprivileged communities with scholarships and financial
                            aid, fostering an inclusive learning environment.</p>
                        <a href="about.html" class="theme-btn mt-30">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <svg class="feature-bg">
                <path fill-rule="evenodd" opacity="0.039" fill="rgb(8, 106, 215)"
                    d="M-0.000,232.999 C-0.000,232.999 239.131,-52.566 575.000,47.000 C910.869,146.565 1087.000,55.653 1231.000,19.999 C1375.000,-15.654 1800.820,-31.520 1915.000,232.999 C1445.000,232.999 -0.000,232.999 -0.000,232.999 Z" />
            </svg>
        </section>

        <!-- <div class="client-brand-logo-wrap techex-landing-page  section-padding-3 bg-white">
            <div class="container">
                <div class="brand-carousel-active d-flex justify-content-between owl-carousel">
                    @php
                        $partnerLogos = \App\Models\PartnerLogo::all();
                    @endphp
                    @foreach ($partnerLogos as $logo)
                        <div class="single-client">
                            <img src="{{ asset('public/'.$logo->image) }}" alt>
                        </div>
                    @endforeach

                </div>
            </div>
        </div> -->


          <section class="case-study-carousel-wrapper style-2 pt-100">
            <div class="container">
                <div class="row mb-70">
                    <div class="col-lg-6 col-12">
                        <div class="section-title style-3">
                            <span>process</span>
                            <p>working process</p>
                            <h1>How Does We Works</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 col-12 text-lg-right">
                        <div class="work-process-nav"></div>
                    </div>
                </div>

                <div class="case-study-items owl-carousel text-center">
                    @php
                        $blogs = \App\Models\Blog::all();
                    @endphp
                    @foreach ($blogs as $blog)
                        <div class="single-case-item">
                            <div class="case-thumb bg-cover" style="background-image: url('{{ asset('public/'.$blog->image) }}')">
                            </div>
                            <div class="contents">
                                <div class="content-visible">
                                    <span>{{ $blog->title }}</span>
                                </div>
                                <div class="overlay-content">
                                    <h3><a href="project-details.html">{{ $blog->title }}</a></h3>
                                    <p>{{ $blog->excerpt }}</p>
                                    <a href="{{ route('blog.details', [$blog->slug]) }}" class="theme-btn">read more <i
                                            class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>



    </div><!-- content-area -->
    @include('frontend.layouts.footer-banner')
@endsection
