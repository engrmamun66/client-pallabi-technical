<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.setting.admission-section.index');
    }
    public function getAdmissionSection()
    {
        $admissionSections = Admission::all();
      return Datatables::of($admissionSections)
        ->addColumn('image', function ($admissionSections) {
           return "<img src='" . asset('public/'.$admissionSections->image) . "' class='img-thumbnail' width='50px'>";
        })
        ->addColumn('description', function ($admissionSections) {
            // Render HTML content from the description column
            return $admissionSections->description;
        })
        ->addColumn('action', function ($admissionSections)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $admissionSections->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
        //    $html .= '<a data-toggle="tooltip" '  . '  id="' . $admissionSections->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['description','mission','vision','action', 'image'])
        ->addIndexColumn()
        ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

        if ($request->ajax()) {
             $admission = Admission::find($id);
               $view = View::make('backend.setting.admission-section.edit', compact('admission'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            // Setup the validator
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'image' => 'image|max:2024|mimes:jpeg,jpg,png'
              ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

                $data = $request->all();
                $admission = Admission::find($id);
                // image  start
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                        // Check if file exists before deleting
                        if ($admission->image && file_exists(public_path($admission->image))) {
                            unlink(public_path($admission->image));
                        }
                       $destinationPath = public_path('backend/media/setting/admission_section/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/setting/admission_section/' . $fileName;
                       $request->file('image')->move($destinationPath, $fileName);
                       $data['image'] = $file_path;
                    } else {
                       return response()->json([
                         'type' => 'error',
                         'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                       ]);
                    }
                 }
                // image end

               DB::beginTransaction();
               try {
                  $admission->update($data);
                  DB::commit();
                  return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

               } catch (\Exception $e) {
                  DB::rollback();
                  return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
               }

            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
