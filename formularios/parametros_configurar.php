<?php
	session_start();
	
	require_once "../clases/parametros_data.php";
	$parametro =  new Parametros;
	
	
	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_empresa']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
	//$empresa->empresa_ver($_SESSION['sesion_id_empresa']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../javascript/eventos.js"></script>
<title>Sistema de Ventas</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
</table>

<form id="form1" name="form1" >
  <table width="684" align="center">
   <tr>
     <td width="676" align="center">&nbsp;</td>
   </tr>
   <tr>
       <td align="center"><span class="titulo">CONFIGURAR PARAMETROS</span></td>
     </tr>
    <tr>
      <td align="center">Parametros actuales por generar</td>
   </tr>
     <tr>
       <td><table width="100%" border="0">
         <tr class="fondonegro">
           <td colspan="2" align="center">Nota de crédito</td>
           <td colspan="2" align="center">Factura</td>
           <td colspan="2" align="center">Boleta</td>
           <td align="center">&nbsp;</td>
         </tr>
         <tr class="fondonegro">
           <td align="center">Serie</td>
           <td align="center">Número</td>
           <td width="11%" align="center">Serie</td>
           <td width="12%" align="center">Número</td>
           <td width="10%" align="center">Serie</td>
           <td width="13%" align="center">Número</td>
           <td width="11%" align="center">Editar</td>
         </tr>
         <?php 
  $rs=$parametro->parametros_listar($_SESSION['sesion_id_empresa']);
  while($campo =mysql_fetch_array($rs)) { 
  ?>
         <tr bgcolor="#FFFFFF" style="cursor: hand" onmouseover="bgColor='#FFDBB7'" onmouseout ="bgColor='#FFFFFF'">
           <td width="12%" align="center"><?php echo $campo['pcom_serie_notacredito'];?></td>
           <td width="11%" align="center"><?php echo $campo['pcom_nro_notacredito'];?></td>
           <td align="center"><?php echo $campo['pcom_serie_factura'];?></td>
           <td align="center"><?php echo $campo['pcom_nro_factura'];?></td>
           <td align="center"><?php echo $campo['pcom_serie_boleta'];?></td>
           <td align="center"><?php echo $campo['pcom_nro_boleta'];?></td>
           <td align="center"><a href="parametro_editar.php?cod=<?php echo $campo['pcom_id'];?>"><img src="../imagenes/icono_editar.gif" width="14" height="14" border="0" /></a></td>
         </tr>
         <?php } ?>
       </table></td>
     </tr>
   </table>
</form>
</body>
</html>
<?php $parametro->_util->_cn->desconectar()?>
