<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function getCertificateView()
    {
        $certificate = null;

        if(request()->has('certificate_number')) {
             $certificate = Certificate::with(['course', 'student', 'batch'])->where('certificate_number', request()->input('certificate_number'))->first();
        }
        return view('frontend.pages.certificate', compact('certificate'));
    }

    public function search(Request $request)
    {
        return $request->all();
        $certificateNumber = $request->input('certificate_number');
        $certificateType = $request->input('type');
        $certificate = Certificate::where('certificate_number', $certificateNumber)->where('type',$certificateType)->first();

        if ($certificate) {
            // Assuming certificate image path is stored in a column 'image_path'
            $imagePath = asset('public').'/'.$certificate->image;

            return response()->json([
                'image_path' => $imagePath,
                'pdf_path' => asset('storage/app/public/' . $certificate->pdf_path),
            ]);
        }

        return response()->json(['error' => 'Certificate not found.'], 404);
    }

    public function downloadRegularCertificate(string $id) {
        $certificate = Certificate::with(['course', 'student', 'batch'])->find($id);
        $certificate->update(['is_download' => true]);
        $data = [
            'certificate' => $certificate
        ];
        $pdf = Pdf::loadView('regular-certificate', $data)->setPaper([0, 0, 750, 850], 'landscape');
        return $pdf->download('certificate.pdf');
    }

    public function downloadTestCertificate(string $id) {
        $certificate = Certificate::with(['course', 'student', 'batch'])->find($id);
        $certificate->update(['is_download' => true]);
        $data = [
            'certificate' => $certificate
        ];
        $pdf = Pdf::loadView('test-certificate', $data)->setPaper([0, 0, 600, 750], 'portrait');
        return $pdf->download('certificate.pdf');
    }
}
