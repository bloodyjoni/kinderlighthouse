<?php
include_once("clases/init.php");
include_once('clases/imagenes.php');

$thumb = new imagenes();
$resultado = $thumb->cropImagen($imagen,$ancho);
?>