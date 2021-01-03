<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<title>WRSC Membership Application</title>
  </head>
  <body>
      <div class="container-fluid-md">
 <div class="jumbotron col-md-6 offset-md-3 ">
  <h1 class="display-4">Wildlife Rescue South Coast, Application Form</h1>
  <p class="lead ">
    Thank you for wanting become a member.																				
WRSC is licenced by NPWS and we abide by our licence conditions</p>																				
<div class="alert alert-primary">Please note, before you can rescue and care, you will need specific training																				
and the majority of caring of native animals occurs in members homes																				
</div>
<p>The cost of membership is a $30 annual fee for the Primary member, plus a once off joining fee of $30 which includes cost of the Introduction course. Family members are $5 annual	</p>																			
<p>	Each member must complete an application - Primary and family members	</p>																		
<p>	If someone in the household is a member of WIRES, please contact the membership officer <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a><p>																			
<div class="alert alert-warning">Native animals are not pets, our aim is that native animals are to be rehabilitated when we can, and returned to the wild</div>																				
Please Note:
<ul>																				
        <li>All carers and rescuers must be over the age of 18 years by law																				</li>
        <li>Wildlife Rescue South Coast members must be financial and 18 years and over to vote at meetings																				</li>
        <li>Membership depends on your application being accepted by our committee. This happens at the monthly committee meeting. If your application is received after these meetings it may not be accepted until the following month.</li>
        <li>Our membership year runs from July to June. Applications accepted before the end of March will expire in June (nicer wording perhaps)																				</li>
</ul>
</p>
  <hr class="my-4">
  <p>If you encounter any difficulties please email <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a></p>
</div>
<form class="col-md-6 offset-md-3" method="POST">
{{ csrf_field() }}
  <div class="form-group row">
    <label for="first_name" class="col-4 col-form-label">First Name</label> 
    <div class="col-8">
      <input id="first_name" name="first_name" placeholder="First Name" type="text" class="form-control" aria-describedby="first_nameHelpBlock" required="required"> 
      <span id="first_nameHelpBlock" class="form-text text-muted">Enter your first name</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="last_name" class="col-4 col-form-label">Last Name</label> 
    <div class="col-8">
      <input id="last_name" name="last_name" placeholder="Last Name" type="text" class="form-control" aria-describedby="last_nameHelpBlock" required="required"> 
      <span id="last_nameHelpBlock" class="form-text text-muted">Enter you last name</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="title" class="col-4 col-form-label">Title</label> 
    <div class="col-2">
      <select id="title" name="title" class="form-control" aria-describedby="titleHelpBlock" required="required">
        <option value="ms">Ms</option>
        <option value="mr">Mr</option>
        <option value="mrs">Mrs</option>
        <option value="dr">Dr</option>
      </select> 
      <span id="titleHelpBlock" class="form-text text-muted">Enter your title</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_address" class="col-4 col-form-label">Primary Residential Address. <strong> Please note you cannot care for wildlife outside our licenced area, but may assist within our licenced area. <a href="images/wrsc_map.pdf"> Click Here</a> for licenced area</strong></label> 
    <div class="col-8">
      <input id="residential_address" name="residential_address" placeholder="Enter Your Residential Address" type="text" class="form-control" aria-describedby="residential_address HelpBlock"> 
      <span id="residential_address HelpBlock" class="form-text text-muted">Enter your residential address</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_city" class="col-4 col-form-label">Residential City </label> 
    <div class="col-8">
      <input id="residential_city" name="residential_city" placeholder="City" type="text" class="form-control" aria-describedby="residential_cityHelpBlock"> 
      <span id="residential_cityHelpBlock" class="form-text text-muted">Enter your residential city </span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_postcode" class="col-4 col-form-label">Postcode Residental </label> 
    <div class="col-8">
      <input id="residential_postcode" name="residential_postcode" placeholder="XXXX" type="text" class="form-control" aria-describedby="residential_postcodeHelpBlock"> 
      <span id="residential_postcodeHelpBlock" class="form-text text-muted">Enter your residential postcode </span>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4">Postal address is the same as Residential Address.</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="addresses_same" id="addresses_same_0" type="checkbox" aria-describedby="addresses_sameHelpBlock" class="form-check-input" value="yes"> 
        <label for="addresses_same_0" class="form-check-label"></label>
      </div> 
      <span id="addresses_sameHelpBlock" class="form-text text-muted">Tick if your postal and residential address are the same.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="address" class="col-4 col-form-label">Address   (Postal)</label> 
    <div class="col-8">
      <input id="address" name="address" placeholder="Your Address" type="text" class="form-control" aria-describedby="addressHelpBlock" required="required"> 
      <span id="addressHelpBlock" class="form-text text-muted">Enter your postal address</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="city" class="col-4 col-form-label">City (Postal)</label> 
    <div class="col-8">
      <input id="city" name="city" placeholder="City" type="text" class="form-control" aria-describedby="cityHelpBlock" required="required"> 
      <span id="cityHelpBlock" class="form-text text-muted">Enter Your city</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="postcode" class="col-4 col-form-label">Post Code (Postal)</label> 
    <div class="col-8">
      <input id="postcode" name="postcode" placeholder="Post Code" type="number" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="mobile" class="col-4 col-form-label">Mobile phone</label> 
    <div class="col-8">
      <input id="mobile" name="mobile" placeholder="xxxx xxx xxx" type="tel" class="form-control" aria-describedby="mobileHelpBlock" required="required"> 
      <span id="mobileHelpBlock" class="form-text text-muted">Enter your mobile phone number</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="home_phone" class="col-4 col-form-label">Land line</label> 
    <div class="col-8">
      <input id="home_phone" name="home_phone" placeholder="(xx) xxxx xx xx" type="tel" class="form-control" aria-describedby="home_phoneHelpBlock"> 
      <span id="home_phoneHelpBlock" class="form-text text-muted">Enter your home phone number</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="col-4 col-form-label">Email</label> 
    <div class="col-8">
      <input id="email" name="email" placeholder="your@email.at" type="email" class="form-control" aria-describedby="emailHelpBlock" required="required"> 
      <span id="emailHelpBlock" class="form-text text-muted">Enter Your email Address</span>
    </div>
  </div>
   <div class="form-group row">
    <label class="col-4">Are you over the age of 18?</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="over_18" id="over_18_0" type="checkbox" aria-describedby="over_18HelpBlock" class="form-check-input" value="yes "> 
        <label for="over_18_0" class="form-check-label"></label>
      </div> 
      <span id="over_18HelpBlock" class="form-text text-muted">You can not be a primary member if you are not over the age of 18.</span>
    </div>
  </div>

  <div class="form-group row">
    <label for="family_member_count" class="col-4 col-form-label">Will you be adding other family members?  If so please choose how many.</label> 
    <div class="col-2">
      <select id="family_member_count" name="family_member_count" class="custom-select" aria-describedby="family_member_countHelpBlock">
        <option value="0" selected="selected">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select> 
      <span id="family_member_countHelpBlock" class="form-text text-muted">Please choose the number of additional family members you intend to add.</span>
    </div>
  </div> 
  <div class="form-group row">
    <label class="col-4">Are you now or have you been a member of another wildlife group?</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="member_of_other_group" id="member_of_other_group_0" type="checkbox" aria-describedby="member_of_other_groupHelpBlock" class="form-check-input" value="yes "> 
        <label for="member_of_other_group_0" class="form-check-label"></label>
      </div> 
    </div>
  </div>
  <div class="form-group row">
    <label for="textarea" class="col-4 col-form-label">If you answered  YES above  – please provide name of group and approx year left that group	</label> 
    <div class="col-8">
      <textarea id="textarea" name="textarea" cols="40" rows="5" class="form-control" aria-describedby="textareaHelpBlock"></textarea> 
    </div>
  </div>
  <div class="form-group row">
    <label for="textarea1" class="col-4 col-form-label">Have you cared for native wildlife in the past 12 months?  If YES – please give details:</label> 
    <div class="col-8">
      <textarea id="textarea1" name="textarea1" cols="40" rows="5" class="form-control" aria-describedby="textarea1HelpBlock"></textarea> 
      <span id="textarea1HelpBlock" class="form-text text-muted">	Provide details of where and which animals</span>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4">Have you been charged or convicted of an offence relating to wildlife or domestic animals? </label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="previous_conviction" id="previous_conviction_0" type="radio" class="form-check-input" value="yes" aria-describedby="previous_convictionHelpBlock" required="required"> 
        <label for="previous_conviction_0" class="form-check-label">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input name="previous_conviction" id="previous_conviction_1" type="radio" class="form-check-input" value="no" aria-describedby="previous_convictionHelpBlock" required="required"> 
        <label for="previous_conviction_1" class="form-check-label">No</label>
      </div> 
      <span id="previous_convictionHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
    </div>
  </div> 

  <div class="form-group row">
    <label class="col-4">Is any member of your household a member of WIRES</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="member_wires" id="member_wires_0" type="radio" class="form-check-input" value="yes" aria-describedby="member_wiresHelpBlock" required="required"> 
        <label for="member_wires_0" class="form-check-label">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input name="member_wires" id="member_wires_1" type="radio" class="form-check-input" value="no" aria-describedby="member_wiresHelpBlock" required="required"> 
        <label for="member_wires_1" class="form-check-label">No</label>
      </div> 
      <span id="member_wiresHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
    </div>
  </div>
   <div class="jumbotron col-md-12  ">
  <h1 class="display-4">Terms and conditions</h1>
  <p class="lead ">
Upon joining,
<ol> 								
<li>1.      I agree to be bound by the conditions of :								</li>
<ol type="a">
<li>a: Licence number MWL000100253 issued to Wildlife Rescue South Inc by NPWS.								</li>
<li>b: Constitution, rules and guidelines of  Wildlife Rescue South Coast Inc. need to make this available somehow								</li>
<li>c: Policies and Procedures of Wildlife Rescue South Coast Inc								</li>
</ol>
<li>2.      I agree to be guided by the WRSC Coordinators and WRSC Committee in every facet of the wildlife’s care and rehabilitation and will allow the relevant coordinators or Committee members to inspect my premises at a time of mutual agreement.								</li>
<li>3.      I agree to return any property loaned to me by WRSC when requested by the Committee.								</li>
<li>4.      I agree that all my labour is voluntary and that all activities are carried out at my own risk and with no right of recourse against any member of WRSC.								</li>
<li>5.      I declare that I am not a prohibited person under the Commission for Children and Young People Act 2007.								</li>
<li>6.      I declare that I have not been convicted on charges relating to wildlife / domestic animals.								</li>
</ol>
  <div class="form-group row">
    <label class="col-4">I AGREE TO THE CONDITIONS OF MEMBERSHIP</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="agree_to_conditions" id="agree_to_conditions_0" type="checkbox" aria-describedby="agree_to_conditionsHelpBlock" required="required" class="form-check-input" value="yes"> 
        <label for="agree_to_conditions_0" class="form-check-label">I agree</label>
      </div> 
      <span id="agree_to_conditionsHelpBlock" class="form-text text-muted">By ticking this you signify that you agree to be bound by the conditions of membership of Wildlife Rescue South Coast.</span>
    </div>
  </div> 
</div>
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
</div> 
</body>
<script>
(function() {
    var checkbox = document.getElementById('addresses_same_0').addEventListener('change', 
    function() { 
        if( this.checked){
           var address_fields = ['address', 'city', 'postcode']  
           address_fields.forEach(function(field){
               document.getElementById('residential_'+field).value = document.getElementById(field).value;
           })
           }});
})();
(function () {
  document.getElementById('member_wires_0').addEventListener('change', 
  function() {
    var modal = document.getElementById('modal');
    var modal_template_text = document.getElementById('modal_template').innerHTML;
    modal_template_text.replace('[[title]]', 'Warning')
    modal_template_text.replace('[[text]]',"Yes - WIRES and WRSC policies do not allow members (who are authorised carers) in the same household to belong to the two different groups. We ask that you consider which group the family would like to be members of")
    modal.innerHTML= modal_template_text;
    var myModal = new bootstrap.Modal(modal, options)

  })
})();
</script>

<!-- templates -->

<div id="modal" class="modal" tabindex="-1">

</div>

<script id="modal_template" type="text/template">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">[[title]]</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>[[text]]</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

</script>
</html>

<script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>