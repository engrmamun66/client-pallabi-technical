<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('backend.user-management.teachers.index');
    }

    public function getAll()
   {

      $teachers = Teacher::all();
      return Datatables::of($teachers)
        ->addColumn('status', function ($teachers) {
           return $teachers->user->status ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>';
        })
        ->addColumn('email', function ($teacher) {
            return '<label class="badge badge-secondary">' . $teacher->user->email ??'' . '</label>';
        })
        ->addColumn('action', function ($teacher)  {
           $html = '<div class="btn-group">';
           $html .= '<a data-toggle="tooltip" '  . '  id="' . $teacher->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit" style="color:white"><i class="fa fa-edit"></i> </a>';
           $html .= '<a data-toggle="tooltip" '  . ' id="' . $teacher->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete" style="color:white"><i class="fa fa-trash"></i> </a>';
           $html .= '</div>';
           return $html;
        })
        ->rawColumns(['action','status','email'])
        ->addIndexColumn()
        ->make(true);
   }

    public function create(Request $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
               $view = View::make('backend.user-management.teachers.create')->render();
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
              'address' => 'nullable|string|max:255',
              'mobile' => 'required|digits:11|unique:students',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               info($validator->getMessageBag()->toArray());
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               DB::beginTransaction();
               try {
                  $data = $request->all();
                 // Create the user
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);

                  // generate role
                  $roles = Role::where('title','Teacher')->latest()->first();
                  if (isset($roles->id)) {
                     $user->roles()->sync($roles->id);
                  }
                   // Create student-specific data
                    $teacher = Teacher::create([
                        'user_id' => $user->id,
                        'name' => $request->name,
                        'address' => $request->address ?? null,
                        'mobile' => $request->mobile
                    ]);

                  DB::commit();
                  return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

               } catch (\Exception $e) {
                  info($e);
                  DB::rollback();
                  return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
               }

            }
         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function edit(Request $request,User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
              $user->load('roles');
               $roles = Role::all(); //Get all roles
               $view = View::make('backend.user-management.students.edit', compact('user', 'roles'))->render();
               return response()->json(['html' => $view]);

         } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
         }

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->ajax()) {

            $rules = [
              'name' => 'required',
              'email' => 'required|email|unique:users,email,' . $user->id,
              'photo' => 'image|max:2024|mimes:jpeg,jpg,png'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               $file_path = $request->input('SelectedFileName');;

               if ($request->hasFile('photo')) {
                  if ($request->file('photo')->isValid()) {
                     $destinationPath = public_path('assets/images/users/');
                     $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                     $fileName = time() . '.' . $extension;
                     $file_path = 'assets/images/users/' . $fileName;
                     $request->file('photo')->move($destinationPath, $fileName);
                  } else {
                     return response()->json([
                       'type' => 'error',
                       'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                     ]);
                  }
               }

               DB::beginTransaction();
               try {
                  $user->update($request->all());

                  $roles = $request->input('roles');
                  if (isset($roles)) {
                     $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
                  } else {
                     $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
                  }

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

    public function destroy(Request $request,Teacher $teacher)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
           $user = $teacher->user;
           $teacher->delete();
           if($user){
                $user->delete();
           }
            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
    }
}
