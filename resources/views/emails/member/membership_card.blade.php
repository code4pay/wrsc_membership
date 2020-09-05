
@component('mail::message')
# Membership Card  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

Dear {{ $user->first_name }}
Thank you for being part of WRSC. 

Please find attached you updated Membership card. 

You can either print this out or have it available on your phone to present when required. If you require a laminated card, please let me know at
<a mailto="membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a>.
Please do not reply to this email as it is not monitored.

Thank you again for your membership.<br/>

Yours Sincerely <br/>   

Anne Cherry<br> 
Membership Officer<br>
Wildlife Rescue South Coast
@endcomponent
