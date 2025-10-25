@extends('frontend.layouts.front')
@section('title', 'Contact Page')

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif

    <div class="content-area">
        <section class="contact-page-wrap">
            <div class="container">
                <div class="row" style="padding: 50px;">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-contact-card card1">
                            <div class="top-part">
                                <div class="icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="title">
                                    <h4>Email Address</h4>
                                    <span>Sent mail asap anytime</span>
                                </div>
                            </div>
                            <div class="bottom-part">
                                <div class="info">
                                    <p>pallabitechnical@gmail.com</p>
                                </div>
                                <div class="icon">
                                    <i class="fal fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-contact-card card2">
                            <div class="top-part">
                                <div class="icon">
                                    <i class="fal fa-phone"></i>
                                </div>
                                <div class="title">
                                    <h4>Phone Number</h4>
                                    <span>call us asap anytime</span>
                                </div>
                            </div>
                            <div class="bottom-part">
                                <div class="info">
                                    <p>01786721718</p>
                                </div>
                                <div class="icon">
                                    <i class="fal fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-contact-card card3">
                            <div class="top-part">
                                <div class="icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="title">
                                    <h4>Office Address</h4>
                                    <span>Sent mail asap anytime</span>
                                </div>
                            </div>
                            <div class="bottom-part">
                                <div class="info">
                                    <p>P#30,R#14,B#Ta</p>
                                    <p>Mirpur-12,Dhaka-1216</p>
                                </div>
                                <div class="icon">
                                    <i class="fal fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  pb-0">
                    <div class="col-12 text-center mb-20">
                        <div class="section-title">
                            {{-- <p>send us message</p> --}}
                            <p>Don’t Hesited To Contact Us <br> Say Hello or Message</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="contact-form">
                            <form action="{{ route('contact.submit') }}" method="POST" class="row conact-form">
                                @csrf
                                <div class="col-md-6 col-12">
                                    <div class="single-personal-info">
                                        <label for="fname">Full Name</label>
                                        <input type="text" id="fname" name="name" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="single-personal-info">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email"
                                            placeholder="Enter Email Address" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="single-personal-info">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone_number" placeholder="Enter Number">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="single-personal-info">
                                        <label for="subject">Subject</label>
                                        <input type="text" id="subject" name="subject" placeholder="Enter Subject">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="single-personal-info">
                                        <label for="subject">Enter Message</label>
                                        <textarea placeholder="Enter message" name="message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 text-center">
                                    <button type="submit" class="theme-btn">send message <i
                                            class="fas fa-arrow-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 50px;">
                    <div class="col-12 col-lg-12">
                        <div class="contact-map-wrap">
                            <div id="map">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d383.6330698879939!2d90.36930764132217!3d23.82738225706685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c135747ab2c3%3A0xbde3f0cb1ff965a!2sPallabi%20Technical%20Institute!5e0!3m2!1sen!2sbd!4v1722693839851!5m2!1sen!2sbd"
                                    frameborder="0" style="border:0; width:100%" allowfullscreen="" aria-hidden="false"
                                    tabindex="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- content-area -->
    @include('frontend.layouts.footer-banner')

@endsection
