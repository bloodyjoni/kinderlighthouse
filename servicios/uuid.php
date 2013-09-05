<?php
include_once('../clases/init.php');
include_once('../clases/usuarios.php');

$objuuid = new usuarios();
$resultado = $objuuid->buscarUuid($uuid);

echo $resultado->cantidad;
?>