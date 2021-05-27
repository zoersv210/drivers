<?php

namespace App\Models;

use App\Contracts\HasPhoneInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Authenticatable implements JWTSubject, HasPhoneInterface
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'lon',
        'lat',
    ];

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

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return $this|null
     */
    public function getAllActiveDrivers()
    {
        return self::where('status', true)->get();
    }
}
