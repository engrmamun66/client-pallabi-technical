<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('batch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.batch.index');
    }

    public function getAll()
    {
 
       $batches = Batch::with('course')->get();
       return Datatables::of($batches)
         ->addColumn('course', function ($batches) {
             return '<label class="badge badge-secondary">' . $batches->course->course_name??'' . '</label>';
          })
         ->addColumn('action', function ($batches)  {
            $html = '<div class="btn-group">';
            $html .= '<a data-toggle="tooltip" '  . '  id="' . $batches->id . '" href="' . route('admin.batch.edit', $batches->id) . '" class="btn btn-xs btn-info mr-1" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
            $html .= '<a data-toggle="tooltip" '  . '  id="' . $batches->id . '" class="btn btn-xs btn-primary mr-1 view" title="View" style="color:white"><i class="fa fa-eye"></i> </a>';
            $html .= '<a data-toggle="tooltip" '  . ' id="' . $batches->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
            $html .= '</div>';
            return $html;
         })
         
         ->rawColumns(['action', 'course'])
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
        $courses = Course::all();

        return view('backend.batch.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator  = Validator::make(
            $request->all(),
            [
                'batch_name' => "required|min:2|max:255",
                'course_id' => "required|integer",
                'student_ids' => "required|array|min:1",
            ],
            [
                'name.required'     => 'Batch name is required',
                'course_id.required'     => 'Course is required',
                'students.required'     => 'At least one student is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['type' => 'error', 'errors' =>$validator->errors()]);
        }

        DB::beginTransaction();

        try {
            $maxId = Batch::max('id');
            $code = str_pad($maxId ? ($maxId + 1) : 1, 4, 0, STR_PAD_LEFT);
            $batch = Batch::create([
                'batch_name' => $request->batch_name,
                'course_id' => $request->course_id,
                'batch_code' => $code,
            ]);
            $batch->students()->sync($request->student_ids);
            DB::commit();
            return response()->json(['type' => 'success', 'message' => 'Batch created successfully']);
        } catch (\Exception $e) {
            DB::rollback(); 
            info($e->getMessage());
            return response()->json(['type' => 'error', 'errors' => $e->getMessage()]);
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
    public function edit($id)
    {
        $batch = Batch::with(['course', 'students'])->find($id);
        $courses = Course::all();

        return view('backend.batch.edit', compact('courses', 'batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $validator  = Validator::make(
            $request->all(),
            [
                'batch_name' => "required|min:2|max:255",
                'course_id' => "required|integer",
                'student_ids' => "required|array|min:1",
            ],
            [
                'name.required'     => 'Batch name is required',
                'course_id.required'     => 'Course is required',
                'students.required'     => 'At least one student is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['type' => 'error', 'errors' =>$validator->errors()]);
        }

        DB::beginTransaction();

        try {
            $batch->update([
                'batch_name' => $request->batch_name,
                'course_id' => $request->course_id,
            ]);
            $batch->students()->sync($request->student_ids);
            DB::commit();
            return response()->json(['type' => 'success', 'message' => 'Batch updated successfully']);
        } catch (\Exception $e) {
            DB::rollback(); 
            info($e->getMessage());
            return response()->json(['type' => 'error', 'errors' => $e->getMessage()]);
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
