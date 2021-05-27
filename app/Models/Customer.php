<?php

namespace App\Models;

use App\Contracts\HasPhoneInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject, HasPhoneInterface
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'phone',
        'lon',
        'lat',
        'type_id',
        'service_type',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param string $phone
     * @return $this|null
     */
    public function getByPhone(string $phone): ?HasPhoneInterface
    {
        return self::where('phone', $phone)->first();
    }

    public static function getById(int $customerId)
    {
        return self::where('id', $customerId)->first();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function getCustomersWithoutOrders()
    {
        return self::whereDoesntHave('orders')->orWhereHas('orders', function ($query){
            $query->where('status', true);
        })->get();
    }
}
