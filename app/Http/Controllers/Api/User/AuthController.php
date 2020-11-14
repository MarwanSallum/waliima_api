<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiGeneralTrait;

    public function register(Request  $request){

        $user = User::create([
            'name' => $request -> name,
            'mobile' => $request -> mobile,
            'password' => bcrypt($request -> password),
        ]);
       //return user
        return $this -> returnData('user' , $user);
    }

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

           $token =  Auth::guard('user-api') -> attempt($credentials);

           if(!$token)
               return $this->returnError('E001','بيانات الدخول غير صحيحة');

             $user = Auth::guard('user-api') -> user();
             $user -> api_token = $token;
            //return token
             return $this -> returnData('user' , $user);

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }
}
