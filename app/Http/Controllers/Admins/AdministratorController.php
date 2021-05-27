<?php

namespace App\Http\Controllers\Admins;

use App\Models\Role;
use App\Rules\PhoneMaxRule;
use App\Rules\PhoneMinRule;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;
use Appus\Admin\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends AdminController
{
    public function grid(): Table
    {
        $table = new Table(new User());

        $table->setSubtitle('Administrators')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', 'ID')->sortable(true);
        $table->column('full_name', 'Name');
        $table->column('email', 'Email')->sortable(true);
        $table->column('phone', 'Phone')->sortable(true);
        $table->column('created_at', 'Registration Date')->sortable(true);

        $table->createAction()
            ->route('administrators.create')
            ->field('administrator');

        $table->viewAction()
            ->route('administrators.show')
            ->field('administrator');

        $table->editAction()
            ->route('administrators.edit')
            ->field('administrator');

        $table->deleteAction()
            ->route('administrators.destroy')
            ->field('administrator');

        $table->query(function ($query) {

            $query->where('role_id', '=', User::ROLE_ADMIN);

            if ($search = request()->get('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'ilike', "%$search%")
                        ->orWhere('email', 'ilike', "%$search%")
                        ->orWhere('first_name', 'ilike', "%$search%")
                        ->orWhere('last_name', 'ilike', "%$search%")
                        ->orWhere('phone', 'ilike', "%$search%");
                });
            }
        });

        $table->css(['/css/common_tables_styles.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new User());

        $details->field('id', 'ID');
        $details->field('first_name', 'First Name');
        $details->field('last_name', 'Last Name');
        $details->field('email', 'Email');
        $details->field('phone', 'Phone');
        $details->field('created_at', 'Registration Date');

        $details->viewPrepend('button.back', ['route' => 'administrators.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new User());

        $form->string('first_name', 'First Name')->rules('required');
        $form->string('last_name', 'Last Name')->rules('required');
        $form->string('email', 'Email')->rules('email');
        $form->string('password', 'Password')->rules('required|min:6');
        $form->field('password', 'Password')
            ->saveAs(function () {
                if ('' === request()->get('password')) {
                    return null;
                }
                return Hash::make(request()->get('password'));
            })->valueAs(function () {
                return '';
            })->creationRules('required|min:6|max:16')
            ->updatingRules('nullable|min:6|max:16');

        $form->string('phone', 'Phone')->rules(['required','numeric','integer', new PhoneMinRule, new PhoneMaxRule]);
        $form->select('role_id', 'Role')
            ->options(Role::pluck('name', 'id')->toArray())
            ->rules('required');

        $form->redirectWhenUpdated('administrators.index');

        $form->viewPrepend('button.back', ['route' => 'administrators.index']);

        return $form;
    }

}
