@extends('frontend.layouts.front')
@section('title', 'Admission Page')

@section('content')


    <section class="about-us-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 pr-5">
                    <div class="section-title mb-30">
                        <p>Admission</p>
                        <h1>{{ $latestAdmission->title }}</h1>
                    </div>

                    <p class="pr-lg-5">{!! $latestAdmission->description !!}</p>
                </div>

                <div class="col-lg-6 pl-lg-5 mt-5 mt-lg-0 col-12">
                    <div class="about-right-img">
                        <span class="dot-circle"></span>
                        <div class="about-us-img" style="background-image: url('{{ asset('public/'.$latestAdmission->image) }}')">
                        </div>
                        <span class="triangle-bottom-right"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.footer-banner')

@endsection
