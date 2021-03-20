<?php
namespace App\Http\Service\SmsGateways;

use Illuminate\Support\Facades\Http;

class MsegatGateway
{

    public function sendSms($mobile, $message)
    {
        $params = [
            'userName' => env('MSEGAT_USER_NAME') ,
            'numbers' => $mobile,
            'userSender' => 'OTP',
            'apiKey' => env('MSEGAT_SMS_GATEWAY_API_KEY'),
            'msg' => "Pin Code is: xxxx",
            'msgEncoding' => 'UTF8',
        ];

        try{
            $smsURL = "https://www.msegat.com/gw/sendsms.php";

            $response = Http::post($smsURL,$params);
            return $response;

        
        }catch(\Exception $ex){
            info('Msegat GateWay has been trying to send sms to '. $mobile. ' but operation faild !');
            return false;
        }
    }

}