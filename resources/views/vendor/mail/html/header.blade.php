<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ config('app.logo') }}" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
<tr>
<td class="header">
WILDLIFE RESCUE SOUTH COAST INC<br/>
PO Box 666<br/>
NOWRA NSW 2541<br/>
NPWS Licence No: MWL000100253 | ABN: 49 616 307 526<br/>
E: <a href="mailto:info@wildlife-rescue.org.au">info@wildlife-rescue.org.au</a> | W: <a href="http://www.wildlife-rescue.org.au">www.wildlife-rescue.org</a></td>

</tr>
