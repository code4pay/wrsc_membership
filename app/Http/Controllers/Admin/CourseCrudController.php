<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Course');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/course');
        $this->crud->setEntityNameStrings('course', 'courses');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setColumns(
            [
                'name' => 'name',
                'description' => 'description',
            ]
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CourseRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->addFields([[
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'],
            [
                'name' => 'description',
                'type' => 'textarea',
                'label' => 'Description'
            ]]
            );
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
