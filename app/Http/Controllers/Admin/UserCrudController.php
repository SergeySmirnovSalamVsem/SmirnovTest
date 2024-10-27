<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserCrudController extends CrudController
{
    public function setup(): void
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('username');
        CRUD::column('is_blocked')->type('checkbox');
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::field('name')->type('text');
        CRUD::field('username')->type('text');
        CRUD::field('is_blocked')->type('checkbox');
    }
}
