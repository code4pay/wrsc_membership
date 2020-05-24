<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Blade;
use App\Models\EmailTemplate;
use App\Mail\MemberRenewalRequest;
use App\Models\BackpackUser;
use Illuminate\Support\Facades\Mail;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    #use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings('Member', 'Members');
        $this->crud->setRoute(backpack_url('user'));
    }
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumn(
            [
                'label' => "First Name", // Table column heading
                'type' => "text",
                'name' => 'first_name', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Last Name", // Table column heading
                'type' => "text",
                'name' => 'last_name', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Email", // Table column heading
                'type' => "email",
                'name' => 'email', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                // 1-n relationship
                'label' => "Region", // Table column heading
                'type' => "select",
                'name' => 'region_id', // the column that contains the ID of that connected entity;
                'entity' => 'region', // the method that defines the relationship in your Model
                'attribute' => "region_name", // foreign key attribute that is shown to user
                'model' => "App\Models\Region", // foreign key model
            ]
        );
        $this->crud->addColumn(
            [
                // 1-n relationship
                'label' => "Member Type", // Table column heading
                'type' => "select",
                'name' => 'member_type_id', // the column that contains the ID of that connected entity;
                'entity' => 'memberType', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Membershiptype", // foreign key model
            ]
        );
        $this->crud->addColumn(
            [
                // run a function on the CRUD model and show its return value
                'name' => "postal_address_formatted",
                'label' => "Postal Address", // Table column heading
                'type' => "model_function",
                'function_name' => 'formattedPostalAddress', // the method in your Model
            ]
        );
        $this->crud->addColumn(
            [
                // run a function on the CRUD model and show its return value
                'name' => "residential_address_formatted",
                'label' => "Residential Address", // Table column heading
                'type' => "model_function",
                'function_name' => 'formattedResidentialAddress', // the method in your Model
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Member Id", // Table column heading
                'type' => "text",
                'name' => 'member_number', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Wildman Number", // Table column heading
                'type' => "text",
                'name' => 'wildman_number', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Mobile", // Table column heading
                'type' => "telephone",
                'name' => 'mobile', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Home Phone", // Table column heading
                'type' => "telephone",
                'name' => 'home_phone', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Date Joined", // Table column heading
                'type' => "date",
                'name' => 'joined', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "paid until", // Table column heading
                'type' => "date",
                'name' => 'paid_until', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Lyssa Date", // Table column heading
                'type' => "date",
                'name' => 'lyssa_serology_date', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Lyssa Value", // Table column heading
                'type' => "integer",
                'name' => 'lyssa_serology_value', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'name'  => 'lyssa_serology_comment',
                'label' => 'Lyssa Serology comment',
                'type'  => 'text',
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Primary Member", // Table column heading
                'type' => "boolean",
                'name' => 'last_name', // the column that contains the ID of that connected entity;
            ]
        );

        $this->crud->addColumn(
            [
                'label' => "Terms and Conditions Date", // Table column heading
                'type' => "date",
                'name' => 'tac_date', // the column that contains the ID of that connected entity;
            ]
        );
    }
    public function bladeCompile($value, array $args = array())
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.
        try {
            eval('?>' . $generated);
        }

        // If we caught an exception, we'll silently flush the output
        // buffer so that no partially rendered views get thrown out
        // to the client and confuse the user with junk.
        catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        $content = ob_get_clean();

        return $content;
    }


    public function emailRenewal(BackpackUser $user)
    {
        if (!$user) {
            abort(400, 'Could not find that user.');
        }
        //return (new MemberRenewalRequest($user))->render();
        Mail::to($user)->send(new MemberRenewalRequest($user));
        $user->addComment('Emailed Renewal Request with total amount Payable $' . $user->totalRenewalAmount());
    }

    public function setupListOperation()
    {
        //turns on the export button on the first page. 
        $this->crud->enableExportButtons();

        // Custom buttons on the bottom of the list
        $this->crud->addButtonFromView('bottom', 'email', 'email', 'beginning');
        $this->crud->addButtonFromView('bottom', 'print', 'print', 'beginning');

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
            ],

            [ // n-n relationship (with pivot table)
                'label'     => 'Region', // Table column heading
                'type'      => 'select',
                'name'      => 'region_id',
                'entity'    => 'region', // the method that defines the relationship in your Model
                'attribute' => 'region_name', // foreign key attribute that is shown to user
            ],
            [
                'name'  => 'city',
                'label' => 'City',
                'type'  => 'text',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => 'Type', // Table column heading
                'type'      => 'select',
                'name'      => 'member_type_id',
                'entity'    => 'memberType', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
            ],
            [ // n-n relationship (with pivot table)
                'label'     => 'Authorities', // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'authorities',
                'entity'    => 'authorities', // the method that defines the relationship in your Model
                'attribute' => 'authority.name', // foreign key attribute that is shown to user
                'model'     => '\App\Models\AuthorityUser', // foreign key model
            ],

            [
                'name'  => 'lyssa_serology_value',
                'label' => 'Lyssa Value',
                'type'  => 'text',
            ],
            [
                'name'  => 'lyssa_serology_date',
                'label' => 'Lyssa Date',
                'type'  => 'date',
            ],
            [
                'name'  => 'lyssa_serology_comment',
                'label' => 'Lyssa Serology comment',
                'type'  => 'text',
            ]
        ]);

        //enable the selection of mutiple entries in list. 
        $this->crud->enableBulkActions();

        // Course Filter on Main members list page
        $this->crud->addFilter(
            [
                'name'  => 'course',
                'type'  => 'select2_multiple',
                'label' => 'Course',
            ],
            \App\Models\Course::all()->pluck('name', 'id')->toArray(),
            function ($values) { // if the filter is active
                foreach (json_decode($values) as $key => $value) {
                    $this->crud->addClause('whereHas', 'courses', function ($query) use ($value) {
                        $query->orwhere('course_id', '=', $value);
                    });
                }
            }
        );


        $this->crud->addFilter(
            [
                'name'  => 'autorities',
                'type'  => 'select2_multiple',
                'label' => 'Authorities',
            ],
            \App\Models\Authority::all()->pluck('name', 'id')->toArray(),
            function ($values) { // if the filter is active
                foreach (json_decode($values) as $key => $value) {
                    $this->crud->addClause('whereHas', 'authorities', function ($query) use ($value) {
                        $query->orWhere('authority_id', '=', $value);
                    });
                }
            }
        );
        $this->crud->addFilter(
            [
                'name'  => 'regions',
                'type'  => 'select2_multiple',
                'label' => 'Region',
            ],
            \App\Models\Region::all()->pluck('region_name', 'id')->toArray(),
            function ($values) { // if the filter is active
                foreach (json_decode($values) as $key => $value) {
                    $this->crud->addClause('orwhere', 'region_id', $value);
                }
            }
        );
        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'city',
                'label' => 'City'
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'city_residential', 'LIKE', "%$value%");
            }
        );
        $this->crud->addFilter(
            [
                'name'  => 'memberType',
                'type'  => 'select2_multiple',
                'label' => 'Member Type',
            ],
            \App\Models\Membershiptype::all()->pluck('name', 'id')->toArray(),
            function ($values) { // if the filter is active
                foreach (json_decode($values) as $key => $value) {
                    $this->crud->addClause('Where', 'member_type_id', $value);
                }
            }
        );
        $this->crud->addFilter(
            [
                'type' => 'dropdown',
                'name' => 'paid_to',
                'label' => 'Paid To'
            ],
            [
                '2018-06-30' => '2018-06-30',
                '2019-06-30' => '2019-06-30',
                '2020-06-30' => '2020-06-30',
                '2021-06-30' => '2021-06-30',
                '2022-06-30' => '2022-06-30',
                '2023-06-30' => '2023-06-30',
                '2023-06-30' => '2023-06-30',
                '2024-06-30' => '2024-06-30',
                '2025-06-30' => '2025-06-30',
                '2026-06-30' => '2026-06-30',
                '2027-06-30' => '2027-06-30',
                '2028-06-30' => '2028-06-30',
                '2029-06-30' => '2029-06-30',
                '2030-06-30' => '2030-06-30',
                '2031-06-30' => '2031-06-30',
                '2032-06-30' => '2032-06-30',
                '2033-06-30' => '2033-06-30',
                '2034-06-30' => '2034-06-30',
                '2035-06-30' => '2035-06-30',
            ],
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'paid_to', $value);
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->removeField('courses');
        $this->crud->removeField('authorities');

        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        if (!$this->crud->settings()['update.access']) {
            abort(403, 'You do not have access to this action');
        }
        $user = $this->getUser();
        $this->addUserFields($user);
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     * StoreRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        //Allow new members to be created with out entering a password
        // So set a random one. 
        $password = str_random(50);
        $this->crud->request->request->set('password', $password);
        $this->crud->request->request->set('password_confirmation', $password);
        $this->crud->request = $this->crud->validateRequest();
        $this->crud->request = $this->handlePasswordInput($this->crud->request);
        $latest_membership_id = BackpackUser::max('member_number');
        if (!$request->input('member_number')) {
            $this->crud->request->request->set('member_number', $latest_membership_id + 1);
        }
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

    /*
    * @return App\Models\BackpackUser
    */
    protected function getUser()
    {
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->request->get('id') ?? \Request::instance()->segment($routeSegmentWithId);
        $user = $userModel->find($userId);
        if (!$user) {
            abort(400, 'Could not find that entry in the database.');
        }
    }


    protected function addUserFields(\App\Models\BackpackUser $user = NULL)
    {
        $user_id = NULL;
        if (isset($user)) {
            $user_id = $user->id;
        }
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
                'tab' => 'Main',
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
                'allows_null' => false,
                'attributes' => ["autocomplete" => "new-password"],
            ],
            [
                'tab' => 'Main',
                'name'  => 'mobile',
                'label' => 'Mobile Phone',
                'type'  => 'text',
            ],
            [
                'tab' => 'Main',
                'name'  => 'home_phone',
                'label' => 'Home Phone',
                'type'  => 'text',
            ],

            [
                'tab' => 'Main',
                'name'  => 'password',
                'label' => 'Password',
                'type'  => 'password',
                'attributes' => ["autocomplete" => "new-password"],
            ],
            [
                'tab' => 'Main',
                'name'  => 'password_confirmation',
                'label' => 'Password Confirmation',
                'type'  => 'password',
                'attributes' => ["autocomplete" => "off"],
            ],
            [
                'tab' => 'Main',
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
                'tab' => 'Main',
                'name'  => 'address',
                'label' => 'Street Address Postal',
                'type'  => 'text',
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'city',
                'label' => 'City/Suburb Postal',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'post_code',
                'label' => 'Post Code Postal',
                'type'  => 'text',
                'attributes' => ['maxlength' => 4],
                'wrapperAttributes' => ['class' => 'col-md-3'],
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name' => 'separator2',
                'type' => 'custom_html',
                'value' => '<hr>'
            ],
            [
                'tab' => 'Main',
                'name'  => 'address_residential',
                'label' => 'Street Address Residential',
                'type'  => 'text',
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'city_residential',
                'label' => 'City/Suburb Residential',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'post_code_residential',
                'label' => 'Post Code Residential',
                'type'  => 'text',
                'attributes' => ['maxlength' => 4],
                'wrapperAttributes' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],
            [
                // two interconnected entities
                'tab' => 'Permissions',
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
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'label' => "Primary Member",
                'type' => 'select2',
                'placeholder' => "Select a category",
                'minimum_input_length' => 2,
                'name' => 'primary_member_id', // the method that defines the relationship in your Model
                'entity' => 'primary',
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'options'   => (function ($query) use ($user_id) {
                    return $query->whereNull('primary_member_id')->where('id', '<>', $user_id)->get();
                }),
                #'data_source' => url("/api/primary_user"),
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'wildman_number',
                'label' => 'Wildman Number',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-6']
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
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'tac_date',
                'label' => 'Terms and Conditions Acceptance Date',
                'type'  => 'date',
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'receipt_date',
                'label' => 'Receipt Date',
                'type'  => 'date',
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'receipt_number',
                'label' => 'Receipt Number',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'col-md-6']
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
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_value',
                'label' => 'Lyssa Serology Level',
                'type'  => 'number',
                'wrapperAttributes' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_comment',
                'label' => 'Lyssa Serology comment',
                'type'  => 'text',
            ],

            [
                'tab' => 'Membership Details',
                'label' => "Profile Image",
                'name' => "image",
                'type' => 'image',
                'upload' => true,
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                // 'disk' => 's3_bucket', // in case you need to show images from a different disk
                //'prefix' => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],

            [
                'tab' => 'Family members',
                'label' => 'family',
                'type'  => 'sibling_members',
                'name'  => 'sibling'
            ],

            [
                'tab' => 'Comments',
                'name' => 'comments',
                'type' => 'repeatable2',
                'fields' => [
                    [   // Textarea
                        'name' => 'comment',
                        'label' => 'Comment',
                        'type' => 'textarea'
                    ],
                    [
                        'name' => 'date',
                        'label' => 'date',
                        'type' => 'date',
                        'wrapper' => ['class' => 'd-none']
                    ],
                    [
                        'name' => 'author',
                        'label' => 'Author',
                        'type' => 'text'
                    ]

                ]
            ],
            [
                'tab' => 'Authorities',
                'label' => 'Authorities',
                'type'  => 'authorities',
                'name'  => 'authorities',
                'model'   => 'App\Models\AuthoritiesUser',
            ],

        ]);
    }
}
