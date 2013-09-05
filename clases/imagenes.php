<?php 
//includes
include_once('bd.php');
include_once('thumb.php');

class imagenes {
	//properties
	var $base;
	var $thumb;
	var $path;
	var $imagen;
	
	//constructor
	function imagenes(){
		$this->thumb = new thumb();
		
		$this->base = new bd();
		$this->base->conectar();
	}
	
	//methods ---------------------------------------------------------------
	function cropImagen($imagen,$ancho){
		$this->imagen = trim($imagen);
		$ancho = intval($ancho);
		$posicion = 'width';
		$subfijo = explode('.',$this->imagen);
		$path = '';
		if($this->imagen != ''){
			if (file_exists($path . $this->imagen)){
				$path .= $imagen;
			}else{
				$path .= 'default.jpg';
			}
		}else{
			$path .= 'default.jpg';
		}
		$fileType = substr($path,- strlen($subfijo[1]));
		switch ($fileType) {
		   case "jpg":
		   			$fileType = 'image/jpeg';
			   break;
		   case "jpe":
				$fileType = 'image/jpeg';
		   break;
		   case "jpeg":
				$fileType = 'image/jpeg';
		   break;
		   case "gif":
		   			$fileType = 'image/gif';
			   break;
		   case "png":
		   			$fileType = 'image/png';
			   break;
		   default:
		   $fileType = 'image/jpeg';
		}
		$this->thumb->loadImage($path);
		$this->thumb->resize($ancho, $posicion);
		
		return $this->thumb->show($fileType);
	}
	//-----------------------------------------------------------------------
}
?>