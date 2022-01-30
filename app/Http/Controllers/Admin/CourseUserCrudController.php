<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\CourseUserRequest as StoreRequest;

/**
 * Class CourseUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        if (is_null(backpack_user()) || !(backpack_user()->can('Manage Member Courses') || backpack_user()->can('Modify All'))){
        abort(403, 'You do not have access to this action');
       }

        $this->crud->setModel('App\Models\CourseUser');
        $this->crud->setTitle('Add a Course to User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/courseuser');
        $this->crud->setEntityNameStrings('courseuser', 'course_users');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {

        $this->crud->setTitle('Add a Course to User');
        $userId =  \Request::input('user_id'); // default value
        $this->addDefinedFields($userId);
        $this->crud->setValidation(StoreRequest::class);
        // TODO: remove setFromDb() and manually define Fields
    }

    protected function setupUpdateOperation()
    {
        $userId =  \Request::has('user_id') ? \Request::has('user_id') : false; // default value
        $this->addDefinedFields($userId);
        $this->crud->setValidation(StoreRequest::class);
    }

    protected function addDefinedFields($userId)
    {

        $this->crud->addFields([
            [
                'label' => "User",
                'type' => 'text',
                'name' => 'user_id', // the db column for the foreign key
                'default' => $userId,
                'attributes' => [
                    'class' => '',
                    'readonly' => 'readonly'
                ],

            ],
            [
                'label' => "Course",
                'type' => 'select',
                'name' => 'course_id', // the db column for the foreign key
                'entity' => 'course', // the method that defines the relationship in your Model
                'attribute' => 'name',
            ],
             [
                'label' => "Comment",
                'type' => 'text',
                'name' => 'comment', // the db column for the foreign key
            ],
            [
                'label' => "Course By",
                'type' => 'text',
                'name' => 'course_by', // the db column for the foreign key
            ],
            [
                'label' => "Date Completed",
                'type' => 'date',
                'name' => 'date_completed', // the db column for the foreign key
            ],

        ]);
    }
}
