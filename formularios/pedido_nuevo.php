<?php
	//session_start();
	require_once('../clases/pedidos_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;

	$producto = new Producto;
	$linea = new Linea;
	$marca = new Marca;
	$cliente = new Cliente;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema de Ventas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">


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


<!-- combo autocompletable-->
<script>
window.dhx_globalImgPath = "../librerias/dhtmlxCombo/codebase/imgs/";
</script>
<link rel="STYLESHEET" type="text/css" href="../librerias/dhtmlxCombo/codebase/dhtmlxcombo.css">
<script  src="../librerias/dhtmlxCombo/codebase/dhtmlxcommon.js"></script>
<script  src="../librerias/dhtmlxCombo/codebase/dhtmlxcombo.js"></script>
<script src="../librerias/dhtmlxCombo/codebase/ext/dhtmlxcombo_whp.js" type="text/javascript"></script>
<!-- final de combo autocompletable -->



</head>

<body>
<?php 

if($_REQUEST['id']==='1')
{
	$_SESSION['pedido']->introduce_producto($_REQUEST['producto'],$_REQUEST['cantidad'],$_REQUEST['unidades'],$_REQUEST['precio'],$_REQUEST['factor'],$_REQUEST['prod_nombre']);
	
	$_REQUEST['producto']='';
	$_REQUEST['cantidad']='';
	$_REQUEST['unidades']='';
}

		
if ($_REQUEST['id']==='2')
{
	$_SESSION["pedido"]->elimina_producto($_REQUEST["cod_linea"]);
}

if ($_REQUEST['id']==='3')
{
	$_SESSION["pedido"]->vaciar_carrito();
}

if ($_REQUEST['id']==='4')
{
	$rs = $_SESSION["pedido"]->grabar_pedido($_REQUEST['fecha'],$_REQUEST['cliente']);
	
	if ($rs)
	{
		$_SESSION["pedido"]->vaciar_carrito();
		
		if($_REQUEST['venta']!=1)
		{		
			echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'pedidos.php';
		window.close();</script>";
		}
		else
		{
			echo "<script  LANGUAGE='JavaScript'> location.href = 'pedido_ver.php?ped_codigo=".$_SESSION['pedido_id']."'; </script>";
		}		
			
	}
}

if (!isset($_REQUEST['cliente']))
{
	$_REQUEST['cliente']=1;
}

?>

	
	<form name="form1"  id="form1">
	  <table border="0" cellpadding="0">
      <tr>
            <td colspan="6" align="center" class="titulo">PEDIDO NUEVO </td>
        </tr>
          <tr>
            <td width="35" align="right" class="enfasis">&nbsp;</td>
            <td width="79" align="right" class="enfasis">&nbsp;</td>
            <td width="19" align="center" class="enfasis">&nbsp;</td>
            <td colspan="3" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="right" class="enfasis">Fecha</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="3" align="left"><input name="fecha" type="text" id="fecha" size="10" readonly="readonly"/>
            <input name="id" type="hidden" id="id">
            <input name="ing_id" type="hidden" id="ing_id2"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td width="153" align="left">
			
			<?php $producto->generar_select_producto_total('producto','listar()','0','0','0','');  ?>
		
	
			
			
			
			
<?php //$producto->generar_select_producto('producto','listar()',$_REQUEST['linea'],$_REQUEST['marca']);  
			
				$producto->producto_ver($_REQUEST['producto']);
			
			?> </td>
            <td colspan="2" align="left">STOCK:
              <input name="stock" type="text" id="stock" value="<?php echo $producto->ver_stock_producto($_REQUEST['producto']);?>" size="5" readonly="readonly" >
              <input name="prod_nombre" type="hidden" id="prod_nombre2" value="<?php echo $producto->pro_descripcion;?>"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="right" class="enfasis">Cantidad</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td colspan="3" align="left">              <?php  $producto->generar_select_unidad_precio('unidad','listar()',$_REQUEST['producto']);  ?>
              <input name="cantidad" type="text" id="cantidad" onChange='mayusculas(this);' value="<?php echo $_REQUEST['cantidad'];?>" size="5">
             + 
            <input name="unidades" type="text" id="unidades" value="<?php echo $_REQUEST['unidades'];?>" size="5">
            <input name="precio" type="hidden" id="precio" value="<?php echo $producto->ver_precio($_REQUEST['unidad']);?>">            
            <input name="factor" type="hidden" id="factor" value="<?php echo $producto->ver_factor_precio($_REQUEST['unidad']);?>"></td></tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td colspan="3" align="left" class="enfasis">
			<input name="Submit" type="button" class="btn" onClick="agregar();" value="Agregar producto">
              <input name="Submit2" type="button" class="btn" value="Borrar Todo" onClick="borrar_todo()">
              <input name="Submit3" type="button" class="btn" value="Cerrar Ventana" onClick="javascript:window.close()">
            <input name="cod_linea" type="hidden" id="cod_linea"></td>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><?php echo $_SESSION['pedido']->imprime_pedido();?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right"><span class="enfasis">Cliente</span></td>
            <td align="center"><span class="enfasis">:</span></td>
            <td><?php $cliente->generar_select_cliente('cliente','','');?>            </td>
            <td width="105" align="left"><input name="Submit4" type="button" class="btn" value="Agregar Cliente" onClick="nuevo_cliente()"></td>
            <td width="111" align="left"> <input name="venta" type="checkbox" id="venta" value="1">
            Registra venta</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3"><input name="Submit5" type="button" class="btn" value="Grabar Pedido" onClick="grabar_pedido()">
              <span class="enfasis">
              <input name="Submit32" type="button" class="btn" value="Cerrar Ventana" onClick="javascript:window.close()">
            </span></td>
          </tr>
      </table>
</form>
</body>


</html>

<?php //$_SESSION['pedido']->_util->_cn->desconectar();?>
<!-- script combo autocompletable -->
<script>

	var z = dhtmlXComboFromSelect("producto");
	z.enableFilteringMode(true);
	z.attachEvent("onOpen", limpiar_combo_producto);
		
	var z2 = dhtmlXComboFromSelect("cliente");
	z2.enableFilteringMode(true);
	z2.attachEvent("onOpen", limpiar_combo_cliente);	

	function limpiar_combo_producto(){z.setComboText("");}
	function limpiar_combo_cliente(){z2.setComboText("");}	
	
</script>		
<!-- script fin combo autocompletable -->

<script src="../javascript/eventos.js">  </script>
<script language="javascript">


	var fecha=new Date();
	var diames=fecha.getDate();
	
	if(diames<10)
	{
		diames = '0'+diames;
	}
	
	
	var diasemana=fecha.getDay();
	var mes=fecha.getMonth() +1 ;
	
	if(mes<10)
	{
		mes = '0'+mes;
	}	
	
	var ano=fecha.getFullYear();
	
	document.forms.form1.fecha.value= diames + "/" + mes + "/" + ano;

function agregar()
{

	if (document.forms.form1.fecha.value=="")
	{ 
		document.forms.form1.fecha.focus();
		alert("Ingresar la fecha de ingreso");
		return false; 
	}
	
	cantidad = parseFloat(document.forms.form1.cantidad.value);
	factor = parseFloat(document.forms.form1.factor.value);
	
	if(document.forms.form1.unidades.value=='')
	{
		unidades = 0;
	}
	else
	{
		unidades = parseFloat(document.forms.form1.unidades.value);
	}
	
	total_cantidad = (cantidad * factor) + unidades;
	
	if(parseFloat(document.forms.form1.stock.value) < total_cantidad)
	{
		document.forms.form1.stock.focus();
		alert("No hay stock suficiente para realizar el pedido");
		return false; 
	}

	if (document.forms.form1.unidad.value=="")
	{ 
		document.forms.form1.unidad.focus();
		alert("Seleccione una unidad");
		return false; 
	}

	if (document.forms.form1.cantidad.value=="")
	{ 
		document.forms.form1.cantidad.focus();
		alert("Ingresar la cantidad");
		return false; 
	}

document.forms.form1.action='pedido_nuevo.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}

function listar()
{
   document.forms.form1.action='pedido_nuevo.php';
   document.forms.form1.method='POST';
   document.forms.form1.submit();
}

function eliminar_producto(linea)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.cod_linea.value=linea;		
   		document.forms.form1.action='pedido_nuevo.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}

function nuevo_cliente()
{
	ventana = window.open("cliente_nuevo.php", "_blank", "resizable,height=200,width=500");
}

function grabar_pedido()
{
   		document.forms.form1.id.value='4';
   		document.forms.form1.action='pedido_nuevo.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
}

function borrar_todo()
{

	if (confirm("¿Seguro que desea eliminar todos los registros?"))
	{
   		document.forms.form1.id.value='3';
   		document.forms.form1.action='pedido_nuevo.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}


</script>

