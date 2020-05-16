<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmailTemplateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
/**
 * Class EmailTemplateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmailTemplateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\EmailTemplate');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/email_template');
        $this->crud->setEntityNameStrings('email_template', 'email_templates');
    }

    protected function setupListOperation()
    {
        $this->addDefinedFields();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EmailTemplateRequest::class);
      
        $this->addDefinedFields();
    }
      /**
     * Store a newly created resource in the database.
     * StoreRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        //Allow new members to be created with out entering a password
        // So set a random one. 
        $this->crud->request = $this->crud->validateRequest();
        $this->crud->request = $this->handlePasswordInput($this->crud->request);
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }


    protected function setupUpdateOperation()
    {
        $this->addDefinedFields();
    }

    protected function addDefinedFields()
    {

        $this->crud->addFields([
            [
                'label' => "Name",
                'type' => 'text',
                'name' => 'name',
            ],
            [
                'label' => "Template",
                'type' => 'summernote',
                'name' => 'template', // the db column for the foreign key
            ],
            [
                'label' => "Description",
                'type' => 'text',
                'name' => 'description', // the db column for the foreign key
            ],
        ]);
    }
}
