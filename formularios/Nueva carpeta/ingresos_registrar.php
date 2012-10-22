<?php   session_start();
		require_once "../clases/ingresos_data.php";
		include_once "../clases/PHPPaging.lib.php";
		
		$paging = new PHPPaging;		
		$ingreso = new Ingreso;
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
		$ingreso->ingresos_insertar($_REQUEST['producto'],$_REQUEST['fecha'],$_REQUEST['cantidad']);
		}
		
		
	if($_REQUEST['id']==='2')
	{
		
		$ingreso->ingresos_borrar($_REQUEST['cod_ingreso'],$_REQUEST['cod_producto'],$_REQUEST['cant_producto']);
	}	  	  
	

?>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center" class="titulo">REGISTRAR INGRESOS DE PRODUCTOS</td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="487" border="0">
        <tr>
          <td align="right" class="enfasis">&nbsp;</td>
          <td align="center" class="enfasis">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td width="103" align="right" class="enfasis">Tipo de producto</td>
          <td width="12" align="center" class="enfasis">:</td>
          <td width="358" align="left"><?php $tipoproducto->generar_select_tipoproducto('tipoproducto','enviar_form("POST","ingresos_registrar.php","")','')?>
            <input type="hidden" name="id" id="id" /></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Producto</td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><?php $producto->generar_select_producto('producto','',$_REQUEST['tipoproducto'])?></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Fecha</td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onKeyUp='fn(this.form,this)' class="date-pick"  /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Cantidad</td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><label>
            <input name="cantidad" type="text" id="cantidad" size="8" onblur="valida_cantidad()" />
          </label></td>
          </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td><input name="button" type="button" class="btn" id="button" value="Registrar Ingreso" onclick="enviar_form('POST','ingresos_registrar.php','1')" /></td>
        </tr>
      </table>
      <table width="800" border="0">
        <tr>
          <td colspan="2" align="center"><input type="hidden" name="cod_ingreso" id="cod_ingreso" />
            <input type="hidden" name="cod_producto" id="cod_producto" />
            <input type="hidden" name="cant_producto" id="cant_producto" /></td>
          <td colspan="3" align="right">&nbsp;</td>
        </tr>
        <tr class="fondonegro">
          <td width="134" align="center">Fecha</td>
          <td width="104" align="center">Tipo</td>
          <td width="406" align="center">Producto</td>
          <td width="83" align="center">Cantidad</td>
          <td width="51" align="center">&nbsp;</td>
        </tr>
        <?php  
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $ingreso->ingresos_listar();
			 
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
          <td align="center"><?php echo  $ingreso->_util->obtiene_fecha($campo['ing_fecha']);  ?></td>
          <td align="center"><?php echo$campo['tipp_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['prod_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['ing_cantidad'];  ?> <?php echo $campo['uni_descripcion'];  ?></td>
          <td align="center"><a href="#" onclick="eliminar(<?php echo $campo['ing_id'];?>,<?php echo $campo['prod_id'];?>,<?php echo $campo['ing_cantidad'];?>)"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0" /></a></td>
        </tr>
        <?php 
			  	$j=$j+1;			  	 
			  	} 
			  } 
			?>
        <tr bgcolor="#FFFFFF" style="cursor: hand" onmouseover="bgColor='#F3E212'" onmouseout ="bgColor='#FFFFFF'">
          <td align="center"><input name="total" type="hidden" id="total" value="<?php echo $j-1?>" />Listar
            <input name="npaginas" type="text" id="npaginas" size="3" onblur="enviar_form('GET','ingresos_registrar.php','')" value="<?php echo $_REQUEST['npaginas']?>" onkeyup='fn(this.form,this)' />
            registros </td>
          <td align="center"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
          <td align="center"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
          <td colspan="2" align="center"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
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
<script src="../javascript/valida.js">  </script>
<SCRIPT language="javascript"> 

function  eliminar(ingreso,producto,cantidad)
  {
	if (confirm("¿Seguro que desea Eliminar todos los Registros Seleccionados?"))
		{
			document.forms.form1.id.value='2';
			document.forms.form1.cod_ingreso.value=ingreso;
			document.forms.form1.cod_producto.value=producto;
			document.forms.form1.cant_producto.value=cantidad;			
			document.forms.form1.action='ingresos_registrar.php';
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

}

<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $producto->_util->_cn->desconectar();?>