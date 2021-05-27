<?php


namespace App\Metrics;

use App\Models\Order;
use Appus\Admin\Metrics\ListMetric;

class DriversOrdersMetric extends ListMetric
{
    protected $name = "Graphs of the driver";
    protected $width = 45;

    public function getData(array $filter = []): array
    {
        $orders = Order::getOrderDriverMetrics();

        return $orders;
    }
}
