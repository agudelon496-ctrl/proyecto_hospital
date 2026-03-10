<?php
session_start();
require_once "config/conexion.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE username = :username AND password = :password";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(":username",$username);
$stmt->bindParam(":password",$password);

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){

$_SESSION['usuario'] = $user['username'];
$_SESSION['rol'] = $user['rol'];

header("Location: dashboard.php");

}else{

echo "Usuario o contraseña incorrectos";

}
?>