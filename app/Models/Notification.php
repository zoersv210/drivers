<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'driver_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public static function getPair($driverId, $customerId)
    {
        $query = self::select(DB::raw("id"))
            ->where('customer_id', '=', $customerId)
            ->where('driver_id', '=', $driverId)
            ->get()
            ->toArray();

        return $query;
    }

    public function getPairById(string $id)
    {
        $pairId = self::where('id', $id)->first();

        return $pairId;
    }



    public static function getByCustomerId(int $customerId)
    {
        $query = self::select(DB::raw("id"))
            ->where('customer_id', '=', $customerId)
            ->get()
            ->toArray();

        return $query;
    }

    public function remove()
    {
        $this->delete();
    }
}
