<?php


namespace App\Metrics;

use App\Models\Order;
use App\Services\DateByKeyService;
use Appus\Admin\Metrics\Filters\SelectFilter;
use Appus\Admin\Metrics\BarMetric;

class CustomersOrdersMetric extends BarMetric
{
    protected $name = "Customer has requested a driver";
    protected $width = 45;

    public function getData(array $filter = []): array
    {
        $period = DateByKeyService::getDate($filter);

        $orders = Order::getOrderCustomerMetrics($period);

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
