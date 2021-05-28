@component('mail::message')
# Membership Application  

A person has applied for membership,  their allocated membership number is {{$user->member_number }} 

### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

Click this link to visit membership record <a href="{{url('/admin')}}/user/{{$user->id}}/edit"> User Record</a> .



<table>
<tr><td>Name</td><td>{{$user->name}}</td></tr>
<tr><td>Member Type</td><td>{{$user->memberType->name}}</td></tr>
<tr><td>Residental Address</td><td>{{$user->address_residential}}</td></tr>
<tr><td>Residental City</td><td>{{$user->city_residential}}</td></tr>
<tr><td>Residental Postcode</td><td>{{$user->post_code_residential}}</td></tr>
<tr><td>Mobile Phone</td><td>{{$user->mobile}}</td></tr>
<tr><td>Home Phone</td><td>{{$user->home_phone}}</td></tr>
<tr><td>Comments</td><td>@php echo(nl2br($user->getCommentsAsArray()[0]['comment'])); @endphp</td></tr>

</table>
@foreach ( $user->siblings as $familyUser )
<br/>
<table>
<tr><td>Name</td><td>{{$familyUser->name}}</td></tr>
<tr><td>Member Type</td><td>{{$familyUser->memberType->name}}</td></tr>
<tr><td>Mobile Phone</td><td>{{$familyUser->mobile}}</td></tr>
<tr><td>Home Phone</td><td>{{$familyUser->home_phone}}</td></tr>
<tr><td>Comments</td><td> @php echo(nl2br($familyUser->getCommentsAsArray()[0]['comment'])); @endphp</td></tr>
</table>
@endforeach


@endcomponent