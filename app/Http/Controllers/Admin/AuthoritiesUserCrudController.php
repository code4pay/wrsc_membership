<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthoritiesUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\User; 
/**
 * Class AuthoritiesUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AuthoritiesUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\AuthoritiesUser');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/authoritiesuser');
        $this->crud->setEntityNameStrings('authoritiesuser', 'authorities_users');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {       
         $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $userId =  \Request::input('user_id'); // default value
        $user = $userModel->find($userId);
        $this->addDefinedFields($user);
        //$this->crud->setValidation(StoreRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $userId =  \Request::input('user_id'); // default value
        $user = $userModel->find($userId);
        $this->addDefinedFields($user);
        $this->crud->setValidation(StoreRequest::class);
    }
    protected function addDefinedFields($user)
    {
        $userId = null;
        if (isset($user)) { $userId = $user->id;}
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
                'label' => "Authority",
                'type' => 'select',
                'name' => 'authority_id', // the db column for the foreign key
                'entity' => 'authority', // the method that defines the relationship in your Model
                'attribute' => 'name',
            ],
            [
                'label' => "Comment",
                'type' => 'textarea',
                'name' => 'comment', 
            ],
            [
                'label' => "Date Authorised",
                'type' => 'date',
                'name' => 'date_authorised', 
            ],
            // [   // Upload
            //     'name'   => 'upload',
            //     'label'  => 'Upload',
            //     'type'   => 'upload',
            //     'upload' => true,

            // ]
        ]);
    }
}
