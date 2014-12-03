@extends ('admin/layout')

@section ('title') Cliente @stop

@section ('content')
	
	<h1 class="page-header">Cliente</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.planilla.index') }}" class="btn btn-info">Lista de planillas</a>
	    </div>
        <div class="form-group col-md-4">
            {{ Form::open(array('url' => array('business/planilla/planillacobropdf'), 'method' => 'POST'), array('role' => 'form')) }}                                        
                {{ Form::hidden('planilla', $planilla->id, array('id' => 'planilla')) }}
                <button type="submit" class="btn btn-danger">
                    <span class="glyphicon glyphicon-file"></span>
                    Generar PDF    
                </button>           
            {{ Form::close() }}
        </div>
  	</div>  

    <div class="row">
        <div class="form-group col-md-3">
            <label>Fecha</label>
            <div>{{ $planilla->fecha }}</div>
        </div>
        <div class="form-group col-md-5">
            <label>Cobrador</label>
            <div>{{ $collector->nombre }}</div>
        </div>
        <div class="form-group col-md-4">
            <label>Zona</label>
            <div>{{ $planilla->zona }}</div>
        </div>
    </div>
    <table id="table-contracts" class="table table-striped" style="width:40%" align="center">
    	<thead>
            <tr>
                <th width="60%">Contrato</th>
                <th width="40%">Saldo</th>
            </tr>   
        </thead>    
    @if(count($contracts) > 0)    	                
        <tbody>
            @foreach ($contracts as $contract)
                <tr>
                    <td>{{ $contract->numero }}</td>
                    <td style="text-align:right;"><?php echo number_format(round($contract->saldo), 2,'.',',' ) ?></td>
                </tr>
            @endforeach
        </tbody>
    @else
		<tr>
			<td align="center" colspan="2">No exiten contratos para la planilla.</td>
		</tr>	
	@endif
	</table>

  	{{--*/ $allowed = array('A') /*--}}
    @if (in_array(Auth::user()->perfil, $allowed))
        <p>         
            <a href="{{ route('business.planilla.edit', $planilla->id) }}" class="btn btn-success">Editar</a>      
        </p>    
    @endif
@stop