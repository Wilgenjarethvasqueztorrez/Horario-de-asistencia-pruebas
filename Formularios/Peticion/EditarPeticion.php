<?php
require("../../Config/Conexion.php");

$id = $_GET['Id'];

// Traer la petición junto con el nombre completo del empleado
$sql = $conexion->query("
    SELECT p.*, u.nombre, u.apellido
    FROM peticiones p
    INNER JOIN empleados e ON p.empleado_id = e.id
    INNER JOIN usuarios u ON e.empleado_id = u.id
    WHERE p.id = $id
");
$peticion = $sql->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Petición</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../src/css/styles.css" />
</head>

<body>

    <h1 class="bg-primary p-2 text-white text-center">Editar Petición</h1>
    <div class="container mt-4">
        <form action="../../CRUD/Peticion/editarPeticion.php" method="post">

            <input type="hidden" name="Id" value="<?php echo $peticion['id']; ?>">

            <!-- Nombre del Empleado (solo lectura) -->
            <div class="mb-3">
                <label class="form-label">Empleado</label>
                <input type="text" class="form-control"
                    value="<?php echo $peticion['nombre'] . ' ' . $peticion['apellido']; ?>"
                    disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control"
                    name="DescripcionPeticion"
                    value="<?php echo $peticion['descripcion']; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="Estado" class="form-select">
                    <option value="Pendiente" <?php if ($peticion['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="Aprobada" <?php if ($peticion['estado'] == 'Aprobada') echo 'selected'; ?>>Aprobada</option>
                    <option value="Rechazada" <?php if ($peticion['estado'] == 'Rechazada') echo 'selected'; ?>>Rechazada</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark">Actualizar</button>
                <a href="../../pages/peticion.php" class="btn btn-dark">Cancelar</a>
            </div>

        </form>
    </div>

</body>

</html>