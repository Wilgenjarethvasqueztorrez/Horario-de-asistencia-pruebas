<?php        
// Proteger la página        
require("Config/verificarSesion.php");        
        
// Solo administradores y oficina pueden ver esta página        
verificarRol(['Administrador','Oficina']);        
      
require("Config/Conexion.php");      
      
// Obtener información del usuario actual    
$usuario_id = $_SESSION['usuario_id'];      
$sql_usuario = $conexion->query("SELECT nombre, apellido, correo, rol_sistema     
                                  FROM usuarios     
                                  WHERE id = $usuario_id");      
$usuario = $sql_usuario->fetch_assoc();      
?>        
<!doctype html>        
<html lang="es">        
<head>        
  <meta charset="UTF-8">        
  <meta name="viewport" content="width=device-width, initial-scale=1">        
  <title>Mi Perfil</title>        
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">      
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">      
  <link rel="stylesheet" href="src/css/styles.css">      
</head>       
<body>        
        
  <?php include('src/includes/Componentes/sidebar.php'); ?>        
      
  <main class="container mt-4">        
    <?php include('src/includes/Componentes/userbar.php'); ?>      
      
    <h1 class="bg-primary p-3 text-white text-center rounded">👤 MI PERFIL</h1>        
      
    <!-- Información Personal -->      
    <div class="row mt-4 g-3">      
      <div class="col-md-8">      
        <div class="card shadow-sm">      
          <div class="card-header bg-primary text-white">    
            <h5 class="mb-0"><i class="bi bi-person-circle"></i> Información Personal</h5>    
          </div>    
          <div class="card-body">      
            <div class="row mb-3">    
              <div class="col-md-6">    
                <label class="text-muted small">Nombre Completo</label>    
                <p class="fw-bold mb-0"><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></p>    
              </div>    
              <div class="col-md-6">    
                <label class="text-muted small">Correo Electrónico</label>    
                <p class="mb-0">    
                  <i class="bi bi-envelope"></i> <?php echo $usuario['correo']; ?>    
                </p>    
              </div>    
            </div>    
            <div class="row mb-3">    
              <div class="col-md-6">    
                <label class="text-muted small">Rol del Sistema</label>    
                <p class="mb-0">    
                  <?php     
                  $badge_class = '';    
                  $icon = '';    
                  switch($usuario['rol_sistema']) {    
                    case 'Administrador':    
                      $badge_class = 'bg-danger';    
                      $icon = 'bi-shield-fill-check';    
                      break;    
                    case 'Oficina':    
                      $badge_class = 'bg-warning text-dark';    
                      $icon = 'bi-briefcase-fill';    
                      break;    
                  }    
                  echo "<span class='badge $badge_class'><i class='bi $icon'></i> ".$usuario['rol_sistema']."</span>";    
                  ?>    
                </p>    
              </div>    
              <div class="col-md-6">    
                <label class="text-muted small">Fecha de Hoy</label>    
                <p class="mb-0">    
                  <i class="bi bi-calendar-event"></i> <?php echo date('d/m/Y'); ?>    
                </p>    
              </div>    
            </div>    
            <hr>    
            <div class="alert alert-info mb-0">    
              <i class="bi bi-info-circle"></i>     
              <strong>Permisos:</strong> Como <?php echo $usuario['rol_sistema']; ?>, tienes acceso completo a la gestión del sistema.    
            </div>    
          </div>      
        </div>      
      </div>    
  
      <!-- Configuración de Cuenta -->    
      <div class="col-md-4">    
        <div class="card shadow-sm">    
          <div class="card-header bg-secondary text-white">    
            <h5 class="mb-0"><i class="bi bi-gear-fill"></i> Configuración de Cuenta</h5>    
          </div>    
          <div class="card-body">    
            <ul class="list-unstyled mb-0">    
              <li class="mb-2">    
                <i class="bi bi-check-circle text-success"></i> Cuenta verificada    
              </li>    
              <li class="mb-2">    
                <i class="bi bi-shield-check text-primary"></i> Acceso de nivel: <?php echo $usuario['rol_sistema']; ?>    
              </li>    
              <li class="mb-2">    
                <i class="bi bi-clock-history text-info"></i> Última sesión: <?php echo date('d/m/Y H:i'); ?>    
              </li>    
            </ul>    
          </div>    
        </div>    
      </div>    
    </div>    
  </main>        
      
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>        
</body>        
</html>