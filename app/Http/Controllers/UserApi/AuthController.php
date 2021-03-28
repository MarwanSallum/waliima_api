<?php

namespace App\Http\Controllers\UserApi;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Service\VerificationServices;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  use ApiGeneralTrait;

    public function __construct(VerificationServices $verificationServices )
    {
      $this->middleware('auth:api', ['except' => ['auth', 'sendOtp']]);
      $this->verificationServices = $verificationServices;
      
    }

    public function sendOtp(Request $request){

        $user = User::where('mobile','=', $request['mobile'])->first();
        $otp = mt_rand(100000, 999999);
        $data['otp'] = $otp;
        try{
            // if user not in DB create new one with otp
            if(!$user){
                $newUser = User::create([
                    'mobile' => $request['mobile'],
                    'otp' => $data['otp'],
                ]);
                $newUser->save();
                return $this->returnSuccessMessage('تم إنشاء حساب جديد وإرسال رمز التفعيل إلى رقم هاتفك');
            }
            // if user in DB update otp
            else{
                $user->update(['otp' => $data['otp']]);
                return $this->returnSuccessMessage('تم إرسال رمز التفعيل إلى رقم هاتفك');
            }
        }catch(\Exception $ex){
            return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');
        }
  }

    
  public function auth(Request $request){
    $user  = User::where([['mobile','=',$request->mobile],['otp','=',$request->otp]])->first();
    if( $user){
        $token = $user->createToken('auth-access')->plainTextToken;
        $user->update(['otp' => null, 'verified' => true, 'logged_in' => true, 'logged_in_at' => now()]);
        return $this->respondWithToken($token, $user->id);
    }
    else{
        return $this->returnError(404, 'رمز التفعيل غير صحيح');
    }
  }


  protected function respondWithToken($token, $userID)
  {
      return response()->json([
              'id' => $userID,
              'access_token' => $token,
              'token_type' => 'bearer',
          ], 200);
  }
}
