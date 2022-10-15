<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');;
    }

    public function index(){
        // if(request()->search){
        //     $data = Category::where('name','like', '%'.request()->search.'%')->paginate(3);
        //     return view('category.index',compact('data'));
        // }
        $data = Category::paginate(3);
        return view('category.index',compact('data'));
    }

    public function create(){
        return view('category.create');
    }

    public function search(Request $request){
        $data = Category::where('name','like', '%'.request()->search.'%')->paginate(3);
        return view('category.index',compact('data'));
    }

    public function store(Request $request){
        $validate = Category::where('name',$request->name)->first();
        if($validate){
            session()->flash('message',"Category $request->name Sudah ada!!");
            return redirect('/category');
        }

        $data = new Category();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect('/category');
    }

    public function edit($id){
        $data = Category::find($id);
        return view('category.edit',compact('data'));
    }

    public function update(Request $request,$id){
        $data = Category::find($id);
        $validate = Category::where('name',$request->name)->where('id','!=',$id)->first();
        // return $validate;
        if($validate){
            session()->flash('message',"Data $request->name sudah ada!!, silahkan edit lagi!!");
            return redirect('/category');
        }


        $data->name = $request->name;
        $data->status_active = $request->status_active;
        $data->description = $request->description;
        $data->update();
        return redirect('/category');
    }

    public function destroy($id){
        $data = Category::find($id);
        $data->delete();
        return redirect('/category');
    }

    public function delete($id){
        $data = Category::find($id);
        $data->delete();
        return redirect('/category');
    }
}
