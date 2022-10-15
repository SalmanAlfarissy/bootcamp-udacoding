<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class Category2Controller extends Controller
{

    public function index(){
        return view('category2.index');
    }

    public function getData(Request $request){
        if($request->id){
            $data= Category::where('id',$request->id)->first();
        }else{
            $data= Category::get();
            $no = 0;

            foreach($data as $d){
                $d->no = $no+=1;
            }
        }

        $result = [
            "data"=>$data,
        ];
        return response()->json($result);
    }

    public function createData(Request $request){
        $result = [
            'status'=>false,
            'data'=>null,
            'newToken'=>csrf_token(),
            'message'=>''
        ];

        $validate = Category::where('name',$request->name)->first();
        if($validate){
            $result['message'] = "Category $request->name Sudah ada!!";
            return response()->json($result);
        }
        $data = new Category();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        $result['status'] = true;
        $result['data'] = $data;
        $result['message'] = "Success create data";

        return response()->json($result);

    }

    public function updateData($id,Request $request){
        $result = [
            'status'=>false,
            'data'=>null,
            'newToken'=>csrf_token(),
            'message'=>''
        ];

        $check = Category::where('name',$request->name)->where('id','!=',$id)->first();
        if($check){
            return response()->json(['message'=>'Category name already exist!!']);
        }

        $data = Category::find($id);
        if(!$data){
            $request['message'] = "Category not found!!";
            return response()->json($request);
        }

        $data->name = $request->name;
        $data->description = $request->description;
        $data->status_active = $request->status_active;
        $data->save();

        $result=[
            'status'=>true,
            'data'=>$data,
            'message'=>'Update data successfully!!',
            'newToken'=>csrf_token()
        ];

        return response()->json($result);

    }

    public function deleteData($id){
        $result = [
            'status'=>false,
            'data'=>null,
            'message'=>'',
            'newToken'=>csrf_token()
        ];
        $data = Category::find($id);
        if(!$data){
            $result['message'] = "Category not found!";
            return response()->json($result);
        }

        $data->delete();

        $result['status'] = true;
        $result['message'] = 'Category has been delete!!';

        return response()->json($result);

    }

    public function updateStatus($id){
        $data = Category::find($id);
        if(!$data){
            return $this->result('data not found!!');
        }

        $status = "ACTIVE";
        if($data->status_active == $status){
            $data->status_active = "NONACTIVE";
        }else{
            $data->status_active = $status;
        }
        $data->update();

        return $this->result("Status $data->name $data->status_active !!", $data, true);
    }


}
