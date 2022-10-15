<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }

    public function getDataProfile(){
        $data = Auth::user();
        return response()->json($data);
    }

    public function updateProfile(Request $request){
        $result = [
            'status'=>false,
            'message'=>'',
            'data'=>null,
            'newToken'=>csrf_token(),
        ];
        $data = User::find($request->id);
        $cek = User::where('email',$request->email)->where('id','!=',$data->id)->first();
        if($cek){
            $result['message'] = "Email sudah digunakan, silahkan ganti email lain!!";
            return response()->json($result);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();

        $result['message'] = "Data profile berhasil di update!";
        $result['status'] = true;
        $result['data'] = $data;

        return response()->json($result);

    }

    public function updatePassword(Request $request){
        $result = [
            'message'=>'',
            'data'=>null,
            'status'=>false,
            'newToken'=>csrf_token(),
        ];
        $data = User::find(Auth::user()->id);
        if(Hash::check($request->oldPassword, $data->password)){
            if($request->newPassword == $request->oldPassword){
                $result['message'] = "Password baru anda sama dengan yang lama!!";
                return response()->json($result);
            }else{
                if($request->confirmPassword == $request->newPassword){
                    $data->password = Hash::make($request->newPassword);
                    $data->save();
                    $result['message'] = "Data password berhasil di update!";
                    $result['status'] = true;
                    $result['data'] = $data;
                    return response()->json($result);

                }else{
                    $result['message'] = "Password anda tidak sama dengan new password!!";
                    return response()->json($result);
                }
            }
        }else{
            $result['message'] = "Password anda tidak diketeahui!!";
            return response()->json($result);
        }

    }



}
