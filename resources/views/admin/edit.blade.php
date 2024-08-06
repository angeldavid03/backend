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

<script>
    document.getElementById('foto').onchange = function (event) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('preview-image-edit');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    
</script>
