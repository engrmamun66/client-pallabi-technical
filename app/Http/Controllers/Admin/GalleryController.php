<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.gallery.index');
    }

    public function getAll()
   {

      $galleries = Gallery::all();
      return Datatables::of($galleries)
        ->addColumn('image', function ($galleries) {
           return "<img src='" . asset('public/'.$galleries->image) . "' class='img-thumbnail' width='50px'>";
        })
        ->addColumn('action', function ($galleries)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $galleries->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $galleries->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . ' id="' . $galleries->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['action', 'image'])
        ->addIndexColumn()
        ->make(true);
   }

    public function create(Request $request)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.gallery.create')->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    public function store(Request $request)
    {


        if ($request->ajax()) {
            // Setup the validator
            $rules = [
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
                //  image start
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                       $destinationPath = public_path('backend/media/gallery/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/gallery/' . $fileName;
                       $request->file('image')->move($destinationPath, $fileName);
                       $data['image'] = $file_path;
                    } else {
                       return response()->json([
                         'type' => 'error',
                         'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                       ]);
                    }
                 }
                //  image end

               DB::beginTransaction();
               try {
                  $gallery = Gallery::create($data);
                  DB::commit();
                  return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

               } catch (\Exception $e) {
                  DB::rollback();
                  return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
               }

            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function edit(Request $request,Gallery $gallery)
    {

        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.gallery.edit', compact('gallery'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function update(UpdateCourseRequest $request, Gallery  $gallery)
    {
        if ($request->ajax()) {

            $rules = [
              'title' => 'required',
              'photo' => 'image|max:2024|mimes:jpeg,jpg,png'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

                $data = $request->all();
                // image  start
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                        unlink(public_path($gallery->image));
                       $destinationPath = public_path('backend/media/gallery/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/gallery/' . $fileName;
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
                  $gallery->update($data);
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

    public function show(Gallery $gallery)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.gallery.show', compact('gallery'));
    }

    public function destroy(Request $request,Gallery $gallery)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            if($gallery->image){
                unlink(public_path($gallery->image));
               $gallery->delete();
            }else{

                $gallery->delete();
            }

            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }
}
