<div class="encabezado">
<div><b>Administrador de contenidos</b></div>
<?php if($_SESSION['cms']){ ?>
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td>Bienvenido <?php echo $_SESSION['usuario']; ?></td>
    <td width="28" align="center"><img src="imagenes/btn_salir.gif" width="24" height="24" alt="Salir" title="Salir" /></td>
    <td><a href="index.php?accion=logout">Cerrar sesi&oacute;n</a></td>
    <td width="27">&nbsp;</td>
  </tr>
</table>
<?php } ?>
</div>