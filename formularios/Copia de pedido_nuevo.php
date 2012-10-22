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

</head>

<body>
<?php 

if($_REQUEST['id']==='1')
{
	$_SESSION['pedido']->introduce_producto($_REQUEST['producto'],$_REQUEST['cantidad'],$_REQUEST['unidades'],$_REQUEST['precio'],$_REQUEST['factor'],$_REQUEST['prod_nombre']);

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
		
		echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'pedidos.php';
		window.close();</script>";	
	}
}

?>

	
	<form name="form1"  id="form1">
	  <table width="100%" border="0" cellpadding="0">
      <tr>
            <td colspan="3" align="center" class="titulo">PEDIDO NUEVO </td>
        </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo date('d/m/y');; ?>" size="10" readonly="readonly"/></td>
          </tr>
          <tr>
            <td width="100" align="right" class="enfasis"><strong>Linea</strong></td>
            <td width="21" align="center" class="enfasis"><strong>:</strong></td>
            <td width="648" align="left"><?php $linea->generar_select_linea('linea','listar()',''); ?>
              <?php  $marca->generar_select_marca('marca','listar()','');  ?>
              <input name="id" type="hidden" id="id">
            <input name="ing_id" type="hidden" id="ing_id"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left">
			<?php $producto->generar_select_producto('producto','listar()',$_REQUEST['linea'],$_REQUEST['marca']);  
			
				$producto->producto_ver($_REQUEST['producto']);
			
			?> STOCK: 
              
            <input name="stock" type="text" id="stock2" value="<?php echo $producto->ver_stock_producto($_REQUEST['producto']);?>" size="5" readonly="readonly" >
            <input name="prod_nombre" type="hidden" id="prod_nombre" value="<?php echo $producto->pro_descripcion;?>"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Cantidad</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left">              <?php  $producto->generar_select_unidad_precio('unidad','listar()',$_REQUEST['producto']);  ?>
              <input name="cantidad" type="text" id="cantidad" size="5" onChange='mayusculas(this);'>
             + 
            <input name="unidades" type="text" id="unidades" size="5">
            <input name="precio" type="hidden" id="precio" value="<?php echo $producto->ver_precio($_REQUEST['unidad']);?>">
            <input name="factor" type="hidden" id="factor" value="<?php echo $producto->ver_factor_precio($_REQUEST['unidad']);?>"></td></tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">
			<input name="Submit" type="button" class="btn" onClick="agregar();" value="Agregar producto">
              <input name="Submit2" type="button" class="btn" value="Borrar Todo" onClick="borrar_todo()">
              <input name="Submit3" type="button" class="btn" value="Cerrar Ventana" onClick="javascript:window.close()">
            <input name="cod_linea" type="hidden" id="cod_linea"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="3"><?php echo $_SESSION['pedido']->imprime_pedido();?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right"><span class="enfasis">Cliente</span></td>
            <td align="center"><span class="enfasis">:</span></td>
            <td><?php $cliente->generar_select_cliente('cliente','','');?>
            <input name="Submit4" type="button" class="btn" value="Agregar Cliente" onClick="nuevo_cliente()"></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="Submit5" type="button" class="btn" value="Grabar Pedido" onClick="grabar_pedido()">
              <span class="enfasis">
              <input name="Submit32" type="button" class="btn" value="Cerrar Ventana" onClick="javascript:window.close()">
            </span></td>
          </tr>
      </table>
</form>
</body>


</html>

<?php //$_SESSION['pedido']->_util->_cn->desconectar();?>

<script src="../javascript/eventos.js">  </script>
<script language="javascript">


function agregar()
{

	if (document.forms.form1.fecha.value=="")
	{ 
		document.forms.form1.fecha.focus();
		alert("Ingresar la fecha de ingreso");
		return false; 
	}
	
	if(document.forms.form1.stock.value<=0)
	{
		document.forms.form1.stock.focus();
		alert("No hay stock suficiente para realizar el pedido");
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

