<?php


namespace App\Services;


use App\Models\Order;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class GetOrderService
{
    public static function getListOrders(Order $orderModel, Request $request, int $driver): array
    {
        $orderCorrect = self::getRemotenessFromCustomer($orderModel, $request);

        $orderArr = [];
        $ordersArr = [];

        if($orderCorrect != null){
            foreach ($orderCorrect as $order){
                $orderArr += ["order_id" => $order->id];
                $orderArr += ["first_name" => $order->customer->first_name];
                $orderArr += ["last_name" => $order->customer->last_name];
                $orderArr += ["phone" => $order->customer->phone];
                $orderArr += ["address" => $order->customer->address];
                $orderArr += ["remoteness" => $order->remoteness];
                $orderArr += ["driver_id" => $driver];
                $orderArr += ["longitude" => $order->customer->lon];
                $orderArr += ["latitude" => $order->customer->lat];
                $orderArr += ["customer_id" => $order->customer->id];

                array_push($ordersArr, $orderArr);
                $orderArr = [];
            }
        }

        return $ordersArr;
    }

    public static function getRemotenessFromCustomer(Order $orderModel, $request): array
    {
        $orders = $orderModel->getAllMissedOrders();

        $lonDriver = $request->get('longitudeDriver');
        $latDriver = $request->get('latitudeDriver');
        $ordersCorrect = [];

        foreach ($orders as $order){
            $lonCustomer = $order->customer->lon;
            $latCustomer = $order->customer->lat;

            $remoteness = GetDistanceService::getDistance($latCustomer, $lonCustomer, $latDriver, $lonDriver);
            if($remoteness <= env('MAX_REMOTENESS')){
                $order->remoteness  = $remoteness;
                array_push($ordersCorrect, $order);
            }
        }

        return $ordersCorrect;
    }

    public static function setOrder(Order $orderModel)
    {
        $profile = auth('customer')->user();

        $orderModel->customer_id = $profile->id;
        $orderModel->save();

        return $orderModel;
    }
}
