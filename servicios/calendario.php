<?php
include_once('../clases/init.php');
include_once('../clases/agenda.php');

$obj = new agenda();
$listado = $obj->proximosEventos($uuid);

header("Content-Type: text/xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<root>';
if($listado->cantidad > 0){
foreach($listado->items as $v){
echo '<item id="' . $v->id . '">' . '<fecha>' . $v->fecha . '</fecha><titulo>' . $v->titulo . '</titulo><leido>' . $v->leido . '</leido></item>';
}
}
echo '</root>';
?>