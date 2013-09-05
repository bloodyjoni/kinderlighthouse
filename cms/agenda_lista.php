<?php
include_once('../clases/init.php');

if(!$_SESSION['cms']){
	header ("Location: index.php");
	exit;
}
if(empty($p)){
	$p = 1;
}
include_once('../clases/agenda.php');

if($accion == "borrar"){
	$obj1 = new agenda();
	$borro = $obj1->borroEvento($id);
}

$obj = new agenda();
$lista = $obj->listaCMS($p,$key);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Kinder Light House - Sistema de gesti&oacute;n de contenidos</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="js/funciones.js" type="text/javascript"></script>
</head>

<body>
<?php include_once('estructura/head.php'); ?>
<div class="cuerpo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><?php include_once('estructura/menu.php'); ?></td>
    <td align="center" valign="top">
    <table width="500" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td height="50">&nbsp;</td>
        </tr>
      <tr>
        <td align="left"><h1>Agenda</h1> Lista</td>
        </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            <form action="agenda_lista.php" method="get" enctype="multipart/form-data" id="buscador">
            Buscar: <input type="text" name="key" id="key" style="margin:2px; width:140px;" />
            <input name="buscar" type="submit" id="buscar" value="Buscar" />
            </form>
            </td>
            <td><?php if(isset($key)){ if($key != ''){ ?><a href="agenda_lista.php">Ver listado completo</a><?php } }else{ ?>&nbsp;<?php } ?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <?php
		if($lista->cantidad > 0){
		$datos = get_object_vars($lista->items);
		foreach ($datos as $v){
		?>
        <div class="divLista">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="475" rowspan="3" valign="top" align="left">
            <div class="divListaTextos">
                <h3><?php echo $v->fecha; ?></h3>
                <h2><?php echo utf8_decode($v->titulo); ?></h2>
                <h3><?php echo utf8_decode($v->texto); ?>...</h3>
            </div>
            </td>
            <td height="36">&nbsp;</td>
          </tr>
          <tr>
            <td><a href="agenda_editar.php?id=<?php echo $v->id; ?>&amp;p=<?php echo $p; ?>&amp;e=1&amp;key=<?php echo $key; ?>"><img src="imagenes/editar_cms.gif" width="28" height="28" alt="Editar" title="Editar" class="btn_lista" /></a></td>
          </tr>
          <tr>
            <td><a href="javascript:borrarEvento(<?php echo $v->id; ?>,<?php echo $p; ?>,'<?php echo $key; ?>');"><img src="imagenes/borrar_cms.gif" width="28" height="28" alt="Borrar" title="Borrar" class="btn_lista" /></a></td>
          </tr>
        </table>
        </div>
        <?php }}else{ ?>
		<div class="divMensaje">No hay items para mostrar</div>
		<?php } ?>
        </td>
      </tr>
      <tr>
        <td align="right"><?php echo $lista->links; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
<?php include_once('estructura/pie.php'); ?>
</body>
</html>