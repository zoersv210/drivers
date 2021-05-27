<?php


namespace App\Services;


use App\Models\Driver;
use App\Models\Order;

class GetDriverAroundService
{
    public static function getListDrivers(Driver $driverModel): array
    {
        $customer = auth('customer')->user();

        $driverAround = self::getDrivers($driverModel, $customer);

        $driverData = [];
        $driversData = [];

        if($driverAround !== null){
            foreach ($driverAround as $driver){
                $driverData += ["driver_id" => $driver->id];
                $driverData += ["first_name" => $driver->first_name];
                $driverData += ["last_name" => $driver->last_name];
                $driverData += ["phone" => $driver->phone];
                $driverData += ["remoteness" => $driver->remoteness];
                $driverData += ["lonDriver" => $driver->lon];
                $driverData += ["latDriver" => $driver->lat];
                $driverData += ["status" => $driver->status];
                $driverData += ["customer_id" => $customer->id];

                array_push($driversData, $driverData);
                $driverData = [];
            }
        }

        return $driversData;
    }

    public static function getDrivers(Driver $driverModel, $customer): array
    {
        $activeDrivers = $driverModel->getAllActiveDrivers();

        $lonCustomer = $customer->lon;
        $latCustomer = $customer->lat;

        $driversAround = [];

        foreach ($activeDrivers as $activeDriver){
            $lonDriver = $activeDriver->lon;
            $latDriver = $activeDriver->lat;

            $remoteness = GetDistanceService::getDistance($latCustomer, $lonCustomer, $latDriver, $lonDriver);

            if($remoteness <= env('MAX_REMOTENESS')){
                $activeDriver->remoteness  = $remoteness;
                array_push($driversAround, $activeDriver);
            }
        }

        return $driversAround;
    }

    public static function setOrder(Order $orderModel)
    {
        $profile = auth('customer')->user();

        $orderModel->customer_id = $profile->id;
        $orderModel->save();

        return $orderModel;
    }
}
