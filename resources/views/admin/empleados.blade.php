@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
    <h4>Lista de Empleados</h4>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-body">
        <button id="createNewEmpleado" class="btn btn-success mb-3">Agregar Empleado</button>
        <table id="empleados-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo de Empleado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Contacto</th>
                    <th>Género</th>
                    <th>Puesto de Trabajo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal for CRUD operations -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="empleadoForm" name="empleadoForm" class="form-horizontal">
                @csrf
                    <input type="hidden" name="empleado_id" id="empleado_id">
                    
                    
                    
                    <div class="form-group">
                        <label for="nombre" class="col-sm-4 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre"
                             placeholder="Enter Name" value=""  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="col-sm-4 control-label">Apellido</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="apellido" name="apellido" 
                            placeholder="Enter Apellido" value=""  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="col-sm-4 control-label">Direccion</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="direccion" name="direccion" 
                            placeholder="Enter Direccion" value=""  required>
                        </div>
                    </div>

                                    <div class="form-group">
                        <label for="fecha_nacimiento" class="col-sm-4 control-label">Fecha de Nacimiento</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" 
                            placeholder="Enter Fecha de Nacimiento" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="informacion_contacto" class="col-sm-4 control-label">Contacto</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="informacion_contacto" name="informacion_contacto" 
                            placeholder="Enter Contacto" value="" required>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="genero" class="col-sm-4 control-label">Género</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="genero" name="genero" required>
                                <option value="">------</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_puesto_trabajo" class="col-sm-4 control-label">Puesto de Trabajo</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="id_puesto_trabajo" name="id_puesto_trabajo" required>
                            <option value="">------</option>
                                <option value="1">Recursos Humanos</option>
                                <option value="2">Logistica</option>
                                <option value="3">Auxuliar de Bodega</option>
                                <option value="4">diseñador Grafico</option>
                                <option value="5">Asesoria Comercial</option> 
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#empleados-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('empleados.datatables') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'codigo_empleado', name: 'codigo_empleado' },
                { data: 'nombre', name: 'nombre' },
                { data: 'apellido', name: 'apellido' },
                { data: 'direccion', name: 'direccion' },
                { data: 'fecha_nacimiento', name: 'fecha_nacimiento' },
                { data: 'informacion_contacto', name: 'informacion_contacto' },
                { data: 'genero', name: 'genero' },
                { data: 'id_puesto_trabajo', name: 'id_puesto_trbajo' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ]
        });

        // Crear empleado
        $('#createNewEmpleado').click(function () {
            $('#saveBtn').val("create-empleado");
            $('#empleado_id').val('');
            $('#empleadoForm').trigger("reset");
            $('#modelHeading').html("Crear Nuevo Empleado");
            $('#ajaxModel').modal('show');
        });

        

        // Guardar o actualizar empleado
        $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Enviando...');

                var empleado_id = $('#empleado_id').val();
                var url = empleado_id ? "{{ url('admin/empleados/update') }}/" + empleado_id : "{{ route('empleados.store') }}";
                var method = empleado_id ? 'POST' : 'POST';
                var formData = new FormData($('#empleadoForm')[0]);

                $.ajax({
                    data: formData,
                    url: url,
                    type: method,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#empleadoForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Guardar');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Guardar');
                    }
                });
            });

        // Eliminar empleado
        $('body').on('click', '.deleteEmpleado', function () {
            var empleado_id = $(this).data("id");
            if(confirm("¿Está seguro de que desea eliminar este empleado?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('empleados.destroy', '') }}" + '/' + empleado_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>
@stop
