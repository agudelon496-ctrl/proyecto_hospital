<?php
/**
 * Controlador de cierre de sesión.
 * Destruye la sesión y redirige al formulario de login.
 */
session_start();
session_destroy();
header("Location:../index.html");
exit();
?>