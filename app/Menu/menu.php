<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

/**
 *  It is configuration for menu items.
 *
 *  Adding of that items are like routes.
 *
 *  For more information read documentation.
 *
 */

use Appus\Admin\Services\Menu\Facades\Menu;
use Illuminate\Support\Facades\Auth;

Menu::add('Administrators')
    ->order(1)
    ->icon('flaticon-users-1')
    ->route('administrators.index')
    ->if(function () {
        return Auth::user()->isSuperAdmin();
    });

Menu::add('Drivers')
    ->order(1)
    ->icon('fas fa-taxi')
    ->route('drivers.index');

Menu::add('Customers')
    ->order(2)
    ->icon('fas fa-user')
    ->route('customers.index');

Menu::add('Service Provider')
    ->order(3)
    ->icon('fas fa-user-cog')
    ->route('service-providers.index');

Menu::add('Orders')
    ->order(4)
    ->icon('fas fa-hand-holding-usd')
    ->route('orders.index');

Menu::add('Companies')
    ->order(4)
    ->icon('fas fa-landmark')
    ->route('companies.index')
    ->if(function () {
        return Auth::user()->isSuperAdmin();
    });

