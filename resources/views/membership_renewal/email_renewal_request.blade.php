@component('mail::message')
# Membership Renewal  
### Member Number: {{$user->member_number }}  Name: {{$user->name}}    

 Dear {{ $user->first_name }}
<p>
The Wildlife Rescue South Coast committee thanks you for your support and being part of
our community of wildlife carers. Although it is hard to believe, another year has passed and
that it’s renewal time again. We ask that you take a moment to renew as soon as possible –
so it doesn’t get forgotten!
</p>
<p>
We are also looking to simplify our membership arrangements next year, so we urge you to
read the attached President’s report to learn about this changing environment, and what it
means for you - our members. This report will also explain what has happened in the last 12
months.
</p>
<p>
<b>
Last year we discounted the renewal cost by 50% to $15 for Primary members as
recognition of the fact that COVID prevented us from delivering some services to our
members. Although the 2022 renewal was to have been the last time we discounted our
fees, we have decided to extend the discount to this year’s renewals. We know times are
tough so hopefully this small token helps a little.
<b>
</p>
<p>
After years of flood, fire and COVID, we are finally emerging into an environment which is in
some ways different to the years prior to COVID. Part of this is due to the increased
government regulation of the wildlife rehabilitation sector, which impacts on the way we go
about our wildlife rescue and rehabilitation operations and has a huge impact on how
training is delivered. NPWS has created new valuable Codes of Practice for many species of
wildlife, and some of our coordinators have contributed to these Codes.
</p>
<p>
We welcome members who joined us this year and gratefully acknowledge the hard work
carried out by our volunteers, whether involved in rescues and rehabilitation, fundraising,
administration, publicity, communications, or any of the other vital roles needed to keep
this organisation running. We hope those who haven’t, will attend an introduction to
wildlife rescue in the very near future.
</p>
<p>
In this email you will find a link to your membership record, where you can check and
update personal details. When your details are correct, all you need to do is acknowledge
the terms and conditions and remit the funds as shown on the acknowledgement screen. If
you do not want to renew online, please email membership@wildlife-rescue.org.au and I
will post your renewal form.
</p>

<p>
Wherever possible, we will be emailing your acknowledgement letters along with a pdf of
your membership card, which you may print out and upload to your smartphone. If you
would like a laminated membership card, please let me know.
</p>
<p>
 <a href="{{url('/tac_accept')}}/{{$user->createToken('tac')}}"> Click this link to renew your membership online </a>. For family 
 memberships, each family member must renew by clicking on the link. <i>Only the
 person identified as the primary family member will be asked to pay</i>
</p>
<p>
If you don't wish to renew please <a href="{{url('/dont_renew')}}/{{$user->createToken('tac')}}"> Click here to let us know you won't be renewing </a> 
</p>
<p>
<b>It is important that all renewals are confirmed by 1 July 2023</b>. If you have not paid
membership by then, you will not be covered by WRSC’s NPWS licence to rehabilitate, or by
insurance. If you currently have authority care for wildlife – that also expires at the same
time as your membership.
Thank for your continued support and I look forward to receiving your renewal as soon as
possible.
</p>


 Yours Sincerely <br/>   

 Thanks,<br>
 Anne Cherry<br> 
 Membership Officer<br>
 Wildlife Rescue South Coast
 @endcomponent
