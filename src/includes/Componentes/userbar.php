<!--Consulta-->
<?php
// A partir de aquí:  
require(BASE_PATH . "Config/Conexion.php");

$result = $conexion->query("
    SELECT id, descripcion
    FROM peticiones 
    WHERE estado = 'pendiente' 
    LIMIT 5
");

$peticiones = [];
while ($row = $result->fetch_assoc()) {
    $peticiones[] = $row;
}

$totalpendientes = $conexion->query("
    SELECT COUNT(*) as total 
    FROM peticiones 
    WHERE estado = 'pendiente'
")->fetch_assoc()['total'];
?>
<!-- Agregar barra de usuario logueado -->
<div class="user-header-bar">
    <div class="user-info-section">
        <a href="<?php echo BASE_URL; ?>pages/perfil.php">
            <div class="user-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
        </a>
        <div class="user-details">
            <span class="welcome-text">Bienvenido/a,</span>
            <div class="user-name">
                <?php echo $_SESSION['usuario_nombre'] . ' ' . $_SESSION['usuario_apellido']; ?>
            </div>
            <span class="badge role-badge"><?php echo $_SESSION['usuario_rol']; ?></span>
            <div class="notification-wrapper">

                <div class="dropdown">
                    <a class="notification-bell <?php echo ($totalpendientes > 0 ? 'has-notification' : ''); ?>"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <i class="bi bi-bell-fill"></i>

                        <?php if ($totalpendientes > 0): ?>
                            <span class="badge notification-badge">
                                <?php echo ($totalpendientes > 9) ? '9+' : $totalpendientes; ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <!-- Dropdown -->
                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown">

                        <li class="dropdown-header">
                            Peticiones Pendientes
                        </li>

                        <?php if (count($peticiones) > 0): ?>
                            <?php foreach ($peticiones as $p): ?>
                                <li>
                                    <a class="dropdown-item notification-item" href="peticion.php">
                                        <strong>#<?php echo $p['id']; ?></strong><br>
                                        <small><?php echo $p['descripcion']; ?></small>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="dropdown-item text-center text-muted">
                                No hay pendientes
                            </li>
                        <?php endif; ?>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item text-center fw-bold" href="<?php echo BASE_URL; ?>pages/peticion.php">
                                Ver todas
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
    <a href="<?php echo BASE_URL; ?>CRUD/Login/cerrarSesion.php" class="btn-logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Cerrar Sesión</span>
    </a>
</div>