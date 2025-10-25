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
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class CertificateController extends Controller
{
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
           return "<img src='" . asset('public/'.$certificates->image) . "' class='img-thumbnail' width='50px'>";
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

   //  public function store(StoreCertificateRequest $request)
   //  {


   //      if ($request->ajax()) {
   //          // Setup the validator
   //          $rules = [
   //            'course_id' => 'required',
   //            'certificate_number' => 'required',
   //            'image' => 'image|max:2024|mimes:jpeg,jpg,png|required'
   //          ];

   //          $validator = Validator::make($request->all(), $rules);
   //          if ($validator->fails()) {
   //             return response()->json([
   //               'type' => 'error',
   //               'errors' => $validator->getMessageBag()->toArray()
   //             ]);
   //          } else {
   //              $data = $request->all();
   //              //  image start
   //              if ($request->hasFile('image')) {
   //                  if ($request->file('image')->isValid()) {
   //                     $destinationPath = public_path('backend/media/certificate/');
   //                     $extension = $request->file('image')->getClientOriginalExtension();
   //                     $fileName = time() . '.' . $extension;
   //                     $file_path = 'backend/media/certificate/' . $fileName;
   //                     $request->file('image')->move($destinationPath, $fileName);
   //                     $data['image'] = $file_path;
   //                  } else {
   //                     return response()->json([
   //                       'type' => 'error',
   //                       'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
   //                     ]);
   //                  }
   //               }
   //              //  image end
   //               // Handle the pdf file upload
   //                  if ($request->hasFile('pdf')) {
   //                      // Get the uploaded file
   //                      $file = $request->file('pdf');

   //                      // Define the file path
   //                      $filePath = $file->store('pdfs', 'public'); // Store in storage/app/public/pdfs

   //                      // Save file path in the database
   //                      $data['pdf_path'] = $filePath;
   //                  }

   //             DB::beginTransaction();
   //             try {
   //                $certificate = certificate::create($data);
   //                DB::commit();
   //                return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

   //             } catch (\Exception $e) {
   //                DB::rollback();
   //                return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
   //             }

   //          }
   //       } else {
   //          return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
   //       }

   //  }

   public function store(StoreCertificateRequest $request) {
      // return $request->all();
      $request->validated();
      $data = $request->all();
      Certificate::create($data);
      return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
   }

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

    public function update(UpdateCertificateRequest $request, Certificate $certificate){
        $request->validated();
        $data = $request->all();
        $certificate->update($data);
        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
    }

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
}
