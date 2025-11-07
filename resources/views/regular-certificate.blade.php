
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        /* @font-face {
            font-family: 'GreatVibes';
            font-weight: normal;
            font-style: normal;
            src: url("{{ resource_path('fonts/GreatVibes-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'BlackOpsOne';
            font-weight: normal;
            font-style: normal;
            src: url("{{ resource_path('fonts/BlackOpsOne-Regular.ttf') }}") format('truetype');
        } */

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        :root{
            --fieldLeft: 320px;  
            --firstY: 360px;   
        }
        
        
        .certificate-container {
            position: relative;
            width: 1011px;
            /* image width */
            height: 768px;
            /* image height */
            background: url('/public/assets/images/certificate/certificate-new.png') no-repeat center;
            background-size: cover;
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
           top: 215px;
            left: 824px;
            width: 108px;
            height: 126px;
            background-color: #00000054;

            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;

            /* background-image: url('./img/profile.jpg'); */
        }
        .field.cr-no {
            top: 329px;
            left: var(--fieldLeft);
        }

        .field.certified-that {
            top: 366px;
            left: var(--fieldLeft);
            width: 600px;
        }

        .field.son-of {
            top: 400px;
            left: var(--fieldLeft);
            width: 600px;
        }

        .field.duration {
            top: 433px;
            left: var(--fieldLeft);
            width: 600px;
        }

        .field.contact-hour {
            top: 466px;
            left: var(--fieldLeft);
            width: 600px;
        }

        .field.issue-date {
            top: 495px;
            left: var(--fieldLeft);
            width: 200px;
        }

        /* === Completion Text === */
        .field.course-text { 
            top: 556px;
            left: 502px;   
        }

        /* === Signatures === */
        .field.training-manager { 
            top: 630px;
            left: 120px;
        }
        .field.training-manager img{
            mix-blend-mode: multiply;
            width: 53px;
        
        }

        .field.director {  
            top: 612px;
            left: 818px;
        }
        .field.director  img{ 
            mix-blend-mode: multiply;
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


        <div class="field cr-no uppercase">{{ $certificate?->certificate_number }}</div>
        <div class="field certified-that uppercase">{{ $certificate?->student?->name }}</div>
        <div class="field son-of uppercase">{{ $certificate?->student?->fathers_name }}</div>
        <div class="field duration">{{ $certificate?->course->duration }} {{ ucFirst($certificate?->course->duration_type) }}</div>
        <div class="field contact-hour">{{ $certificate?->contact_hour }} Hours</div>
        <div class="field issue-date">{{  Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</div>

        <div class="field course-text">
            <b>{{ $certificate?->course->course_name }} <<<</b>
        </div>

        <div class="field training-manager">
            <img src="{{ public_path('assets/images/certificate/training.jpg') }}" alt="">
        </div>
        <div class="field director">
            <img src="{{ public_path('assets/images/certificate/director.jpg') }}" alt="">
        </div>
    </div>
      </div>

   

</body>

</html>
