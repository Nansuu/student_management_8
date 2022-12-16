<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $data = Student::select('*');
        if ($data) {
            if ($request->ajax()) {
                return DataTables::of($data)
                    ->make(true);
            }
            return view('student.all');
        }else{
            return view('student.all')->with('info', 'データがありません。');
        }
    }
    public function deleteindex(Request $request)
    {
        $data = Student::select('*');
        if ($request->ajax()) {
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('edit', function ($row) {
                //return ' <button type="submit" data-target="#deletemodal" data-toggle="modal" data-id="' .$row->id .'" class="btn btn-outline-danger delete border-0"><i class="fa fa-trash fa-lg text-center" style="display:block" aria-hidden="true"></i></button>';
                return '
                <a class="btn btn-outline-info" href="{{ url("/articles/edit/$article->id") }}">
                    <i class="fa fa-edit"></i>
                </a>';
            })
                ->addColumn('action', function ($row) {
                    //return ' <button type="submit" data-target="#deletemodal" data-toggle="modal" data-id="' .$row->id .'" class="btn btn-outline-danger delete border-0"><i class="fa fa-trash fa-lg text-center" style="display:block" aria-hidden="true"></i></button>';
                    return '
                    <a href="" class="del_ btn btn-outline-danger" data-target="#deletemodal" data-toggle="modal"  data-id="' .$row->id .'" ><i class="fa fa-trash fa-lg text-center" style="display:block" aria-hidden="true"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }



        return view('student.delete');




    }
    public function delete()
    {
        $student = Student::find(request()->stu_id);
        $student->delete();
        return redirect('/students/all')->with('info', '正常に削除されました。');
    }

    public function create()
    {

        return view('student.add');
    }
    public function edit()
    {
        $data = Student::all();
        return view('student.add', [
            'students' => $data
        ]);
    }
    public function store()
    {
        $validator = validator(request()->all(), [
            'roll_no' => 'required|unique:students|starts_with:mkpt-,MKPT-',
            'student_name' => 'required|not_regex:/[!@#$%^&*()_+\-=\[\]{};,<>\/?]+/',
            'age' => 'required|integer|between:15,45',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $student = new Student;
        $student->roll_no = request()->roll_no;
        $student->student_name = request()->student_name;
        $student->age = request()->age;
        $student->reg_date = Carbon::now()->format('Y-m-d');
        $student->save();
        return redirect('/students/all')->with('info', '正常に登録されました。');
    }
    public function fetchStudent($id)
    {
        $data = Student::where("id", $id)
            ->get();
        return response()->json($data);
    }
    public function fetchStudentList(Request $request)
    {
        $data = Student::select('*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(
                            function ($w) use ($request) {
                                    $search = $request->get('search');
                                    $w->orWhere('roll_no', 'LIKE', "%$search%")
                                        ->orWhere('student_name', 'LIKE', "%$search%")->orWhere('age', 'LIKE', "%$search%")->orWhere('reg_date', 'LIKE', "%$search%");
                                }
                        );
                    }
                })

                ->make(true);
        }
    }
    public function fetchStudentListDelete(Request $request)
    {
        $data = Student::select('*');
        if ($request->ajax()) {
            return DataTables::of($data)->smart(true)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="" class="del_ btn btn-outline-danger"data-target="#deletemodal" data-toggle="modal"  data-id="'.$row->id .'" ><i class="fa fa-trash fa-lg text-center" style="display:block" aria-hidden="true"></i></a>';
                    // return ' <button type="submit" data-target="#deletemodal" data-toggle="modal" data-id="' .
                    //             $row->id .
                    //             '" class="btn btn-outline-danger border-0"><i class="fa fa-trash fa-lg text-center" style="display:block" aria-hidden="true"></i></button>';
                })

                ->filter(function ($instance) use ($request) {

                    if (!empty($request->get('search'))) {
                        $instance->where(
                            function ($w) use ($request) {
                                    $search = $request->get('search');
                                    $w->orWhere('roll_no', 'LIKE', "%$search%")
                                        ->orWhere('student_name', 'LIKE', "%$search%")->orWhere('age', 'LIKE', "%$search%")->orWhere('reg_date', 'LIKE', "%$search%");
                                }
                        );
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function update()
    {
        $validator = validator(request()->all(), [
            'roll_no' => 'required',
            'student_name' => 'required|not_regex:/[!@#$%^&*()_+\-=\[\]{};,<>\/?]+/',
            'age' => 'required|integer|between:15,45',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $student = Student::find(request()->roll_no);
        $student->student_name = request()->student_name;
        $student->age = request()->age;
        $student->update();
        return redirect('/students/all')->with('info', '正常に更新されました。');
    }

}