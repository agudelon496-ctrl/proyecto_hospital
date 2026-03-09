<?php
session_start();

if(!isset($_SESSION['usuario'])){

header("Location: ../vistas/login.php");

}

?>

<h1>Bienvenido al sistema MedicarFlow</h1>

<p>Usuario: <?php echo $_SESSION['usuario']; ?></p>

<a href="../logout.php">Cerrar sesión</a>