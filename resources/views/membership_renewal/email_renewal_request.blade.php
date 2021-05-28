@component('mail::message')
# Membership Renewal  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

 Dear {{ $user->first_name }}
 We sincerely thank you for being part of WRSC.  Although it is hard to believe, it is now membership renewal time!

 Before going into the renewal section in this letter we would like to acknowledge the incredible amount of hard work carried out by our members, some of whom are still recovering from the damage occasioned by the bushfires.  We also understand that it has been a difficult 12 months for many of our members living under COVID-19 restrictions.

 Welcome to all our new members who have joined us this past year. To see what has happened during the past 12 months at WRSC, please see the attached President’s report.

 To support the efforts of our carers, for our new members who have not been able to fully partake in activities, and because of the generosity of donors, we are discounting the renewal cost by 50% to $15 for Primary members for this year only. Also, many of our food costs are still presently being subsidised 100%.

 Last year, we processed renewals in a new fashion, and this year we are continuing that process. In this email you will find a link to your membership record, where you can check and update personal details. When your details are correct, all you need to do is acknowledge the terms and conditions and remit the funds as shown on the acknowledgement screen. If you do not want to renew online, please email me and I will post your renewal form. 

 Wherever possible, we will be emailing your acknowledgement letters along with a pdf of your membership card, which you may print out and upload to your smartphone. If you would like a laminated membership card, please let me know.


 <a href="{{url('/tac_accept')}}/{{$user->createToken('tac')}}"> Click this link to renew your membership online </a>. For family
 memberships, each family member must renew by clicking on the link. Only the
 person identified as the primary family member will be asked to pay

 If you don't wish to renew please <a href="{{url('/dont_renew')}}/{{$user->createToken('tac')}}"> Click here to let us know you won't be renewing </a> 

 If you have animals in care, and have not paid membership by the commencement of the new financial year i.e. 1st July 2021 then you will not be covered by WRSC’s NPWS licence MWL000100253 or our insurance and your authorisation to care, if applicable, will no longer be current.

 Thank you again for your membership, it is indeed a new world that we are encountering and we look forward to facing it with your assistance.


 Yours Sincerely <br/>   

 Thanks,<br>
 Anne Cherry<br> 
 Membership Officer<br>
 Wildlife Rescue South Coast
 @endcomponent
