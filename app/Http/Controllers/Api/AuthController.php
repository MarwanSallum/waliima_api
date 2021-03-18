<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  use ApiGeneralTrait;
  
    public function auth(Request $request){
      Log::info($request);
      $user  = User::where([['mobile','=',request('mobile')],['otp','=',request('otp')]])->first();
      if( $user){
          Auth::login($user, true);
          User::where('mobile','=',$request->mobile)->update(['otp' => null, 'verified' => true, 'logged_in' => true]);
          return $this->returnSuccessMessage('تم تسجيل الدخول بنجاح');
      }
      else{
          return $this->returnError(404, 'رمز التحقق غير صحيح');
      }
    }

    public function sendOtp(Request $request){
      if($user =User::where('mobile', $request->mobile)->where( 'verified', true)->first()){
        Auth::login($user, true);
        User::where('mobile','=',$request->mobile)->update([ 'logged_in' => true]);
        return $this->returnSuccessMessage('تم تسجيل الدخول بنجاح');
      }else{
        $otp = rand(1000,9999);
        Log::info("otp = ".$otp);
        $user = User::where('mobile','=',$request->mobile)->first();
        try{
          if(!$user){
            $newUser = User::create([
              'mobile' => $request->mobile,
              'otp' => $otp,
            ]);
            $newUser->save();
              // send otp to mobile no using sms api
            return $this->returnSuccessMessage('تم إنشاء حساب جديد وإرسال رمز التفعيل إلى هاتفك');
          }else{
            $user->update(['otp' => $otp]);
            // send otp to mobile no using sms api
            return $this->returnSuccessMessage('تم إرسال رمز التفعيل إلى رقم هاتفك');
          }
        }catch(\Exception $ex){
          return $this->returnError(404, 'حدث خطأ ما - يرجى المحاولة فيما بعد');
        }
      }
  }
}
