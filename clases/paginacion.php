<?php 
//inclusiones
include_once('bd.php');


//clase
class paginacion{
	//propiedades
	var $base;	
	var $xml;
	var $linksHTML = '';
	var $itemstotal = 0;
	var $pagtotal = 0;
	var $pagina = 1;
	var $cantitems = 0;
	
	var $estado;
	var $mensaje;
	
	//constructor ------------------------------------------------------------------------------
	function __construct($sql,$pagina,$itemsxpag = 8,$linkscant = 2, $destino='',$variables=''){
		$this->base = new bd();
		$this->base->conectar();
		
		//
		if ($destino == ''){
			$destino = pathinfo($_SERVER["SCRIPT_NAME"]);
			$destino = $path_parts['basename'];
		}
		
		//valida datos
		if ($itemsxpag <= 0){
			$itemsxpag = 8;	
		}

		
		//averiguar 
		$sqltotal = "select count(*) as total from ($sql) t";
		$this->base->consultar( $sqltotal );
		
		//si la consulta de cantidad total salio bien, continua
		if($this->base->estado){
			$r = mysql_fetch_object($this->base->datos);
			$this->itemstotal = $r->total;
			//Si hay al menos 1 item, continuo
			if ($this->itemstotal > 0){
				$this->estado = "true";
				//determina cantidad de paginas
				$this->pagtotal = ceil($this->itemstotal/$itemsxpag);					 
				 
				//si la pagina actual es incorrecta la resetea
				$this->pagina = intval($pagina);				  
				if ($this->pagina > $this->pagtotal){
					$this->pagina = $this->pagtotal;					 
				}else if ($this->pagina <= 0){
					$this->pagina = 1;
				}
				
				//realiza el select de la pagina puntual
				$sql .= " LIMIT ".($itemsxpag*($this->pagina-1)).",".$itemsxpag;	 
					
				$this->base->consultar($sql);
				$this->listado = $this->base->datos;
				$this->cantitems = $this->base->cantidad;			
				
				//genera los links	
				
				$this->linksHTML = '<div id="paginacion">';
				if($this->pagina >1){
					$this->linksHTML .= "<a href='$destino?p=".($this->pagina - 1) . $variables ."' target='_self'>";
					$this->linksHTML .= "Anterior";//habititado
					$this->linksHTML .= "</a> ";
				}else{
					$this->linksHTML .= "Anterior ";//deshabilitado
				}
				
				$p_inicial = $this->pagina - $linkscant;	
				if ($p_inicial <= 1){
					$p_inicial = 1;
				}
				
				// calcula pa pagina final del bloque
				$p_final = $p_inicial + ($linkscant * 2);
				if ($p_final >= $this->pagtotal){
					$p_final = $this->pagtotal;			
				}
				
				if (($p_final - $p_inicial - 1) < ($linkscant * 2 + 1)){						
						$p_inicial = $p_final - ($linkscant * 2);
						if ($p_inicial <= 1){
							$p_inicial = 1;
						}
				}
				
				// dibuja el primer link si corresponde
				
				if ($p_inicial > 1){
					//muestra el 1 al principio	
					$this->linksHTML .= "<a href=\"$destino?p=1\" target=\"_self\">1</a>";					
					$puntos = $pagina - ($linkscant * 2+1);
					// si corresponde muestra los puntos suspensivos
					if ($puntos > 1){
						$this->linksHTML .= "&nbsp;<a href=\"$destino?p=$puntos\" target=\"_self\">...</a>";
					}else if ($p_inicial > 2 ){
						$this->linksHTML .= "&nbsp;<a href=\"$destino?p=2\" target=\"_self\">...</a>";						
					}
				}
				
				// dibuja los links visibles con numeros
				for ($i=$p_inicial; $i <= $p_final; $i++){
					if ($i != $this->pagina){
						$this->linksHTML .= "&nbsp;<a href=\"$destino?p=$i" . $variables . "\" target=\"_self\">$i</a> ";	
					}else{
						$this->linksHTML .= "<strong>$i</strong> ";	
					}					
				}
				
				//si corresponde muestra el link de la ultima pagina al final
				if ($p_final < $this->pagtotal){
					
					$puntos = $pagina + ($linkscant * 2+1);					
					if ($puntos  <  $this->pagtotal){
						$this->linksHTML .= "&nbsp;<a href=\"$destino?p=$puntos\" target=\"_self\">...</a>";
					}else if ($p_final <  ($this->pagtotal - 1) ){
						$this->linksHTML .= "&nbsp;<a href=\"hh.php?p=".intval($this->pagtotal-1)."\" target=\"_self\">...</a>";						
					}					
					$this->linksHTML .= "&nbsp;<a href=\"$destino?p=$this->pagtotal\" target=\"_self\">$this->pagtotal</a>";				
				}				
				if($this->pagina < $this->pagtotal){
					$this->linksHTML .= "<a href='$destino?p=" . ($this->pagina + 1) . $variables . "' target='_self'>";
					$this->linksHTML .= " Siguiente";//habititado
					$this->linksHTML .= "</a>";
				}else{
					$this->linksHTML .= " Siguiente";//deshabilitado
				}
				$this->linksHTML .= "</div>";			
				
			//si no hay items tira error	
			}else{
				$this->estado = "false";
				$this->mensaje = "No hay registros para mostrar";				
			}
			
			
		//si la consulta de cantidad NO salio bien tira error
		}else{
			$this->estado = "false";
			$this->mensaje = "Error al consultar la base de datos";		
		}
	}
	
	//-------------------------------------------------------------
}




/*

include ("init.php");

$sql = "SELECT * FROM categnombre";

$obj = new paginacion($sql, $p, 1,2);

echo "Items totales: ".$obj->itemstotal."<br>";
echo "Paginas totales: ".$obj->pagtotal."<br>";
echo "Pagina actual: ".$obj->pagina."<br>";
echo "Items por pagina: 15 <br>";
echo "Items en esta pagina: ".$obj->cantitems."<br>";

// ver listado ---------------------
echo "<br>";


while($resultado = mysql_fetch_object($obj->listado)) {
	echo $resultado->nombre."<br>";
}

echo $obj->linksHTML;
*/

//----------------------------------
?>