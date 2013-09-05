<?php
include_once('../clases/init.php');

if(!$_SESSION['cms']){
	header ("Location: index.php");
	exit;
}

include_once('../clases/configuracion.php');

$objdat = new configuracion();
$listado = $objdat->getConfig();

$valor1 = str_replace('.', ':', $listado->items->item1->valor);
$valor2 = str_replace('.', ':', $listado->items->item2->valor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Kinder Light House - Sistema de gesti&oacute;n de contenidos</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery_002.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
// esperamos que el DOM cargue
$(document).ready(function() { 
	// definimos las opciones del plugin AJAX FORM
	var opciones= {
					   beforeSubmit: mostrarLoader, //funcion que se ejecuta antes de enviar el form
					   success: mostrarRespuesta, //funcion que se ejecuta una vez enviado el formulario
	};
	 //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
	$('#myForm').ajaxForm(opciones) ; 
	
	 //lugar donde defino las funciones que utilizo dentro de "opciones"
	 function mostrarLoader(){
			  $("#loader_gif").fadeIn("slow");
	 };
	 function mostrarRespuesta (responseText){
		   //alert("Mensaje enviado: "+responseText);
		  $("#loader_gif").fadeOut("slow");
		  //$("#ajax_loader").append(responseText);
		  var elemento = document.getElementById('ajax_loader');
		  elemento.innerHTML = responseText;
	 };

}); 
</script> 
<style type="text/css">
<!--
#result {
	margin: 2px;
	padding: 0px;
	width:227px;
	padding:2px;
	text-align:center;
	color:#930d26;
}
-->
</style>
</head>

<body>
<?php include_once('estructura/head.php'); ?>
<div class="cuerpo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><?php include_once('estructura/menu.php'); ?></td>
    <td align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50">&nbsp;</td>
      </tr>
      <tr>
        <td align="left"><h1>Configuraci&oacute;n</h1>Editar horarios</td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      </tr>
      <tr>
      	<td align="left">
        <form action="estructura/set.php?accion=modificar" method="post" enctype="multipart/form-data" id="myForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      	  <tr>
      	    <td width="50%" align="right" class="label">Horario 1</td>
      	    <td align="left"><input name="valor1" type="text" class="campoHora" id="valor1" value="<?php echo $valor1; ?>" /></td>
    	  </tr>
      	  <tr>
      	    <td align="right" class="label">Horario 2</td>
      	    <td align="left"><input name="valor2" type="text" class="campoHora" id="valor2" value="<?php echo $valor2; ?>" /></td>
    	  </tr>
      	  <tr>
      	    <td colspan="2">&nbsp;</td>
    	  </tr>
          <tr>
      	    <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="25%">&nbsp;</td>
                <td align="left">
                <div class="divBoton"><input type="submit" name="button" id="button" value="Editar" /></div>
                <div class="divBoton"><img id="loader_gif" src="imagenes/loader.gif" style="display: none;" alt="" /></div>
                <div id="ajax_loader" class="divBoton divMensaje"></div>
                </td>
              </tr>
            </table>
            </td>
    	  </tr>
        </table>
        </form>
        </td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
<?php include_once('estructura/pie.php'); ?>
</body>
</html>