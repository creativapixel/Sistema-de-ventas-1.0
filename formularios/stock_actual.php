<?php   session_start();
		require_once "../clases/producto_data.php";
		

		$producto = new Producto;
		$linea = new Linea;
		$marca = new Marca;
		//$tipoproducto = new Tipoproducto;	
	
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

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center" class="titulo">STOCK DE PRODUCTOS</td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="800" border="0">
        <tr>
          <td colspan="5" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%">Linea</td>
              <td><?php $linea->generar_select_linea('linea','listar()',''); ?></td>
              <td width="8%">Marca</td>
              <td align="center"><?php  $marca->generar_select_marca('marca','listar()','');  ?></td>
              <td align="center"><input name="Submit2" type="button" class="btn" 
							value="Imprimir Listado" onclick="vista_previa(<?php echo $_REQUEST['linea'];?>,<?php echo $_REQUEST['marca'];?>)" /></td>
            </tr>
          </table>            </td>
          </tr>
      
        <tr class="fondonegro">
          <td width="178" align="center">Linea</td>
          <td width="155" align="center">Marca</td>
          <td width="336" align="center">Descripci&oacute;n</td>
          <td width="72" align="center">Stock</td>
          <td width="37" align="center">&nbsp;</td>
          </tr>       
          <tr>
              <td colspan="5" align="center">
              
              <div style="width:100%; height:300px; overflow:scroll;">
              <table width="800" border="0">
            <?php  
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $producto->producto_listar($_REQUEST['linea'],'0',$_REQUEST['marca']);
	 
			 if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) {
			  ?>               
                <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
                  <td width="178" align="center"><?php echo $campo['tipp_descripcion'];  ?><?php echo $campo['lin_descripcion'];  ?></td>
                  <td width="164" align="center"><?php echo $campo['mar_descripcion'];  ?></td>
                  <td width="338" align="center"><?php echo $campo['pro_descripcion'];  ?></td>
                  <td width="67" align="center"><?php echo $campo['pro_stock'];  ?></td>
                  <td width="31">&nbsp;</td>
                </tr>
             <?php 
			  	$j=$j+1;			  	 
			  	} 
			  } 
			?>
            </table>
           </div> 
            </td>
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

function vista_previa(linea,marca){
	window.open("reporte_stock_impresion.php?linea="+linea+"&marca="+marca, "_blank", "resizable,height=600,width=800");
}

function listar()
{
	document.forms.form1.action='stock_actual.php';
	document.forms.form1.method='POST';
	document.forms.form1.submit();
}


<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $producto->_util->_cn->desconectar();?>