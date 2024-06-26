@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
    <h4>Lista de Empleados</h4>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .action-buttons {
        display: flex;
        gap: 10px;
    }
</style>
@stop

@section('content')
@php
    use Carbon\Carbon;
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-body">
    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3"> 
    <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo
    </a>
        <table id="empleados-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Código de Empleado</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Puesto de Trabajo</th>
                    <th>Jornada</th>
                    <th>Miembro desde</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->codigo_empleado }}</td>
                         <td>
                @if($empleado->foto)
                    <img src="{{ asset('storage/' . $empleado->foto) }}" height="50"/>
                @else
                    <span>No hay foto</span>
                @endif
                          </td>

                        
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->apellido }}</td>
                        <td>{{ $empleado->puestoTrabajo->nombre }}</td>
                        <td>
                            @if ($empleado->jornadas)
                                {{ $empleado->jornadas->entrada }} - {{ $empleado->jornadas->salida }}
                            @else
                                Sin jornada asignada
                            @endif
                        </td>
                        <td>{{ Carbon::parse($empleado->created_at)->format('d-m-Y') }}</td> <!-- Aquí se muestra la fecha de creación -->
                        <td>
                    <div class="action-buttons">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.edit',$empleado->id)}}"> 
                            <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                            </a>
                            <a class="btn btn-danger btn-sm" href="{{route('admin.empleados.confirmDelete', $empleado->id)}}"> 
                            <i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar
                            </a>
                               
                            
                        </td>
                    </div>
                           
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        // Ocultar el mensaje después de 4 segundos
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000);

        $('#empleados-table').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }
        });
    
    });
    </script>
@stop
