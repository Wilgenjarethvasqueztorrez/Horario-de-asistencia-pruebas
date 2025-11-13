<?php  
include("../Config/Conexion.php");  
  
$id = $_POST['Id'];  
$empleadoId = $_POST['EmpleadoId'];  
$fecha = $_POST['Fecha'];  
$horaEntrada = $_POST['HoraEntrada'];  
$horaSalida = $_POST['HoraSalida'];  
$totalHoras = $_POST['TotalHoras'];  
  
// Si no hay hora de salida, total de horas es NULL  
if (empty($horaSalida)) {  
    $sql = "UPDATE asistencias   
            SET empleado_id='$empleadoId',   
                fecha='$fecha',   
                hora_entrada='$horaEntrada',   
                hora_salida=NULL,   
                total_horas=NULL   
            WHERE id=$id";  
} else {  
    $sql = "UPDATE asistencias   
            SET empleado_id='$empleadoId',   
                fecha='$fecha',   
                hora_entrada='$horaEntrada',   
                hora_salida='$horaSalida',   
                total_horas='$totalHoras'   
            WHERE id=$id";  
}  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../asistencia.php");  
} else {  
    echo "Error al actualizar: " . mysqli_error($conexion);  
}  
