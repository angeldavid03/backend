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
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

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
                        <button class="btn btn-primary editButton"  data-toggle="modal" data-target="#editmodal{{$empleado->id}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</button>

                        <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="{{$empleado->id}}" data-bs-nombre="{{ $empleado->nombre }}">
                         <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                          </button>
                       </td>
                    </div>
                           
                        
                    </tr>
                </div>  
<div class="modal fade" id="editmodal{{ $empleado->id }}" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Editar Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.empleados.update', $empleado->id) }}"  method="POST" enctype="multipart/form-data" id="editEmployeeForm" autocomplete="off">
                    @csrf
                    @method('PUT')

                    

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{$empleado->nombre}}" placeholder="Ingrese el nombre"  required>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" value="{{$empleado->apellido}}" placeholder="Ingrese el apellido" required>
                        @error('apellido')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{$empleado->direccion}}" placeholder="Ingrese la dirección" required>
                        @error('direccion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{$empleado->fecha_nacimiento}}" required>
                        @error('fecha_nacimiento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="informacion_contacto">Email</label>
                        <input type="text" name="informacion_contacto" id="informacion_contacto" class="form-control" value="{{$empleado->informacion_contacto}}" placeholder="Ingrese la información de contacto" required>
                        @error('informacion_contacto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select name="genero" id="genero" class="form-control" value="{{$empleado->genero}}" required>
                        <option value="">Seleccione</option>
                            <option value="Masculino" {{ $empleado->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ $empleado->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ $empleado->genero == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_puesto_trabajo">Cargo</label>
                        <select name="id_puesto_trabajo" id="id_puesto_trabajo" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}" {{ $empleado->id_puesto_trabajo == $puesto->id ? 'selected' : '' }}>{{ $puesto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_jornadas">Jornada</label>
                        <select name="id_jornadas" id="id_jornadas" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" {{ $empleado->id_jornadas == $jornada->id ? 'selected' : '' }}>{{ $jornada->entrada }} - {{ $jornada->salida }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>

                    <div class="form-group">
                        <img id="preview-image-edit" src="#" alt="Preview Image" style="display: none; max-height: 150px;">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>
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

<!--creacion de empleados-->

  @include('admin.create')


   
    <!-- Modal de Eliminación -->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p>
        ¿Confirmas la eliminacion de este empleado?
       </p>

      </div>
      <div class="modal-footer">
        
         <form method="post" action="" id="deleteForm">
            @csrf 
            @method('DELETE')
         <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Eliminar</button>
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

    const deleteModal = document.getElementById('deleteModal');
if (deleteModal) {
  deleteModal.addEventListener('show.bs.modal', event => {
    // Botón que activó el modal
    const button = event.relatedTarget;

    // Extrae el ID del empleado desde los atributos data-bs-*
    const empleadoId = button.getAttribute('data-bs-whatever');
    const empleadoNombre = button.getAttribute('data-bs-nombre');

    // Encuentra el formulario dentro del modal y actualiza su acción
    const deleteForm = deleteModal.querySelector('#deleteForm');
    deleteForm.action = `/admin/empleados/${empleadoId}/destroy`; 

    const modalTitle = deleteModal.querySelector('.modal-title');
    modalTitle.textContent = `Eliminar empleado: ${empleadoNombre}`;
  });
}



</script>


@stop
