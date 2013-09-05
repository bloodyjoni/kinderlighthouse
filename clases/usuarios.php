<?php 
//includes
include_once('bd.php');

class usuarios {
	//properties
	var $base;
	var $configuracion;
	var $datos;
	
	//constructor
	function usuarios(){
		$this->base = new bd();
		$this->base->conectar();
	}
	
	//methods ---------------------------------------------------------------
	function deslogueoUsuario(){
		session_start();
		session_unset();
		session_destroy();
		
		$this->datos->resultado = "OK";
		
		return $this->datos;
	}
	//-----------------------------------------------------------------------
	function accesoSitio($d){
		if($d->user != '' && $d->clave != ''){
			$d->user = trim($d->user);
			$d->clave = trim($d->clave);
			$d->clave = md5($d->clave);
			$sql = "SELECT * FROM klh_acceso WHERE usuario = '$d->user'";
			$this->base->consultar($sql);
			if($this->base->estado){
				if($this->base->cantidad == 1){
					$resultado = mysql_fetch_object($this->base->datos);
					if($d->clave == $resultado->clave){
						$sql = "INSERT INTO klh_usuarios (uuid) VALUES ('$d->uuid')";
						$this->base->consultar($sql);
						$this->datos->resultado = "OK";
					}else{
						$this->datos->resultado = "Contraseña incorrecta";
					}
				}else{
					$this->datos->resultado = "Usuario incorrecto";
				}
			}else{
				$this->datos->resultado = "Error en la consulta SQL";
			}
		}else{
			$this->datos->resultado = "No se puede acceder. Faltan parámetros";
		}
		return $this->datos;
	}
	//-----------------------------------------------------------------------
	function logueoCMS($d){
		if($d->usuario != '' && $d->clave != ''){
			$d->usuario = trim($d->usuario);
			$d->clave = trim($d->clave);
			$d->clave = md5($d->clave);
			$sql = "SELECT * FROM klh_cms_usuarios WHERE usuario = '$d->usuario'";
			$this->base->consultar($sql);
			if($this->base->estado){
				if($this->base->cantidad == 1){
					$resultado = mysql_fetch_object($this->base->datos);
					if($d->clave == $resultado->clave){
						session_start();
						$_SESSION['cms'] = true;
						$_SESSION['id'] = $resultado->id;
						$_SESSION['usuario'] = $resultado->usuario;
						
						$this->datos->resultado = "OK";
					}else{
						$this->datos->resultado = "Contraseña incorrecta";
					}
				}else{
					$this->datos->resultado = "Usuario incorrecto";
				}
			}else{
				$this->datos->resultado = "Error en la consulta SQL";
			}
		}else{
			$this->datos->resultado = "No se puede acceder. Faltan parámetros";
		}
		$this->base->cerrarConexion();
		return $this->datos;
	}
	//-----------------------------------------------------------------------
	function buscarUuid($uuid){
		$sql = "SELECT uuid FROM klh_usuarios WHERE uuid = '$uuid'";
		$this->base->consultar($sql);
		if($this->base->estado){
			$this->datos->cantidad = $this->base->cantidad;
		}else{
			$this->datos->cantidad = 0;
		}
		return $this->datos;
	}
	//-----------------------------------------------------------------------
	function editarClave($d){
		$pass = md5($d->pass);
		$sql = "SELECT * FROM klh_cms_usuarios WHERE id = $d->id AND clave = '$pass'";
		$this->base->consultar($sql);
		if($this->base->estado){
			if($this->base->cantidad == 1){
				if($d->nueva1 == $d->nueva2){
					$pass = md5($d->nueva1);
					$sql = "UPDATE klh_cms_usuarios SET clave = '$pass' WHERE id = $d->id";
					$this->base->consultar($sql);
					
					$this->datos->resultado = "Contraseña cambiada con éxito";
				}else{
					$this->datos->resultado = "La contraseña no coincide";
				}
			}else{
				$this->datos->resultado = "Contraseña actual incorrecta";
			}
		}else{
			$this->datos->resultado = "Error en la consulta SQL";
		}
		$this->base->cerrarConexion();
		return $this->datos;
	}
	//-----------------------------------------------------------------------
}
?>