@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => 'Reports',
        'content'     => 'Reports will be downloaded as Excel Spreadsheets',
    ];
@endphp
@section('content')
    <div class="alert alert-success" role="alert">
    Lyssavirus Immunistaion Report
    </div>
        <form method="post">
            {{ csrf_field() }}
            <input type="hidden" name="report_name" value="immunisation_report">
            <div class="form-group row">
                <label for="from_date" class="col-2 col-form-label">Immunised Since</label>
                <div class="col-4">
                    <input id="from_date" name="from_date" type="date" class="form-control" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="to_date" class="col-2 col-form-label">Immunised Before</label>
                <div class="col-4">
                    <input id="to_date" name="to_date" value="{{ date('Y-m-d') }}" type="date" class="form-control" required="required">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-4">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    <div class="alert alert-success" role="alert">
    MYOB Member Export
    </div>
        <form method="post">
            {{ csrf_field() }}
            <input type="hidden" name="report_name" value="myob_export">
            <div class="form-group row">
                <label for="from_date" class="col-2 col-form-label">Joined Since</label>
                <div class="col-4">
                    <input id="from_date" name="from_date" type="date" class="form-control" required="required">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-4">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
@endsection