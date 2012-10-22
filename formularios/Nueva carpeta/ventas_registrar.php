<?php   session_start();
		require_once "../clases/ventas_data.php";
		include_once "../clases/PHPPaging.lib.php";
		
		$paging = new PHPPaging;		
		$venta = new Venta;
		$producto = new Producto;
		$tipoproducto = new Tipoproducto;	
	
 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	} 

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=15;
	}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
<script src="../javascript/eventos.js"></script>
		<!-- jQuery -->
		<script type="text/javascript" src="../librerias/jquery/jquery-1.2.6.pack.js"></script>
        <!-- required plugins -->
		<script type="text/javascript" src="../librerias/date_picker/date.js"></script>

        
        <!-- jquery.datePicker.js -->
		<script type="text/javascript" src="../librerias/date_picker/jquery.datePicker.js"></script>
        
        <!-- datePicker required styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="../librerias/date_picker/datePicker.css">
        
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
           
			  $(function()
			  {
				  $('.date-pick').datePicker({startDate:'01/01/1980'});
			  });
				  
		</script>
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
		$venta->venta_insertar($_REQUEST['producto'],$_REQUEST['fecha'],$_REQUEST['cantidad'],$_REQUEST['precio']);
		}
		
	if($_REQUEST['id']==='2')
	{

		
		$venta->venta_borrar($_REQUEST['cod_venta'],$_REQUEST['cod_producto'],$_REQUEST['cant_producto']);
	}	  	  
			

?>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center"><p class="titulo">REGISTRAR VENTAS DE PRODUCTOS</p></td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="487" border="0">
        <tr>
          <td width="107" align="right" class="enfasis">Tipo de producto</td>
          <td width="8" align="center" class="enfasis">:</td>
          <td colspan="4"  align="left"><?php $tipoproducto->generar_select_tipoproducto('tipoproducto','enviar_form("POST","ventas_registrar.php","")','')?>
            <input type="hidden" name="id" id="id" /></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Producto</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><?php $producto->generar_select_producto('producto','enviar_form("POST","ventas_registrar.php","")',$_REQUEST['tipoproducto'])?></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Fecha</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onKeyUp='fn(this.form,this)' class="date-pick"/></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Cantidad</td>
          <td align="center" class="enfasis">:</td>
          <td width="63" align="left"><label>
            <input name="cantidad" type="text" id="cantidad" size="8" onblur="valida_cantidad()" />
          </label></td>
          <td width="81" align="left" class="enfasis">Stock Actual</td>
          <td width="8" align="center" class="enfasis">:</td>
          <td width="194" align="left"><input name="stock" type="text" disabled="disabled" id="stock" size="8" value="<?php echo $producto->ver_stock_producto($_REQUEST['producto'])?>" /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Precio</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="precio" type="text" id="precio" value="<?php echo $producto->ver_precio_producto($_REQUEST['producto'])?>" size="8" readonly="readonly" /></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="4"><input name="button" type="button" class="btn" id="button" value="Registrar Venta" onclick="enviar_form('POST','ventas_registrar.php','1')" /></td>
        </tr>
      </table>
      <table width="800" border="0">
        <tr>
          <td colspan="2" align="center"><input type="hidden" name="cod_venta" id="cod_venta" />
            <input type="hidden" name="cod_producto" id="cod_producto" />
            <input type="hidden" name="cant_producto" id="cant_producto" /></td>
          <td width="37%" align="center">&nbsp;</td>
          <td colspan="2" align="center">&nbsp;</td>
          <td width="5%" align="center">&nbsp;</td>
        </tr>
        <tr class="fondonegro">
          <td width="18%" align="center">Fecha</td>
          <td width="17%" align="center">Tipo</td>
          <td align="center">Producto</td>
          <td width="12%" align="center">Cantidad</td>
          <td width="11%" align="center">Precio</td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php  
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $venta->ventas_listar();
			 
			  $paging->porPagina($_REQUEST['npaginas']);
			  $paging->mostrarAnterior("< Anterior");
			  $paging->mostrarSiguiente("Siguiente >");		  
			  $paging->agregarConsulta($rs);
			  
			  $paging->ejecutar();			 
			 
			 
			 if($rs)
			 
			 {
			 $j=1;
  			  while($campo = $paging->fetchResultado()) {
			  ?>
        <tr bgcolor="#FFFFFF" style="cursor: hand" onmouseover="bgColor='#F3E212'" onmouseout ="bgColor='#FFFFFF'">
          <td align="center"><?php echo  $venta->_util->obtiene_fecha($campo['ven_fecha']);  ?></td>
          <td align="center"><?php echo$campo['tipp_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['prod_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['ven_cantidad'];  ?> <?php echo $campo['uni_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['tipm_descripcion'];  ?> <?php echo $campo['ven_precio'];  ?></td>
          <td align="center"><a href="#" onclick="eliminar(<?php echo $campo['ven_id'];?>,<?php echo $campo['prod_id'];?>,<?php echo $campo['ven_cantidad'];?>)"><img src="../imagenes/icono_eliminar.gif" alt="" width="14" height="14" border="0" /></a></td>
        </tr>
        <?php 
			  	$j=$j+1;			  	 
			  	} 
			  } 
			?>
        <tr bgcolor="#FFFFFF" style="cursor: hand" onmouseover="bgColor='#F3E212'" onmouseout ="bgColor='#FFFFFF'">
          <td align="center">Listar
            <input name="npaginas" type="text" id="npaginas" size="3" onblur="enviar_form('GET','ventas_registrar.php','')" value="<?php echo $_REQUEST['npaginas']?>" onkeyup='fn(this.form,this)' />
            registros </td>
          <td align="center"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
          <td colspan="2" align="center"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
          <td colspan="2" align="center"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
      <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>

</table>

	</body>
</html>
<script src="../javascript/valida.js">  </script>
<SCRIPT language="javascript"> 


function  eliminar(venta,producto,cantidad)
  {
	if (confirm("¿Seguro que desea Eliminar todos los Registros Seleccionados?"))
		{
			document.forms.form1.id.value='2';
			document.forms.form1.cod_venta.value=venta;
			document.forms.form1.cod_producto.value=producto;
			document.forms.form1.cant_producto.value=cantidad;			
			document.forms.form1.action='ventas_registrar.php';
			document.forms.form1.method='post';
			document.forms.form1.submit();
		}

	else
		{
			return false; 
		} 
  }

function valida_cantidad()
{

	if (document.forms.form1.cantidad.value=="")
	{
	 	alert("Ingrese la cantidad que va a vender");
	 	return false;
	}

	if (!Esnum(document.forms.form1.cantidad.value))
	{
	 	alert("Ingrese un valor numerico para la cantidad");
	 	return false;
	}
	
	if (parseFloat(document.forms.form1.cantidad.value) > parseFloat(document.forms.form1.stock.value))
	{
	 	alert("La cantidad supera al stock");
	 	return false;
	}

}

<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $venta->_util->_cn->desconectar();?>