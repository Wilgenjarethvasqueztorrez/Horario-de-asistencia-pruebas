<?php  
session_start();  
  
// Si ya está logueado, redirigir a usuarios.php  
if (isset($_SESSION['usuario_id'])) {  
    header("location: index.php");  
    exit();  
}  
?>  
<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Inicio de Sesión</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
</head>  
<body class="bg-light">  
    <div class="container">  
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">  
            <div class="col-md-5">  
                <div class="card shadow">  
                    <div class="card-body p-5">  
                        <h2 class="text-center mb-4">  
                            <i class="bi bi-person-circle"></i> Iniciar Sesión  
                        </h2>  
                          
                        <?php  
                        // Mostrar mensaje de error si existe  
                        if (isset($_GET['error'])) {  
                            echo '<div class="alert alert-danger" role="alert">';  
                            if ($_GET['error'] == 'credenciales') {  
                                echo 'Correo o contraseña incorrectos';  
                            } elseif ($_GET['error'] == 'sesion') {  
                                echo 'Debe iniciar sesión para acceder';  
                            }  
                            echo '</div>';  
                        }  
                        ?>  
                          
                        <form action="CRUD/validarLogin.php" method="post">  
                            <div class="mb-3">  
                                <label class="form-label">Correo Electrónico</label>  
                                <div class="input-group">  
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>  
                                    <input type="email" class="form-control" name="Correo" placeholder="usuario@ejemplo.com" required autofocus>  
                                </div>  
                            </div>  
                              
                            <div class="mb-3">  
                                <label class="form-label">Contraseña</label>  
                                <div class="input-group">  
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>  
                                    <input type="password" class="form-control" name="Password" placeholder="••••••••" required>  
                                </div>  
                            </div>  
                              
                            <div class="d-grid">  
                                <button type="submit" class="btn btn-primary btn-lg">  
                                    <i class="bi bi-box-arrow-in-right"></i> Ingresar  
                                </button>  
                            </div>  
                        </form>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>