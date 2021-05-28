@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
@endphp
@section('content')
<div class="row">
<table class="table col-md-5">
<tr><td>Active member Count</td><td>@php echo( \App\Models\BackpackUser::where('member_type_id','<>', 8)->count()) @endphp </td>
<tr><td>Members Paid To 2022</td><td>@php echo( \App\Models\BackpackUser::where('paid_to', '2022-06-30')->count()) @endphp </td>
<tr><td>Members Paid by PayPal</td><td>@php echo( \App\Models\BackpackUser::whereNotNull('paid_paypal_date')->count()) @endphp </td>
<tr><td>Members Accepted T&amp;C's </td><td>@php echo( \App\Models\BackpackUser::whereNotNull('tac_date')->count()) @endphp </td>
<tr><td>Members Not Renewing </td><td>@php echo( \App\Models\BackpackUser::where('dont_renew', true)->count()) @endphp </td>

</table>
</div>
@endsection