<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Driver;
use App\Models\Order;
use App\Services\CreateProfileService;
use App\Services\DeviceTokenService;
use App\Services\GetDistanceService;
use App\Services\GetOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class DriverController extends Controller
{
    const TITLE = 'A Driver Is Nearby';
    const BODY = 'There is a driver nearby, do you want him to come to your house?';

    public function getProfile(Request $request, Driver $driverModel): JsonResponse
    {
        $driver = auth('driver')->user();

        return response()->json([
            'driverId' => $driver->id,
            'first_name' => $driver->first_name,
            'last_name' => $driver->last_name,
            'phone' => $driver->phone,
            'status' => $driver->status
        ]);
    }

    public function editProfile(Request $request): JsonResponse
    {
        $driver = CreateProfileService::editDriverProfile($request);

        return response()->json([
            'first_name' => $driver->first_name,
            'last_name' => $driver->last_name,
            'driverId' => $driver->id
        ]);
    }

    public function setStatus(Request $request): JsonResponse
    {
        $driver = CreateProfileService::changeDriverStatus($request->get('status'));

        return response()->json([
            'driverId' => $driver->id,
            'status' => $driver->status
        ]);
    }

    public function getOrders(Request $request, Order $orderModel, Driver $driverModel): JsonResponse
    {
        $driver = auth('driver')->user();

        CreateProfileService::saveNewCoordinates($request);

        $orders = GetOrderService::getListOrders($orderModel, $request, (int)$driver->id);

        $customers = Customer::getCustomersWithoutOrders();

        if( null !==  $customers && true ===  $driver->status){
            foreach ($customers as $customer){
                $remoteness = GetDistanceService::getDistance($customer->lat, $customer->lon, $driver->lat, $driver->lon);

                if($remoteness <= env('MAX_REMOTENESS') && !Cache::has('driverId' . $driver->id . '_' . 'customerId' . $customer->id)){
                    $tokens = Device::getTokens($customer->id, 'customer');

                    if ($tokens) {
                        DeviceTokenService::sendNotification($tokens, self::TITLE, self::BODY);
                        Cache::put('driverId' . $driver->id . '_' . 'customerId' . $customer->id, 1, $seconds = 1800);
                    }
                }
            }
        }

        return response()->json($orders);
    }

    public function orderConfirm(Request $request, Order $orderModel): JsonResponse
    {
        if(null === $request->order){
            return response()->json(['error' => 'The order field is required'], 401);
        }

        if(!is_numeric($request->order)){
            return response()->json(['error' => 'The order must be an integer'], 401);
        }

        $driver = CreateProfileService::changeDriverStatus(false);
        $order = CreateProfileService::changeOrderStatus($orderModel, $request);

        if(true === $order){
            return response()->json(['error' => 'The order is already taken by another driver'], 401);
        }

        if(null === $order){
            return response()->json(['error' => 'The order does not exist'], 401);
        }

        return response()->json([
            'driverId' => $order->driver->id,
            'order' => $order->id,
            'status' => $order->status
        ]);
    }

    public function saveTokenDevices(Request $request, Device $deviceModel)
    {
        $profile = auth('driver')->user();

        CreateProfileService::saveTokenDevices($deviceModel, $request, $profile, 'driver');

        return response()->json(['success' => true]);
    }

    public function getSupport()
    {
        return response()->json([
            'whatsapp' => env('SUPPORT_WHATSAPP'),
        ]);
    }
}
