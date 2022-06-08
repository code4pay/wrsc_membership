# Notes

This project is based on Laravel and Backpack. 
- https://laravel.com/ (8.61.0)
- https://backpackforlaravel.com/ (v4.1)

## setting up database for dev
In the root dir of the project run `php artisan migrate:fresh`
The to add the first user ` php artisan wrsc:member`  it will then prompt you for the fields. 
you should then be able to login.  If using Homestead it will be `http://localhost:8000` 

To add things like courses etc run `artisan db:seed` 

Then you can give admin permissions to the first user with this SQL

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\User', '1');

## Adding a new table 
To add a new database table to the Admin panel with a link on the left hand side. 
First run the schema generator to create the migration and the model 
https://github.com/laracasts/Laravel-5-Generators-Extended
- `php artisan make:migration:schema create_users_table --schema="username:string, email:string:unique" --model=0`  types examples (Table name Plural)  include the option to not make a model `--model=0` 
as we will create this later (if you do just delete the file under `app`)

these are the field options, Note that id Created_at and update_at  are automatically included. 
```
username:string
body:text
age:integer
published_at:date
excerpt:text:nullable
email:string:unique:default('foo@example.com')
```

Then run - `php artisan migrate` to  create the table in your database. 

To create the controller run  `php artisan backpack:crud <table name singular>`

It will also
- Add a link from the admin panel.  `resources/views/vendor/backpack/base/inc/sidebar_content.blade.php` add the link where appropriate in a `<LI>` 
- Add a route to make the controller accessible  to here `routes/backpack/custom.php` 

You will want to add the `$fillable` variable so that results get saved. 
Example:
```
    protected $fillable = 
        
        'region_name',
        'description',
    ];
 ``` 



To create seeds for tables
`php artisan iseed {table_name}`  Note  create the `seeders` dir first and then copy the results over
it will error out but just copy the file over to `seeds` and update the `DatabaseSeeder.php` file in that dir. 
Make sure you run ` composer dump-autoload ` when updating classes etc. 


## Adding or changing fields that appear on a form. 
Check the `app/Http/Controllers/UserCrudController.php` for examples 
These are the fields you add to your controller for them to show up on the form 
Backback fields
https://backpackforlaravel.com/docs/4.1/crud-fields





# Form builder
if you want to build a complex (non Backpack) form this is good. Choose the right version of Bootstrap. 
Bootstrap form builder used to build application form.  
https://bootstrapformbuilder.com/


## Technologies used. 
MySQL 
Backpack v 4.1
Currently using bootstrap "4.4.1"
uses Jquery


## VSCode settings

### Debug (When using Homestead (Vagrant))

`launch.json` Setting

```
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "externalConsole": false,
            "log":true,
            "pathMappings": {
                "/home/vagrant/wrsc": "${workspaceFolder}"
            },
            "ignore": [
            ]
        }
    ]
}
```

xdebug setting

```
xdebug.remote_handler=dbgp
zend_extension=xdebug.so
xdebug.remote_enable = 1
xdebug.remote_port = 9000
xdebug.max_nesting_level = 512
xdebug.remote_autostart=1
xdebug.remote_host=10.0.2.2
xdebug.remote_log="/tmp/xdebug.log"
xdebug.remote_connect_back=0
xdebug.default_enable=1
xdebug.idekey=VSCODE
```

# Production Release
- Pull new master
- run `composer dump-autoload`
- run `composer clear-cache`
- Add any new settings to .env
- run `php artisan config:clear` 
- run `php artisan migrate` to apply DB changes
- run `npm run production` to apply js and css changes

# Homestead
Some notes on using Homestead 
to set the php version for the cli `sudo update-alternatives --config php` 
