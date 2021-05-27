<?php

namespace App\Http\Controllers\Admins;

use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;
use App\Models\Customer;

class CustomerController extends CustomerBaseController
{

    public function getType()
    {
        return null;
    }
}
