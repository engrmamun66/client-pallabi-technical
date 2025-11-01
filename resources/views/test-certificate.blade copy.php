<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Trade Course Certificate</title>
    <style>
        @font-face {
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
        }

        html, body {
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding-right: 80px;
            font-family: DejaVu Sans, sans-serif;
        }

        .page {
            width: 100%;
            height: 830px;
            padding: 30px 40px;
            position: relative;
            box-sizing: border-box;
        }

        .certificate {
            border: 8px double #1a237e;
            padding: 30px;
            position: relative;
            height: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }

        .title {
            font-family: "BlackOpsOne", sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #0d1b70;
        }

        .subtitle {
            color: #0d1b70;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .badge {
            font-family: 'GreatVibes', cursive;
            font-size: 35px;
            background: #0d1b70;
            color: white;
            padding: 8px 20px;
            display: inline-block;
            border-radius: 50px;
            margin-bottom: 20px;
        }

        .photo {
            position: absolute;
            top: 90px;
            right: 50px;
            border: 2px solid #000;
            width: 90px;
            height: 100px;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 0;
        }

        .watermark img {
            width: 100%;
        }

        .content {
            font-family: 'Roboto', sans-serif;
            font-style: italic;
            position: relative;
            z-index: 1;
            font-size: 20px;
            margin-top: 20px;
        }

        .content p {
            margin: 6px 0;
        }

        .content strong {
            font-weight: bold;
            font-style: normal;
        }

        .signatures {
            width: 100%;
            margin-top: 40px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
        }

        .signature {
            text-align: center;
            width: 180px; /* fixed width for consistency */
        }

        .signature img {
            height: 40px;
            display: block;
            margin: 0 auto 5px;
        }

        .footer {
            text-align: center;
            font-weight: bold;
            margin-top: 30px;
        }

        .grade-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
            page-break-inside: avoid;
        }

        .grade-table th,
        .grade-table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
            page-break-inside: avoid !important;
            page-break-after: auto;
        }

        .grade-table th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="certificate">
            <div class="header">
                <img src="{{ public_path('assets/images/certificate/pallabi.jpg') }}" class="logo" alt="logo" />
                <div class="title">PALLABI TECHNICAL INSTITUTE</div>
                <div class="subtitle">www.pallabitechnical.org</div>
                <div class="badge">Trade Course Certificate</div>
            </div>

            <div class="photo">
                <img src="{{ public_path($certificate?->student?->image) }}" alt="Student Photo" />
            </div>

            <div class="watermark">
                <img src="{{ public_path('assets/images/certificate/pallabi.jpg') }}" alt="Watermark" />
            </div>

            <div class="content mt-4">
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
                    <span style="display: inline-block; width: 200px;">He/She Deserved Grade</span><br>
                    <span>: <strong>{{ $certificate?->grade }}</strong></span>
                </p>
                <p style="margin-bottom: 10px; display: flex;">
                    <span style="display: inline-block; width: 200px;">Recommendation</span>
                    <span>: <strong>{{ $certificate?->recommendation }}</strong></span>
                </p>
                <p style="margin-bottom: 10px; display: flex;">
                    <span style="display: inline-block; width: 200px;"><strong>Issue Date</strong></span>
                    <span>: {{ Carbon\Carbon::parse($certificate?->issue_date)?->format('d/m/Y') }}</span>
                </p>
            </div>

            <table style="width: 100%; margin-top: 120px;">
                <tr>
                    <td style="text-align: start;">
                        <img src="{{ public_path('assets/images/certificate/training.jpg') }}" style="height: 40px; margin-left: 5px" /><br>
                        Training Manager
                    </td>
                    <td style="text-align: right;">
                        <img src="{{ public_path('assets/images/certificate/director.png') }}" style="height: 40px; margin-right: 5px" /><br>
                        Director
                    </td>
                </tr>
            </table>

            <table class="grade-table">
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
        </div>
    </div>
</body>
</html>
