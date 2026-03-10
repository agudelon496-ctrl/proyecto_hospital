<?php
session_start();

if(!isset($_SESSION['usuario'])){
header("Location:index.php");
}

echo "Bienvenido ".$_SESSION['usuario'];
?>

<h2>Panel Hospital</h2>

<a href="camas.php">Ver Camas</a>