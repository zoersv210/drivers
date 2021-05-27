<?php

namespace App\Http\Controllers\Admins;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Http\Controllers\AdminController;
use Appus\Admin\Table\Table;

class OrderController extends AdminController
{
    public function grid(): Table
    {
        $table = new Table(new Order());

        $table->setSubtitle('Orders')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->sortable(true);
//        $table->setWidth(100);

        $table->column('customers.name', 'Customer Name')->valueAs(function ($row) {
            return $this->getFullName($row->customer);
        });
        $table->column('customer_id', 'Customer ID')->sortable(true);
        $table->column('status', 'Status')->valueAs(function ($row) {
            if($row->status == 1){
                return 'completed';
            }
            return 'missed';
        })->sortable(true);

        $table->column('created_at', 'Date')->sortable(true);

        $table->column('drivers.name', 'Driver Name')->valueAs(function ($row) {
            return $this->getFullName($row->driver);
        });

//        $table->column('payment', 'Payment')->sortable(true);

        $table->css(['/css/admin_tables.css', '/css/common_tables_styles.css']);

        $table->editAction()
            ->route('orders.edit')
            ->field('order')->disabled(true);

        $table->deleteAction()->disabled(true);
        $table->viewAction()->disabled(true);

        $table->query(function ($query) {
            if ($search = request()->get('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'ilike', "%$search%")
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('first_name', 'ilike', "%$search%");
                        })
                        ->orWhereHas('customer', function ($q) use ($search) {
                            $q->where('last_name', 'ilike', "%$search%");
                        })
                        ->orWhereHas('driver', function ($q) use ($search) {
                            $q->where('first_name', 'ilike', "%$search%");
                        })
                        ->orWhereHas('driver', function ($q) use ($search) {
                            $q->where('last_name', 'ilike', "%$search%");
                        })
                        ->orWhere('customer_id', 'ilike', "%$search%")
                        ->orWhere('payment', 'ilike', "%$search%");
                });
            }
        });

        $table->disableMultiDelete();

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Order());

        $details->field('id', '#');
        $details->field('customer.name', 'Customer Name')->valueAs(function ($row) {
            return $row->customer->name;
        });
        $details->field('customer_id', 'CustomerID');
        $details->field('status', 'Status')->valueAs(function ($row) {
            if($row->status == 1){
                return 'completed';
            }
            return 'missed';
        });
        $details->field('drivers.name', 'Driver Name')->valueAs(function ($row) {
            return $row->driver->name;
        });
        $details->field('payment', 'Payment');

        $details->viewPrepend('button.back', ['route' => 'orders.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Order());

        $form->string('customer_id', 'CustomerID')->rules('required|integer');
        $form->select('status', 'Status')->options([
            '0' => 'missed',
            '1' => 'completed',
        ]);
        $form->string('driver_id', 'DriverID')->rules('nullable|integer');
        $form->string('payment', 'Payment')->rules('nullable|integer');
        $form->redirectWhenCreated('orders.index');
        $form->redirectWhenUpdated('orders.index');

        $form->viewPrepend('button.back', ['route' => 'orders.index']);

        return $form;
    }

    private function getFullName($date): string
    {
        if(isset($date->first_name) && isset($date->last_name)){
            return $date->first_name . ' ' . $date->last_name;
        }elseif (!isset($date->last_name) && isset($date->first_name)){
            return $date->first_name;
        }elseif (!isset($date->first_name) && isset($date->last_name)){
            return $date->last_name;
        }

        return '';
    }
}
