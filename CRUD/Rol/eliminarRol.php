<?php  
include("../../Config/Conexion.php");  
  
// Recibir el ID del rol a eliminar  
$id = $_GET['Id'];  
  
// Eliminar el rol de la base de datos  
$sql = "DELETE FROM roles WHERE id=$id";  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/rol.php?success=eliminado");  
} else {  
    header("location:../../pages/rol.php?error=db");  
}