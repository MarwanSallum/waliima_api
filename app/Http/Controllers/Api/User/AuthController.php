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

    public $loginAfterSignUp = true;

    public function register(Request $request)
    {
        $mobile = $request -> mobile;

        $checkExistUser = User::where('mobile', $mobile)
        ->first();

        if($checkExistUser){
            return $this -> returnError(301, 'هذا المستخدم مسجل مسبقا');
        }

        $user = User::create([
        'name' => $request->name,
        'mobile' => $request->mobile,
        'password' => bcrypt($request->password),
    ]);

    $token = auth()->login($user);

    return $this->respondWithToken($user,$token);
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
            return $this -> respondWithToken($user , $token);

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
