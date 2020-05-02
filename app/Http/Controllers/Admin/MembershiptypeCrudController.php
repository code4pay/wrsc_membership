<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MembershiptypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MembershiptypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MembershiptypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Membershiptype');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/membershiptype');
        $this->crud->setEntityNameStrings('Membership type', 'Membership Types');
    }

    protected function setupListOperation()
    {

     //if(!backpack_user()->hasPermissionTo('manage membership types')) { abort(403, 'You do not have access to this');}
      //  dd($this->crud->settings());
      //  if (!$this->crud->settings()['update.access']) {abort(403, 'You do not have access to this action');}
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MembershiptypeRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
