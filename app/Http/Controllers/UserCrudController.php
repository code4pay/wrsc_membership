<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
     use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings('Member', 'Members');
        $this->crud->setRoute(backpack_url('user'));
    }

    public function setupListOperation()
    {
        //turns on the export button on the first page. 
        $this->crud->enableExportButtons();


        $this->crud->setColumns([
            [
                'name'  => 'first_name',
                'label' => 'First Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Last Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
            ],

            [ // n-n relationship (with pivot table)
                'label'     => 'Courses', // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'courses',
                'entity'    => 'courses', // the method that defines the relationship in your Model
                'attribute' => 'course.name', // foreign key attribute that is shown to user
                'model'     => '\App\Models\CourseUser', // foreign key model
            ],
        ]);

        //enable the selection of mutiple entries in list. 
        $this->crud->enableBulkActions();

        // Course Filter on Main members list page
        $this->crud->addFilter([
            'name'  => 'course',
            'type'  => 'dropdown',
            'label' => 'Course',
        ],
        \App\Models\Course::all()->pluck('name', 'id')->toArray(),
        function ($value) { // if the filter is active
            $this->crud->addClause('whereHas', 'courses', function ($query) use ($value) {
                $query->where('course_id', '=', $value);
            });
        });

    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->removeField('courses');

        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        if (!$this->crud->settings()['update.access']) {abort(403, 'You do not have access to this action');}
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->request->get('id') ?? \Request::instance()->segment($routeSegmentWithId);
        $user = $userModel->find($userId);
        if (!$user) {
            abort(400, 'Could not find that entry in the database.');
        }
        $this->addUserFields($user);
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->request = $this->crud->validateRequest();
        $this->crud->request = $this->handlePasswordInput($this->crud->request);
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {

        $this->crud->request = $this->crud->validateRequest();
        $this->crud->request = $this->handlePasswordInput($this->crud->request);
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields(\App\Models\BackpackUser $user=NULL)
    {
        $user_id = NULL;
        if (isset($user)) {$user_id = $user->id;}
        $this->crud->addFields([
            [
                'name'  => 'first_name',
                'label' => 'First Name',
                'type'  => 'text',
                'allows_null' => false,
            ],
            [
                'name'  => 'last_name',
                'label' => 'Last Name',
                'type'  => 'text',
                'allows_null' => false,
            ],
            [
                'tab' => 'main',
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
                'allows_null' => false,
                'attributes' => ["autocomplete" => "new-password"],
            ],
            [
                'tab' => 'main',
                'name'  => 'password',
                'label' => 'Password',
                'type'  => 'password',
                'attributes' => ["autocomplete" => "new-password"],
            ],
            [
                'tab' => 'main',
                'name'  => 'password_confirmation',
                'label' => 'Password Confrimation',
                'type'  => 'password',
                'attributes' => ["autocomplete" => "off"],
            ],
            [   
                'tab' => 'main',
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<hr/>'
            ],
            [  
                'label' => "Region",
                'type' => 'select',
                'name' => 'region_id', // the db column for the foreign key
                'entity' => 'region', // the method that defines the relationship in your Model
                'attribute' => 'region_name', // foreign key attribute that is shown to user
                'model' => "App\Models\Region" // foreign key model
            ],
            [
                'tab' => 'main',
                'name'  => 'address',
                'label' => 'Street Address Postal',
                'type'  => 'text',
                'allows_null' => false,
            ],    
            [
                'tab' => 'main',
                'name'  => 'city',
                'label' => 'City/Suburb Postal',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],    
            [
                'tab' => 'main',
                'name'  => 'post_code',
                'label' => 'Post Code Postal',
                'type'  => 'text',
                'attributes' => ['maxlength' =>4],
                'wrapperAttributes' => [    'class' => 'col-md-3'],
                'allows_null' => false,
            ],
            [   
                'tab' => 'main',
                'name' => 'separator2',
                'type' => 'custom_html',
                'value' => '<hr>'
            ],
            [
                'tab' => 'main',
                'name'  => 'address_residential',
                'label' => 'Street Address Residential',
                'type'  => 'text',
                'allows_null' => false,
            ],    
            [
                'tab' => 'main',
                'name'  => 'city_residential',
                'label' => 'City/Suburb Residential',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],    
            [
                'tab' => 'main',
                'name'  => 'post_code_residential',
                'label' => 'Post Code Residential',
                'type'  => 'text',
                'attributes' => ['maxlength' =>4],
                'wrapperAttributes' => [   'class' => 'col-md-4'],
                'allows_null' => false,
            ],
                [
                // two interconnected entities
                'tab' => 'permissions',
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
            [
                'tab' => 'Courses',
                'label' => 'Courses Completed',
                'type'  => 'courses_completed',
                'name'  => 'courses',
                'model'   => 'App\Models\CourseUser',
            ],

            [
                'tab' => 'Membership Details',
                'name'  => 'member_number',
                'label' => 'Membership Number',
                'type'  => 'text',
                'wrapperAttributes' => [    'class' => 'col-md-4']
            ],    
            [
                'label' => "Primary Member",
                'type' => 'select2',
                'placeholder' => "Select a category",
                'minimum_input_length' => 2,
                'name' => 'primary_member_id', // the method that defines the relationship in your Model
                'entity' => 'primary',
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'options'   => (function ($query) use($user_id) {
                    return $query->whereNull('primary_member_id')->where('id', '<>', $user_id)->get();
                }), 
                                #'data_source' => url("/api/primary_user"),
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'wildman_number',
                'label' => 'Wildman Number',
                'type'  => 'text',
                'wrapperAttributes' => [    'class' => 'col-md-4']
            ],    
            [  
                'label' => "Member Type",
                'type' => 'select',
                'name' => 'member_type_id', // the db column for the foreign key
                'entity' => 'memberType', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Membershiptype" // foreign key model
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'joined',
                'label' => 'Date Joined',
                'type'  => 'date',
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'paid_to',
                'label' => 'Paid To',
                'type'  => 'date',
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_date',
                'label' => 'Last Lyssa Test Date',
                'type'  => 'date',
                'wrapperAttributes' => [    'class' => 'col-md-4']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_value',
                'label' => 'Lyssa Serology Level',
                'type'  => 'number',
                'wrapperAttributes' => [    'class' => 'col-md-4']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'tac_date',
                'label' => 'Terms and Conditions Acceptance Date',
                'type'  => 'date',
            ],
            [
                'tab' => 'Siblings',
                'label' => 'Siblings',
                'type'  => 'sibling_members',
                'name'  => 'sibling',
                'model'   => 'App\Models\CourseUser',
            ],

            [
               'tab' => 'Comments', 
                'name' =>'comments',
                'type' => 'repeatable2',
                'fields' => [
                    [   // Textarea
                        'name' => 'comment',
                        'label' => 'Comment',
                        'type' => 'textarea'
                    ],

                ]
            ]

        ]);
    }
}
