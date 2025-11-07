@extends('frontend.layouts.front')
@section('title', 'Certificate Page')

@section('content')

<div class="content-area">

    <section class="contact-page-wrap section-padding" style="margin-top: -10%; padding: 70px 0px !important">
        <div class="container">
            <div class="row section-padding pb-0">
                <div class="col-12 text-center mb-10">
                    <div class="section-title">
                        <p>Certificate Search</p>
                    </div>
                </div>
                <div class="col-12 col-lg-12">
                    <div class="contact-form">
                        <form action="{{ route('certificate.page') }}" class="row conact-form">
                            <div class="col-md-12 col-12">
                                <div class="single-personal-info">
                                    <label for="fname">Enter Certificate Number</label>
                                    <input type="text" id="certificate_number" value="{{ request('certificate_number') }}" name="certificate_number" placeholder="Enter Certificate Number" required >
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-12">
                                <div class="single-personal-info">
                                    <label for="fname">Select Certificate Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type" checked value="regular" {{ request('type') == 'regular' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_regular">
                                            Certificate
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" {{ request('type') == 'test' ? 'checked' : '' }} name="type" id="type" value="test">
                                        <label class="form-check-label" for="type_test">
                                           Trade Test
                                        </label>
                                    </div>

                                </div>
                            </div> -->
                            <div class="col-md-12 col-12 text-center">
                                <button type="submit" class="theme-btn">Search <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (request()->has('certificate_number') && $certificate == null)
        <div>
            <h4 class="text-center">No Certificate Found</h4>
        </div>
    @endif

    @if (isset($certificate))
        @if ($certificate->is_old)
            <section style="margin-top: 120px" class="contact-page-wrap ms-auto section-padding">
                <div class="container">
                    <div class="row pb-0">
                        <div class="col-12 text-center mb-20" id="imageContainer">
                            <img src="{{ 'public/'. $certificate->image }}" alt="Certificate Image" style="margin-top: -25%"><br>
                            <a href="{{ asset('storage/app/public/' . $certificate->pdf_path) }}" download class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="contact-page-wrap">
                <div class="container">
                    <div class="row pb-0">
                        <div class="col-12 mb-20" id="imageContainer">
                            @if ($certificate->type == 'regular')
                                <!-- Regular Certificate Design -->
                                <div class="certificate-container">
                                    <div class="field profile-image-area" style="background-image: url('{{ $certificate?->student?->image ? asset('public/' . $certificate?->student?->image) : '/public/assets/images/certificate/profile.jpg' }}')"></div>
                                    <div class="field cr-no uppercase">{{ $certificate?->certificate_number }}</div>
                                    <div class="field certified-that uppercase">{{ $certificate?->student?->name }}</div>
                                    <div class="field son-of uppercase">{{ $certificate?->student?->fathers_name }}</div>
                                    <div class="field duration">{{ $certificate?->course->duration }} {{ ucFirst($certificate?->course->duration_type) }}</div>
                                    <div class="field contact-hour">{{ $certificate?->contact_hour }} Hours</div>
                                    <div class="field issue-date">{{ Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</div>
                                    <div class="field course-text">
                                        <b>{{ $certificate?->course->course_name }}</b>
                                    </div>
                                    <div class="field training-manager">
                                        <img src="{{ asset('assets/images/training.jpg') }}" alt="Training Manager Signature">
                                    </div>
                                    <div class="field director">
                                        <img src="{{ asset('assets/images/director.jpg') }}" alt="Director Signature">
                                    </div>
                                </div>
                            @else
                                <!-- Test Certificate Design -->
                                <div class="certificate-container test-certificate">
                                    <div class="field profile-image-area" style="background-image: url('{{ $certificate?->student?->image ? asset('public/' . $certificate?->student?->image) : '/public/assets/images/certificate/profile.jpg' }}')"></div>
                                    <div class="field tr-no uppercase">{{ $certificate?->certificate_number }}</div>
                                    <div class="field name uppercase">{{ $certificate?->student?->name }}</div>
                                    <div class="field father-name uppercase">{{ $certificate?->student?->fathers_name }}</div>
                                    <div class="field nid-number uppercase">{{ $certificate?->student?->nid_or_passport ?? 'N/A' }}</div>
                                    <div class="field test-of">{{ $certificate?->course->course_name }}</div>
                                    <div class="field date-of-test">{{ $certificate?->test_date }}</div>
                                    <div class="field marks-obtained">{{ $certificate?->mark_obtained }}%</div>
                                    <div class="field deserved-grage uppercase">{{ $certificate?->grade }}</div>
                                    <div class="field recommendation uppercase">{{ $certificate?->recommendation }}</div>
                                    <div class="field training-manager">
                                        <img src="{{ asset('assets/images/training.jpg') }}" alt="Training Manager Signature">
                                    </div>
                                    <div class="field director">
                                        <img src="{{ asset('assets/images/director.jpg') }}" alt="Director Signature">
                                    </div>
                                    <div class="field issue-date">{{ Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</div>
                                </div>
                            @endif

                            <!-- Download Button -->
                            <div class="col-12 text-center mt-4">
                                @if ($certificate->type == 'regular')
                                    <a href="{{ route('download.regularCertificate', $certificate->id) }}" class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                                @else
                                    <a href="{{ route('download.testCertificate', $certificate->id) }}" class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

</div><!-- content-area -->
@include('frontend.layouts.footer-banner')

<style>
    @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&family=Black+Ops+One&display=swap");

    /* Common Certificate Styles */
    .certificate-container {
        position: relative;
        font-family: sans-serif;
        margin: 0 auto;
    }

    .field {
        position: absolute;
        font-size: 16px;
        color: #000;
        font-weight: bold;
    }
    .uppercase {
        text-transform: uppercase;
    }
    /* Regular Certificate Styles */
    .certificate-container:not(.test-certificate) {
        width: 1011px;
        height: 768px;
        background: url('/public/assets/images/certificate/certificate-new.png') no-repeat center;
        background-size: cover;
    }

    .certificate-container:not(.test-certificate) .field.profile-image-area {
        top: 215px;
        left: 824px;
        width: 108px;
        height: 126px;
        background-color: #00000054;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .certificate-container:not(.test-certificate) .field.cr-no {
        top: 322px;
        left: 320px;
    }

    .certificate-container:not(.test-certificate) .field.certified-that {
        top: 361px;
        left: 320px;
        width: 600px;
    }

    .certificate-container:not(.test-certificate) .field.son-of {
        top: 394px;
        left: 320px;
        width: 600px;
    }

    .certificate-container:not(.test-certificate) .field.duration {
        top: 427px;
        left: 320px;
        width: 600px;
    }

    .certificate-container:not(.test-certificate) .field.contact-hour {
        top: 459px;
        left: 320px;
        width: 600px;
    }

    .certificate-container:not(.test-certificate) .field.issue-date {
        top: 489px;
        left: 320px;
        width: 200px;
    }

    .certificate-container:not(.test-certificate) .field.course-text {
        top: 551px;
        left: 502px;
        font-family: sans-serif;
    }

    .certificate-container:not(.test-certificate) .field.training-manager {
        top: 630px;
        left: 120px;
    }

    .certificate-container:not(.test-certificate) .field.training-manager img {
        mix-blend-mode: multiply;
        width: 53px;
    }

    .certificate-container:not(.test-certificate) .field.director {
        top: 611px;
        left: 818px;
    }

    .certificate-container:not(.test-certificate) .field.director img {
        mix-blend-mode: multiply;
    }

    /* Test Certificate Styles */
    .certificate-container.test-certificate {
        width: 850px;
        height: 1090px;
        background: url('/public/assets/images/certificate/marksheet-new.png') no-repeat center;
        background-size: cover;
    }

    .certificate-container.test-certificate .field.profile-image-area {
        top: 319px;
        left: 658px;
        width: 111px;
        height: 131px;
        background-color: #00000054;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .certificate-container.test-certificate .field.tr-no {
        top: 358px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.name {
        top: 442px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.father-name {
        top: 481px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.nid-number {
        top: 519px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.test-of {
        top: 557px;
        left: 320px;
        font-family: sans-serif;
    }

    .certificate-container.test-certificate .field.date-of-test {
        top: 596px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.marks-obtained {
        top: 634px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.deserved-grage {
        top: 673px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.recommendation {
        top: 709px;
        left: 320px;
    }

    .certificate-container.test-certificate .field.training-manager {
        top: 790px;
        left: 131px;
    }

    .certificate-container.test-certificate .field.training-manager img {
        mix-blend-mode: multiply;
        width: 53px;
    }

    .certificate-container.test-certificate .field.director {
        top: 770px;
        left: 658px;
    }

    .certificate-container.test-certificate .field.director img {
        mix-blend-mode: multiply;
    }
    
    .certificate-container.test-certificate .field.issue-date {
        top: 866px;
        left: 220px;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .certificate-container:not(.test-certificate) {
            transform: scale(0.8);
            transform-origin: top center;
        }
        
        .certificate-container.test-certificate {
            transform: scale(0.7);
            transform-origin: top center;
        }
    }

    @media (max-width: 768px) {
        .certificate-container:not(.test-certificate) {
            transform: scale(0.6);
            transform-origin: top center;
        }
        
        .certificate-container.test-certificate {
            transform: scale(0.5);
            transform-origin: top center;
        }
    }
</style>
@endsection