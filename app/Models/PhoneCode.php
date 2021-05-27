<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class PhoneCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'code',
        'expire_at',
    ];
    /**
     * @param string $phone
     * @return $this|null
     */
    public function getCodeByPhone(string $phone)
    {
        $code = self::where('phone', $phone)->first();

        return $code;
    }

    public function remove()
    {
        $this->delete();
    }
}
