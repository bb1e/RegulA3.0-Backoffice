<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{route('/')}}/img/logo/logo1_resized2.png" alt="Regul-A Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
