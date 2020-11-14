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

    public function register(Request  $request){

        $admin = Admin::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'mobile' => $request -> mobile,
            'password' => bcrypt($request -> password),
            
        ]);
        $admin -> attachRole('admin');
       //return user
        return $this -> returnData('admin' , $admin);
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

           $token =  Auth::guard('admin-api') -> attempt($credentials);

           if(!$token)
               return $this->returnError('E001','بيانات الدخول غير صحيحة');

             $admin = Auth::guard('admin-api') -> user();
             $admin -> api_token = $token;
            //return token
             return $this -> returnData('user' , $admin);

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }
}
