<?php  
include("../../Config/Conexion.php");  
  
// Recibir el ID de la asistenca a eliminar  
$id = $_GET['Id'];  
  
// Eliminar la asistencia de la base de datos  
$sql = "DELETE FROM asistencias WHERE id=$id";  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/asistencia.php?success=eliminado");  
} else {  
    header("location:../../pages/asistencia.php?error=db");  
}