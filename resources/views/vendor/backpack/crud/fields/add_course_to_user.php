<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<table class="table">
<thead>
<tr><th>Course Name</th><th>Date_completed</th><th>Course By</th><tr>
@foreach ($field['value'] as  $attributes)
    <tr> <td>{{ $attributes->course->name }} </td><td>{{ $attributes['created_at'] }} </td></tr>

     @endforeach
     <form>
     <tr><td><input type="text"/></td><td></td><td></td></tr>
</table>
@include('crud::fields.inc.wrapper_end')