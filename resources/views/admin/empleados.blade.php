@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
    <h4>Lista de Empleados</h4>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .fixed-size-img {
        width: 50px; 
        height: 50px; 
        object-fit: cover;
    }
     
    table th {
        background-color: #0FC2C0 !important;
        background: white;
    }

    

</style>
@stop



@section('content')
@php
    use Carbon\Carbon;
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
           @if(session('success'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                 {{ session('success') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
             </div>
           @endif
           <button class="btn btn-success" data-toggle="modal" data-target="#createmodal"><i class="fa fa-user-plus" aria-hidden="true"></i>Agregar</button>
         <table id="empleados-table" class="table table-bordered display nowrap" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th>Código de Empleado</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
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
                    <img src="{{ asset('storage/' . $empleado->foto) }}" class="fixed-size-img"/>
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
                        <td>{{ Carbon::parse($empleado->created_at)->format('d-m-Y') }}</td> 
                        <td>
                        <button class="btn btn-primary editButton" data-id="{{ $empleado->id }}" data-toggle="modal" data-target="#editmodal">Editar</button>
                             <button class="btn btn-danger " data-id="{{ $empleado->id }}" data-toggle="modal" data-target="#deleteEmployeeModal">Eliminar</button>
                       </td>
                    </div>
                           
                        
                    </tr>
                </div>  
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!--creacion de empleados-->

  @include('admin.create')

    <!--edicion de empleado-->
    @include('admin.edit')

    <!--Eliminar Empleado -->
    @include('admin.delete')



@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https:////cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        // Ocultar el mensaje después de 3 segundos
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 4000);

        new DataTable('#empleados-table', {
            responsive: true,
        });

        $('#createmodal').on('shown.bs.modal', function () {
        $('#createEmployeeForm')[0].reset();
        });

        document.getElementById('foto').onchange = function (event) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('preview-image');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    });
</script>


@stop
