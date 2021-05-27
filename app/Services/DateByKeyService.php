<?php


namespace App\Services;


use Carbon\Carbon;

class DateByKeyService
{
    static function getDate(array $filter): Carbon
    {
        if($filter['period'] === null){
            $filter = ['period' => 'month'];
        }
        switch ($filter['period']){
            case 'month':
                $date = Carbon::now()->startOfMonth();
                break;
            case 'week':
                $date = Carbon::now()->startOfWeek();
                break;
            case 'day':
                $date = Carbon::now()->startOfDay();
                break;
        }

        return $date;
    }
}
