<?php


namespace App\Metrics;

use App\Models\Order;
use App\Services\DateByKeyService;
use Appus\Admin\Metrics\BarMetric;
use Appus\Admin\Metrics\Filters\SelectFilter;

class ProfitCompanyMetric extends BarMetric
{
    protected $name = "Profit of the company";
    protected $width = 45;

    public function getData(array $filter = []): array
    {
        $period = DateByKeyService::getDate($filter);

        $orders = Order::getProfitCompanyMetrics($period);

        return $orders;
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            new SelectFilter(
                'Period',
                'period',
                [
                    'month' => 'Month',
                    'week' => 'Week',
                    'day' => 'Day',
                ]
            ),
        ];
    }

}
