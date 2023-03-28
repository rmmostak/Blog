<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Auth;

class AuthController extends Controller {

    public function login(Request $request) {
        $cred=$request->only(['email', 'password']);
        if(!$token = auth()->attempt($cred)) {
            return response()->json([
                'success' => false,
                'message' =>'Invalid credentials'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => Auth::user()
            ]);
        }
    }

    public function register(Request $request) {
        $encryptedPass=Hash::make($request->password);

        $user=new User;
        try {
            //$user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user->save();

            return $this->login($request);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }
    }

    public function logout(Request $request) {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'logout successfully'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }

    public function userInfo(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $photo = '';
        //if user add photo
        if($request->photo !='') {
            $photo = time().'.jpg';
            file_put_contents('storage/profiles/'.$photo, base64_decode($request->photo));
            $user->photo = $photo;
        }

        $user->update();
        return response()->json([
            'success' => true,
            'photo' => $photo,
        ]);
    }
}
