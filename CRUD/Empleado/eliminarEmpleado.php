<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM empleados WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if (mysqli_query($conexion, $sql)) {  
    header("location:../../empleado.php?success=eliminado");  
} else {  
    header("location:../../empleado.php?error=db");  
}