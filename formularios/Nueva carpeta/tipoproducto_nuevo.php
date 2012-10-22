<?php
	session_start();
	
	require_once "../clases/tipoproducto_data.php";
	$tipoproducto = new Tipoproducto;
	
	if (!isset($_SESSION['sesion_id_usuario']))
	{
		die("Usted no tiene acceso a esta area");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NUEVA CATEGORIA DE PRODUCTO</title>
<script src="../javascript/eventos.js"></script>

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
</head>
<?php

		if($_POST['id']=='1')
		{
	  
			$rs = $tipoproducto->tipoproducto_insertar($_POST['descripcion']);
			if ($rs)
			{
				echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'producto_registrar.php?tipoproducto=".$_SESSION['tipoproducto_id']."';
window.close();  </script>";	
			}
		}

  ?>
<body onload="centrar_pagina()">
<form id="form1" name="form1" >
  <table width="389" border="0">
    <tr>
      <td width="90" align="right" class="enfasis">Tipo Producto</td>
      <td width="17" align="center" class="enfasis">:</td>
      <td width="268"><input name="descripcion" type="text" id="descripcion" size="30" />
      <input type="hidden" name="id" id="id" /></td>
    </tr>
    <tr>
      <td class="fondo_celda_form">&nbsp;</td>
      <td align="center" class="fondo_celda_form">&nbsp;</td>
      <td><input name="button" type="button" class="btn" id="button" onclick="enviar_form('POST','tipoproducto_nuevo.php','1')" value="Grabar"/>
      <input name="button2" type="button" class="btn" id="button2" onclick="cerrar_ventana()" value="Cerrar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php //$tipoproducto->_util->cn->cerrar($tipoproducto->_util->cn);?>