<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>WRSC Membership Payment</title>
</head>

<body>
  <div class="container-fluid-md">
    <div class="jumbotron col-md-6 offset-md-3 alert-success" style="margin-top:1em">
      <h1 class="display-4">Membership Renewal</h1>
      <p class="lead ">Thank You for renewing {{$user->first_name}}!</p>
      @if ($user->totalRenewalAmount() > 0 && !$user->primary_member_id &&  $user->paid_to != '2021-06-30')
      <p class="lead ">Your renewal will be confirmed once your payment has been recieved.</p>
      @endif
      <hr class="my-4">
      <p>IF YOU HAVE ANY QUESTIONS ABOUT YOUR RENEWAL, EMAIL <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a> OR
        PHONE THE MEMBERSHIP OFFICER ON <a href="tel:0402403057">0402 403 057</a>
        </a></p>
    </div>

    @if ($user->totalRenewalAmount() > 0 && !$user->primary_member_id && $user->paid_to != '2021-06-30')
    <form class="col-md-6 offset-md-3" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="id" value="{{ $user->id }}" />

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
            <td>${{$user->renewalAmount()}}
               
              @foreach ( $user->siblings as $familyUser)
          <tr>
            <td>{{$familyUser->name}}</td>
            <td>{{$familyUser->memberType->name}}</td>
            <td>${{$familyUser->renewalAmount()}}
          <tr>
            <td></td>
            <td><strong>Total:</strong></td>
            <td><strong>${{$user->totalRenewalAmount()}}</strong></td>
          </tr>
          @endforeach
        </table>
      </div>

      <h3> Payment Options: </h3>
      <div class="row alert alert-success">
        <ul>
          <li><strong>Pay by direct deposit to:</strong></li>
          <li>Account Name: Wildlife Rescue South Coast</li>
          <li>BSB: 633 000 Account: 152 817 854 </li>
          <li>Reference: Membership Number & Surname </li>
          <li>And please email the receipt of your payment to:<a href="mailto:membership@wildlife-rescue.org.au"> membership@wildlife-rescue.org.au</a></li>
        </ul>
      </div>
      <strong> OR</strong>
      <div class="row alert alert-warning">
        <ul>
          <li> <strong>Pay by cheque </strong></li>
          <li> (made payable to Wildlife Rescue South Coast Inc) and post together with your name and membership number to PO Box 666, NOWRA NSW 2541</li>
          
        </ul>
      </div>
      <strong>OR</strong>
      <div class="row" id="paypal-button-container"></div>
    </form>
    @endif
  </div>
<div class="modal" id="processing_payment" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Process</h5>
      </div>
      <div class="modal-body">
        <p>Processing  Payments Please wait.  </p>
      </div>
    </div>
  </div>
</div>

</body>

<script src="https://www.paypal.com/sdk/js?client-id=@php echo(config('app.paypal_key')) @endphp&currency=AUD">
</script>

<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({purchase_units: 
        {!! $user->renewalAmountForPayPal() !!}
      });
    },
    onApprove: function(data, actions) {
      $('#processing_payment').modal({ show:true});
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
    
        // This function shows a transaction success message to your buyer.
        var jqxhr = $.post("/paid_paypal", 
          {
            'token' : '{{ $token }}',
            'amount' : details.purchase_units[0].amount.value,
            'member_number' : '{{ $user->member_number }}',
            'order_id' : details.purchase_units[0].payments.captures[0].id,
            '_token' : '{{ csrf_token() }}'
           })
           .done(function(){
            alert("Thank You for Your payment! ");
            window.location = "https://www.wildlife-rescue.org.au/";
           })
          .fail(function() {
            alert("Sorry An error Occurred,  Please email membership@wildlife-rescue.org.au for help.");
            $('#processing_payment').modal({ show:false})
          });
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>
<script type="text/javascript" src="/packages/backpack/base/js/bundle.js?v=4.0.61@1977e0cc52fa7cf9547eaeadf03f5cd88402b574"></script>


</html>