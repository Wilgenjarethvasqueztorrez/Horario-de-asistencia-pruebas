<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Día No Laboral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <!-- Agregar Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../src/css/styles.css">
</head>

<body>
    <h1 class="bg-primary p-2 text-white text-center">Editar Día No Laboral</h1>
    <br>
    <form class="container" action="../../CRUD/DiaNoLaboral/editarDiaNoLaboral.php" method="post">
        <?php
        include('../../Config/Conexion.php');
        $sql = "SELECT dias_no_laborales.*,   
                  usuarios.nombre,   
                  usuarios.apellido  
           FROM dias_no_laborales  
           LEFT JOIN empleados ON dias_no_laborales.empleado_id = empleados.id  
           LEFT JOIN usuarios ON empleados.empleado_id = usuarios.id  
           WHERE dias_no_laborales.id = " . $_GET['Id'];
        $resultado = $conexion->query($sql);
        $row = $resultado->fetch_assoc();
        ?>
        <input type="hidden" class="form-control" name="Id" value="<?php echo $row['id']; ?>">

        <!-- Tipo de día no laboral (solo lectura) -->
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select class="form-select mb-3" name="Motivo" id="motivo" required onchange="toggleEmpleadoField()">
                <option selected disabled>--Seleccionar tipo--</option>
                <option value="Feriado" <?php echo ($row['motivo'] == 'Feriado') ? 'selected' : ''; ?>>Feriado (Aplica a
                    todos)</option>
                <option value="Vacaciones" <?php echo ($row['motivo'] == 'Vacaciones') ? 'selected' : ''; ?>>Vacaciones
                    (Empleado específico)</option>
            </select>
        </div>

        <!-- Información del empleado (solo para vacaciones) -->
        <div id="empleadoField" style="display: none;">
            <label for="">Empleado</label>
            <select id="select2" class="form-select mb-3" name="EmpleadoId" required>
                <?php
                $resultadoEmpleados = $conexion->query("SELECT empleados.id,   
                                                           usuarios.nombre,   
                                                           usuarios.apellido,  
                                                           roles.nombre as rol_nombre  
                                                    FROM empleados  
                                                    INNER JOIN usuarios ON empleados.empleado_id = usuarios.id  
                                                    INNER JOIN roles ON empleados.rol_id = roles.id  
                                                    WHERE empleados.activo = 1  
                                                    ORDER BY usuarios.nombre ASC");
                while ($empleado = $resultadoEmpleados->fetch_assoc()) {
                    $selected = ($empleado['id'] == $row['empleado_id']) ? 'selected' : '';
                    echo "<option value='" . $empleado['id'] . "' $selected>" . $empleado['nombre'] . " " . $empleado['apellido'] . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Fecha de inicio -->
        <div class="mb-3">
            <label class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" name="FechaInicio" value="<?php echo $row['fecha_inicio']; ?>"
                required>
        </div>

        <!-- Fecha de fin -->
        <div class="mb-3">
            <label class="form-label">Fecha de Fin</label>
            <input type="date" class="form-control" name="FechaFin" value="<?php echo $row['fecha_fin']; ?>" required>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="Descripcion" value="<?php echo $row['descripcion']; ?>"
                placeholder="Ej: Día del Trabajador, Vacaciones anuales">
        </div>

        <!-- Botones -->
        <div class="text-center">
            <button type="submit" class="btn btn-dark">Actualizar</button>
            <a href="../../pages/dia_no_laboral.php" class="btn btn-dark">Cancelar</a>
        </div>
    </form>

    <script>
        // Mostrar o ocultar el campo de empleado según el tipo de dia no laboral seleccionado
        function toggleEmpleadoField() {
            const motivo = document.getElementById('motivo').value;
            const empleadoField = document.getElementById('empleadoField');
            const empleadoSelect = empleadoField.querySelector('select');

            if (motivo === 'Vacaciones') {
                empleadoField.style.display = 'block';
                empleadoSelect.required = true;
            } else {
                empleadoField.style.display = 'none';
                empleadoSelect.required = false;
                empleadoSelect.value = '';
            }
        }

        // Inicializar al cargar      
        document.addEventListener('DOMContentLoaded', function() {
            toggleEmpleadoField();

        });
    </script>

    <!-- Incluir Flatpickr -->
    <?php include('../../src/includes/Dependencias/Flatpickr.php'); ?>
    <!-- Incluir Select2 -->
    <?php include('../../src/includes/Dependencias/Select2.php'); ?>

</body>

</html>