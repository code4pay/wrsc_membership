<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>WRSC Membership Renewal</title>
</head>

<body>
  <div class="container-fluid-md">
    <div class="jumbotron col-md-6 offset-md-3 alert-success" style="margin-top:1em">
      <h1 class="display-4">Membership Renewal Form </h1>
      <p class="lead ">To continue as a member of Wildlife Rescue South Coast please confirm your details below. </p>
      <hr class="my-4">
      <p>IF YOU REQUIRE HELP WITH YOUR RENEWAL PLEASE EMAIL <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a> OR
        PHONE THE MEMBERSHIP OFFICER ON <a href="tel:0402403057">0402 403 057</a>
        </a></p>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <form class="col-md-6 offset-md-3" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="token" value="{{ $token->token }}" />
      <div class="form-group row">
        <label for="member_number" class="col-4 col-form-label">Membership Number</label>
        <div class="col-8">
          <input id="member_number" name="member_number" value="{{ $user->member_number }}" type="text" readonly="readonly" class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label for="first_name" class="col-4 col-form-label">First Name</label>
        <div class="col-8">
          <input id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="First Name" type="text" class="form-control" aria-describedby="first_nameHelpBlock" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label for="last_name" class="col-4 col-form-label">Last Name</label>
        <div class="col-8">
          <input id="last_name" name="last_name" placeholder="Last Name" type="text" class="form-control" value="{{ $user->last_name }}" aria-describedby="last_nameHelpBlock" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
          <input id="email" name="email" value="{{ $user->email }}" type="email" class="form-control" aria-describedby="emailHelpBlock" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label for="address" class="col-4 col-form-label">Address (Postal)</label>
        <div class="col-8">
          <input id="address" name="address" value="{{ $user->address }}" type="text" class="form-control" aria-describedby="addressHelpBlock" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label for="city" class="col-4 col-form-label">City (Postal)</label>
        <div class="col-8">
          <input id="city" name="city" value="{{ $user->city }}" type="text" class="form-control" aria-describedby="cityHelpBlock" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label for="post_code" class="col-4 col-form-label">Post Code (Postal)</label>
        <div class="col-8">
          <input id="post_code" name="post_code" value="{{ $user->post_code }}" type="number" class="form-control" required="required">
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
        <label for="address_residential" class="col-4 col-form-label">Residential Address </label>
        <div class="col-8">
          <input id="address_residential" name="address_residential" value="{{ $user->address_residential }}" required="required" type="text" class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label for="city_residential" class="col-4 col-form-label">Residential City </label>
        <div class="col-8">
          <input id="city_residential" name="city_residential" value="{{ $user->city_residential }}" type="text" class="form-control" required="required" aria-describedby="city_residentialHelpBlock">
        </div>
      </div>
      <div class="form-group row">
        <label for="post_code_residential" class="col-4 col-form-label">Postcode Residental</label>
        <div class="col-8">
          <input id="post_code_residential" name="post_code_residential" required="required" value="{{ $user->post_code_residential }}" type="text" class="form-control" aria-describedby="post_code_residentialHelpBlock">
        </div>
      </div>
      <div class="form-group row">
        <label for="mobile" class="col-4 col-form-label">Mobile</label>
        <div class="col-8">
          <input id="mobile" name="mobile" value="{{ $user->mobile }}" type="tel" class="form-control" aria-describedby="mobileHelpBlock">
        </div>
      </div>
      <div class="form-group row">
        <label for="home_phone" class="col-4 col-form-label">Home Phone</label>
        <div class="col-8">
          <input id="home_phone" name="home_phone" value="{{ $user->home_phone }}" type="tel" class="form-control" aria-describedby="home_phoneHelpBlock">
        </div>
      </div>

      <div class=jumbotron>
        <h3>Conditions of Membership:</h3>

@include('global_includes.terms_and_conditions')
        <br />
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
      @if (!$user->primary_member_id && $user->paid_to != '2022-06-30')
      <div class="row">
        <p><strong>Renewal Fees. </strong> </p>
      </div>
      <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Member type</th>
              <th>amount</th>
            </tr>
          </thead>
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->memberType->name}}</td>
            <td>${{$user->renewalAmount()}}</td>
            @foreach ( $user->siblings as $familyUser)
          <tr>
            <td>{{$familyUser->name}}</td>
            <td>{{$familyUser->memberType->name}}</td>
            <td>${{$familyUser->renewalAmount()}}</td>
          <tr>
            <td></td>
            <td><strong>Total:</strong></td>
            <td><strong>${{$user->totalRenewalAmount()}}</strong></td>
          </tr>
          @endforeach
        </table>
      </div>
      <div class="row">
        <h4> Accept Terms and Conditions and Proceed to Payment options </h4>
      </div>
      @endif
      <div class="form-group row">
        <div class="offset-4 col-8">
          <button name="submit" type="submit" class="btn btn-primary">Accept</button>
        </div>
      </div>



    </form>
  </div>
</body>
<script>
  (function() {
    var checkbox = document.getElementById('addresses_same_0').addEventListener('change',
      function() {
        if (this.checked) {
          var address_fields = ['address', 'city', 'post_code']
          address_fields.forEach(function(field) {
            document.getElementById(field + '_residential').value = document.getElementById(field).value;
          })
        }
      });
  })();
</script>

</html>