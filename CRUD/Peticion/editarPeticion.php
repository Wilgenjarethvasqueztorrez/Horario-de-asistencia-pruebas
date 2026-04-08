<?php
require("../../Config/Conexion.php");

$id = $_POST['Id'];
$descripcion = $_POST['DescripcionPeticion'];
$estado = $_POST['Estado'];

$stmt = $conexion->prepare("
    UPDATE peticiones 
    SET descripcion = ?, estado = ? 
    WHERE id = ?
");

$stmt->bind_param("ssi", $descripcion, $estado, $id);

if ($stmt->execute()) {
    header("Location: ../../pages/peticion.php?success=editado");
} else {
    header("Location: ../../pages/peticion.php?error=db");
}
exit();