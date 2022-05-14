@component('mail::message')
# Membership Renewal  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

 Dear {{ $user->first_name }}
We sincerely thank you for being part of WRSC.  Although it is hard to believe, it is now membership renewal time!

We would like to acknowledge the wide variety of hard work that is carried out by our members in the rescue, care and release of our wildlife, as well as keeping the organisation ticking over in the background.  It has been a difficult couple of years for many of our members with fire, flood and COVID. It has also been a difficult time for wildlife. To see what has happened during the past 12 months at WRSC, please see the attached President’s report.

Welcome to all our new members who have joined us this past year. 

To support the efforts of our carers, for our new members who have not been able to fully partake in activities, and because of the generosity of donors, we are continuing to discount the renewal cost by 50% to $15 for Primary members for this year only. 

In this email you will find a link to your membership record, where you can check and update personal details. When your details are correct, all you need to do is acknowledge the terms and conditions and remit the funds as shown on the acknowledgement screen. If you do not want to renew online, please email me and I will post your renewal form. 
 
Wherever possible, we will be emailing your acknowledgement letters along with a pdf of your membership card, which you may print out and upload to your smartphone. If you would like a laminated membership card, please let me know.

 <a href="{{url('/tac_accept')}}/{{$user->createToken('tac')}}"> Click this link to renew your membership online </a>. For family 
 memberships, each family member must renew by clicking on the link. <i>Only the
 person identified as the primary family member will be asked to pay</i>

If you don't wish to renew please <a href="{{url('/dont_renew')}}/{{$user->createToken('tac')}}"> Click here to let us know you won't be renewing </a> 

If you have animals in care, and have not paid membership by the commencement of the new financial year i.e. 1st July 2022 then you will not be covered by WRSC’s NPWS licence MWL000100253 or our insurance and your authorisation to care, if applicable, will no longer be current.

Thank you again for your membership, thank you for your support and look forward to receiving your renewal as soon as possible.


 Yours Sincerely <br/>   

 Thanks,<br>
 Anne Cherry<br> 
 Membership Officer<br>
 Wildlife Rescue South Coast
 @endcomponent
