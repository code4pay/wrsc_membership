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
  <h1 class="display-4">Application Form</h1>
  <p class="lead ">If you wish to join,  please fill the form below.</p>
  <hr class="my-4">
  <p>If you encounter any difficulties please email <a href="mailto:someonewhowcares@asdasd.com">someonewhowcares@asdasd.com</a></p>
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
    <label for="email" class="col-4 col-form-label">Email</label> 
    <div class="col-8">
      <input id="email" name="email" placeholder="your@email.at" type="email" class="form-control" aria-describedby="emailHelpBlock" required="required"> 
      <span id="emailHelpBlock" class="form-text text-muted">Enter Your email Address</span>
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
    <label class="col-4">Residential Address is the same as Postal Address.</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="addresses_same" id="addresses_same_0" type="checkbox" aria-describedby="addresses_sameHelpBlock" class="form-check-input" value="yes"> 
        <label for="addresses_same_0" class="form-check-label"></label>
      </div> 
      <span id="addresses_sameHelpBlock" class="form-text text-muted">Tick if your postal and residential address are the same.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_address" class="col-4 col-form-label">Residential Address  (If different to postal address)</label> 
    <div class="col-8">
      <input id="residential_address" name="residential_address" placeholder="Enter Your Residential Address" type="text" class="form-control" aria-describedby="residential_address HelpBlock"> 
      <span id="residential_address HelpBlock" class="form-text text-muted">Enter your residential address (If different to postal address)</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_city" class="col-4 col-form-label">Residential City (if different to Postal Address)</label> 
    <div class="col-8">
      <input id="residential_city" name="residential_city" placeholder="City" type="text" class="form-control" aria-describedby="residential_cityHelpBlock"> 
      <span id="residential_cityHelpBlock" class="form-text text-muted">Enter your residential city if different to Postal Address.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="residential_postcode" class="col-4 col-form-label">Postcode Residental (If different to Postal address)</label> 
    <div class="col-8">
      <input id="residential_postcode" name="residential_postcode" placeholder="XXXX" type="text" class="form-control" aria-describedby="residential_postcodeHelpBlock"> 
      <span id="residential_postcodeHelpBlock" class="form-text text-muted">Enter your residential postcode (if different to your postal address)</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="mobile" class="col-4 col-form-label">Mobile</label> 
    <div class="col-8">
      <input id="mobile" name="mobile" placeholder="xxxx xxx xxx" type="tel" class="form-control" aria-describedby="mobileHelpBlock" required="required"> 
      <span id="mobileHelpBlock" class="form-text text-muted">Enter your mobile phone number</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="home_phone" class="col-4 col-form-label">Home Phone</label> 
    <div class="col-8">
      <input id="home_phone" name="home_phone" placeholder="(xx) xxxx xx xx" type="tel" class="form-control" aria-describedby="home_phoneHelpBlock"> 
      <span id="home_phoneHelpBlock" class="form-text text-muted">Enter your home phone number</span>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4">Are you now or have you been a member of another wildlife group?</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="member_of_other_group" id="member_of_other_group_0" type="checkbox" aria-describedby="member_of_other_groupHelpBlock" class="form-check-input" value="yes "> 
        <label for="member_of_other_group_0" class="form-check-label"></label>
      </div> 
      <span id="member_of_other_groupHelpBlock" class="form-text text-muted">Tick if you are or have been a member of another wildlife group</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="textarea" class="col-4 col-form-label">If you answered  YES above  – please give details including any relevant training courses completed within last 3 years.</label> 
    <div class="col-8">
      <textarea id="textarea" name="textarea" cols="40" rows="5" class="form-control" aria-describedby="textareaHelpBlock"></textarea> 
      <span id="textareaHelpBlock" class="form-text text-muted">Enter any relevant training courses completed within last 3 years.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="textarea1" class="col-4 col-form-label">Have you cared for native wildlife in the past 12 months?  If YES – please give details:</label> 
    <div class="col-8">
      <textarea id="textarea1" name="textarea1" cols="40" rows="5" class="form-control" aria-describedby="textarea1HelpBlock"></textarea> 
      <span id="textarea1HelpBlock" class="form-text text-muted">please give details of previous wildlife caring in last 12 months</span>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4">Have you been charged or convicted of an offence relating to wildlife or domestic animals?  YES?  Please contact the Membership Officer before proceeding with your application.</label> 
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
    <label class="col-4">Are you a prohibited person under the Commission for Children and Young People Act 2007?  If YES?  Please contact the Membership Officer before proceeding with your application.</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="prohibited_person" id="prohibited_person_0" type="radio" class="form-check-input" value="yes" aria-describedby="prohibited_personHelpBlock" required="required"> 
        <label for="prohibited_person_0" class="form-check-label">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input name="prohibited_person" id="prohibited_person_1" type="radio" class="form-check-input" value="no" aria-describedby="prohibited_personHelpBlock" required="required"> 
        <label for="prohibited_person_1" class="form-check-label">No</label>
      </div> 
      <span id="prohibited_personHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
    </div>
  </div> 
  <div class="form-group row">
    <label class="col-4">Do you hold a current firearms licence?</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="firearms_licence" id="firearms_licence_0" type="radio" class="form-check-input" value="yes" aria-describedby="firearms_licenceHelpBlock" required="required"> 
        <label for="firearms_licence_0" class="form-check-label">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input name="firearms_licence" id="firearms_licence_1" type="radio" class="form-check-input" value="no" aria-describedby="firearms_licenceHelpBlock" required="required"> 
        <label for="firearms_licence_1" class="form-check-label">No</label>
      </div> 
      <span id="firearms_licenceHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
    </div>
  </div> 
  <div class="form-group row">
    <label class="col-4">If you answered YES to above, would you be willing to undertake specific training to assess and if required euthanase injured wildlife by firearm?</label> 
    <div class="col-8">
      <div class="form-check form-check-inline">
        <input name="euthanase_ok" id="euthanase_ok_0" type="radio" class="form-check-input" value="yes" aria-describedby="euthanase_okHelpBlock" required="required"> 
        <label for="euthanase_ok_0" class="form-check-label">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input name="euthanase_ok" id="euthanase_ok_1" type="radio" class="form-check-input" value="no" aria-describedby="euthanase_okHelpBlock" required="required"> 
        <label for="euthanase_ok_1" class="form-check-label">No</label>
      </div> 
      <span id="euthanase_okHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
    </div>
  </div> 
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
</script>
</html>