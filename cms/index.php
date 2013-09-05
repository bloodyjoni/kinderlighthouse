<?php
include('../clases/init.php');

if($accion == "logout"){
	include_once('../clases/usuarios.php');
	$obj = new usuarios();
	$desconectar = $obj->deslogueoUsuario();
}
if($_SESSION['cms']){
	header ("Location: inicio.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Kinder Light House - Sistema de gesti&oacute;n de contenidos</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#result').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#result').fadeIn('slow');
    });
    $('#form, #login').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
				if(data == "OK"){
					window.location = 'inicio.php';
				}
                $('#result').html(data);
            }
        })
        
        return false;
    }); 
})  
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
<?php include('estructura/head.php'); ?>
<div class="cuerpo">
<form id="login" name="login" method="post" action="estructura/conectar.php">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" align="left"><h1>Login</h1></td>
    </tr>
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="3">&nbsp;</td>
    <td><input name="logueo" type="hidden" id="logueo" value="1" /></td>
  </tr>
  <tr>
    <td align="right" class="label">Usuario</td>
    <td align="center"><div class="divisiones">&nbsp;</div></td>
    <td align="left"><input name="user" type="text" class="campoNormal" id="user" /></td>
  </tr>
  <tr>
    <td align="right" class="label">Clave</td>
    <td align="center"><div class="divisiones">&nbsp;</div></td>
    <td><input name="pass" type="password" class="campoNormal" id="pass" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left"><div class="divBoton"><input type="submit" name="button" id="button" value="Ingresar" /></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left"><div id="result"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
<?php include('estructura/pie.php'); ?>
</body>
</html>