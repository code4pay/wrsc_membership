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

@endsection