<?php
include_once('../clases/init.php');
include_once('../clases/configuracion.php');

$obj = new configuracion();
$listado = $obj->getConfig();

header("Content-Type: text/xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<root>';
if($listado->cantidad > 0){
foreach($listado->items as $v){
echo '<item id="' . $v->id . '">' . '<nombre>' . $v->nombre . '</nombre><valor>' . $v->valor . '</valor></item>';
}
}
echo '</root>';
?>