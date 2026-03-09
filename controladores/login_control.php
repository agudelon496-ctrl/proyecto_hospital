<?php

session_start();

require_once "../config/conexion.php";

$db=(new Conexion())->conectar();

$usuario=$_POST['usuario'];
$password=$_POST['password'];

$sql="SELECT * FROM usuarios WHERE username=:usuario";

$stmt=$db->prepare($sql);

$stmt->bindParam(":usuario",$usuario);

$stmt->execute();

$user=$stmt->fetch(PDO::FETCH_ASSOC);

if($user){

    if($password==$user['password']){

        $_SESSION['usuario']=$user['username'];
        $_SESSION['rol']=$user['fk_rol'];

        header("Location: ../panel/dashboard.php");

    }else{

        echo "Contraseña incorrecta";

    }

}else{

    echo "Usuario no encontrado";

}

?>