@extends('frontend.layouts.front')
@section('title', 'Director Page')

@section('content')

    <section class="about-us-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 pr-5">
                    <div class="section-title mb-30">
                        <p>About Institute</p>
                        <h1>{{ $latestDirectorSection->title }}</h1>
                    </div>

                    <p class="pr-lg-5">{!! $latestDirectorSection->description !!}</p>
                </div>

                <div class="col-lg-6 pl-lg-5 mt-5 mt-lg-0 col-12">
                    <div class="about-right-img">
                        <span class="dot-circle"></span>
                        <div class="about-us-img" style="background-image: url('{{ asset('public/'.$latestDirectorSection->image) }}');background-position: center; background-size: cover; background-repeat: no-repeat;">
                        </div>
                        <span class="triangle-bottom-right"></span>
                    </div>
                </div>
            </div> 
        </div>
    </section> 

    @include('frontend.layouts.footer-banner')

@endsection
