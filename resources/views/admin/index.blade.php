@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => 'Admin',
        'content'     => 'Various Admin Tasks',
    ];
@endphp
@section('content')
    <div class="alert alert-success" role="alert">
    Presidents report to include in membership Renewals
    </div>
        <form method="post" action='/site_admin/presidents_report' enctype="multipart/form-data" >
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="from_date" class="col-2 col-form-label">Presidents Report</label>
                <div class="col-4">
                    <input id="presidents_report" name="presidents_report" type="file" class="form-control" required="required">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-4">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
  <div class="row">
      <a href="/site_admin/presidents_report"> Download existing Presidents Report </a>
  </div>


    <div class="alert alert-success" role="alert">
    Set the Current Paid Until Date. This will also update things like the Valid to on the membership cards. 
    </div>
        <form method="post" action='/site_admin/currentPaidTo' >
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="current_paid_to" class="col-2 col-form-label">Current Paid Until Normally 30th June </label>
                <div class="col-4">
                    <input id="current_paid_to" name="current_paid_to" type="date" class="form-control" required="required" value="{{ $current_paid_to }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-4">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

    <div class="alert alert-success" role="alert">
    Reset Membership fields for start of new Membership Year.
    </div>
        <form method="post" action='/site_admin/resetTandCsAcceptedDate' >
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="offset-4 col-4">
                    <input class="btn btn-primary" 
                    type="submit" name="submit" value="Reset Membership Dates" onclick="return confirm('This will reset all Membership dates click OK to continue.');"
                    />
                </div>
            </div>
        </form>
@endsection