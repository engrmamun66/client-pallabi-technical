<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet</title>
    <style>
        @font-face {
            font-family: 'GreatVibes';
            src: url("{{ resource_path('fonts/GreatVibes-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'BlackOpsOne';
            src: url("{{ resource_path('fonts/BlackOpsOne-Regular.ttf') }}") format('truetype');
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: white;
            font-family: sans-serif;
        }

        :root{
            --fieldLeft: 360px; 
            --adjustY: 30px;    
        }

        .certificate-container {
            position: relative;
            width: 950px;
            height: 1190px;
            background: url('/public/assets/images/certificate/marksheet-new.png') no-repeat center;
            background-size: cover;
            /* Center the container */
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

        /* === Student Info Fields === */
        .field.profile-image-area {
            top: 352px;
            left: 740px;
            width: 111px;
            height: 131px;
            background-color: #00000054;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .field.tr-no {
            top: 397px;
            left: var(--fieldLeft);
        }
        .field.name {
            top: 489px;
            left: var(--fieldLeft);
        }
        .field.father-name {
            top: 532px;
            left: var(--fieldLeft);
        }
        .field.nid-number {
            top: 573px;
            left: var(--fieldLeft);
        }
        .field.test-of {
            top: 615px;
            left: var(--fieldLeft);
            font-family: sans-serif;
        }
        .field.date-of-test {
            top: 658px;
            left: var(--fieldLeft);
        }
        .field.marks-obtained {
            top: 700px;
            left: var(--fieldLeft);
        }
        .field.deserved-grage {
            top: 742px;
            left: var(--fieldLeft);
        }
        .field.recommendation {
            top: 782px;
            left: var(--fieldLeft);
        }

        /* === Signatures === */
        .field.training-manager { 
            top: 857px;
            left: 170px;
        }
        .field.training-manager img{
            mix-blend-mode: multiply;
            width: 53px;
        }

        .field.director {  
            top: 845px;
            left: 735px;
        }
        .field.director  img{ 
            mix-blend-mode: multiply;
        }

        .field.issue-date {
            top: 958px;
            left: 260px;
        }

        /* Print-specific styles */
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
            }
            .certificate-container {
                margin: 0 !important;
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="certificate-container">
             @php
                $studentImagePath = null;
                if ($certificate?->student?->image) {
                    $imagePath = public_path($certificate->student->image);
                    if (file_exists($imagePath)) {
                        $studentImagePath = $imagePath;
                    }
                }
                
                $finalImagePath = $studentImagePath ?: public_path('assets/images/certificate/profile.jpg');
            @endphp
            <div class="field profile-image-area" style="background-image: url('{{ $finalImagePath }}')"> </div>
            <div class="field tr-no uppercase">{{ $certificate?->certificate_number }}</div>
            <div class="field name uppercase">{{ $certificate?->student?->name }}</div>
            <div class="field father-name uppercase">{{ $certificate?->student?->fathers_name }}</div>
            <div class="field nid-number uppercase">{{ $certificate?->student?->nid ?? 'N/A'}}</div>
            <div class="field test-of">{{ $certificate?->course->course_name }}</div>
            <div class="field date-of-test">{{ $certificate?->test_date }}</div>
            <div class="field marks-obtained">{{ $certificate?->mark_obtained }}%</div>
            <div class="field deserved-grage uppercase">{{ $certificate?->grade }}</div>
            <div class="field recommendation uppercase">{{ $certificate?->recommendation }}</div>

            <div class="field training-manager">
                <img src="{{ public_path('assets/images/certificate/training.jpg') }}" alt="">
            </div>
            <div class="field director">
                <img src="{{ public_path('assets/images/certificate/director.jpg') }}" alt="">
            </div>
            <div class="field issue-date">{{ Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</div>
        </div>
    </div>
</body>
</html>