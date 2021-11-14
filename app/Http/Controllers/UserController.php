<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=Userr::all();
        return response()->json($data);
    }


    public function store(Request $request)
    {
        $data= new Userr();
        $data->name=$request->input('name');
        $data->phone=$request->input('phone');
       if($request->hasfile('image')){
        $uploaded_image=$request->file('image');
        $new_name=time().'.'.$uploaded_image->extension();
        $uploaded_image->move(public_path('user_images/'),$new_name);
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
        $data=Userr::findOrFail($id);
        return response()->json($data);
    }


    public function updated(Request $request)
    {
        $data_id=$request->input('id');
         $data=Userr::findOrFail($data_id);
        $data->name=$request->input('name');
        $data->phone=$request->input('phone');
       if($request->hasfile('image')){
        $uploaded_image=$request->file('image');
        $new_name=time().'.'.$uploaded_image->extension();
        $uploaded_image->move(public_path('user_images/'),$new_name);
        $data->image=$new_name;
       }
       $data->update();
       return response()->json(['success'=>'success']);

    }

    public function destroy($id)
    {
        $data= Userr::findOrFail($id);
        unlink('user_images/'.$data->image);
        $data->delete();
        return response()->json(['success'=>'success']);
    }
}
