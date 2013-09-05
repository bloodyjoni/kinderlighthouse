<?php 
//includes
include_once('bdConfig.php');

class bd {
	//properties
	var $servidor ;
	var $usuario ;
	var $clave ;
	var $base ;	
	var $conexion;
	var $sql;
	var $datos;	
	var $ultimoId;
	var $estado = true;
	var $cantidad;	
	var $mensaje;
	var $mailsitio;
	var $nombresitio;
	
	//constructor
	function __construct(){
		$bdConfig = new bdConfig(); 
		$this->servidor		= $bdConfig->servidor;
		$this->usuario		= $bdConfig->usuario;
		$this->clave		= $bdConfig->clave;
		$this->base			= $bdConfig->base;
		$this->mailsitio	= $bdConfig->mailsitio;
		$this->nombresitio	= $bdConfig->nombresitio;
	}
	
	//methods ---------------------------------------------------------------
	function conectar(){
		$this->conexion = mysql_connect($this->servidor, $this->usuario, $this->clave);
		mysql_select_db($this->base, $this->conexion) or die(mysql_error());
		return $this->conexion;
	}
	//-----------------------------------------------------------------------
	function consultar($sql){
		$this->sql = $sql;
		if($this->conexion && $this->sql != ''){
			$this->datos = mysql_query($this->sql, $this->conexion);
			if($this->datos){
					$this->cantidad		= mysql_affected_rows();
					$this->ultimoId		= mysql_insert_id();
					$this->estado		= true;
					$this->mensaje		= "Ok";
			}else{
				$this->cantidad		= 0;
				$this->estado		= false;
				$this->mensaje		= "Error en la consulta SQL";
			}
		}else{
			$this->estado		= false;
			if(!$this->conexion){
				$this->mensaje		= "Error, no se realizó la conexión a la base de datos";
			}else{
				$this->mensaje		= "Error, la consulta no puede estar vacía";
			}
		}
	}
	//-----------------------------------------------------------------------	
	function cerrarConexion(){
		if($this->conexion){
			mysql_close($this->conexion);
		}
	}
}
?>