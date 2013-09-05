<?php
include_once('../../clases/init.php');
include_once('../../clases/usuarios.php');

$datos->usuario = $user;
$datos->clave = $pass;

$obj = new usuarios();
$conectar = $obj->logueoCMS($datos);

echo $conectar->resultado;
?>