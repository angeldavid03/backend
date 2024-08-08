@extends('adminlte::page')

@section('title', 'Jornadas')

@section('content_header')
    <h1>Jornadas</h1>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        table th {
        background-color: #0FC2C0 !important;
        background: white;
    }
    </style>
@stop

@section('content')
@if(session('success'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                 {{ session('success') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
             </div>
           @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#createJornadaModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar Jornada
                </button>

                <table id="jornadas-table" class="table table-bordered display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($jornadas as $jornada)
                            <tr>
                                <td>{{ $jornada->id }}</td>
                                <td>{{ $jornada->entrada }}</td>
                                <td>{{ $jornada->salida }}</td>
                                <td>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{ $jornada->id }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                                    </button>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $jornada->id }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                              
                            <!-- edicion de jornada-->
                            <div class="modal fade" id="editModal{{ $jornada->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Editar Jornada</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{ route('admin.jornadas.update', $jornada->id) }}" method="POST">
                                             @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="edit-entrada" class="form-label">Hora de Entrada</label>
                                                <input type="time" class="form-control" id="edit-entrada" value="{{ $jornada->entrada }}" name="entrada" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-salida" class="form-label">Hora de Salida</label>
                                                <input type="time" class="form-control" id="edit-salida" value="{{$jornada->salida}}" name="salida" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Actualizar</button>

                                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                             <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <!-- eliminacion de jornada-->
                        <div class="modal fade" id="deleteModal-{{ $jornada->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $jornada->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $jornada->id }}">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                     Eliminar jornada {{ $jornada->entrada }} - {{ $jornada->salida }} 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                    <i class="fa fa-ban" aria-hidden="true"></i> Cancelar </button>
                                    <form action="{{ route('admin.jornadas.destroy', $jornada->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <!-- creacion de jornada-->
    <div class="modal fade" id="createJornadaModal" tabindex="-1" aria-labelledby="createJornadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createJornadaModalLabel">Agregar Nueva Jornada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.jornadas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="entrada" class="form-label">Hora de Entrada</label>
                            <input type="time" class="form-control" id="entrada" name="entrada" required>
                        </div>
                        <div class="mb-3">
                            <label for="salida" class="form-label">Hora de Salida</label>
                            <input type="time" class="form-control" id="salida" name="salida" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i>Guardar</button>

                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    

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

        new DataTable('#jornadas-table', {
            responsive: true,
        });
        });

        
    
    </script>
@stop
