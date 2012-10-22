<?php   session_start();

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
	die("No tiene acceso  a esta seccion");
 	} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistema de Ventas</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
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
	<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center" class="titulo">REINICIAR BASE DE DATOS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
     
    
    <?php if($_REQUEST['id']==1){
		
		require_once "../clases/reiniciar_bd_data.php";
		$reiniciar = new Reiniciar;
		
		
		$reiniciar->vaciar_tabla('detalle_ventas');
		$reiniciar->vaciar_tabla('ventas');		
		$reiniciar->vaciar_tabla('detalle_pedidos');		
		$reiniciar->vaciar_tabla('pedidos');		
		$reiniciar->vaciar_tabla('ingresos');
		$reiniciar->actualizar_tabla('productos','pro_stock',0);
		
		
		?>
    
      <h3>La base de datos se a reiniciado con &eacute;xito!</h3>
	  
	<?php }else{ ?>
      
    <p>Reiniciar base de datos permite ejecutar las siguienets acciones:</p>   
    <p>Vaciar detalle de ventas<br />
      Vaciar ventas<br />
      Vaciar detalle de pedidos<br />
      Vaciar pedidos<br />
      Vaciar ingresos a almac&eacute;n y stock<br />
      Mantiene lineas<br />
      Mantiene marcas<br />
      Mantiene productos<br />
      Mantiene unidades<br />
      Mantiene precios
      <br />
      Mantiene clientes<br />
      Mantiene permisos<br />
      Mantiene parametros de comprobantes</p>
    <form id="form1" name="form1" method="post" action="">
      <input type="hidden" name="id" id="id" />
      <input name="button" type="button" class="btn" id="button" value="Reiniciar base de datos" onclick="reiniciar()" />
    </form>
    <p> <br />
    </p>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
  </tr>
</table>

	</body>
</html>
<script language="javascript">

function reiniciar()
{

	if (confirm("¿Seguro que desea reiniciar la base de datos?"))
	{
   		document.forms.form1.id.value='1';	
   		document.forms.form1.action='reiniciar_bd.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}
</script>
<SCRIPT language="javascript"> 
<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 
