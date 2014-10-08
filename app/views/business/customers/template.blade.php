<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('cedula', 'Cédula') }}
        {{ Form::text('cedula', null, array('placeholder' => 'Ingrese cédula de ciudadania', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('nomnre', 'Nombre completo') }}
        <div class="input-append date">	
        	{{ Form::text('nombre', null, array('placeholder' => 'Ingrese nombre y apellido', 'class' => 'form-control')) }}        
    	</div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('direccion_casa', 'Dirección CASA') }}
        {{ Form::text('direccion_casa', null, array('placeholder' => 'Ingrese dirección casa', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('barrio_casa', 'Barrio') }}
        {{ Form::text('barrio_casa', null, array('placeholder' => 'Ingrese barrio', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('telefono_casa', 'Teléfono') }}
        {{ Form::text('telefono_casa', null, array('placeholder' => 'Ingrese teléfono', 'class' => 'form-control')) }}        
    </div>        
</div>
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('empresa', 'Empresa') }}
        {{ Form::text('empresa', null, array('placeholder' => 'Ingrese empresa', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('cargo', 'Cargo') }}
        {{ Form::text('cargo', null, array('placeholder' => 'Ingrese cargo', 'class' => 'form-control')) }}        
    </div>        
</div>
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('direccion_empresa', 'Dirección EMPRESA') }}
        {{ Form::text('direccion_empresa', null, array('placeholder' => 'Ingrese dirección empresa', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('barrio_empresa', 'Barrio') }}
        {{ Form::text('barrio_empresa', null, array('placeholder' => 'Ingrese barrio', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('telefono_empresa', 'Teléfono') }}
        {{ Form::text('telefono_empresa', null, array('placeholder' => 'Ingrese teléfono', 'class' => 'form-control')) }}        
    </div>        
</div>
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('ref1_nombre', 'Nombre REFERENCIA 1') }}
        {{ Form::text('ref1_nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('ref1_parentesco', 'Parentesco') }}
        {{ Form::text('ref1_parentesco', null, array('placeholder' => 'Ingrese parentesco', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('ref1_direccion', 'Dirección') }}
        {{ Form::text('ref1_direccion', null, array('placeholder' => 'Ingrese dirección', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('ref1_telefono', 'Teléfono') }}
        {{ Form::text('ref1_telefono', null, array('placeholder' => 'Ingrese teléfono', 'class' => 'form-control')) }}        
    </div>        
</div>
<div class="row">
    <div class="form-group col-md-3">
        {{ Form::label('ref2_nombre', 'Nombre REFERENCIA 2') }}
        {{ Form::text('ref2_nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('ref2_parentesco', 'Parentesco') }}
        {{ Form::text('ref2_parentesco', null, array('placeholder' => 'Ingrese parentesco', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('ref2_direccion', 'Dirección') }}
        {{ Form::text('ref2_direccion', null, array('placeholder' => 'Ingrese dirección', 'class' => 'form-control')) }}        
    </div> 
    <div class="form-group col-md-3">
        {{ Form::label('ref2_telefono', 'Teléfono') }}
        {{ Form::text('ref2_telefono', null, array('placeholder' => 'Ingrese teléfono', 'class' => 'form-control')) }}        
    </div>        
</div>