<div class="modal fade" id="eliminarempleado{{$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro que quieres eliminar al empleado <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>?</p>
        <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar </button>
 
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Cancelar</button>
            
        </form>
        </div>
    </div>
  </div>
</div> 

