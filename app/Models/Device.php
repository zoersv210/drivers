<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'device_type',
        'push_token',
    ];

    /**
     * @param string $phone
     * @return $this|null
     */
    public function getDataByToken($request)
    {
        $code = self::where('push_token', $request->deviceToken)->first();

        return $code;
    }

    public static function getTokens($userId, $userType)
    {
        $query = self::select(DB::raw("push_token"))
            ->where('user_id', '=', $userId)
            ->where('user_type', '=', $userType)
            ->pluck('push_token')
            ->toArray();

        return $query;
    }
}
