<?php

namespace App\Services;

use App\Models\PhoneCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneCodeService
{
    public static function createPhoneCode(PhoneCode $phoneCodeModel, Request $request)
    {
        $phone = $request->get('phone');

        CreateProfileService::dropCodeVerify($phone, $phoneCodeModel);

        if((int) $phone === (int) env('TEST_PHONE_NUMBER')){
            //for testing
            $code = env('TEST_CODE');
        }else{
            $code = mt_rand(100000, 999999);
        }

        self::saveCode($phoneCodeModel, $request, $code);

        if($phone != env('TEST_PHONE_NUMBER')){
            SendCodeAuthorizationService::sendCode($phone, $code);
        }

    }

    private static function saveCode(PhoneCode $phoneCodeModel, Request $request, string $code)
    {
        $phone = $request->get('phone');

        $phoneCodeModel->phone = $phone;
        $phoneCodeModel->code = $code;
        $phoneCodeModel->expire_at = date('Y-m-d H:i:s', strtotime('+ ' . config('auth.phone_code_ttl') . ' minutes'));
        $phoneCodeModel->save();
    }

    public static function isValidateCode(string $code, string $phone, PhoneCode $codeModel)
    {
        $data_now = date('Y-m-d H:i:s');
        $getCodeByPhone = DB::table('phone_codes')->where('phone', $phone)->first();

        if ($getCodeByPhone == null ) {

            CreateProfileService::dropCodeVerify($phone, $codeModel);

            return 'This phone is invalid.';
        }

        if ($data_now > $getCodeByPhone->expire_at) {

            CreateProfileService::dropCodeVerify($phone, $codeModel);

            return 'Code has expired.';
        }

        if ($code != $getCodeByPhone->code) {
            return 'Invalid code.';
        }

        return null;
    }
}
