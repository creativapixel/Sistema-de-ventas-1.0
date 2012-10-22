<?php   session_start();
		//require_once('../clases/session_data.php');
		require_once "../clases/productos_data.php";

		//$session= new sessiondata();
		$producto = new Producto;
		$tipoproducto = new Tipoproducto;	
	
 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	} 

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=50;
	}
	

		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
<script src="../javascript/eventos.js"></script>
<div ID="waitDiv" style="position:absolute;left:300;top:300;visibility:hidden"> 
<table  border="0" align="center"> 
<tr><td> 
<img src="../imagenes/loading9.gif" border="0"> 
</td> 
</tr></table> 
</div> 
<SCRIPT> 
<!-- 
var DHTML = (document.getElementById || document.all || document.layers); 
function ap_getObj(name) { 
if (document.getElementById) 
{ return document.getElementById(name).style; } 
else if (document.all) 
{ return document.all[name].style; } 
else if (document.layers) 
{ return document.layers[name]; } 
} 
function ap_showWaitMessage(div,flag) { 
if (!DHTML) return; 
var x = ap_getObj(div); x.visibility = (flag) ? 'visible':'hidden' 
if(! document.getElementById) if(document.layers) x.left=280/2; return true; } ap_showWaitMessage('waitDiv', 3); 
//--> 
</SCRIPT> 


</head>

<?php

	if($_REQUEST['id']=='1')
	{
	
		$producto->productos_editar($_REQUEST['prod_id'],$_REQUEST['tipoproducto'],$_REQUEST['descripcion'],$_REQUEST['stock'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['moneda']);

	}
	
	$producto->producto_ver($_REQUEST['prod_id']);
	$_REQUEST['tipoproducto']=$producto->tipp_id;
	$_REQUEST['moneda']=$producto->tipm_id;
	$_REQUEST['unidad']=$producto->uni_id;
	
?>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center"><h4>EDITAR PRODUCTOS</h4></td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="487" border="0">
        <tr>
          <td width="93" align="right">Tipo de producto</td>
          <td width="10" align="center">:</td>
          <td colspan="2" align="left"><?php $tipoproducto->generar_select_tipoproducto('tipoproducto','','')?>
            <input type="hidden" name="id" id="id" />
            <input name="prod_id" type="hidden" id="prod_id" value="<?php echo $_REQUEST['prod_id']?>" /></td>
        </tr>
        <tr>
          <td align="right">Descripci&oacute;n</td>
          <td align="center">:</td>
          <td colspan="2" align="left"><input name="descripcion" type="text" id="descripcion" value="<?php echo $producto->prod_descripcion;?>" size="50" /></td>
        </tr>
        <tr>
          <td align="right">Stock</td>
          <td align="center">:</td>
          <td width="50"  align="left"><input name="stock" type="text" id="stock" value="<?php echo $producto->prod_stock;?>" size="8" /></td>
          <td width="318" align="left"><?php $producto->generar_select_unidadmedida('unidad','','')?></td>
        </tr>
        <tr>
          <td align="right">Precio</td>
          <td align="center">:</td>
          <td><label>
            <input name="precio" type="text" id="precio" value="<?php echo $producto->prod_precio;?>" size="8" />
            </label></td>
          <td  align="left"><?php $producto->generar_select_tipomoneda('moneda','','','')?></td>
        </tr>
        <tr>
          <td align="right"><input name="button2" type="button" class="btn" id="button2" value="Regresar" onclick="regresar()" /></td>
          <td>&nbsp;</td>
          <td colspan="2"><input name="button" type="button" class="btn" id="button" value="Editar Producto" onclick="enviar_form('POST','producto_editar.php','1')" /></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>

</table>

	</body>
</html>

<SCRIPT language="javascript"> 


function regresar(){
	
   document.forms.form1.action='producto_registrar.php?tipoproducto=<?php echo $_REQUEST['tipoproducto'];?>';
   document.forms.form1.method='post';
   document.forms.form1.submit();	
	
	}


<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $producto->_util->_cn->desconectar();?>