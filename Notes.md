scaffold and new crud https://github.com/laracasts/Laravel-5-Generators-Extended
- `php artisan make:migration:schema create_users_table --schema="username:string, email:string:unique"`  types examples (Table name Plural)

```
username:string
body:text
age:integer
published_at:date
excerpt:text:nullable
email:string:unique:default('foo@example.com')
```

- `php artisan migrate`
- `php artisan backpack:crud <table name singular>`


backback fields
https://backpackforlaravel.com/docs/4.0/crud-fields


Bootstrap form builder used to build application form.  
https://bootstrapformbuilder.com/


Backpack v 4.0
Currently using bootstrap "4.4.1"
uses Jquery