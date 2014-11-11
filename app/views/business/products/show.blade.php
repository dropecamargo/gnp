@extends ('admin/layout')

@section ('title') Producto @stop

@section ('content')
	
	<h1 class="page-header">Producto</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.products.index') }}" class="btn btn-info">Lista de productos</a>
	    </div>
  	</div>
  	<div class="row">
        <div class="form-group col-md-6">
            <label>Nombre</label>
            <div>{{ $product->nombre }}</div>
        </div> 
    </div>
	<div class="row">
        <div class="form-group col-md-4">
            <label>Creación</label>
            <div>{{ $product->created_at }}</div>
        </div>
        <div class="form-group col-md-4">
            <label>Actualización</label>
            <div>{{ $product->updated_at }}</div>
        </div>  
    </div>
    <p>			
		<a href="{{ route('business.products.edit', $product->id) }}" class="btn btn-success">Editar</a>		
	</p>
@stop 