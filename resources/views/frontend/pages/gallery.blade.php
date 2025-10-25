@extends('frontend.layouts.front')
@section('title', 'Gallery Page')

@section('content')

    <section class="case-study-wrapper section-padding">
        <div class="container">
            <div class="row mb-50 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="section-title">
                        <h1>Our Gallery </h1>
                    </div>
                </div>
                <div class="col-12 col-md-7 mt-4 mt-md-0  text-md-right">
                    <div class="case-cat-filter">
                        <button data-filter="*" class="active">All</button>
                        @foreach ($galleries as $gallery)
                            @php
                                $firstWord = ucfirst(explode(' ', $gallery->title)[0]);
                            @endphp
                            <button data-filter=".{{ $firstWord }}">{{ $firstWord }}</button>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="row grid">
                @foreach ($galleries as $gallery)
                    @php
                        $firstWord = ucfirst(explode(' ', $gallery->title)[0]);
                    @endphp
                    <div class="col-xl-4 col-md-6 grid-item {{ $firstWord }}">
                        <div class="single-case-study">
                            <div class="features-thumb bg-cover"
                                style="background-image: url('{{ asset('public/'.$gallery->image) }}');background-size: cover !important;">
                            </div>
                            <div class="content">
                                <p>{{ $gallery->title }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    @include('frontend.layouts.footer-banner')

@endsection
