<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;

class DeviceTokenService
{
    static function sendNotification(array $tokens, $title, $body)
    {
        $server_key = env('FCM_SERVER_KEY');
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $message = new Message();
        $message->setPriority('high');

        foreach ($tokens as $token) {
            $message->addRecipient(new Device($token));
        }

        $message->setNotification(new Notification($title, $body));

        $response = $client->send($message);

        Log::info('Status response: ' . json_encode($response));
    }

    public static function saveNotification(\App\Models\Notification $notificationModel, $driverId, $customerId)
    {
        $notificationModel->customer_id = $customerId;
        $notificationModel->driver_id = $driverId;

        $notificationModel->save();
    }

    public static function removeNotification(\App\Models\Notification $notificationModel, $pairs)
    {
        foreach ($pairs as $pair){
            $pairId = $notificationModel->getPairById($pair['id']);

            if($pairId !== null){
                $pairId->remove();
            }
        }
    }
}
