<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $data = Category::get();
        return view('news.index', compact('data'));
    }

    public function getData(Request $request){
        if($request->id){
            $data = News::find($request->id);
        }else{
            $data = News::with('category')->get();
            foreach ($data as $index=>$item) {
                $item->no = $index+1;
            }
        }

        return response()->json(['data'=>$data]);
    }

    public function trash(){
        return view('news.trash');
    }

    public function getDataTrash(){

        $data = News::with('category')->onlyTrashed()->get();
        foreach ($data as $index=>$item) {
            $item->no = $index+1;
        }

        return response()->json(['data'=>$data]);
    }

    public function restoreData($id){

        $data = News::where('id',$id)->onlyTrashed()->restore();
        if(!$data){
            return $this->result('Data sudah di restore!');
        }
        return $this->result('Data berhasil di restore!', $data, true);


    }

    public function deleteTrash($id){

        $data = News::where('id',$id)->forceDelete();
        if(!$data){
            return $this->result('Data sudah terhapus sebelumnya!!');
        }

        return $this->result('Data sukses dihapus!!', $data, true);

    }

    public function createData(Request $request){

        $validate = News::where('title',$request->title)->first();
        if($validate){
            return $this->result("Data dengan judul $request->title sudah ada!!");
        }

        $data = new News();
        $data->id_category = $request->id_category;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->save();
        return $this->result('Data sukses di tambahkan!!', $data, true);

    }

    public function updateData($id, Request $request){

        $validate = News::where('title',$request->title)->where('id','!=',$id)->first();
        if($validate){
            return $this->result("Data dengan judul $request->title sudah ada!!");

        }

        $data = News::find($id);
        if(!$data){
            return $this->result("Data dengan judul $request->title sudah terhapus!!");

        }

        $data->id_category = $request->id_category;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->save();

        return $this->result('Data sukses di update!!', $data, true);

    }

    public function deleteData($id){

        $data = News::find($id);
        if(!$data){
            return $this->result('Data sudah terhapus sebelumnya!!');

        }
        $data->delete();

        return $this->result('Data sukses di tambahkan!!', $data, true);


    }
}
