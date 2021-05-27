<?php


namespace App\Services;


use App\Contracts\HasPhoneInterface;
use App\Models\Order;
use App\Models\PhoneCode;
use Illuminate\Http\Request;

class CreateProfileService
{
    public static function createProfile(HasPhoneInterface $model, string $phone, PhoneCode $codeModel): HasPhoneInterface
    {
        $profile = $model->getByPhone($phone);

        if($profile === null){
            $model->phone = $phone;
            $model->save();

            return $model;
        }

        return $profile;
    }

    public static function getProfile(HasPhoneInterface $model, string $phone, PhoneCode $codeModel)
    {
        $profile = $model->getByPhone($phone);

        if($profile !== null){
            $profile->status = true;

            self::dropCodeVerify($phone, $codeModel);

            $profile->save();

            return $profile;
        }

        return null;
    }

    public static function existProfile(HasPhoneInterface $model, string $phone)
    {
        $profile = $model->getByPhone($phone);

        if($profile !== null){
            return true;
        }

        return false;
    }

    public static function editDriverProfile(Request $request)
    {
        $profile = auth('driver')->user();

        if($profile !== null){
            $profile->first_name = $request->get('first_name');
            $profile->last_name = $request->get('last_name');
            $profile->save();
        }

        return $profile;
    }

    public static function saveNewCoordinates(Request $request)
    {
        $profile = auth('driver')->user();

        if($profile !== null){
            $profile->lon = $request->get('longitudeDriver');
            $profile->lat = $request->get('latitudeDriver');
            $profile->save();
        }
    }

    public static function signUpCustomerProfile(Request $request)
    {
        $profile = self::changeCustomerData($request);
    }

    public static function signUpCustomerServicesProfile(Request $request)
    {
        self::changeCustomerServicesData($request);
    }

    public static function editCustomerProfile(Request $request)
    {
        return self::changeCustomerData($request);
    }

    public static function changeCustomerData(Request $request)
    {
        $profile = auth('customer')->user();

        $profile->fill($request->only('first_name', 'last_name', 'email', 'phone', 'address', 'lat', 'lon'));
        $profile->save();

        return $profile;
    }

    public static function changeCustomerServicesData(Request $request)
    {
        $profile = self::changeCustomerData($request);
        $profile->fill($request->only('supplier_type', 'service_type'));

        $profile->save();
    }

    public static function changeDriverStatus($status)
    {
        $profile = auth('driver')->user();

        $profile->status = $status;
        $profile->save();

        return $profile;
    }

    public static function changeOrderStatus(Order $model, Request $request)
    {
        $order = $model::find($request->get('order'));

        if(true === $order->status){
            return true;
        }

        if($order !== null){
            $order->status = true;
            $order->driver_id = auth()->id();
            $order->save();
        }

        return $order;
    }

    public static function getProfileByPhone(HasPhoneInterface $model, Request $request): HasPhoneInterface
    {
        $phone = $request->get('phone');
        $profile = $model->getByPhone($phone);

        return $profile;
    }

    public static function dropCodeVerify(string $phone, PhoneCode $codeModel)
    {
        $codeData = $codeModel->getCodeByPhone($phone);

        if($codeData !== null){
            $codeData->remove();
        }
    }

    public static function changeStatusProfile(Request $request)
    {
        $profile = auth('customer')->user();

        $profile->status = $request->get('status');
        $profile->save();

        return $profile;
    }

    public static function saveTokenDevices($deviceModel, $request, $profile, $userType)
    {
        $deviceModel->user_id = $profile->id;
        $deviceModel->user_type = $userType;
        $deviceModel->device_type = $request->type;
        $deviceModel->push_token = $request->deviceToken;
        $deviceModel->save();
    }

}
