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
use App\User;
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
    use \Backpack\ReviseOperation\ReviseOperation;
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
                'label' => "Paid To", // Table column heading
                'type' => "date",
                'name' => 'paid_to', // the column that contains the ID of that connected entity;
            ]
        );
        $this->crud->addColumn(
            [
                'label' => "Pending Approval",
                'type' => "boolean",
                'name' => "pending_approval"
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
        $this->crud->addColumn(
        [
            // n-n relationship (with pivot table)
            'label' => "Courses", // Table column heading
            'type' => "select_multiple",
            'name' => 'courses', // the method that defines the relationship in your Model
            'entity' => 'course', // the method that defines the relationship in your Model
            'attribute' => "course.name", // foreign key attribute that is shown to user
            'model' => "App\Models\CourseUser", // foreign key model
         ]);
         $this->crud->addColumn(
            [
                // n-n relationship (with pivot table)
                'label' => "Authorities", // Table column heading
                'type' => "select_multiple",
                'name' => 'authorities', // the method that defines the relationship in your Model
                'entity' => 'authoritie', // the method that defines the relationship in your Model
                'attribute' => "authority.name", // foreign key attribute that is shown to user
                'model' => "App\Models\AuthoritiesUser", // foreign key model
             ]);
    }



    public function setupListOperation()
    {
        
        if (!backpack_user()->can('Modify All')){
            if (!backpack_user()->can('Read All')){
                $this->crud->denyAccess('update');
            }
            $this->crud->denyAccess('create');
            $this->crud->denyAccess('revisions');
        }
        if (!backpack_user()->can('Read All')){
            $this->crud->denyAccess('show');
        }
        //turns on the export button on the first page. 
        $this->crud->enableExportButtons();

        // Custom buttons on the bottom of the list
        if(backpack_user()->can('Send Renewals')){
        $this->crud->addButtonFromView('bottom', 'email', 'email', 'beginning'); #membership renewals
        $this->crud->addButtonFromView('bottom', 'print', 'print', 'beginning');#membership renewals
        }
        if(backpack_user()->can('Print Membership Cards')){
        $this->crud->addButtonFromView('bottom', 'print_membership_card', 'print_membership_card', 'beginning');#membership renewals
        $this->crud->addButtonFromView('bottom', 'email_membership_card', 'email_membership_card', 'beginning');#membership renewals
        }

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
            ]
        ]);
        if (backpack_user()->can('Read Email Address') || backpack_user()->can('Read All') ){
        $this->crud->addColumns([
             [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
            ]
        ]);
        }
        if (backpack_user()->can('Read Phone Numbers') ){
        $this->crud->addColumns([
             [
                'name'  => 'mobile',
                'label' => 'Mobile',
                'type'  => 'text',
            ],
            [

                'name'  => 'home_phone',
                'label' => 'Home Phone',
                'type'  => 'text',
            
            ]
        ]);
        }
         if( backpack_user()->can('Read All')){
            $this->crud->addColumns([
            [
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
            ]
            ]);
        }
         if( backpack_user()->can('Read Authorities')){
             $this->crud->addColumn(
            [ // n-n relationship (with pivot table)
                'label'     => 'Authorities', // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'authorities',
                'entity'    => 'authorities', // the method that defines the relationship in your Model
                'attribute' => 'authority.name', // foreign key attribute that is shown to user
                'model'     => '\App\Models\AuthorityUser', // foreign key model
            ]);
         }

         if( backpack_user()->can('Read All')){
            $this->crud->addColumns([
            [
                'name'  => 'dont_renew',
                'label' => 'No Renew',
                'type'  => 'boolean',
            ],
            [
                'name'  => 'paid_to',
                'label' => 'Paid To',
                'type'  => 'date',
            ],
            [
                'name'  => 'paid_paypal_date',
                'label' => 'Paid PayPal',
                'type'  => 'date',
            ],
             [ 
                 'name' => 'member_number',
                 'label' => 'Member Number',
                 'type' => 'text'
             ],
             [
                 'name' => 'wildman_number',
                 'label' => 'Wildman Number',
                 'type' => 'text'
             ],
             [
                'name' => 'primary_member',
                'label' => 'Primary Member',
                'type' => 'fullname'
             ],
             [
                'name' => 'pending_approval',
                'label' => 'Pending Approval',
                'type' => 'boolean'
             ],
             [
                 'name' => 'address',
                 'label' => 'Address',
                 'type' => 'text'
             ],
             [
                 'name' => 'post_code',
                 'label' => 'Postcode',
                 'type' => 'text'
             ],
             [
                 'name' => 'joined',
                 'label' => 'Joined date',
                 'type' => 'date'
             ]



          
        ]);
        }

//Start of Filters

        //enable the selection of mutiple entries in list. 
        $this->crud->enableBulkActions();

         if( backpack_user()->can('Read All')){
      
        // Course Filter on Main members list page
        $this->crud->addFilter(
            [
                'name'  => 'course',
                'type'  => 'select2_multiple',
                'label' => 'Course',
            ],
            \App\Models\Course::all()->pluck('name', 'id')->toArray(),
            function ($values) { // if the filter is active
                
             $this->crud->addClause('whereHas', 'courses', function ($query) use ($values) {
                    $query->where(function($subQuery) use ($values) {
                     foreach (json_decode($values) as $key => $value) {
                         $subQuery->orWhere('course_id', '=', $value);
                        
                        }
                    });
                    });
                
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
                    
                $this->crud->addClause('whereHas', 'authorities', function ($query) use ($values) {
                    $query->where(function($subQuery) use ($values) {
                     foreach (json_decode($values) as $key => $value) {
                         $subQuery->orWhere('authority_id', '=', $value);
                        
                        }
                    });
                    });
                
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
                $this->crud->addClause('where', function ($query) use ($values) {
                foreach (json_decode($values) as $key => $value) {
                   
                            $query->orWhere('region_id','=', $value);
                }
            });
            }
        );
        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'member_number',
                'label' => 'M.Number'
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'member_number','=', $value);
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
                $this->crud->addClause('where', function ($query) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                       
                                $query->orWhere('member_type_id','=', $value);
                    }
                });
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

        $this->crud->addFilter([ // simple filter
            'type' => 'simple',
            'name' => 'paid_paypal_date',
            'label'=> 'Paid Paypal'
          ], 
          false, 
          function() { // if the filter is active
               $this->crud->addClause('whereNotNull', 'paid_paypal_date' ); // apply the "active" eloquent scope 
          } );

        $this->crud->addFilter([ // simple filter
            'type' => 'simple',
            'name' => 'dont_renew',
            'label'=> 'Dont Renew'
          ], 
          false, 
          function() { // if the filter is active
               $this->crud->addClause('where', 'dont_renew', 1 ); 
          } );
        $this->crud->addFilter([ // simple filter
            'type' => 'simple',
            'name' => 'tac_email_date',
            'label'=> 'Not Emailed'
          ], 
          false, 
          function() { // if the filter is active
               $this->crud->addClause('whereNull', 'tac_email_date' ); 
          } );  

        $this->crud->addFilter([ // simple filter
            'type' => 'simple',
            'name' => 'pending_approval',
            'label'=> 'Pending Approval'
          ], 
          false, 
          function() { // if the filter is active
               $this->crud->addClause('where', 'pending_approval', 1 ); 
          } );  

        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'tac_date',
            'label'=> 'T&C'
          ], 
          [
             1 =>'Accepted',
             2 => 'Not Accepted'
          ],
          function($value) { 
              if ($value == 1) {
               $this->crud->addClause('whereNotNull', 'tac_date' ); 
              } else {
               $this->crud->addClause('whereNull', 'tac_date' ); 
              }
          } );  


        } // End of "Read All" Permission limit. 

          // This is a default filter to not list non active members
          $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'inactive_members',
            'label' => 'Show Inactive Members',
          ],
          false, // the simple filter has no values, just the "Draft" label specified above
          function () { // if the filter is active (the GET parameter "checkbox" exits)
              $this->crud->addClause('where', 'member_type_id', '=','8');
          },
          function () { // if the filter is NOT active (the GET parameter "checkbox" does not exit)
              $this->crud->addClause('where', 'member_type_id', '<>','8');
          });



    }

    public function setupCreateOperation()
    {
       if (!backpack_user()->can('Modify All')){
        abort(403, 'You do not have access to this action');
       }
        $this->addUserFields();
        $this->crud->removeField('courses');
        $this->crud->removeField('authorities');

        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
       if (!backpack_user()->can('Modify All')&&!backpack_user()->can('Read All') ){
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
        $this->crud->getRequest()->request->set('password', $password);
        $this->crud->getRequest()->request->set('password_confirmation', $password);
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $latest_membership_id = BackpackUser::max('member_number');
        if (!$request->input('member_number')) {
            $this->crud->getRequest()->request->set('member_number', $latest_membership_id + 1);
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

       if (!backpack_user()->can('Modify All')){
        abort(403, 'You do not have access to this action');
       }
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
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
    * @return App\User
    */
    protected function getUser()
    {
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->crud->getRequest()->get('id') ?? \Request::instance()->segment($routeSegmentWithId);
        $user = $userModel->find($userId);
        if (!$user) {
            abort(400, 'Could not find that entry in the database.');
        }
    }


    protected function addUserFields(\App\User $user = NULL)
    {
        $user_id = NULL;
        if (isset($user)) {
            $user_id = $user->id;
        }
        $crud_fields = [
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
                'label' => "Region",
                'type' => 'select',
                'name' => 'region_id', // the db column for the foreign key
                'entity' => 'region', // the method that defines the relationship in your Model
                'attribute' => 'region_name', // foreign key attribute that is shown to user
                'model' => "App\Models\Region" // foreign key model
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
                'label' => "Member Type",
                'type' => 'select',
                'name' => 'member_type_id', // the db column for the foreign key
                'entity' => 'memberType', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Membershiptype", // foreign key model
                'wrapper' => ['class' => 'col-md-4']
            ],
            [   // select2_from_array
                'name' => 'dob',
                'label' => "Year Of Birth (Only if less than 18)",
                'type' => 'select2_from_array',
                'options' => [
                   
                    '2000' => '2000',
                    '2001' => '2001',
                    '2002' => '2002',
                    '2003' => '2003',
                    '2004' => '2004',
                    '2005' => '2005',
                    '2006' => '2006',
                    '2007' => '2007',
                    '2008' => '2008',
                    '2009' => '2009',
                    '2010' => '2010',
                    '2011' => '2011',
                    '2012' => '2012',
                    '2013' => '2013',
                    '2014' => '2014',
                    '2015' => '2015',
                    '2016' => '2016',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019',
                    '2020' => '2020',
                    '2021' => '2021',
                    '2022' => '2022',
                ],
                'allows_null' => true,
                'default' =>null,
                'wrapper' => ['class' => 'col-md-4']
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
                'wrapper' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'post_code',
                'label' => 'Post Code Postal',
                'type'  => 'text',
                'attributes' => ['maxlength' => 4],
                'wrapper' => ['class' => 'col-md-3'],
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
                'wrapper' => ['class' => 'col-md-4'],
                'allows_null' => false,
            ],
            [
                'tab' => 'Main',
                'name'  => 'post_code_residential',
                'label' => 'Post Code Residential',
                'type'  => 'text',
                'attributes' => ['maxlength' => 4],
                'wrapper' => ['class' => 'col-md-4'],
                'allows_null' => false,
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
                'wrapper' => ['class' => 'col-md-6']
            ],
 
            [
                'tab' => 'Membership Details',
                'name'  => 'wildman_number',
                'label' => 'Wildman Number',
                'type'  => 'text',
                'wrapper' => ['class' => 'col-md-6']
            ],
           
            [
                'tab' => 'Membership Details',
                'name'  => 'joined',
                'label' => 'Date Joined',
                'type'  => 'date',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'tac_date',
                'label' => 'Terms and Conditions Acceptance Date',
                'type'  => 'date',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'receipt_date',
                'label' => 'Payment Received Date (D/D)',
                'type'  => 'date',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'receipt_number',
                'label' => 'Receipt Number and Amount',
                'type'  => 'text',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'paid_to',
                'label' => 'Paid To',
                'type'  => 'date',
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'paid_paypal_date',
                'label' => 'PayPal Payment Date',
                'type'  => 'date',
                'wrapper' => ['readonly' => 'readonly']
            ],

            [
                'tab' => 'Membership Details',
                'name'  => 'paid_paypal_amount',
                'label' => 'PayPal Payment Amount',
                'type'  => 'number',
                'prefix' => '$',
                'wrapper' => ['readonly' => 'readonly']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_date',
                'label' => 'Last Lyssa Test Date',
                'type'  => 'date',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_value',
                'label' => 'Lyssa Serology Level',
                'type'  => 'number',
                'wrapper' => ['class' => 'col-md-6']
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'lyssa_serology_comment',
                'label' => 'Lyssa Serology comment',
                'type'  => 'text',
            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'pending_approval',
                'label' => 'Pending Approval',
                'type'  => 'checkbox',
                'wrapper' => ['class' => 'col-md-4'],

            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'dont_renew',
                'label' => 'Do Not Renew',
                'type'  => 'checkbox',
                'wrapper' => ['class' => 'col-md-4'],

            ],
            [
                'tab' => 'Membership Details',
                'name'  => 'tac_email_date',
                'label' => 'T&C Sent',
                'type'  => 'date',
                'wrapper' => ['class' => 'col-md-4'],

            ],


            [
                'tab' => 'Membership Details',
                'label' => "Profile Image",
                'name' => "image",
                'type' => 'image',
                'upload' => true,
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
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
            [   
                'tab' => 'Documents',
                'name' => 'documents',
                'label' => 'Documents',
                'type' => 'upload_multiple',
                'upload' => true,
                'disk' => 'private', 
            ],

        ];

        if (!backpack_user()->can('Modify All')) {
            if (backpack_user()->can('Read All')) {
                foreach ($crud_fields as &$crud_field) {
                    $crud_field["attributes"] = ["readonly" => "readonly", "disabled" => "disabled"];
                }
            }
        }
        $this->crud->addFields($crud_fields);
        if (backpack_user()->hasRole('admin')){
            $this->crud->addFields([
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
            ]);
        }

    }
}
