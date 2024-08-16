@extends('adminlte::page')

@section('title', 'Cargos')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#create">
        <i class="fa fa-plus"></i> Agregar
    </button>

    
        <div class="card-header">
            
        </div>
        <div  class="card-body">
            <table id="cargos-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Puesto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($puestos as $puesto)
                    <tr>
                        <td>{{ $puesto->id }}</td>
                        <td>{{ $puesto->nombre }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $puesto->id }}">
                                <i class="fa fa-edit"></i> Editar
                            </button>

                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $puesto->id }}">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>

                    <!--- modal para editar cargo -->
                <div class="modal fade" id="edit{{ $puesto->id }}" tabindex="-1" aria-labelledby="editPuestoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <form action="{{ route('admin.puestos.update', $puesto->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPuestoModalLabel{{ $puesto->id }}">Editar Cargo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_nombre{{ $puesto->id }}" class="form-label">Cargo</label>
                                        <input type="text" class="form-control" id="edit_nombre{{ $puesto->id }}" name="nombre" value="{{ $puesto->nombre }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                                        <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>

                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="fa fa-save" aria-hidden="true"></i> Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                 <!-- Modal para crear un nuevo puesto -->
      <div class="modal fade" id="create" tabindex="-1" aria-labelledby="createPuestoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="{{ route('admin.puestos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPuestoModalLabel">Crear Nuevo Cargo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Cargo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                            <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>

                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
     </div>

    
               <!-- Modal para eliminar puesto -->
                <div class="modal fade" id="delete{{ $puesto->id }}" tabindex="-1" aria-labelledby="deletePuestoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('admin.puestos.destroy', $puesto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deletePuestoModalLabel">Eliminar Cargo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar el cargo: {{ $puesto->nombre }}?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="fa fa-window-close" aria-hidden="true"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach
            </tbody>
        </table>
    
  </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

<style>
    /* Your custom styles here */
    /* Example: */
    table.dataTable th,
    table.dataTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .alert {
    word-wrap: break-word; /* Permite que el texto se divida en varias líneas si es necesario */
    max-width: 100%; /* Asegura que el mensaje no desborde su contenedor */
    font-size: 1rem; /* Ajusta el tamaño de la fuente para mejorar la legibilidad */
}

</style>
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
   

     

        new DataTable('#cargos-table', {
            responsive: true,
        });

        document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let alertElement = document.querySelector('.alert-dismissible');
            if (alertElement) {
                alertElement.classList.add('fade');
                setTimeout(function() {
                    alertElement.remove();
                }, 500); // tiempo para la transición
            }
        }, 4000); // 4000 milisegundos = 4 segundos
    });
    


</script>
@stop