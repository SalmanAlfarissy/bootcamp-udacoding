<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $data = News::get();
        return view('comment.index', compact('data'));
    }

    public function getData(Request $request){
        if($request->id){
            $data = Comment::find($request->id);
        }else{
            $data = Comment::with('news')->get();
            foreach ($data as $index=>$item) {
                $item->no = $index+1;
            }
        }

        return response()->json(['data'=>$data]);
    }

    public function createData(Request $request){


        $data = new Comment();
        $data->id_news = $request->id_news;
        $data->name = $request->name;
        $data->phone_number = $request->phone_number;
        $data->comment = $request->comment;
        $data->like = $request->like;
        $data->time_comment = $request->time;
        $data->date_comment = $request->date;
        $data->is_active = $request->is_active;
        $data->save();
        return $this->result('Data sukses di tambahkan!!', $data, true);

    }

    public function updateData($id, Request $request){


        $data = Comment::find($id);

        $data->id_news = $request->id_news;
        $data->name = $request->name;
        $data->phone_number = $request->phone_number;
        $data->comment = $request->comment;
        $data->like = $request->like;
        $data->time_comment = $request->time;
        $data->date_comment = $request->date;
        $data->is_active = $request->is_active;
        $data->save();

        return $this->result('Data sukses di update!!', $data, true);

    }

    public function deleteData($id){

        $data = Comment::find($id);
        if(!$data){
            return $this->result('Data sudah terhapus sebelumnya!!');
        }
        $data->delete();
        return $this->result('Data sukses di tambahkan!!', $data, true);


    }

    public function trash(){
        return view('comment.trash');
    }

    public function getDataTrash(){

        $data = Comment::with('news')->onlyTrashed()->get();
        foreach ($data as $index=>$item) {
            $item->no = $index+1;
        }

        return response()->json(['data'=>$data]);
    }

    public function restoreData($id){

        $data = Comment::where('id',$id)->onlyTrashed()->restore();
        if(!$data){
            return $this->result('Data sudah di restore!');
        }
        return $this->result('Data berhasil di restore!', $data, true);


    }

    public function deleteTrash($id){

        $data = Comment::where('id',$id)->forceDelete();
        if(!$data){
            return $this->result('Data sudah terhapus sebelumnya!!');
        }

        return $this->result('Data sukses dihapus!!', $data, true);

    }
}
