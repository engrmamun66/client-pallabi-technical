<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class PartnerLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.setting.partner-logo.index');
    }

    public function getAll()
    {
        $partnerlogos = PartnerLogo::all();
      return Datatables::of($partnerlogos)
        ->addColumn('image', function ($partnerlogos) {
           return "<img src='" . asset('public/'.$partnerlogos->image) . "' class='img-thumbnail' width='50px'>";
        })
        ->addColumn('action', function ($partnerlogos)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $partnerlogos->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $partnerlogos->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . ' id="' . $partnerlogos->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['description','mission','vision','action', 'image'])
        ->addIndexColumn()
        ->make(true);

    }
    public function create(Request $request)
    {
        if ($request->ajax()) {
               $view = View::make('backend.setting.partner-logo.create')->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            // Setup the validator
            $rules = [
              'link' => 'required',
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
                       $destinationPath = public_path('backend/media/setting/partner/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/setting/partner/' . $fileName;
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
                  $partnerLogo = PartnerLogo::create($data);
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
    public function edit(Request $request,PartnerLogo $partnerLogo)
    {
        if ($request->ajax()) {
               $view = View::make('backend.setting.partner-logo.edit', compact('partnerLogo'))->render();
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
    public function update(Request $request, PartnerLogo $partnerLogo)
    {
        if ($request->ajax()) {

            $rules = [
              'link' => 'required',
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
                    if ($request->file('image')->isValid()) {
                        unlink(public_path($partnerLogo->image));
                       $destinationPath = public_path('backend/media/setting/partner/');
                       $extension = $request->file('image')->getClientOriginalExtension();
                       $fileName = time() . '.' . $extension;
                       $file_path = 'backend/media/setting/partner/' . $fileName;
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
                  $partnerLogo->update($data);
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
    public function destroy(Request $request,PartnerLogo $partnerLogo)
    {
        if ($request->ajax()) {
            if($partnerLogo->image){
                unlink(public_path($partnerLogo->image));
               $partnerLogo->delete();
            }else{

                $partnerLogo->delete();
            }

            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }
}
