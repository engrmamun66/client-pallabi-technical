<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Trade Course Certificate</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&family=Black+Ops+One&display=swap");

            body {
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
                font-size: 2.2rem;
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
                font-size: 1.8rem;
                padding: 8px 25px;
                border-radius: 50px;
                display: inline-block;
                margin-left: 100px !important;
                margin: 20px auto;
            }

            .details {
                font-style: italic;
                font-size: 1.1rem;
                margin-top: 20px;
            }

            .details strong {
                font-style: normal;
            }

            .signatures {
                margin-top: 60px;
            }

            .signature {
                text-align: center;
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
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0.08;
                z-index: 0;
            }

            .bg-logo img {
                max-width: 60%;
            }
        </style>
    </head>
    <body>
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
                <img src="student.jpg" alt="student photo" />
            </div>

            <!-- Background logo watermark -->
            <div class="bg-logo">
                <img src="watermark.png" alt="logo watermark" />
            </div>

            <!-- Certificate Body -->
            <div class="details mt-4">
                <p><strong>CR No</strong> : 002024001</p>
                <p>Certified that : <strong>MD SWAPAN MIAH</strong></p>
                <p>Son/Daughter of : <strong>TOAHID MIAH</strong></p>
                <p>He/She successfully completed the trade course on</p>
                <p><strong>Welding Arc (SMAW) 6G Position</strong></p>
                <p>Duration of Course : <strong>24</strong></p>
                <p>With Contact Hour : <strong>192</strong></p>
                <p><strong>Issue Date :</strong> 31/07/2024</p>
            </div>

            <!-- Signatures -->
            <div class="row signatures">
                <div class="col-6 signature">
                    <img src="{{ asset('assets/images/training.jpg') }}" alt="signature" />
                    <div>Training Manager</div>
                </div>
                <div class="col-6 signature">
                    <img src="{{ asset('assets/images/director.jpg') }}" alt="signature" />
                    <div>Director</div>
                </div>
            </div>

            <div class="footer">
                This Certificate is awarded to him this day
            </div>

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
        </div>
    </body>
</html>
