<?php  
// Proteger la página  
require("Config/verificarSesion.php");  
  
// Solo administradores pueden ver esta página  
verificarRol(['Administrador','Oficina']);  
?>  
<!doctype html>  
<html lang="es">  
<head>  
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Horarios</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
  <!-- CSS de DataTables -->  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">  
  <!-- jQuery (requerido por DataTables) -->  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>  
  <link rel="stylesheet" href="src/css/styles.css">  
</head>  
<body>  
  
  <?php include('src/includes/sidebar.php'); ?>  

  <main class="container mt-4">  
    <?php include('src/includes/userbar.php'); ?>
    
    <h1 class="bg-info p-3 text-white text-center rounded">📋 LISTADO DE HORARIOS</h1>  
  
    <div class="text-end mb-3">  
      <a href="Formularios/AgregarHorario.php" class="btn btn-success">  
        <i class="bi bi-plus-circle"></i> Agregar Horario  
      </a>  
    </div>  
  
    <div class="table-container">  
      <table id="tabla"  class="table table-hover">  
        <thead>  
          <tr>  
            <th>Nombre</th>  
            <th>Tipo</th>  
            <th>Horario</th>  
            <th>Horas Mínimas</th>  
            <th>Acciones</th>  
          </tr>  
        </thead>  
        <tbody>  
          <?php  
            require("Config/Conexion.php");  
            $sql = $conexion->query("SELECT * FROM horarios ORDER BY nombre ASC");  
            while ($resultado = $sql->fetch_assoc()) {  
          ?>  
          <tr>  
            <td><strong><?php echo $resultado['nombre']; ?></strong></td>  
            <td>  
              <?php   
              if ($resultado['tipo'] == 'Fijo') {  
                echo "<span class='badge bg-primary'>Fijo</span>";  
              } else {  
                echo "<span class='badge bg-info'>Flexible</span>";  
              }  
              ?>  
            </td>  
            <td>  
              <?php   
              if ($resultado['hora_inicio'] && $resultado['hora_fin']) {  
                echo $resultado['hora_inicio'] . " - " . $resultado['hora_fin'];  
              } else {  
                echo "<span class='text-muted'>Horario flexible</span>";  
              }  
              ?>  
            </td>  
            <td><?php echo $resultado['horas_minimas']; ?> horas</td>  
            <td class="acciones">  
              <a href="Formularios/EditarHorario.php?Id=<?php echo $resultado['id']; ?>" class="btn btn-warning btn-sm">  
                <i class="bi bi-pencil"></i> Editar  
              </a>  
              <a href="CRUD/eliminarHorario.php?Id=<?php echo $resultado['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este horario?')">  
                <i class="bi bi-trash3"></i> Eliminar  
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
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>