
@component('mail::message')
# Membership Card  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

Dear {{ $user->first_name }}
Thank you for being part of WRSC. 

Please find attached you Membership card. 

You can either print this out or have it available on your phone to present when required. 

Thank you again for your membership and it is a new world we are facing and look forward to facing it with your assistance.<br/>

Yours Sincerely <br/>   

Thanks,<br>
Anne Cherry<br> 
Membership Officer<br>
Wildlife Rescue South Coast
@endcomponent
