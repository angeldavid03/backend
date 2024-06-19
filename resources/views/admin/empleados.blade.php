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
        <a id="createNewEmpleado" class="btn btn-primary mb-3">Agregar Empleado</a>
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
                        <td>{{ $empleado->created_at->format('Y-m-d') }}</td> <!-- Aquí se muestra la fecha de creación -->
                        <td>
                            <button class="btn btn-sm btn-primary editEmpleado" data-id="{{ $empleado->id }}">Editar</button>
                            <button class="btn btn-sm btn-danger deleteEmpleado" data-id="{{ $empleado->id }}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
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
                <form id="empleadoForm" name="empleadoForm" class="form-horizontal" method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="empleado_id" id="empleado_id">

                    <div class="form-group">
                        <label for="codigo_empleado" class="col-sm-4 control-label">Código de Empleado</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="codigo_empleado" name="codigo_empleado" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="col-sm-4 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="apellido" class="col-sm-4 control-label">Apellido</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="col-sm-4 control-label">Dirección</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento" class="col-sm-4 control-label">Fecha de Nacimiento</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="informacion_contacto" class="col-sm-4 control-label">Contacto</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="informacion_contacto" name="informacion_contacto" required>
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
                        <label for="nombre_puesto_trabajo" class="col-sm-4 control-label">Puesto de Trabajo</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="nombre_puesto_trabajo" name="nombre_puesto_trabajo" required>
                                <option value="">Select</option>
                                @foreach ($puestos as $puesto)
                                    <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_jornadas" class="col-sm-4 control-label">Jornada</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="id_jornadas" name="id_jornadas" required>
                                <option value="">Select</option>
                                @foreach ($jornadas as $jornada)
                                    <option value="{{ $jornada->id }}">{{ $jornada->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="foto" class="col-sm-4 control-label">Foto</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#empleados-table').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
    // Show create employee modal
    $('#createNewEmpleado').click(function () {
        $('#empleadoForm').trigger("reset");
        $('#empleadoForm').attr('action', "{{ route('empleados.store') }}");
        $('#modelHeading').html("Agregar Empleado");
        $('#ajaxModel').modal('show');
    });

    // Show edit employee modal
    $('body').on('click', '.editEmpleado', function () {
        var empleado_id = $(this).data('id');
        $.get("{{ route('empleados.index') }}" + '/' + empleado_id + '/edit', function (data) {
            $('#empleadoForm').attr('action', "{{ url('empleados') }}" + '/' + empleado_id);
            $('#modelHeading').html("Editar Empleado");
            $('#ajaxModel').modal('show');
            $('#empleado_id').val(data.id);
            $('#codigo_empleado').val(data.codigo_empleado);
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#direccion').val(data.direccion);
            $('#fecha_nacimiento').val(data.fecha_nacimiento);
            $('#informacion_contacto').val(data.informacion_contacto);
            $('#genero').val(data.genero);
            $('#nombre_puesto_trabajo').val(data.nombre_puesto_trabajo);
            $('#id_jornadas').val(data.id_jornadas);
        });
    });

    // Delete employee
    $('body').on('click', '.deleteEmpleado', function () {
        var empleado_id = $(this).data("id");

        if (confirm("¿Estás seguro de eliminar este empleado?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('empleados') }}" + '/' + empleado_id,
                success: function (data) {
                    $('#empleados-table').DataTable().ajax.reload();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    // Save employee
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        var form = $('#empleadoForm')[0];
        var formData = new FormData(form);
        var url = $('#empleadoForm').attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#empleadoForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                $('#empleados-table').DataTable().ajax.reload();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
</script>
@stop
