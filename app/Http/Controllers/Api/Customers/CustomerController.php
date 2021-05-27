<?php

namespace App\Http\Controllers\Api\Customers;

use App\Http\Resources\TypeCustomerResources;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Device;
use App\Models\Notification;
use App\Models\Order;
use App\Models\TypeCustomer;
use App\Services\CreateProfileService;
use App\Services\DeviceTokenService;
use App\Services\GetDistanceService;
use App\Services\GetDriverAroundService;
use App\Services\GetOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    const TITLE = 'I am here';
    const BODY = 'You have new orders';

    public function getTypeCustomer()
    {
        return TypeCustomerResources::collection(TypeCustomer::all());
    }

    public function signUpCustomer(Request $request): JsonResponse
    {
        Log::write('info', 'Request sign up customer'.$request);
        CreateProfileService::signUpCustomerProfile($request);

        return response()->json(['message' => 'Successfully logged up']);
    }

    public function signUpServiceProvider(Request $request): JsonResponse
    {
        CreateProfileService::signUpCustomerServicesProfile($request);

        return response()->json(['message' => 'Successfully logged up']);
    }

    public function getProfile(Customer $customerModel): JsonResponse
    {
        $customer = auth('customer')->user();

        return response()->json([
            'customerId' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'status' => $customer->status,
            'longitude' => (double) $customer->lon,
            'latitude' => (double) $customer->lat
        ]);
    }

    public function editProfile(Request $request): JsonResponse
    {
        $customer = CreateProfileService::editCustomerProfile($request);

        return response()->json([
            'customerId' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'status' => $customer->status,
            'longitude' => (double) $customer->lon,
            'latitude' => (double) $customer->lat
        ]);
    }

    public function setOrders(Request $request, Order $orderModel, Driver $driverModel, Notification $notificationModel): JsonResponse
    {
        $customer = auth('customer')->user();
        $notification = (int) $request->get('notification');

        if(true == $notification){
            $order = null;
            $activeOrder = Order::getActiveOrderByCustomerId($customer->id);

            if(empty($activeOrder)){
                $order = GetOrderService::setOrder($orderModel);
            }

            $drivers = GetDriverAroundService::getListDrivers($driverModel);

            if($drivers !== null){
                foreach ($drivers as $driver){
                    $remoteness = GetDistanceService::getDistance($driver['latDriver'], $driver['lonDriver'], $customer->lat, $customer->lon);

                    if($remoteness <= env('MAX_REMOTENESS') && $driver['status'] === true){
                        $tokens = Device::getTokens($driver['driver_id'], 'driver');
                        if ($tokens) {
                            DeviceTokenService::sendNotification($tokens, self::TITLE, self::BODY);
                        }
                    }
                }
            }
            if(empty($activeOrder)){
                return response()->json([
                    'customerId' => $order->customer_id,
                    'status' => true
                ]);
            }
            return response()->json([
                'customerId' => $activeOrder[0],
                'status' => true
            ]);
        }

        Cache::put('reject_notifications_customer_id' . $customer->id, 1, $seconds = 7200);

        return response()->json([
            'customerId' => $customer->id,
            'status' => false
        ]);
    }

    public function rejectNotifications(Notification $notificationModel): JsonResponse
    {
        $customer = auth('customer')->user();

        if(empty($notificationModel->getByCustomerId($customer->id))){
            $notificationModel->customer_id = $customer->id;
            $notificationModel->save();
        }

        return response()->json([
            'customerId' => $customer->id,
            'status' => true
        ]);
    }

    public function changePushNotifications(Request $request): JsonResponse
    {
        $customer = CreateProfileService::changeStatusProfile($request);

        return response()->json([
            'customerId' => $customer->id,
            'status' => $customer->status
        ]);
    }

    public function getSupport()
    {
        return response()->json([
            'whatsapp' => env('SUPPORT_WHATSAPP'),
        ]);
    }

    public function checkDriversAround(Driver $driverModel, Order $orderModel): JsonResponse
    {
        $customer = auth('customer')->user();

        $order = Order::getActiveOrderByCustomerId($customer->id);

        if(!empty($order) || Cache::has('reject_notifications_customer_id' . $customer->id)){
            return response()->json([]);
        }

        $drivers = GetDriverAroundService::getListDrivers($driverModel);

        return response()->json($drivers);
    }

    public function saveTokenDevices(Request $request, Device $deviceModel)
    {
        $profile = auth('customer')->user();

        CreateProfileService::saveTokenDevices($deviceModel, $request, $profile, 'customer');

        return response()->json(['success' => true]);
    }
}
