@component('mail::message')
# Membership Application  

A person has applied for membership,  their allocated membership number is {{$user->member_number }} 

### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

Click this link to visit membership record <a href="{{url('/admin')}}/user/{{$user->id}}/edit"> User Record</a> .
@endcomponent