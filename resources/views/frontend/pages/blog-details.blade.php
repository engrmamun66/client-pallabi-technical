@extends('frontend.layouts.front')
@section('title', 'Blog Page')

@section('content')


    <section class="blog-wrapper news-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="blog-post-details border-wrap">
                        <div class="single-blog-post post-details">
                            <div class="post-content">
                                <img src="{{ asset('public/'.$blog->image) }}" alt="">
                                <h2>{{ $blog->title }}</h2>
                                <p>{!! $blog->description !!}</p>


                            </div>
                        </div>
                        <div class="related-post-wrap">
                            <h3>Releted Post</h3>

                            <div class="row">
                                @foreach ($relatedBlogs as $blog)
                                    <div class="col-md-6 col-12">
                                        <div class="single-related-post">
                                            <div class="featured-thumb bg-cover"
                                                style="background-image: url('{{ asset($blog->image) }}')"></div>
                                            <div class="post-content">
                                                <div class="post-date">
                                                    <span><i
                                                            class="fal fa-calendar-alt"></i>{{ $blog->created_at->format('d M Y') }}</span>
                                                </div>
                                                <h4><a
                                                        href="{{ route('blog.details', [$blog->slug]) }}">{{ $blog->title }}</a>
                                                </h4>
                                                <p>{!! $blog->excerpt !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('frontend.layouts.footer-banner')

@endsection
