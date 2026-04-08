<?php

include ("../../Config/Conexion.php");

$Id = $_GET['Id'];
$sql = "DELETE FROM peticiones WHERE id=".$Id."";

$query = mysqli_query($conexion,$sql);

if (mysqli_query($conexion, $sql)) {  
    header("location:../../pages/peticion.php?success=eliminado");  
} else {  
    header("location:../../pages/peticion.php?error=db");  
}