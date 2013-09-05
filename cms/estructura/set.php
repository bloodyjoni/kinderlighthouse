<?php
include_once('../../clases/init.php');
include_once('../../clases/configuracion.php');

if($accion == 'modificar'){
	$datos->valor1 = str_replace(':', '.', $valor1);
	$datos->valor2 = str_replace(':', '.', $valor2);
	
	$obj = new configuracion();
	$editar = $obj->editConfig($datos);
	
	echo $editar->resultado;
}
?>