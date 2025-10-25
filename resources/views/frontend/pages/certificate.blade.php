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
                            <div class="col-md-6 col-12">
                                <div class="single-personal-info">
                                    <label for="fname">Enter Certificate Number</label>
                                    <input type="text" id="certificate_number" value="{{ request('certificate_number') }}" name="certificate_number" placeholder="Enter Certificate Number" required >
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
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
                            </div>
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
                            <a href="{{ 'public/storage/'. $certificate->pdf_path }}" download class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="contact-page-wrap">
                <div class="container">
                    <div class="row pb-0">
                        <div class="col-12 mb-20" id="imageContainer">
                            <div class="container certificate-wrapper position-relative">
                                <div class="header">
                                    <img src="{{ asset('assets/images/pallabi.jpg') }}" class="logo" alt="logo" />
                                    <div>
                                        <div class="title-text">PALLABI TECHNICAL INSTITUTE</div>
                                        <div class="subtitle">www.pallabitechnical.org</div>
                                    </div>
                                </div>
                    
                                <div class="text-center">
                                    <div class="badge">Trade Course Certificate</div>
                                </div>
                    
                                <!-- Photo -->
                                <div class="photo">
                                    <img src="{{ 'public/' . $certificate?->student?->image }}" alt="student photo" />
                                </div>
                    
                                <!-- Background logo watermark -->
                                <div class="bg-logo">
                                    <img src="{{ asset('assets/images/pallabi.jpg') }}" alt="logo watermark" />
                                </div>
                    
                                <!-- Certificate Body -->
                                @if ($certificate?->type == 'regular')
                                    <div class="details mt-4">
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;"><strong>CR No</strong></span>
                                            <span>: {{ $certificate?->certificate_number }}</span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Certified that</span>
                                            <span>: <strong>{{ $certificate?->student?->name }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Son/Daughter of</span>
                                            <span>: <strong>{{ $certificate?->student?->fathers_name }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px;">
                                            <span>He/She successfully completed the trade course on</span><br>
                                            <span style="display: inline-block; width: 200px;"></span><span style="margin-top: 40px"><strong>{{ $certificate?->course->course_name }} {{ $certificate?->mark_obtained }} Position</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Duration of Course</span>
                                            <span>: <strong>{{ $certificate?->course->duration }} {{ ucFirst($certificate?->course->duration_type) }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">With Contact Hour</span>
                                            <span>: <strong>{{ $certificate?->contact_hour }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;"><strong>Issue Date</strong></span>
                                            <span>: {{ Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</span>
                                        </p>
                                    </div>
                                @else
                                    <div class="details mt-4">
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;"><strong>TR No</strong></span>
                                            <span>: {{ $certificate?->certificate_number }}</span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Name</span>
                                            <span>: <strong>{{ $certificate?->student?->name }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 20px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Son/Daughter of</span>
                                            <span>: <strong>{{ $certificate?->student?->fathers_name }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Test Of</span>
                                            <span style="margin-bottom: 40px">: <strong>{{ $certificate?->course->course_name }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Date Of Test</span>
                                            <span>: <strong>{{ $certificate?->test_date }} Month</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Marks Obtained</span>
                                            <span>: <strong>{{ $certificate?->mark_obtained }}%</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">He/She Deserved Grade</span>
                                            <span>: <strong>{{ $certificate?->grade }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;">Recommendation</span>
                                            <span>: <strong>{{ $certificate?->recommendation }}</strong></span>
                                        </p>
                                        <p style="margin-bottom: 10px; display: flex;">
                                            <span style="display: inline-block; width: 200px;"><strong>Issue Date</strong></span>
                                            <span>: {{  Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</span>
                                        </p>
                                    </div>
                                @endif
                    
                                <!-- Signatures -->
                                <div class="d-flex justify-content-between" style="width: 100%; margin-top: 120px;">
                                    <div style="text-align: start;">
                                        <img src="{{ asset('assets/images/training.jpg') }}" alt="signature" style="height: 40px; margin-left: 25px" />
                                        <div>Training Manager</div>
                                    </div>
                                    <div style="text-align: right;">
                                        <img src="{{ asset('assets/images/director.png') }}" alt="signature" style="height: 40px;" />
                                        <div style="margin-right: 15px !important">Director</div>
                                    </div>
                                </div>
                    
                                <div class="footer">
                                    This Certificate is awarded to him this day
                                </div>
                    
                                @if ($certificate?->type == 'test')
                                <table class="grade-table mt-4">
                                    <tr>
                                        <th>Marks Range</th>
                                        <td>90%–100%</td>
                                        <td>80%–89%</td>
                                        <td>70%–79%</td>
                                        <td>60%–69%</td>
                                        <td>Below 60%</td>
                                    </tr>
                                    <tr>
                                        <th>Grade</th>
                                        <td>A+</td>
                                        <td>A</td>
                                        <td>B+</td>
                                        <td>B</td>
                                        <td>C (Unfit)</td>
                                    </tr>
                                </table>
                                @endif
                            </div>

                            @if ($certificate->type == 'regular')
                                <div class="col-12 text-center">
                                    <a href="{{ route('download.regularCertificate', $certificate->id) }}" class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                                </div>
                            @else
                                <div class="col-12 text-center">
                                    <a href="{{ route('download.testCertificate', $certificate->id) }}" class="btn ms-auto btn-primary mt-3">Download Certificate</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif


</div><!-- content-area -->
@include('frontend.layouts.footer-banner')
{{-- <script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let certificateNumber = document.getElementById('certificate_number').value;
        const selectedRadio = document.querySelector('input[name="type"]:checked');
        const certificateType = selectedRadio ? selectedRadio.value : null;

          // Construct the query string
          const queryString = new URLSearchParams({
            certificate_number: certificateNumber,
            type: certificateType
        }).toString();

        fetch(`/certificate/search?${queryString}`)
            .then(response => response.json())
            .then(data => {
                if (data.image_path) {
                    document.getElementById('imageContainer').innerHTML = `<img src="${data.image_path}" alt="Certificate Image" style="margin-top: -25%"><br>
                    <a href="${data.pdf_path}" download class="btn btn-primary mt-3">Download Certificate</a>`;
                } else {
                    document.getElementById('imageContainer').innerHTML = 'Certificate not found.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script> --}}

<style>
    @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&family=Black+Ops+One&display=swap");

    .certificate-section {
        margin: 0;
        max-width: 1200px;
        margin-right: 200px !important;
        padding: 2rem;
        font-family: "Georgia", serif;
        background: #fff;
    }

    .certificate-wrapper {
        position: relative;
        max-width: 1000px;
        margin: auto;
        padding: 3rem;
        background: white;
        border: 15px solid;
        border-image: repeating-linear-gradient(
                45deg,
                black 0px,
                black 2px,
                white 2px,
                white 4px
            )
            15;
    }

    .certificate {
        border: 10px double #1a237e;
        padding: 30px;
        position: relative;
        background: white;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .logo {
        height: 80px;
        margin-right: 20px;
    }

    .title-text {
        font-family: "Black Ops One", sans-serif;
        font-size: 1.8rem;
        color: #0d1b70;
        letter-spacing: 1px;
    }

    .subtitle {
        text-align: center;
        font-weight: bold;
        color: #1a237e;
        margin-top: 5px;
    }

    .badge {
        background-color: #0d1b70;
        color: white;
        font-family: "Great Vibes", cursive;
        font-size: 3rem;
        padding: 8px 25px;
        border-radius: 50px;
        display: inline-block;
        margin-left: 100px !important;
        margin: 20px auto;
    }

    .details {
        font-style: italic;
        font-size: 1.3rem;
        margin-top: 30px;
    }

    .details strong {
        font-style: normal;
    }

    .signatures {
        margin-top: 60px;
        position: relative;
        width: 100%;
    }

    .signature {
        text-align: center;
    }

    .signature:last-child {
        position: absolute;
        right: 100px;
    }

    .signature img {
        height: 40px;
    }

    .grade-table {
        width: 100%;
        margin-top: 40px;
        border: 1px solid #000;
        border-collapse: collapse;
    }
    .grade-table th,
    .grade-table td {
        border: 1px solid #000;
        padding: 6px 10px;
        text-align: center;
        font-size: 14px;
    }

    .photo {
        position: absolute;
        top: 140px;
        right: 50px;
        border: 2px solid #000;
    }

    .photo img {
        height: 100px;
        width: 90px;
        object-fit: cover;
    }

    .footer {
        text-align: center;
        font-weight: bold;
        margin-top: 30px;
    }

    .bg-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.08;
        z-index: 0;
    }

    .bg-logo img {
        max-width: 100%;
    }
</style>
@endsection

