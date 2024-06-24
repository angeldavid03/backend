@extends('adminlte::page')

@section('title', editar Empleado)

@section('content_header')
     <h1>Editar Empleado{{$empleado->nombre}}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        {!! Form::open(['route' => 'admin.empleados.update', 'files' => true, 'autocomplete' => 'off'], $empleado) !!}
        
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) !!}
            @error('nombre')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('apellido', 'Apellido') !!}
            {!! Form::text('apellido', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido']) !!}
            @error('apellido')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('direccion', 'Dirección') !!}
            {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la dirección']) !!}
            @error('direccion')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('fecha_nacimiento', 'Fecha de Nacimiento') !!}
            {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control']) !!}
            @error('fecha_nacimiento')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('informacion_contacto', 'Información de Contacto') !!}
            {!! Form::text('informacion_contacto', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la información de contacto']) !!}
            @error('informacion_contacto')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('genero', 'Género') !!}
            {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione']) !!}
            @error('genero')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            {!! Form::label('id_puesto_trabajo', 'Puesto de Trabajo') !!}
            {!! Form::select('id_puesto_trabajo', $puestos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione']) !!}
             
        </div>
        
        <div class="form-group">
             {!! Form::label('id_jornadas', 'Jornada') !!}
             {!! Form::select('id_jornadas', $jornadas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione']) !!}
             @error('id_jornadas')
             <span class="text-danger">{{$message}}</span>
             @enderror
       </div>

        
        <div class="form-group">
            {!! Form::label('foto', 'Foto') !!}
            {!! Form::file('foto', ['class' => 'form-control']) !!}
            @error('foto')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        {!! Form::submit('Guardar empleado', ['class' => 'btn btn-primary']) !!}
        
        {!! Form::close() !!}
    </div>
 </div>
 
@stop