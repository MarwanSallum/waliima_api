<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    use ApiGeneralTrait;

    public function login(Request  $request){
        try {
            $rules = [
                "mobile" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

             $credentials = $request -> only(['mobile','password']) ;

           $token =  Auth::guard('admin-api') -> attempt($credentials);

           if(!$token)
               return $this->returnError('E001','بيانات الدخول غير صحيحة');

             $admin = Auth::guard('admin-api') -> user();
             return $this -> respondWithToken($admin , $token);

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'تم تسجيل الخروج بنجاح']);
    }
}
