<?php
	session_start();
	
	require_once "../clases/parametros_data.php";
	$parametro =  new Parametros;
	
	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_empresa']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
	if(!isset($_REQUEST['id']))
	{
		$_REQUEST['codigo']=$_REQUEST['cod'];	
	}
	



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../javascript/eventos.js"></script>
<title>SISTEMA DE ALMACEN</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>
<?php
if($_REQUEST['id']=='2')
{
	
	$parametro->parametros_editar($_REQUEST['codigo'],$_REQUEST['guia_interna'],$_REQUEST['recibo_interno'],$_REQUEST['serie_notacredito'],$_REQUEST['numero_notacredito'],$_REQUEST['serie_factura'],$_REQUEST['numero_factura'],$_REQUEST['serie_boleta'],$_REQUEST['numero_boleta']);
	
}

	$parametro->parametros_ver($_REQUEST['codigo']);
?>
<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
</table>

<p class="titulo">&nbsp;</p>
 <form id="form1" name="form1" >
   <table width="400" border="0" align="center">
     <tr>
       <td colspan="4" align="center" class="fondo_celda_form"><span class="titulo">EDITAR PARAMETROS</span></td>
     </tr>
     <tr>
       <td colspan="2" align="right">&nbsp;</td>
       <td width="18" align="center">&nbsp;</td>
       <td width="245"><input name="guia_interna" type="hidden" id="guia_interna" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_guia_interna;?>" size="5"/>
         <input type="hidden" name="id" id="id" />
         <input name="recibo_interno" type="hidden" id="recibo_interno" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_recibo_interno;?>" size="5" />
       <input type="hidden" name="codigo" id="codigo" value="<?php echo $parametro->_pcom_id;?>" /></td>
     </tr>
     <tr>
       <td width="60" rowspan="2" align="right" bgcolor="#999999"><strong>Nota de crédito</strong></td>
       <td align="right" bgcolor="#999999"><strong>Serie</strong></td>
       <td align="center" bgcolor="#999999"><strong>:</strong></td>
       <td><input name="serie_notacredito" type="text" id="serie_notacredito" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_serie_notacredito;?>" size="5"/></td>
     </tr>
     <tr>
       <td align="right" bgcolor="#999999"><strong>Número</strong></td>
       <td align="center" bgcolor="#999999"><strong>:</strong></td>
       <td><input name="numero_notacredito" type="text" id="numero_notacredito" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_nro_notacredito;?>" size="5"/></td>
     </tr>
     <tr>
       <td width="60" rowspan="2" align="right" bgcolor="#CCCCCC"><strong>Factura</strong></td>
       <td width="59" align="right" bgcolor="#CCCCCC"><strong>Serie</strong></td>
       <td align="center" bgcolor="#CCCCCC"><strong>:</strong></td>
       <td><input name="serie_factura" type="text" id="serie_factura" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_serie_factura;?>" size="5"/></td>
     </tr>
     <tr>
       <td align="right" bgcolor="#CCCCCC"><strong>Número</strong></td>
       <td align="center" bgcolor="#CCCCCC"><strong>:</strong></td>
       <td><input name="numero_factura" type="text" id="numero_factura" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_nro_factura;?>" size="5"/></td>
     </tr>
     <tr>
       <td rowspan="2" align="right" bgcolor="#999999"><strong>Boleta</strong></td>
       <td align="right" bgcolor="#999999"><strong>Serie</strong></td>
       <td align="center" bgcolor="#999999"><strong>:</strong></td>
       <td><input name="serie_boleta" type="text" id="serie_boleta" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_serie_boleta;?>" size="5"/></td>
     </tr>
     <tr>
       <td align="right" bgcolor="#999999"><strong>Número</strong></td>
       <td align="center" bgcolor="#999999"><strong>:</strong></td>
       <td><input name="numero_boleta" type="text" id="numero_boleta" onkeyup='enter(this.form,this)' value="<?php echo $parametro->_pcom_nro_boleta;?>" size="5"/></td>
     </tr>
     <tr>
       <td colspan="2" class="fondo_celda_form"><a href="parametros_configurar.php">REGRESAR</a></td>
       <td align="center" class="fondo_celda_form">&nbsp;</td>
       <td><input type="button" class="btn" onclick="validar()" value="Editar"></td>
     </tr>
   </table>
</form>
 <p>&nbsp;</p>
</body>
</html>
<?php $parametro->_util->_cn->desconectar()?>
<script language="javascript">
	function validar()
	{

						enviar_form('POST','parametro_editar.php','2');	

	}
	
	
</script>