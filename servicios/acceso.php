<?php
include_once('../clases/init.php');

$datos->user = trim($user);
$datos->clave = trim($pass);
$datos->uuid = $uuid;

include_once('../clases/usuarios.php');
$obj = new usuarios();
$acceso = $obj->accesoSitio($datos);

echo $acceso->resultado;
?>