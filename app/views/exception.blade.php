@if ($exception)
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<ul>
		<li>{{ $exception }}</li>
	</ul>
</div>
@endif