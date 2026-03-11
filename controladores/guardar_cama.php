<?php
/**
 * Controlador para guardar datos de una cama.
 * Actualmente solo valida sesión y recoge variables POST.
 * TODO: implementar inserción en la base de datos.
 */
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:../index.html");
    exit();
}

// Aquí irá la lógica de guardar en base de datos
// Por ahora solo confirmamos que funciona

$numero = isset($_POST['numero']) ? $_POST['numero'] : '';
$paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$diagnostico = isset($_POST['diagnostico']) ? $_POST['diagnostico'] : '';

// TODO: Insertar en base de datos
// INSERT INTO camas VALUES (...)

// Redireccionar
header("Location:../vistas/listar_camas.php");
exit();
?>