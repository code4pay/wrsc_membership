@component('mail::message')
# Membership Renewal
Dear {{ $user->fullname }}
The body of your message.

@component('mail::button', ['url' => 'www.google.com'])
Button Text
@endcomponent

Thanks,<br>
Anne Cherry<br> 
Membership Officer<br>
Wildlife Rescue South Coast
@endcomponent
