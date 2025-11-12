@extends('frontend.layouts.front')
@section('title', 'Notice Page')

@section('content')

<section class="page-banner-wrap bg-cover" style="background-image: url('assets/img/page-banner.jpg')">
    <div class="banner-text">pallabi</div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <div class="page-heading text-white">
                    <div class="page-title">
                        <h1 style="font-size: 50px">Notice Page</h1>
                    </div>
                </div>

                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Notice</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>
</section>

<section class="blog-wrapper news-wrapper section-padding">
    <div class="container">
        <div class="row">
            @foreach ($notices as $notice)
                <div class="col-12 d-flex justify-content-center mb-5">
                    <img src="{{ asset('public/'.$notice->image) }}" alt="image"> 
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('frontend.layouts.footer-banner')

@endsection

