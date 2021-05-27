<?php

namespace App\Http\Controllers\Admins;

use App\Rules\PhoneMaxRule;
use App\Rules\PhoneMinRule;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;
use Appus\Admin\Http\Controllers\AdminController;
use App\Models\Customer;

abstract class CustomerBaseController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Customer());

        $table->query(function ($q) {
            $q->where('type_id', $this->getType());
        });

        $table->setSubtitle('Customers')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', 'ID')->searchable(true)->sortable(true);
        $table->column('first_name', 'First Name')->searchable(true)->sortable(true);
        $table->column('last_name', 'Last Name')->searchable(true)->sortable(true);
        $table->column('email', 'Email')->searchable(true)->sortable(true);
        $table->column('address', 'Address')->searchable(true)->sortable(true);
        $table->column('phone', 'Phone')->searchable(true)->sortable(true);
        $table->column('created_at', 'Registration Date')->searchable(true)->sortable(true);

        $table->css(['/css/common_tables_styles.css', '/css/customer_table.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Customer());

        $details->field('id', 'ID');
        $details->field('first_name', 'First Name');
        $details->field('last_name', 'Last Name');
        $details->field('email', 'Email');
        $details->field('address', 'Address');
        $details->field('phone', 'Phone');
        $details->field('created_at', 'Registration Date');

        $details->viewPrepend('button.back', ['route' => 'customers.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Customer());

        $form->string('first_name', 'First Name')->rules('required');
        $form->string('last_name', 'Last Name')->rules('required');
        $form->string('address', 'Address');

        $form->field('email', 'Email')
            ->saveAs(function () {
                if ('' === request()->get('email')) {
                    return null;
                }
                return request()->get('email');
            })->creationRules('nullable|email')
            ->updatingRules('nullable|email');
        $form->string('phone', 'Phone')->rules(['required','numeric', new PhoneMinRule, new PhoneMaxRule, 'integer']);

        $form->redirectWhenUpdated('customers.index');

        $form->viewPrepend('button.back', ['route' => 'customers.index']);

        return $form;
    }

    abstract function getType();

}
