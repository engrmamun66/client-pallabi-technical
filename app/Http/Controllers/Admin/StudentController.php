<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchStudent;
use App\Models\Certificate;
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
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.user-management.students.index');
    }

    public function getAll()
   {

      $students = Student::all();
      return Datatables::of($students)
        ->addColumn('status', function ($students) {
           return $students->user?->status ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>';
        })
        ->addColumn('email', function ($student) {
            return '<label class="badge badge-secondary">' . $student->user?->email ??'' . '</label>';
        })
        ->addColumn('image', function ($students) {
            return "<img src='" . asset('public/'.$students->image) . "' class='img-thumbnail' width='50px'>";
         })
        ->addColumn('action', function ($student)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $student->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . ' id="' . $student->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['action','status','email', 'image'])
        ->addIndexColumn()
        ->make(true);
   }

    public function create(Request $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.user-management.students.create')->render();
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
              'name' => 'required',
              'email' => 'required|email|unique:users,email',
              'password' => 'required|same:confirm-password',
              'fathers_name' => 'required|string|max:255',
              'address' => 'required|string|max:255',
              'mobile' => 'required|digits:11|unique:students',
              'image' => 'required|image|max:2024|mimes:jpeg,jpg,png'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {
               if ($request->hasFile('image')) {
                  if ($request->file('image')->isValid()) {
                     $destinationPath = public_path('backend/media/students/');
                     $extension = $request->file('image')->getClientOriginalExtension();
                     $fileName = time() . '.' . $extension;
                     $file_path = 'backend/media/students/' . $fileName;
                     $request->file('image')->move($destinationPath, $fileName);
                     $image_path = $file_path;
                  } else {
                     return response()->json([
                       'type' => 'error',
                       'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                     ]);
                  }
               }

               DB::beginTransaction();
               try {
                  $data = $request->all();
                 // Create the user
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'file_path' => isset($image_path) ? $image_path : '',
                        'password' => Hash::make($request->password),
                    ]);

                  // generate role
                  $roles = Role::where('title','Student')->latest()->first();
                  if (isset($roles->id)) {
                     $user->roles()->sync($roles->id);
                  }
                   // Create student-specific data
                    $student = Student::create([
                        'user_id' => $user->id,
                        'name' => $request->name,
                        'fathers_name' => $request->fathers_name,
                        'address' => $request->address,
                        'mobile' => $request->mobile,
                        'image' => isset($image_path) ? $image_path : '',
                    ]);

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

    public function edit(Request $request, Student $student)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.user-management.students.edit', compact('student'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function update(Request $request, Student $student)
    {
      if ($request->ajax()) {
         // Setup the validator
         $rules = [
           'name' => 'required',
           'fathers_name' => 'required|string|max:255',
           'address' => 'required|string|max:255',
           'mobile' => ['required','digits:11', Rule::unique('students')->ignore($student->id),],
           'image' => 'nullable|image|max:2024|mimes:jpeg,jpg,png'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            if ($request->hasFile('image')) {
               if ($request->file('image')->isValid()) {
                  if($student->image) {
                     $fullPath = public_path($student->image);
                     if (file_exists($fullPath)) {
                        unlink($fullPath);
                     }
                  }
                  $destinationPath = public_path('backend/media/students/');
                  $extension = $request->file('image')->getClientOriginalExtension();
                  $fileName = time() . '.' . $extension;
                  $file_path = 'backend/media/students/' . $fileName;
                  $request->file('image')->move($destinationPath, $fileName);
                  $image_path = $file_path;
               } else {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                  ]);
               }
            }

            DB::beginTransaction();
            try {
                // Create student-specific data
                 $student->update([
                     'name' => $request->name,
                     'fathers_name' => $request->fathers_name,
                     'address' => $request->address,
                     'mobile' => $request->mobile,
                     'image' => isset($image_path) ? $image_path : $student->image,
                 ]);

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

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('backend.user-management.users.show', compact('user'));
    }

    public function destroy(Request $request,Student $student)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
           $user = $student->user;
           $student->delete();
           if($user){
                $user->delete();
           }
            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }

   public function getAllStudents(Request $request) {
      $students = Student::query();
      $students = $students->where([["name", "like", "%$request->name%"]])
            ->take(50)
            ->get();

      return [
            "students" => $students
      ];
   }

   public function getBatchStudents(Request $request) {
      $batch_student_ids = BatchStudent::where('batch_id', $request->batch_id)->pluck('student_id')->toArray();
      $exist_student_certificate_ids = Certificate::where('batch_id', $request->batch_id)->pluck('student_id')->toArray();
      $student_ids = array_values(array_diff($batch_student_ids, $exist_student_certificate_ids));
      $students = Student::query();
      $students = $students->whereIn("id", $student_ids)->get();

      return [
            "students" => $students
      ];
   }
}
