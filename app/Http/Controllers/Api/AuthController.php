<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
  public $loginAfterSignUp = true;
  public function register(Request $request){
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'mobile' => $request->mobile,
      'password' => bcrypt($request->password),
    ]);

    $user -> attachRole('user');
    return $user;

    $token = auth()->login($user);

    return $this->respondWithToken($token);
  }
    public function login(Request $request){
      $credentials = $request->only(['mobile', 'password']);

      if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'غير مسجل'], 401);
      }

      return $this->respondWithToken($token);
    }
    public function getAuthUser(Request $request){
        return response()->json(auth()->user());
    }
    public function logout(){
        auth()->logout();
        return response()->json(['message'=>'تم تسجيل الخروج بنجاح']);
    }
    protected function respondWithToken($token){
      return response()->json([
        'data' => [
          'id' => auth()->user()->id,
          'role' => auth()->user()->roles->first()->name,
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
        ]
<<<<<<< HEAD
=======
     
>>>>>>> dfd3318669608844b7d41fbad54cb87f32b8f6a7
      ]);
    }

    public function checkUserExists(){
      
    }
}
