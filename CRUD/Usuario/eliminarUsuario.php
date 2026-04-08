<?php  
include("../../Config/Conexion.php");  
  
// Recibir el ID del usuario a eliminar  
$id = $_GET['Id'];  
  
// Eliminar el usuario de la base de datos  
$sql = "DELETE FROM usuarios WHERE id=$id";  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/usuario.php?success=eliminado");  
} else {  
    header("location:../../pages/usuario.php?error=db");  
}