<?php


namespace App\Services;

use Unifonic;

class SendCodeAuthorizationService
{
    public static function sendCode($phone, $code)
    {
        $send = Unifonic::send($phone, $code);
//        $messageID = (int) $send->data->MessageID;
//        Unifonic::getMessageIDStatus($messageID);
    }
}
