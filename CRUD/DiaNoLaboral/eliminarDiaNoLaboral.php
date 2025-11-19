<?php  
include("../../Config/Conexion.php");  
  
// Recibir el ID del dia no laboral a eliminar  
$id = $_GET['Id'];  
  
// Eliminar el dia no laboral de la base de datos
$sql = "DELETE FROM dias_no_laborales WHERE id=$id";  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../../dia_no_laboral.php?success=eliminado");  
} else {  
    header("location:../../dia_no_laboral.php?error=db");  
}