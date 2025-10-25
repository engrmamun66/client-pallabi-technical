<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.event-management.index');
    }

    public function getAll()
    {

       $notices = Notice::where('status','events')->get();
       return Datatables::of($notices)
         ->addColumn('image', function ($notices) {
             return "<img src='" . asset('public/'.$notices->image) . "' class='img-thumbnail' width='50px'>";
         })
         ->addColumn('action', function ($notice)  {
             if(auth()->user()->hasRole('admin')){
                 $html = '<div class="btn-group">';
                 $html .= '<a data-toggle="tooltip" '  . '  id="' . $notice->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
                 $html .= '<a data-toggle="tooltip" '  . ' id="' . $notice->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
                 $html .= '</div>';
                 return $html;
             }
             return "No Permission";

         })
         ->rawColumns(['action','image'])
         ->addIndexColumn()
         ->make(true);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.event-management.create')->render();
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
              'title' => 'required',
              'description' => 'required',
              'image' => 'image|max:2024|mimes:jpeg,jpg,png|required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               DB::beginTransaction();
               try {
                  $data = $request->all();
                  $data['status'] = 'events';
                   //  image start
                    if ($request->hasFile('image')) {
                        if ($request->file('image')->isValid()) {
                        $destinationPath = public_path('backend/media/notice/');
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileName = time() . '.' . $extension;
                        $file_path = 'backend/media/notice/' . $fileName;
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
                    $notice = Notice::create($data);
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

    public function edit(Request $request,Notice $notice)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

               $view = View::make('backend.event-management.edit', compact('notice'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function update(Request $request, Notice $notice)
    {

        if ($request->ajax()) {

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
               DB::beginTransaction();
               try {
                $data = $request->all();
                // image  start
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                        unlink(public_path($notice->image));
                       $destinationPath = public_path('backend/media/notice/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/notice/' . $fileName;
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
                  $notice->update($data);
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

    public function show(Notice $notice)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.event-management.show', compact('notice'));
    }

    public function destroy(Request $request,Notice $notice)
    {
        abort_if(Gate::denies('notice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            if($notice->image){
                unlink(public_path($notice->image));
               $notice->delete();
            }else{

                $notice->delete();
            }
            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }
}
