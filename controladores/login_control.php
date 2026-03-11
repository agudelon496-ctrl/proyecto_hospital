<?php
/**
 * Controlador de login.
 * Recibe usuario y password via POST,
 * valida contra una lista fija (simulando BD),
 * establece sesión y redirige o muestra error.
 */
session_start();

// Obtener datos del formulario
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Usuarios de prueba (en producción estos vendrían de la BD)
$usuarios_validos = array(
    array('usuario' => 'admin', 'password' => '123', 'rol' => 'administrador'),
    array('usuario' => 'doctor', 'password' => '456', 'rol' => 'doctor'),
    array('usuario' => 'enfermera', 'password' => '789', 'rol' => 'enfermera'),
);

// Buscar usuario
$usuario_encontrado = null;
foreach($usuarios_validos as $u) {
    if($u['usuario'] === $usuario && $u['password'] === $password) {
        $usuario_encontrado = $u;
        break;
    }
}

// Validar credenciales
if($usuario_encontrado) {
    $_SESSION['usuario'] = $usuario_encontrado['usuario'];
    $_SESSION['rol'] = $usuario_encontrado['rol'];
    header("Location:panel/dashboard.php");
    exit();
} else {
    // Redirigir con error
    header("Location:../index.html?error=1");
    exit();
}
?>