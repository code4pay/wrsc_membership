<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>WRSC Membership Non-Renewal</title>
</head>

<body>
    <div class="container-fluid-md">
        <div class="jumbotron col-md-6 offset-md-3 alert-success " style=" margin-top: 1em;">
            <h1 class="display-4">Non-renewal</h1>
            <p class="lead ">We will be sad to see you go, but we understand circumstances change, thankyou for your past support. </p>
            <p class="lead ">Please confirm that this is you by checking the details below and confirm your cancellation by clicking the button. </p>
            <hr class="my-4">
            <p>IF YOU REQUIRE HELP PLEASE EMAIL <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a> OR
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
                    <input id="first_name" name="first_name" value="{{ $user->first_name }}" type="text" readonly="readonly" class="form-control" ">
                </div>
            </div>
            <div class=" form-group row">
                    <label for="last_name" class="col-4 col-form-label">Last Name</label>
                    <div class="col-8">
                        <input id="last_name" name="last_name" type="text" class="form-control" value="{{ $user->last_name }}" readonly="readonly" ">
                </div>
            </div>
                  <div class=" form-group row">
                        <div class="offset-4 col-8">
                            <button name="submit" type="submit" class="btn btn-primary">Confirm Cancellation</button>
                        </div>
                    </div>

        </form>
</body>

</html>