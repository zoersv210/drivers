<?php

namespace App\Http\Controllers\Admins;

use App\Http\Requests\Api\CustomerSignUpRequest;
use App\Rules\PhoneLengthRule;
use App\Rules\PhoneMaxRule;
use App\Rules\PhoneMinRule;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;
use Appus\Admin\Http\Controllers\AdminController;
use App\Models\Driver;

class DriverController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Driver());

        $table->setSubtitle('Drivers')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->searchable(true)->sortable(true);
        $table->column('first_name', 'First Name')->searchable(true)->sortable(true);
        $table->column('last_name', 'Last Name')->searchable(true)->sortable(true);
        $table->column('email', 'Email')->searchable(true)->sortable(true);
        $table->column('phone', 'Phone')->searchable(true)->sortable(true);
        $table->column('status', 'Status')->valueAs(function ($row) {
            if($row->status == 0){
                return 'inactive';
            }
            return 'active';
        })->searchable(true);

        $table->editAction()
            ->route('drivers.edit')
            ->field('driver');

        $table->css(['/css/common_tables_styles.css', '/css/driver_table.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Driver());

        $details->field('id', '#');
        $details->field('first_name', 'First Name');
        $details->field('last_name', 'Last Name');
        $details->field('email', 'Email');
        $details->field('phone', 'Phone');
        $details->field('status', 'Status')->valueAs(function ($row) {
            if($row->status == 0){
                return 'inactive';
            }
            return 'active';
        });

        $details->viewPrepend('button.back', ['route' => 'drivers.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Driver());

        $form->string('first_name', 'First Name')->rules('required');
        $form->string('last_name', 'Last Name')->rules('required');

        $form->field('email', 'Email')
            ->saveAs(function () {
                if ('' === request()->get('email')) {
                    return null;
                }
                return request()->get('email');
            })->creationRules('nullable|email')
            ->updatingRules('nullable|email');
        $form->string('phone', 'Phone')->rules(['required','numeric', new PhoneMinRule, new PhoneMaxRule, 'integer']);

        $form->redirectWhenCreated('drivers.index');

        $form->redirectWhenUpdated('drivers.index');

        $form->viewPrepend('button.back', ['route' => 'drivers.index']);

        return $form;
    }

}
