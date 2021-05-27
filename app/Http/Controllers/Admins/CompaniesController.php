<?php

namespace App\Http\Controllers\Admins;

use App\Models\Company;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Http\Controllers\AdminController;
use Appus\Admin\Table\Table;

class CompaniesController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Company());

        $table->setSubtitle('Companies')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->searchable(true)->sortable(true);
        $table->column('name', 'Name Company')->searchable(true)->sortable(true);
        $table->column('address', 'Address')->searchable(true)->sortable(true);
        $table->column('created_at', 'Date registered')->searchable(true)->sortable(true);

        $table->editAction()
            ->route('companies.edit')
            ->field('company');

        $table->css(['/css/common_tables_styles.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Company());

        $details->field('id', '#');
        $details->field('name', 'Name Company');
        $details->field('address', 'Address');
        $details->field('created_at', 'Date registered');

        $details->viewPrepend('button.back', ['route' => 'companies.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Company());

        $form->string('name', 'Name Company')->rules('required|string');
        $form->string('address', 'Address')->rules('nullable|string');

        $form->redirectWhenCreated('companies.index');

        $form->redirectWhenUpdated('companies.index');

        $form->viewPrepend('button.back', ['route' => 'companies.index']);

        return $form;
    }
}
