<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index(){
        $session = Auth::user();
        if(!empty($session)){
            return redirect(route('dash'));
        }
        // return $session;
        return view('login');
    }
    public function Login(Request $request){
        $user = Auth::attempt(['email'=>$request->email,'password'=>$request->password]);
        // return $user;
        if($user){
            return redirect()->to('/dashboard');
        }else{
            session()->flash('message','User not found!!');
            return Redirect::back();
        }
    }

    public function register(){
        return view('register');
    }

    public function storeRegist(Request $request){

        $result = [
            'data' => null,
            'status' => false,
            'newToken'=>csrf_token(),
            'message'=>''
        ];

        if($request->password != $request->repassword){
            $result['message'] = "Password anda berbeda !!";
            return response()->json($result);
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $password = Hash::make($request->password);
        $data->password = $password;
        $data->save();
        $result['data'] = $data;
        $result['status'] = true;
        $result['message'] = "Registrasi berhasil!!";

        return response()->json($result);
    }

}
