<?php

include_once('../../clases/init.php');
include_once('../../clases/agenda.php');

$datos->id = $id;
$datos->fecha = trim($fecha);
$datos->titulo = utf8_decode(trim($titulo));
$datos->texto = utf8_decode($texto);

$obj = new agenda();

if($accion == "crear"){
	$consulta = $obj->crearEvento($datos);
}
if($accion == "modificar"){
	if($e == 1){
		$consulta = $obj->mofificoEvento($datos);
	}else{
		$consulta->estado = "Operacion no permitida";
	}
}

if($consulta->cargado){
	echo("<script language=\"javascript\">");
	echo("top.location.href = \"../agenda_editar.php?id=" . $consulta->id . "&e=1\";");
	echo("</script>");
}

echo $consulta->estado;
?>