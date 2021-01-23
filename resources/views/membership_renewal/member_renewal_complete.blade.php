<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>WRSC Membership Renewal </title>
</head>

<body>
  <div class="container-fluid-md">
    <div class="jumbotron col-md-6 offset-md-3 ">
      <h1 class="display-4">Membership Renewal</h1>
      <p class="lead ">Thank You for Renewing!</p>
      @if ($user->totalRenewalAmount() > 0  ) 
        <p class="lead ">Your renewal will be confirmed once your payment has been recieved.</p>
      @endif
      <hr class="my-4">
      <p>IF YOU HAVE ANY QUESTIONS ABOUT YOUR RENEWAL EMAIL <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a> OR
        PHONE THE MEMBERSHIP OFFICER ON <a href="tel:0402403057">0402 403 057</a>
        </a></p>
    </div>

    </form>
  </div>
</body>

</html>