@extends('frontend.layouts.front')
@section('title', 'About Page')

@section('content')


    <section class="about-us-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 pr-5">
                    <div class="section-title mb-30">
                        <p>About Institute</p>
                        <h1>{{ $latestAboutSection->title }}</h1>
                    </div>

                    <p class="pr-lg-5">{!! $latestAboutSection->description !!}</p>
                </div>

                <div class="col-lg-6 pl-lg-5 mt-5 mt-lg-0 col-12">
                    <div class="about-right-img">
                        <span class="dot-circle"></span>
                        <div class="about-us-img" style="background-image: url('{{ asset('public/'.$latestAboutSection->image) }}')">
                        </div>
                        <span class="triangle-bottom-right"></span>
                    </div>
                </div>
            </div>

            <div class="row mpt-50 pt-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="single-features-item">
                        <div class="icon">
                            <i class="flaticon-speech-bubble"></i>
                        </div>
                        <div class="content">
                            <h3>Mission</h3>
                            <p>{!! $latestAboutSection->mission !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="single-features-item">
                        <div class="icon">
                            <i class="flaticon-mobile-app"></i>
                        </div>
                        <div class="content">
                            <h3>Vision</h3>
                            <p>{!! $latestAboutSection->vision !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.footer-banner')

@endsection
