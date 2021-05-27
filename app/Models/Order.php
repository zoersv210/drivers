<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'driver_id',
        'payment',
    ];

    public function getAllMissedOrders()
    {
        return self::where('status', false)->get();
    }

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public static function getOrderCustomerMetrics($period)
    {
        $query = self::select(DB::raw("count(*) as count, extract(day FROM created_at) as date"))
            ->groupBy('date')
            ->where('created_at', '>=', $period)
            ->pluck('count', 'date')
            ->toArray();

        return $query;
    }

    public static function getOrderDriverMetrics()
    {
        $query = self::select(DB::raw("driver_id, CONCAT(drivers.first_name,' ',drivers.last_name) as driver, sum(payment) as total"))
            ->groupBy('driver_id')
            ->groupBy('drivers.first_name')
            ->groupBy('drivers.last_name')
            ->join('drivers', 'drivers.id', '=', 'orders.driver_id')
            ->get()
            ->toArray();

        return $query;
    }

    public static function getProfitCompanyMetrics($period)
    {
        $query = self::select(DB::raw("sum(payment) as total, extract(day FROM created_at) as date"))
            ->groupBy('date')
            ->where('created_at', '>=', $period)
            ->pluck('total', 'date')
            ->toArray();

        return $query;
    }


    public static function getActiveOrderByCustomerId($userId)
    {
        $query = self::select(DB::raw("customer_id"))
            ->where('customer_id', '=', $userId)
            ->where('status', '=', 'false')
            ->pluck('customer_id')
            ->toArray();

        return $query;
    }
}
