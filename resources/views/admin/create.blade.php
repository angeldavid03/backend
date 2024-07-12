<!-- Modal -->
<div class="modal fade" id="createmodal" tabindex="-1" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEmployeeModalLabel">Nuevo Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.empleados.store') }}" method="POST" enctype="multipart/form-data" id="createEmployeeForm" autocomplete="on">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" class="form-control" placeholder="Ingrese el apellido" required>
                        @error('apellido')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" class="form-control" placeholder="Ingrese la dirección" required>
                        @error('direccion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                        @error('fecha_nacimiento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="informacion_contacto">Email</label>
                        <input type="text" name="informacion_contacto" class="form-control" placeholder="Ingrese la información de contacto" required>
                        @error('informacion_contacto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select name="genero" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('genero')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_puesto_trabajo">Cargo</label>
                        <select name="id_puesto_trabajo" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($puestos as $puesto)
                                <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_jornadas">Jornada</label>
                        <select name="id_jornadas" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($jornadas as $jornada)
                                <option value="{{ $jornada->id }}">{{ $jornada->entrada }} - {{ $jornada->salida }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control" id="foto" required>
                    </div>
                    <div class="form-group">
                        <img id="preview-image" src="#" alt="Preview Image" style="display: none; max-height: 150px;">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Guardar</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    document.getElementById('foto').onchange = function (event) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('preview-image');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    $('#createmodal').on('shown.bs.modal', function () {
        $('#createEmployeeForm')[0].reset();
        
    });
</script>
