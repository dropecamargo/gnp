@extends ('admin/layout')

@section ('title') Reportes @stop

@section ('content')
	
	{{--*/ $allowed = array('A','C') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
		<h1 class="page-header">Reportes</h1>
		<div class="panel-group" id="accordion-reportes" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Cartera vencida por edades
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						{{ Form::open(array('url' => array('business/reports/carteraedades'), 'method' => 'POST'), array('role' => 'form')) }}			
							{{ Form::submit('Cartera vencida por edades', array('class' => 'btn btn-info')) }}
						{{ Form::close() }}
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Estado de cuenta
					</a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						Estado de cuenta
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
						Recibos de caja
					</a>
					</h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
						Recibos de caja
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFour">
					<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-reportes" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
						Ventas de un periodo
					</a>
					</h4>
				</div>
				<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
					<div class="panel-body">
						Ventas de un periodo
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(function() {	

			});
		</script>
	@else
		@include('denied')
	@endif
@stop