@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Perfil del Administrador</h1>
    
@stop

@section('content')
<div class="container">
    <!-- Mostrar mensajes de éxito o error -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    

    <!-- Formulario de actualización del perfil -->
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="username">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $admin->username) }}">
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $admin->nombre) }}">
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $admin->apellido) }}">
            @error('apellido')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
            <img id="imagePreview" src=""  style="max-width: 100%; height: auto; margin-top: 10px;"/>
     </div>

     <div class="form-group">
            <label for="current_password">Contraseña Actual</label>
            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="******" readonly>
            <small class="form-text text-muted">La contraseña actual está protegida y no se puede editar. Ingrese una nueva contraseña si desea cambiarla.</small>
        </div>

        <div class="form-group">
            <label for="new_password">Nueva Contraseña</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
        </div>



        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

<style>
    input[type="file"] {
    border: 1px solid #ced4da;
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
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
       $(document).ready(function() {
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000);


        setTimeout(function () {
            $('.alert-info').fadeOut('slow')
        }, 3000);

        new DataTable('#empleados-table', {
            responsive: true,
        });
    });
    </script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#foto").change(function() {
        readURL(this);
    });
</script>



@stop