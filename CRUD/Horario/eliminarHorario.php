<?php
include ("../../Config/Conexion.php");

// Recibir el ID del horario a eliminar  
$Id = $_GET['Id'];

// Eliminar el horario de la base de datos  
$sql = "DELETE FROM horarios WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if (mysqli_query($conexion, $sql)) {  
    header("location:../../horario.php?success=eliminado");  
} else {  
    header("location:../../horario.php?error=db");  
}