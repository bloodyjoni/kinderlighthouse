<?php
include_once('../clases/init.php');
include_once('../clases/agenda.php');

$obj = new agenda();
$ficha = $obj->fichaEvento($id,$uuid);

header("Content-Type: text/xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<root>';
echo '<item id="' . $ficha->id . '">';
echo '<fecha>' . $ficha->fecha . '</fecha>';
echo '<titulo>' . $ficha->titulo . '</titulo>';
echo '<texto><![CDATA[' . $ficha->texto . ']]></texto>';
echo '<activo>' . $ficha->activo . '</activo>';
echo '</item></root>';
?>