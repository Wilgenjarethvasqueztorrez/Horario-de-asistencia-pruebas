<?php  
session_start();  
include("../../Config/Conexion.php");  
  
// Verificar que existe la sesión temporal  
if (!isset($_SESSION['temp_usuario_id'])) {  
    header("location: ../../Formularios/Login/login.php");  
    exit();  
}  
  
// Recibir datos del formulario  
$usuario_id = $_POST['UsuarioId'];  
$password = $_POST['Password'];  
$confirmar_password = $_POST['ConfirmarPassword'];  
  
// Validar que las contraseñas coincidan  
if ($password !== $confirmar_password) {  
    header("location: ../../Formularios/Login/establecerPassword.php?error=no_coinciden");  
    exit();  
}  
  
// Validar longitud mínima  
if (strlen($password) < 6) {  
    header("location: ../../Formularios/Login/establecerPassword.php?error=muy_corta");  
    exit();  
}  
  
// Hashear la contraseña  
$password_hash = password_hash($password, PASSWORD_DEFAULT);  
  
// Actualizar la contraseña en la base de datos  
$sql = "UPDATE usuarios SET password = '$password_hash' WHERE id = $usuario_id";  
  
if (mysqli_query($conexion, $sql)) {  
    // Contraseña guardada exitosamente  
    // Obtener datos del usuario para crear la sesión completa  
    $sqlUsuario = "SELECT id, nombre, apellido, correo, rol_sistema   
                   FROM usuarios   
                   WHERE id = $usuario_id";  
    $resultado = $conexion->query($sqlUsuario);  
    $usuario = $resultado->fetch_assoc();  
      
    // Limpiar sesión temporal  
    unset($_SESSION['temp_usuario_id']);  
      
    // Crear sesión completa  
    $_SESSION['usuario_id'] = $usuario['id'];  
    $_SESSION['usuario_nombre'] = $usuario['nombre'];  
    $_SESSION['usuario_apellido'] = $usuario['apellido'];  
    $_SESSION['usuario_correo'] = $usuario['correo'];  
    $_SESSION['usuario_rol'] = $usuario['rol_sistema'];  
      
        // Redirigir según el rol  
        if ($usuario['rol_sistema'] == 'Administrador') {    
            header("location: ../../index.php");    
         } elseif ($usuario['rol_sistema'] == 'Oficina') {    
            header("location: ../../empleado.php");    
         } else {  // Empleado  
            header("location: ../../perfil_empleado.php");    
        }    
        exit();
} else {  
    // Error al guardar  
    header("location: ../../Formularios/Login/establecerPassword.php?error=db");  
    exit();  
}  
