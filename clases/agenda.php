<?php 
//Iclusiones
include_once('bd.php');
include_once('paginacion.php');

class agenda {
	//Propiedades
	var $base;
	var $datos;
	var $total;
	
	//Constructor
	function agenda(){
		$this->base = new bd();
		$this->base->conectar();
	}
	//------------------------------------------------------------
	function proximosEventos($uuid){
		$hoy = date('Y-m-d');
		//$sql = "SELECT id, fecha, titulo FROM klh_agenda WHERE fecha >= '$hoy' ORDER BY fecha ASC";
		$sql = "SELECT id, fecha, titulo FROM klh_agenda ORDER BY fecha DESC";
		$this->base->consultar($sql);
		if($this->base->estado){
			$cantidad = $this->base->cantidad;
			$this->datos->cantidad = $cantidad;
			if($cantidad > 0){
				while($resultado = mysql_fetch_object($this->base->datos)){
					$this->datos->items->{'item'. $resultado->id}->id = $resultado->id;
					$fecha = intval(substr($resultado->fecha,8)) . '/' . intval(substr($resultado->fecha,5,2));
					$this->datos->items->{'item'. $resultado->id}->fecha = $fecha;
					$this->datos->items->{'item'. $resultado->id}->titulo = utf8_encode($resultado->titulo);
					$this->datos->items->{'item'. $resultado->id}->leido = 0;
				}
				$sql = "SELECT idevento AS id FROM klh_leidos WHERE uuid = '$uuid'";
				$this->base->consultar($sql);
				if($this->base->estado){
					$cantidad = $this->base->cantidad;
					if($cantidad > 0){
						while($resultado = mysql_fetch_object($this->base->datos)){
							$this->datos->items->{'item'. $resultado->id}->leido = 1;
						}
					}
				}
			}
		}else{
			$this->datos->cantidad = 0;
		}
		$fecha = date('Y-m-d H:i:s');
		$sql = "INSERT INTO klh_log (uuid, fecha) VALUES ('$uuid', '$fecha')";
		$this->base->consultar($sql);
		return $this->datos;
	}
	//------------------------------------------------------------
	function fichaEvento($id,$uuid){
		$sql = "SELECT * FROM klh_agenda WHERE id = $id";
		$this->base->consultar($sql);
		$cantidad = 0;
		if($this->base->estado){
			$cantidad = $this->base->cantidad;
			$this->datos->cantidad = $cantidad;
			if($cantidad > 0){
				while($resultado = mysql_fetch_object($this->base->datos)){
					$this->datos->id = $resultado->id;
					$fecha = intval(substr($resultado->fecha,8)) . '/' . intval(substr($resultado->fecha,5,2));
					$this->datos->fecha = $fecha;
					$this->datos->titulo = utf8_encode($resultado->titulo);
					$this->datos->texto = nl2br(utf8_encode($resultado->texto));
					$this->datos->activo = 1;
				}
				$sql = "SELECT * FROM klh_leidos WHERE uuid = '$uuid' AND idevento = $id";
				$this->base->consultar($sql);
				$cantread = $this->base->cantidad;
				if($cantread == 0){
					$fecha = date('Y-m-d H:i:s');
					$sql = "INSERT INTO klh_leidos (idevento, uuid, fecha) VALUES ($id, '$uuid', '$fecha')";
					$this->base->consultar($sql);
				}
			}
		}else{
			$this->datos->cantidad = 0;
		}
		if($cantidad == 0){
			$this->datos->id = $id;
			$this->datos->fecha = '';
			$this->datos->titulo = 'Hubo un error';
			$this->datos->texto = utf8_encode('El evento seleccionado no existe o ha sido borrado');
			$this->datos->activo = 0;
		}
		return $this->datos;	 			
	}
	//-----------------------------------------------------------------------
	function listaCMS($p,$key){
		$hoy = date('Y-m-d');
		$key = trim($key);
		$destino = '';
		$variables = "&key=" . $key;
		$variables =  htmlspecialchars($variables, ENT_QUOTES);
		$sql = "SELECT * FROM klh_agenda";
		if($key != ""){
			$sql .= " WHERE (fecha LIKE '%$key%' OR titulo LIKE '%$key%' OR texto LIKE '%$key%')";
		}
		$sql .= " ORDER BY fecha DESC";
		$obj = new paginacion($sql, $p, 6,3,$destino,$variables);
		//si salio bien genera Objeto
		if($obj->estado && $obj->cantitems > 0){
			//ecribo resultado
			$cantidad = $obj->cantitems;
			$this->datos->cantidad = $cantidad;
			$this->datos->links = $obj->linksHTML;
			while($resultado = mysql_fetch_object($obj->listado)) {
				$this->datos->items->{'item'. $resultado->id}->id = $resultado->id;
				$this->datos->items->{'item'. $resultado->id}->fecha = $resultado->fecha;
				$this->datos->items->{'item'. $resultado->id}->titulo = utf8_encode($resultado->titulo);
				$this->datos->items->{'item'. $resultado->id}->texto = substr(utf8_encode($resultado->texto),0,80);
			}
		}else{
			$this->datos->cantidad = 0;
		}
		return $this->datos;
	}
	//------------------------------------------------------------
	function fichaCMS($id){
		$sql = "SELECT * FROM klh_agenda WHERE id = $id";
		$this->base->consultar($sql);
		if($this->base->estado){
			$cantidad = $this->base->cantidad;
			$this->datos->cantidad = $cantidad;
			if($cantidad > 0){
				while($resultado = mysql_fetch_object($this->base->datos)){
					$this->datos->id = $resultado->id;
					$this->datos->fecha = $resultado->fecha;
					$this->datos->titulo = utf8_encode($resultado->titulo);
					$this->datos->texto = utf8_encode($resultado->texto);
				}
			}
		}else{
			$this->datos->cantidad = 0;
		}
		return $this->datos;	 			
	}
	//-----------------------------------------------------------------------
	function mofificoEvento($d){
		$sql = "SELECT id FROM klh_agenda WHERE id = $d->id";
		$this->base->consultar($sql);
		if($this->base->estado){
			if($this->base->cantidad == 1){
				if($d->fecha != '' && $d->titulo != '' && $d->texto != ''){
					$sql = "UPDATE klh_agenda SET 
					fecha = '$d->fecha', 
					titulo = '$d->titulo', 
					texto = '$d->texto'
					WHERE id = $d->id";
					$this->base->consultar($sql);
					if($this->base->estado){
						$this->datos->estado = "Evento modificado correctamente";
					}else{
						$this->datos->estado .= "<br />";
						$this->datos->estado = "Error en la consulta SQL";
					}
				}else{
					$this->datos->estado = "Error. Faltan Datos";
				}
			}else{
				$this->datos->estado = "No exite el registro";
			}
		}else{
			$this->datos->estado = "Error en la consulta SQL";
		}
		return $this->datos;
	}
	//-----------------------------------------------------------------------
	function crearEvento($d){
		if($d->fecha != '' && $d->titulo != '' && $d->texto != ''){
			$sql = "INSERT INTO
			klh_agenda (fecha, titulo, texto)
			VALUES ('$d->fecha', '$d->titulo', '$d->texto')";
			$this->base->consultar($sql);
			if($this->base->estado){
				$this->datos->estado = "Evento creado correctamente";
				$this->datos->id = $this->base->ultimoId;
				$this->datos->cargado = true;
			}
		}else{
			$this->datos->estado = "Error. Faltan Datos";
		}
		return $this->datos;	 			
	}
	//-----------------------------------------------------------------------
	function borroEvento($id){
		//realiza consulta
		$sql = "SELECT id FROM klh_agenda WHERE id = $id";
		$this->base->consultar($sql);
		
		//si salio bien genera Objeto
		if($this->base->estado){
			$cantidad = $this->base->cantidad;
			$this->datos->cantidad = $cantidad;
			if($cantidad > 0){
				$sql = "DELETE FROM klh_agenda WHERE id = '$id'";
				$this->base->consultar($sql);
				$sql = "DELETE FROM klh_leidos WHERE idevento = '$id'";
				$this->base->consultar($sql);
				
				$this->datos->estado = "Evento eliminado correctamente";
				$this->datos->borrado = true;
			}else{
				$this->datos->estado = "No exite el registro";
			}
		}else{
			$this->datos->estado = "Error en la consulta SQL";
		}
		return $this->datos;
	}
	//-----------------------------------------------------------------------
}
?>