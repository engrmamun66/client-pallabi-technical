@extends('frontend.layouts.front')
@section('title', 'Director Page')

@section('content')


    <section class="faq-section section-padding">
        <div class="faq-bg bg-cover d-none d-lg-block"
            style="background-image: url('{{ asset('public/'.$latestDirectorSection->image) }}')"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7">
                    <div class="col-12 col-lg-12 mb-40">
                        <div class="section-title">
                            <p>{{ $latestDirectorSection->title }}</p>
                            <h1>{!! $latestDirectorSection->description !!}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.footer-banner')

@endsection
