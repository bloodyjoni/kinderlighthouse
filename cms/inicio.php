<?php
include('../clases/init.php');

if(!$_SESSION['cms']){
	header ("Location: index.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>Kinder Light House - Sistema de gesti&oacute;n de contenidos</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
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
        <td align="center"><h1><?php echo $_SESSION['usuario']; ?><br />Bienvenido al panel de control</h1></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      </tr>
      <tr>
      	<td align="left">En este panel de control puede gestionar toda la informaci&oacute;n din&aacute;mica del sitio web</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
<?php include_once('estructura/pie.php'); ?>
</body>
</html>