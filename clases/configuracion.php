<?php 
//Iclusiones
include_once('bd.php');

class configuracion {
	//Propiedades
	var $base;
	var $datos;
	
	//Constructor
	function __construct(){
		$this->base = new bd();
		$this->base->conectar();
	}
	//------------------------------------------------------------
	function getConfig(){
		$sql = "SELECT * FROM klh_config";
		$this->base->consultar($sql);
		if($this->base->estado){
			$cantidad = $this->base->cantidad;
			$this->datos->cantidad = $cantidad;
			if($cantidad > 0){
				while($resultado = mysql_fetch_object($this->base->datos)){
					$this->datos->items->{'item'. $resultado->id}->id = $resultado->id;
					$this->datos->items->{'item'. $resultado->id}->nombre = utf8_encode($resultado->nombre);
					$this->datos->items->{'item'. $resultado->id}->valor = $resultado->valor;
				}
			}
		}else{
			$this->datos->cantidad = 0;
		}
		return $this->datos;
	}
	//------------------------------------------------------------
	function editConfig($d){
		$sql = "UPDATE klh_config SET valor = '$d->valor1' WHERE id = 1";
		$this->base->consultar($sql);
		if($this->base->estado){
			$sql = "UPDATE klh_config SET valor = '$d->valor2' WHERE id = 2";
			$this->base->consultar($sql);
			if($this->base->estado){
				$this->datos->resultado = "Datos cambiados con éxito";
			}else{
				$this->datos->resultado = "Error en la consulta SQL";
			}
		}else{
			$this->datos->resultado = "Error en la consulta SQL";
		}
		return $this->datos;
	}
	//-----------------------------------------------------------------------
}
?>