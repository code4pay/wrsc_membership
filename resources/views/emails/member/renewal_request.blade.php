@component('mail::message')
# Membership Renewal  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

Dear {{ $user->first_name }}
Thank you for being part of WRSC. It is renewal time, following one of the strangest 12 months we have ever faced.

Before going into the renewal section in this letter we would like to acknowledge the incredible amount of hard work, long hours and heartbreak experienced by our rescuers and carers during the recent drought and bushfires. From our members losing their properties, to the bat clinic taking in over 400 babies in the space of a few days, it has not been a good year. But there has been a superhuman effort by our members so thank you to the rescuers, the carers and the support members who answered thousands of emails and phone calls - not to mention the huge amount of donations that have to be processed. 

Please see the attached President’s report with details on our last 12 months

A big hi to all the new members who have joined us. We would love to welcome you with open arms, but under social distancing we cannot, and nor can we offer our standard training. We hope you will bear with us while we try to get back to normal.

In acknowledgement for the efforts of our carers, for our new members not being able to fully partake in activities, and because of the generosity of donors, we are discounting the renewal cost by 50% to $15 for Primary members for this year only.

We have a major change to the way we are doing renewals this year. You now have the opportunity to renew online. 
In this email you will find a link to your membership record, where you can check and update personal details.
When your details are correct, all you need to do is acknowledge the terms and conditions and remit the funds as shown on the acknowledgement screen
If you would do not want to renew on line, that is not a problem, email me and I will email out your renewal form.
Wherever possible, we will be emailing your acknowledgement letters along with a pdf of your membership card, which you may print out, load to your phone, or if you want a laminated one, please let me know.

Click the link to renew your membership online <a href="{{url('/tac_accept')}}/{{$user->createToken('tac')}}"> Click here to renew </a>. For family
memberships, each family member must renew by clicking on the link. Only the
person identified as the primary family member will be asked to pay

If you don't wish to renew please <a href="{{url('/dont_renew')}}/{{$user->createToken('tac')}}"> Click here to let us know you won't be renewing </a> 

If you have animals in care, and have not paid membership by the start of the new financial year ie 1 July 2020 then you are not covered by NPWS licence MWL000100253 or our insurance.


Thank you again for your membership and it is a new world we are facing and look forward to facing it with your assistance.<br/>

Yours Sincerely <br/>   

Thanks,<br>
Anne Cherry<br> 
Membership Officer<br>
Wildlife Rescue South Coast
@endcomponent