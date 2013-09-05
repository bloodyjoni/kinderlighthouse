<?php
include_once('../../clases/init.php');
include_once('../../clases/usuarios.php');

if($accion == 'modificar'){
	$datos->id = $_SESSION['id'];
	$datos->pass = $pass;
	$datos->nueva1 = $nueva1;
	$datos->nueva2 = $nueva2;
	
	$obj = new usuarios();
	$editar = $obj->editarClave($datos);
	
	echo $editar->resultado;
}
?>