<?php
namespace App\Http\Service;

use App\Models\User;
use App\Helpers\ApiGeneralTrait;


class VerificationServices
{
    use ApiGeneralTrait;
    public function setVerificationCode($data)
    {
        
        $user = User::where('mobile','=', $data['mobile'])->first();
        $otp = mt_rand(100000, 999999);
        $data['otp'] = $otp;
        try{
            // if user not in DB create new one with otp
            if(!$user){
                $newUser = User::create([
                    'mobile' => $data['mobile'],
                    'otp' => $data['otp'],
                ]);
                $newUser->save();
                return $newUser;
            }
            // if user in DB update otp
            else{
                $user->update(['otp' => $data['otp']]);
                return $user;
            }
        }catch(\Exception $ex){
            return $this->returnError(404, 'حدث خطأ ما - يرجى المحاولة فيما بعد');
        }
    }

    public function getSmsVerificationMessage($otp)
    {
        $message =  $otp.":رمز التحقق \nمرحبا بك في تطبيق وليمة";
        return $message;
    }
}