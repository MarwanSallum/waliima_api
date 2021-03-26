<?php

namespace App\Http\Controllers\UserApi;

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

      $credentials = request(['mobile', 'otp']);

      if( !$token = auth('user-api')->attempt($credentials)){
        return response()->json(['error' => 'Unauthorized'], 401);
      }
      return $this->respondWithToken($token);
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
                return $this->returnSuccessMessage('New Account Created with OTP code sent to your Mobile');
            }
            // if user in DB update otp
            else{
                $user->update(['otp' => $data['otp']]);
                return $this->returnSuccessMessage('OTP code sent to your Mobile');
            }
        }catch(\Exception $ex){
            return $this->returnError(404, 'There is an Error');
        }
          // $verification = [];
          // $verification['mobile'] = $request->mobile;
          // $this->verificationServices->setVerificationCode($verification);
          // this work after activate the SMS Gateway
          // $message = $this->verificationServices->getSmsVerificationMessage($user->otp);
          // app(MsegatGateway::class)->sendSms($request->mobile, $message);
  }

  protected function respondWithToken($token)
  {
      return response()->json([
          'data' => [
              'access_token' => $token,
              'token_type' => 'bearer',
              'expires_in' => auth('user-api')->factory()->getTTL() * 60
          ]
      
          ], 200);
  }
}
