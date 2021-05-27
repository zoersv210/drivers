<?php

namespace App\Http\Controllers\Admins;


use App\Metrics\CustomersOrdersMetric;
use App\Metrics\DriversOrdersMetric;
use App\Metrics\ProfitCompanyMetric;
use Appus\Admin\Http\Controllers\DashboardController;

class AdminPanelController extends DashboardController
{
    /**
     * @return array
     */
    public function metrics(): array
    {
        return [
            (new DriversOrdersMetric()),
            (new CustomersOrdersMetric()),
            (new ProfitCompanyMetric()),
        ];
    }

}
