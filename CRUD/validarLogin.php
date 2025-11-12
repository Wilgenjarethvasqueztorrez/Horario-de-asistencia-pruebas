<?php  
session_start();  
include("../Config/Conexion.php");  
  
$correo = $_POST['Correo'];  
$password = $_POST['Password'];  
  
$sql = "SELECT id, nombre, apellido, correo, rol_sistema, password   
        FROM usuarios   
        WHERE correo = '$correo'";  
  
$resultado = $conexion->query($sql);  
  
if ($resultado->num_rows > 0) {  
    $usuario = $resultado->fetch_assoc();  
      
    // Verificar si el usuario tiene contraseña establecida  
    if ($usuario['password'] === NULL || $usuario['password'] === '') {  
        // Usuario sin contraseña - redirigir a establecer contraseña  
        $_SESSION['temp_usuario_id'] = $usuario['id'];  
        header("location: ../Formularios/establecerPassword.php");  
        exit();  
    }  
      
    // Verificar contraseña  
    if (password_verify($password, $usuario['password'])) {  
        // Contraseña correcta - Crear sesión  
        $_SESSION['usuario_id'] = $usuario['id'];  
        $_SESSION['usuario_nombre'] = $usuario['nombre'];  
        $_SESSION['usuario_apellido'] = $usuario['apellido'];  
        $_SESSION['usuario_correo'] = $usuario['correo'];  
        $_SESSION['usuario_rol'] = $usuario['rol_sistema'];  
          
        if ($usuario['rol_sistema'] == 'Administrador') {  
            header("location: ../index.php");  
        } else {  
            header("location: ../empleado.php");  
        }  
        exit();  
    } else {  
        header("location: ../login.php?error=credenciales");  
        exit();  
    }  
} else {  
    header("location: ../login.php?error=credenciales");  
    exit();  
}  
