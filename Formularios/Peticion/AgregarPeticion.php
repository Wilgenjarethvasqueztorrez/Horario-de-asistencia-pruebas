<?php
// Proteger la página    
require("../../Config/verificarSesion.php");

require("../../Config/Conexion.php");

// Obtener el empleado_id del usuario actual  
$usuario_id = $_SESSION['usuario_id'];
$sql_empleado = $conexion->query("SELECT empleados.id,   
                                          usuarios.nombre,   
                                          usuarios.apellido,  
                                          roles.nombre as rol_nombre,  
                                          horarios.nombre as horario_nombre,  
                                          horarios.tipo as horario_tipo,  
                                          horarios.horas_minimas  
                                   FROM empleados  
                                   INNER JOIN usuarios ON empleados.empleado_id = usuarios.id  
                                   INNER JOIN roles ON empleados.rol_id = roles.id  
                                   LEFT JOIN horarios ON roles.horario_id = horarios.id  
                                   WHERE usuarios.id = $usuario_id");
$empleado = $sql_empleado->fetch_assoc();
$empleado_id = $empleado['id'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enviar Peticon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <!-- Agregar Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>
    <h1 class="bg-primary p-2 text-white text-center">Enviar Peticion</h1>
    <div class="container">
        <form action="../../CRUD/Peticion/insertarPeticion.php" method="post">
            <!-- Empleado -->
            <label>Empleado</label>
            <input type="text" class="form-control mb-3"
                value="<?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?>"
                disabled>

            <!-- Enviar empleado_id oculto -->
            <input type="hidden" name="EmpleadoId" value="<?php echo $empleado_id; ?>">

            <!-- Descripcion -->
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <input type="text" class="form-control" name="DescripcionPeticion" required>
            </div>

            <!-- Botones -->
            <div class="text-center">
                <button type="submit" class="btn btn-dark">Enviar</button>
                <a href="../../pages/perfil_empleado.php" class="btn btn-dark">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Incluir Flatpickr -->
    <?php include('../../src/includes/Dependencias/Flatpickr.php'); ?>
    <!-- Incluir Select2 -->
    <?php include('../../src/includes/Dependencias/Select2.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>