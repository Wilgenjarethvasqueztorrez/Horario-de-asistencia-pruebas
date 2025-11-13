<?php  
// Proteger la página  
require("Config/verificarSesion.php");  
  
// Solo administradores pueden ver esta página  
verificarRol(['Administrador','Oficina','Empleado']);  
?>  
<!doctype html>  
<html lang="es">  
<head>  
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Gestión de Empleados</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
  <!-- CSS de DataTables -->  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">  
  <!-- jQuery (requerido por DataTables) -->  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>  
  <!-- SweetAlert2 CSS -->  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">  
  <link rel="stylesheet" href="src/css/styles.css">  
</head>  
<body>  
    
  <?php include('src/includes/sidebar.php'); ?>  

  <main class="container mt-4">  
    <?php include('src/includes/userbar.php'); ?>
   
    <h1 class="bg-info p-3 text-white text-center rounded">👷 GESTIÓN DE EMPLEADOS</h1>  
    
    <div class="text-end mb-3">  
      <a href="Formularios/AgregarEmpleado.php" class="btn btn-success">  
        <i class="bi bi-plus-circle"></i> Agregar Empleado  
      </a>  
      <a href="Formularios/RegistrarAsistencia.php" class="btn btn-primary">  
        <i class="bi bi-clock"></i> Registrar Asistencia  
      </a>  
    </div>  
    
    <div class="table-container">  
      <table id="tabla"  class="table table-hover">  
        <thead>  
          <tr>  
            <th>Nombre</th>  
            <th>Rol Laboral</th>  
            <th>Horario Asignado</th>  
            <th>Estado</th>  
            <th>Acciones</th>  
          </tr>  
        </thead>  
        <tbody>  
          <?php  
          require("Config/Conexion.php");  
  
          $sql = $conexion->query("SELECT empleados.id,  
                                          usuarios.nombre,  
                                          usuarios.apellido,  
                                          roles.nombre as rol_nombre,  
                                          horarios.nombre as horario_nombre,  
                                          horarios.tipo as horario_tipo,  
                                          empleados.activo  
                                   FROM empleados  
                                   INNER JOIN usuarios ON empleados.empleado_id = usuarios.id  
                                   INNER JOIN roles ON empleados.rol_id = roles.id  
                                   LEFT JOIN horarios ON roles.horario_id = horarios.id  
                                   ORDER BY usuarios.nombre ASC");  
  
          while ($resultado = $sql->fetch_assoc()) {  
          ?>  
            <tr>  
              <td>  
                <div class="nombre-apellido">  
                  <span><strong><?php echo $resultado['nombre']; ?></strong></span>  
                  <span><?php echo $resultado['apellido']; ?></span>  
                </div>  
              </td>  
              <td><?php echo $resultado['rol_nombre']; ?></td>  
              <td>  
                <?php   
                if ($resultado['horario_nombre']) {  
                  echo $resultado['horario_nombre'] . " (" . $resultado['horario_tipo'] . ")";  
                } else {  
                  echo "<span class='text-muted'>Sin horario asignado</span>";  
                }  
                ?>  
              </td>  
              <td>  
                <?php   
                if ($resultado['activo'] == 1) {  
                  echo "<span class='badge bg-success'>Activo</span>";  
                } else {  
                  echo "<span class='badge bg-secondary'>Inactivo</span>";  
                }  
                ?>  
              </td>  
              <td class="acciones">  
                <a href="Formularios/EditarEmpleado.php?Id=<?php echo $resultado['id']; ?>" class="btn btn-warning btn-sm">  
                  <i class="bi bi-pencil"></i> Editar  
                </a>  
                <a href="CRUD/eliminarEmpleado.php?Id=<?php echo $resultado['id']; ?>" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirmarEliminacion(this.href)"  >  
                  <i class="bi bi-trash3"></i> Eliminar  
                </a>  
                <a target="_blank" href="Formularios/VerAsistencias.php?Id=<?php echo $resultado['id']; ?>" class="btn btn-info btn-sm">  
                  <i class="bi bi-calendar-check"></i> Asistencias  
                </a>  
              </td>  
            </tr>  
          <?php } ?>  
        </tbody>  
      </table>  
    </div>  
  </main>  
    
  <!-- Inicializar DataTables -->
  <!-- Primero: JavaScript de DataTables -->  
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>  
  
  <!-- Segundo: script de inicialización -->  
  <script>  
  $(document).ready(function() {  
      $('#tabla').DataTable({  
          "language": {  
              "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"  
          }  
      });  
  });  
  </script>  

   <!-- SweetAlert2 JS (antes de cerrar </body>) -->  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>  
    function confirmarEliminacion(url) {  
     Swal.fire({  
        title: '¿Está seguro?',  
        text: "¿Desea eliminar este registro?",  
        icon: 'warning',  
        showCancelButton: true,  
        confirmButtonColor: '#d33',  
        cancelButtonColor: '#3085d6',  
        confirmButtonText: 'Sí, eliminar',  
        cancelButtonText: 'Cancelar'  
    }).then((result) => {  
         if (result.isConfirmed) {  
            window.location.href = url;  
        }  
    });  
   }  
 </script>

 <script>  
// Detectar parámetros de URL para mostrar mensajes  
document.addEventListener('DOMContentLoaded', function() {  
    const urlParams = new URLSearchParams(window.location.search);  
    const success = urlParams.get('success');  
    const error = urlParams.get('error');  
      
    if (success) {  
        let titulo = '¡Éxito!';  
        let mensaje = '';  
          
        switch(success) {  
            case 'agregado':  
                mensaje = 'Registro agregado exitosamente';  
                break;  
            case 'editado':  
                mensaje = 'Registro actualizado exitosamente';  
                break;  
            case 'eliminado':  
                mensaje = 'Registro eliminado exitosamente';  
                break;  
            default:  
                mensaje = 'Operación realizada exitosamente';  
        }  
          
        Swal.fire({  
            icon: 'success',  
            title: titulo,  
            text: mensaje,  
            timer: 2000,  
            showConfirmButton: false  
        });  
          
        // Limpiar URL sin recargar la página  
        window.history.replaceState({}, document.title, window.location.pathname);  
    }  
      
    if (error) {  
        let mensaje = '';  
          
        switch(error) {  
            case 'db':  
                mensaje = 'Error en la base de datos';  
                break;  
            case 'datos':  
                mensaje = 'Error en los datos proporcionados';  
                break;  
            default:  
                mensaje = 'Ocurrió un error al procesar la solicitud';  
        }  
          
        Swal.fire({  
            icon: 'error',  
            title: 'Error',  
            text: mensaje  
        });  
          
        window.history.replaceState({}, document.title, window.location.pathname);  
    }  
});  
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>