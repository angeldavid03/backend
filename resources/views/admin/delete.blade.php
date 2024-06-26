@extends('adminlte::page')

@section('title', 'Eliminar Empleado')

@section('content_header')
    <h4>Confirmar Eliminación</h4>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p>¿Estás seguro que quieres eliminar al empleado <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>?</p>
        <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar </button>
            <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">
            <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
            </a>
        </form>
    </div>
</div>
@stop
