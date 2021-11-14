<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{

    public function index()
    {
        return view('student/index');
    }

   
    public function create()
    {
        $data=Student::all();
        return response()->json($data);
    }


    public function store(Request $request)
    {
        $data=new Student();
        $data->name=$request->input('name');
        $data->roll=$request->input('roll');
        if($request->hasfile('image')){
            $uploaded_image=$request->file('image');
            $new_name=time().'.'.$uploaded_image->extension();
            $uploaded_image->move(public_path('/student_images/'),$new_name);
            $data->image=$new_name;
        }
        $data->save();
       
        return response()->json(['success'=>'success']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data=Student::findOrFail($id);
        return response()->json($data);
    }


    public function updated(Request $request)
    {
        $id=$request->input('id');
         $data=Student::findOrFail($id);
        $data->name=$request->input('name');
        $data->roll=$request->input('roll');
        if($request->hasfile('image')){
            $uploaded_image=$request->file('image');
            $new_name=time().'.'.$uploaded_image->extension();
            $uploaded_image->move(public_path('/student_images/'),$new_name);
            $data->image=$new_name;
        }
        $data->update();
       
        return response()->json(['success'=>'success']);
    }


    public function destroy($id)
    {
        $data=Student::findOrFail($id);
        unlink('student_images/'.$data->image);
        $data->delete();
        return response()->json(['success'=>'sdfsdf']);
    }
}
