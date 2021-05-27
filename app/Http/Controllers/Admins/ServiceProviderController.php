<?php

namespace App\Http\Controllers\Admins;

use App\Models\TypeCustomer;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;

class ServiceProviderController extends CustomerBaseController
{

    public function getType()
    {
        return TypeCustomer::where('name', 'Service Provider')->first()->id;
    }

    public function grid(): Table
    {
        $table = parent::grid();

        $table->setSubtitle('Service Providers');

//        $table->column('type_id', 'Type')->valueAs(function ($row) {
//            if($row->type_id == 1){
//                return 'Service Provider';
//            }
//            return ' ';
//        })->searchable(true)->sortable(true);
        $table->column('service_type', 'Service')->searchable(true)->sortable(true);

        $table->createAction()
            ->route('service-providers.create')
            ->field('service_provider');

        $table->viewAction()
            ->route('service-providers.show')
            ->field('service_provider');

        $table->editAction()
            ->route('service-providers.edit')
            ->field('service_provider');

        $table->deleteAction()
            ->route('service-providers.destroy')
            ->field('service_provider');

        return $table;
    }

    public function details(): Details
    {
        $details = parent::details();

        $details->setTitle('Service Provider');

        $details->field('type_id', 'Type');
        $details->field('service_type', 'Service');

        $details->viewPrepend('button.back', ['route' => 'service-providers.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = parent::form();

        $form->setTitle('Service Provider');

        $form->select('type_id', 'Type')->options([
            '1' => 'Service Provider',
        ]);

        $form->string('service_type', 'Service');

        $form->redirectWhenCreated('service-providers.index');

        $form->redirectWhenUpdated('service-providers.index');

        $form->viewPrepend('button.back', ['route' => 'service-providers.index']);

        return $form;
    }
}
