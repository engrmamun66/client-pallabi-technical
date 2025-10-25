<section class="hero-slide-wrapper techex-landing-page">
    <div class="hero-slider-active-2 owl-carousel owl-theme">
        @php
            $sliders = App\Models\Slider::get();
        @endphp
        @foreach ($sliders as $slider)
        <div class="single-slide bg-cover" style="background-image: url('{{ asset('public/'.$slider->image) }}');min-height: 500px">
        </div>
        @endforeach

    </div>

</section>
