<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Service\SmsGateways\MsegatGateway;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\VerificationServices;

class AuthController extends Controller
{
  use ApiGeneralTrait;

    public function __construct(VerificationServices $verificationServices )
    {
      $this->middleware('guest');
      $this->verificationServices = $verificationServices;
      
    }
  
    public function auth(Request $request){
      Log::info($request);
      $user  = User::where([['mobile','=',request('mobile')],['otp','=',request('otp')]])->first();
      if( $user){
          $token = $user->createToken('auth-access')->plainTextToken;
          User::where('mobile','=',$request->mobile)
          ->update(['otp' => null, 'verified' => true, 'logged_in' => true, 'logrred_in_at' => now()]);
          return $this->returnToken($token);
      }
      else{
          return $this->returnError(404, 'رمز التحقق غير صحيح');
      }
    }

    public function sendOtp(Request $request){
      // check if user already verified. direct take him token without send OTP
      $verifiedUser = User::where('mobile', $request->mobile)->where( 'verified', true)->first();
      if($verifiedUser){
        $token = $verifiedUser->createToken('auth-access')->plainTextToken;
        $verifiedUser->update([ 'logged_in' => true]);
        return $this->returnToken($token);
      }else{
          $verification = [];
          $verification['mobile'] = $request->mobile;
          $this->verificationServices->setVerificationCode($verification);
          $user = User::where('mobile', $request->mobile)->first();

          // this work after activate the SMS Gateway
          // $message = $this->verificationServices->getSmsVerificationMessage($user->otp);
          // app(MsegatGateway::class)->sendSms($request->mobile, $message);

      }
  }
}
