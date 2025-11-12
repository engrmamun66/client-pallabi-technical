<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;


class SliderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.setting.slider.index');
    }

    public function getAll()
   {

      $sliders = Slider::all();
      return Datatables::of($sliders)
        ->addColumn('image', function ($sliders) {
           return "<img src='" . asset('public/'.$sliders->image) . "' class='img-thumbnail' width='50px'>";
        })
        ->addColumn('action', function ($sliders)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $sliders->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $sliders->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . ' id="' . $sliders->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['action', 'image'])
        ->addIndexColumn()
        ->make(true);
   }

    public function create(Request $request)
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.setting.slider.create')->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    public function store(StoreSliderRequest $request)
    {


        if ($request->ajax()) {
            // Setup the validator
            $rules = [
              'title' => 'required',
              'image' => 'image|max:2024|mimes:jpeg,jpg,png|required'
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
                       $destinationPath = public_path('backend/media/setting/slider/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/setting/slider/' . $fileName;
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
                  $slider = Slider::create($data);
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

    public function edit(Request $request,Slider $slider)
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.setting.slider.edit', compact('slider'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        if ($request->ajax()) {

            // Setup the validator
            $rules = [
                'title' => 'required',
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
                // image  start
                  if ($request->hasFile('image')) {
                    if ($request->file('image') && $request->file('image')->isValid()) {
                        $oldImagePath = public_path($slider->image);

                        if (!empty($slider->image) && file_exists($oldImagePath)) {
                           @unlink($oldImagePath);
                        }

                        $destinationPath = public_path('backend/media/setting/slider/');
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileName = time() . '.' . $extension;
                        $file_path = 'backend/media/setting/slider/' . $fileName;

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
                  $slider->update($data);
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

    public function show(slider $slider)
    {
        abort_if(Gate::denies('slider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.setting.slider.show', compact('slider'));
    }

    public function destroy(Request $request,Slider $slider)
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            if($slider->image){
                unlink(public_path($slider->image));
               $slider->delete();
            }else{
                $slider->delete();
            }

            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }
}
