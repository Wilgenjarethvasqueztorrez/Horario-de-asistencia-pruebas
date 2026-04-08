<?php  
include("../../Config/Conexion.php");  
  
$usuario_id = $_POST['UsuarioId'];  
$rol_id = $_POST['RolId'];  
$activo = $_POST['Activo'];  
  
$sql = "INSERT INTO empleados (empleado_id, rol_id, activo)   
        VALUES ($usuario_id, $rol_id, $activo)";  
  
if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/empleado.php?success=agregado");  
} else {  
    header("location:../../pages/empleado.php?error=db");  
}