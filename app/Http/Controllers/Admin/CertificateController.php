<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use App\Traits\FileUpload;
class CertificateController extends Controller
{
    use FileUpload;
    public function index()
    {
        abort_if(Gate::denies('certificate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.certificate.index');
    }

    public function getAll()
   {

      $certificates = Certificate::all();
      return Datatables::of($certificates)
       ->addColumn('image', function ($certificates) {
        // Check if image exists
        if ($certificates->image && file_exists(public_path($certificates->image))) {
            return "<img src='" . asset('public/'.$certificates->image) . "' class='img-thumbnail' width='50px' height='50px' style='object-fit: cover;'>";
        } 
        // If no image but PDF exists, show PDF in iframe
        elseif ($certificates->pdf_path && Storage::disk('public')->exists($certificates->pdf_path)) {
            $pdfUrl = asset('storage/' . $certificates->pdf_path);
                return "
                    <iframe 
                        src='http://pallabitechnical.test/storage/app/public/pdfs/68fee7eeec31b.pdf#toolbar=0&navpanes=0&scrollbar=0&zoom=page-fit&view=Fit'
                        width='60' 
                        height='82' 
                        style='border: 1px solid #ddd; border-radius: 4px; transform: scale(0.8); transform-origin: 0 0;'
                        title='PDF Preview'
                    >
                    </iframe>
                ";
        }
        // If neither image nor PDF exists
        else {
                return "<div class='no-preview bg-light d-flex align-items-center justify-content-center' style='width: 50px; height: 50px; border: 1px solid #ddd; border-radius: 4px;'>
                        <i class='fa fa-file text-muted'></i>
                    </div>";
            }
        })
        ->addColumn('course', function ($certificates) {
            return '<label class="badge badge-secondary">' . $certificates->course->title??'' . '</label>';
         })
        ->addColumn('action', function ($certificates)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $certificates->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
           if(!$certificates->is_download){
            $html .= '<a data-toggle="tooltip" '  . '  id="' . $certificates->id . '" class="btn btn-xs btn-info mr-1" href="' . route('admin.certificates.edit', $certificates->id) . '" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
            $html .= '<a data-toggle="tooltip" '  . ' id="' . $certificates->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           }
           $html .= '</div>';
           return $html;
        })
        ->addColumn('pdf', function ($certificate) {
            if ($certificate->pdf_path) {
                return '<a href="' . asset('storage/app/public/' . $certificate->pdf_path) . '" target="_blank" class="btn btn-sm btn-info">View PDF</a>';
            } else {
                return '<span class="badge badge-danger">No PDF</span>';
            }
        })
        ->rawColumns(['action', 'image','course','pdf'])
        ->addIndexColumn()
        ->make(true);
   }

   //  public function create(Request $request)
   //  {
   //      abort_if(Gate::denies('certificate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

   //      if ($request->ajax()) {
   //             $courses = Course::all();
   //             $view = View::make('backend.certificate.create',compact('courses'))->render();
   //             return response()->json(['html' => $view]);

   //       } else {
   //          return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
   //       }
   //  }

    public function create(Request $request)
    {
        abort_if(Gate::denies('certificate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $batches = Batch::all();

        return view('backend.certificate.create', compact('batches'));
    }

// public function store(StoreCertificateRequest $request)
// {
//     try {
//         // ✅ Don’t call $request->all() yet
//         $data = $request->except(['image', 'pdf']);

//         // === IMAGE UPLOAD ===
//         if ($request->hasFile('image') && $request->file('image')->isValid()) {
//             $destinationPath = public_path('backend/media/certificate/');
//             if (!file_exists($destinationPath)) {
//                 mkdir($destinationPath, 0755, true);
//             }

//             $extension = $request->file('image')->getClientOriginalExtension();
//             $fileName = time() . '.' . $extension;
//             $request->file('image')->move($destinationPath, $fileName);
//             $data['image'] = 'backend/media/certificate/' . $fileName;
//         }

//         // === PDF UPLOAD ===
//         if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
//             $pdf = $request->file('pdf');
//             \Log::info('PDF upload debug', [
//                 'realPath' => $pdf->getRealPath(),
//                 'isValid' => $pdf->isValid(),
//                 'path' => $pdf->path(),
//                 'exists' => file_exists($pdf->getRealPath() ?? ''),
//             ]);
//             $data['pdf_path'] = $this->uploadFile($pdf, 'pdfs');
//         }

//         DB::beginTransaction();
//         Certificate::create($data);
//         DB::commit();

//         return response()->json([
//             'type' => 'success',
//             'message' => 'Certificate created successfully'
//         ]);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'type' => 'error',
//             'message' => 'Error creating certificate: ' . $e->getMessage(),
//         ]);
//     }
// }

//    public function store(StoreCertificateRequest $request) {
//       // return $request->all();
//       $request->validated();
//       $data = $request->all();
//       Certificate::create($data);
//       return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
//    }

    // public function edit(Request $request,Certificate $certificate)
    // {
    //     abort_if(Gate::denies('certificate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     if ($request->ajax()) {
    //            $certificate->load('course');
    //            $courses = Course::get();
    //            $view = View::make('backend.certificate.edit', compact('certificate','courses'))->render();
    //            return response()->json(['html' => $view]);

    //      } else {
    //         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    //      }

    // }
    public function edit(Request $request,string $id)
    {
        $batches = Batch::all();
        $certificate = Certificate::with(['course', 'student', 'batch'])->findOrFail($id);

        return view('backend.certificate.edit', compact('batches', 'certificate'));
    }

    // public function update(UpdateCertificateRequest $request, Certificate $certificate)
    // {
    //     if ($request->ajax()) {

    //         // Setup the validator
    //         $rules = [
    //             'course_id' => 'required',
    //             'certificate_number' => 'required',
    //             'image' => 'image|max:2024|mimes:jpeg,jpg,png'
    //           ];

    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //            return response()->json([
    //              'type' => 'error',
    //              'errors' => $validator->getMessageBag()->toArray()
    //            ]);
    //         } else {

    //             $data = $request->all();
    //             // image  start
    //             if ($request->hasFile('image')) {
    //                 if ($request->file('image')->isValid()) {
    //                     unlink(public_path($certificate->image));
    //                    $destinationPath = public_path('backend/media/certificate/');
    //                    $extension = $request->file('image')->getClientOriginalExtension();
    //                    $fileName = time() . '.' . $extension;
    //                    $file_path = 'backend/media/certificate/' . $fileName;
    //                    $request->file('image')->move($destinationPath, $fileName);
    //                    $data['image'] = $file_path;
    //                 } else {
    //                    return response()->json([
    //                      'type' => 'error',
    //                      'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
    //                    ]);
    //                 }
    //              }
    //             // image end
    //               // Handle file upload if a new file is uploaded
    //                 if ($request->hasFile('pdf')) {
    //                     // Delete old file if exists
    //                     if ($certificate->pdf_path) {
    //                         Storage::disk('public')->delete($certificate->pdf_path);
    //                     }

    //                     // Store the new file
    //                     $file = $request->file('pdf');
    //                     $filePath = $file->store('pdfs', 'public');
    //                     $data['pdf_path'] = $filePath;
    //                 }

    //            DB::beginTransaction();
    //            try {
    //               $certificate->update($data);
    //               DB::commit();
    //               return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

    //            } catch (\Exception $e) {
    //               DB::rollback();
    //               return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
    //            }

    //         }
    //      } else {
    //         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    //      }
    // }

    // public function update(UpdateCertificateRequest $request, Certificate $certificate){
    //     $request->validated();
    //     $data = $request->all();
    //     $certificate->update($data);
    //     return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
    // }

    public function show(Certificate $certificate)
    {
        abort_if(Gate::denies('certificate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.certificate.show', compact('certificate'));
    }

    public function destroy(Request $request,Certificate $certificate)
    {
        abort_if(Gate::denies('certificate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            if($certificate->image){
                if ($certificate->pdf_path) {
                    Storage::disk('public')->delete($certificate->pdf_path);
                }
                unlink(public_path($certificate->image));
               $certificate->delete();
            }else{

                $certificate->delete();
            }

            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }


    public function store(StoreCertificateRequest $request)
    {
        try {
            // Don't call $request->all() yet
            $data = $request->except(['image', 'pdf']);

            $uploadPath = public_path('backend/media/certificate/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Handle different formats
            if ($request->certificate_format === 'old') {
                // === OLD FORMAT: Manual Upload ===
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $destinationPath = public_path('backend/media/certificate/');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time() . '.' . $extension;
                    $request->file('image')->move($destinationPath, $fileName);
                    $data['image'] = 'backend/media/certificate/' . $fileName;
                }

                // === PDF UPLOAD ===
                if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
                    $pdf = $request->file('pdf');
                    \Log::info('PDF upload debug', [
                        'realPath' => $pdf->getRealPath(),
                        'isValid' => $pdf->isValid(),
                        'path' => $pdf->path(),
                        'exists' => file_exists($pdf->getRealPath() ?? ''),
                    ]);
                    $data['pdf_path'] = $this->uploadFile($pdf, 'pdfs');
                }


            } else {
                // === NEW FORMAT: Auto-Generated Files ===
                
                // First create the certificate record to get an ID
                DB::beginTransaction();
                $certificate = Certificate::create($data);
                
                // Auto-generate PDF using your existing template
                $pdfPath = $this->generateCertificatePDF($certificate);
                $data['pdf_path'] = $pdfPath;
                $imagePath = null;
                $data['image'] = $imagePath;

                // Update the certificate with generated file paths
                $certificate->update([
                    'pdf_path' => $pdfPath,
                    'image' => $imagePath
                ]);
                
                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Certificate created successfully with auto-generated files'
                ]);
            }

            // For old format, create certificate after file handling
            DB::beginTransaction();
            Certificate::create($data);
            DB::commit();

            return response()->json([
                'type' => 'success',
                'message' => 'Certificate created successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Certificate creation failed: ' . $e->getMessage());
            
            return response()->json([
                'type' => 'error',
                'message' => 'Error creating certificate: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateCertificateRequest $request, Certificate $certificate)
    {
        try {
            // Don't call $request->all() yet - use except like in store function
          

            $data = $request->except(['image', 'pdf']);
            // Get current version history - handle both array and JSON string
            $currentVersionHistory = $certificate->version_history;
            
            // If version_history is a string, decode it to array, otherwise use empty array
            if (is_string($currentVersionHistory)) {
                $versionHistory = json_decode($currentVersionHistory, true) ?? [];
            } else {
                $versionHistory = is_array($currentVersionHistory) ? $currentVersionHistory : [];
            }
            
            $currentData = $certificate->toArray();
            $versionData = [
                'data' => $currentData,
                'timestamp' => now()->toISOString(),
                'version' => count($versionHistory) + 1,
                'updated_by' => auth()->id()
            ];

            // Add new version to history
            $versionHistory[] = $versionData;
            
            // Store all previous versions as JSON
            $data['version_history'] = json_encode($versionHistory);

            $uploadPath = public_path('backend/media/certificate/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }


            // Handle different formats like in store function
            if ($request->certificate_format === 'old') {
               
                // Handle image upload
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    // Delete old image if exists
                    if ($certificate->image && file_exists(public_path($certificate->image))) {
                        unlink(public_path($certificate->image));
                    }

                    $destinationPath = public_path('backend/media/certificate/');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time() . '.' . $extension;
                    $request->file('image')->move($destinationPath, $fileName);
                    $data['image'] = 'backend/media/certificate/' . $fileName;
                }

                // === PDF UPLOAD ===
                if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
                    // Delete old PDF if exists
                    if ($certificate->pdf_path) {
                        Storage::disk('public')->delete($certificate->pdf_path);
                    }

                    $pdf = $request->file('pdf');
                    \Log::info('PDF upload debug - Update', [
                        'realPath' => $pdf->getRealPath(),
                        'isValid' => $pdf->isValid(),
                        'path' => $pdf->path(),
                        'exists' => file_exists($pdf->getRealPath() ?? ''),
                    ]);
                    $data['pdf_path'] = $this->uploadFile($pdf, 'pdfs');
                }

                // For old format, update certificate after file handling
                DB::beginTransaction();
                $certificate->update($data);
                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Certificate updated successfully'
                ]);

            } else {
                // === NEW FORMAT: Auto-Generated Files ===
                
                DB::beginTransaction();

                // First update the certificate with the new data
                $certificate->update($data);
                
                // Refresh the certificate instance to get the updated data
                $certificate->refresh();

                // Delete old files if they exist
                if ($certificate->pdf_path) {
                    Storage::disk('public')->delete($certificate->pdf_path);
                }
                if ($certificate->image && file_exists(public_path($certificate->image))) {
                    unlink(public_path($certificate->image));
                }

                // Auto-generate PDF using UPDATED certificate data
                $pdfPath = $this->generateCertificatePDF($certificate);
                
                $imagePath = null;

                // Update the certificate with generated file paths
                $certificate->update([
                    'pdf_path' => $pdfPath,
                    'image' => $imagePath
                ]);
                
                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Certificate updated successfully with auto-generated files'
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Certificate update failed: ' . $e->getMessage());
            
            return response()->json([
                'type' => 'error',
                'message' => 'Error updating certificate: ' . $e->getMessage(),
            ]);
        }
    }
    /**
     * Generate certificate PDF using your existing template
     */
    private function generateCertificatePDF($certificate)
    {
        try {
            $folder = 'pdfs';
            $path = storage_path("app/public/{$folder}/");
            // Create directory if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $fileName = uniqid().'.pdf';
            $fullPath = $path . $fileName;

            // Load your existing Blade template with the certificate data
            if($certificate->type == ''){
                $pdf = Pdf::loadView('regular-certificate', [
                    'certificate' => $certificate
                ]);

            }else{
                $pdf = Pdf::loadView('regular-certificate', [
                    'certificate' => $certificate
                ]);
            }
          

            // Set paper options
            $pdf->setPaper('A4', 'portrait');
            
            // Save the PDF to file
            $pdf->save($fullPath);

            return "{$folder}/{$fileName}";;

        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
            throw new \Exception('Failed to generate PDF: ' . $e->getMessage());
        }
    }

}
