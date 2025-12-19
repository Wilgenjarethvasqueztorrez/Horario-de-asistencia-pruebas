<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Editar Asistencia</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Flatpickr -->  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">  
    <!-- Agregar Select2 -->  
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />   
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>  
<body>  
    <h1 class="bg-primary p-2 text-white text-center">Editar Asistencia</h1>  
    <div class="container">  
        <?php  
        include("../../Config/Conexion.php");  
          
        // Obtener datos de la asistencia a editar  
        $id = $_GET['Id'];  
        $sql = $conexion->query("SELECT * FROM asistencias WHERE id = $id");  
        $datos = $sql->fetch_assoc();  
        ?>  
          
        <form action="../../CRUD/Asistencia/editarAsistencia.php" method="post">  
            <input type="hidden" name="Id" value="<?php echo $datos['id']; ?>">  
              
            <!-- Seleccionar empleado -->  
            <label for="">Empleado</label>  
            <select id="select2" class="form-select mb-3" name="EmpleadoId" required>  
                <?php  
                $sqlEmpleados = $conexion->query("SELECT empleados.id,   
                                                         usuarios.nombre,   
                                                         usuarios.apellido,  
                                                         roles.nombre as rol_nombre  
                                                  FROM empleados  
                                                  INNER JOIN usuarios ON empleados.empleado_id = usuarios.id  
                                                  INNER JOIN roles ON empleados.rol_id = roles.id  
                                                  WHERE empleados.activo = 1  
                                                  ORDER BY usuarios.nombre ASC");  
                while ($empleado = $sqlEmpleados->fetch_assoc()) {  
                    $selected = ($empleado['id'] == $datos['empleado_id']) ? 'selected' : '';  
                    echo "<option value='".$empleado['id']."' $selected>".$empleado['nombre']." ".$empleado['apellido']." - ".$empleado['rol_nombre']."</option>";  
                }  
                ?>  
            </select>  
  
            <!-- Fecha -->  
            <div class="mb-3">  
                <label class="form-label">Fecha</label>  
                <input type="date" class="form-control" name="Fecha" value="<?php echo $datos['fecha']; ?>" required>  
            </div>  
  
            <!-- Hora de entrada -->  
            <div class="mb-3">  
                <label class="form-label">Hora de Entrada</label>  
                <input type="time" class="form-control" name="HoraEntrada" id="horaEntrada" value="<?php echo $datos['hora_entrada']; ?>" required>  
            </div>  
  
            <!-- Hora de salida -->  
            <div class="mb-3">  
                <label class="form-label">Hora de Salida</label>  
                <input type="time" class="form-control" name="HoraSalida" id="horaSalida" value="<?php echo $datos['hora_salida']; ?>">  
            </div>  
  
            <!-- Total de horas -->  
            <div class="mb-3">  
                <label class="form-label">Total de Horas</label>  
                <input type="text" class="form-control" name="TotalHoras" id="totalHoras" value="<?php echo $datos['total_horas']; ?>" readonly>  
            </div>  
  
            <script>  
                function calcularHoras() {  
                    const entrada = document.getElementById("horaEntrada").value;  
                    const salida = document.getElementById("horaSalida").value;  
  
                    if (entrada && salida) {  
                        const [hEntrada, mEntrada] = entrada.split(":").map(Number);  
                        const [hSalida, mSalida] = salida.split(":").map(Number);  
  
                        const entradaMin = hEntrada * 60 + mEntrada;  
                        const salidaMin = hSalida * 60 + mSalida;  
  
                        let totalMin = salidaMin - entradaMin;  
                        if (totalMin < 0) totalMin += 24 * 60;  
  
                        const horas = Math.floor(totalMin / 60);  
                        const minutos = totalMin % 60;  
                          
                        const totalDecimal = (horas + minutos / 60).toFixed(2);  
                        document.getElementById("totalHoras").value = totalDecimal;  
                    }  
                }  
  
                document.addEventListener("DOMContentLoaded", function() {  
                    document.getElementById("horaEntrada").addEventListener("change", calcularHoras);  
                    document.getElementById("horaSalida").addEventListener("change", calcularHoras);  
                });  
            </script>  
  
            <div class="text-center">  
                <button type="submit" class="btn btn-primary">Actualizar</button>  
                <a href="../../asistencia.php" class="btn btn-dark">Cancelar</a>  
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