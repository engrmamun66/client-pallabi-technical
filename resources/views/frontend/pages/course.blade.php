@extends('frontend.layouts.front')
@section('title', 'Course Page')

@section('content')


    <section class="blog-wrapper news-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="blog-posts">
                        <div class="single-blog-post">
                            <div class="post-featured-thumb bg-cover"
                                style="background-image: url('{{ asset('public/'.$course->image) }}')">
                            </div>
                            <div class="post-content">
                                <h2><a href="#">{{ $course->title }}</a></h2>
                                <div class="post-meta">
                                    <span><i class="fal fa-wallet"></i>{{ $course->price }} .tk</span>
                                    <span><i class="fal fa-clock"></i>{{ $course->duration }} Duration</span>
                                </div>
                                <p>{!! $course->description !!}</p>
                                {{-- <div class="d-flex justify-content-between align-items-center mt-30">
                                    <div class="author-info">
                                        <div class="author-img"
                                            style="background-image: url('assets/img/blog/author_img.jpg')"></div>
                                        <h5><a href="#">by Hetmayar</a></h5>
                                    </div>
                                    <div class="post-link">
                                        <a href="news-details.html"><i class="fal fa-arrow-right"></i> Read More</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.footer-banner')

@endsection
