<?php
	session_start();
	require_once('../clases/ventas_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	
	$venta = new Venta;
	$pedido = new Pedido;
	$producto = new Producto;
	$linea = new Linea;
	$marca = new Marca;
	$cliente = new Cliente;
	$comprobante = new Comprobante;
	$parametro = new Parametros;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}

	$pedido->pedido_ver($_REQUEST['ped_codigo']);

	
	
	
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema de Ventas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 

if ($_REQUEST['id']==='1')
{
	$rs = $pedido->detalle_pedido_listar($_REQUEST['ped_codigo']);	
	
	//verificamos disponibilidad de stock
	while($campos = mysql_fetch_array($rs))
	{
		$stock = $producto->ver_stock_producto($campos['pro_id']);
		
		if($stock<$campos['dped_totalcantidad'])
		{
			$disponible=1;		
		}
		/*else
		{
			$disponible=0;	echo "entreeeeeee";
		}*/

	}
	
	if($disponible==1)

	{
		echo "<h2 style='color:red'>Algun producto e la lista se quedo sin stock. Anule el pedido</h2>";
	}
	//elseif($disponible==0)
	else
	{

		 $venta->grabar_venta($_REQUEST['ped_codigo'],$_REQUEST['cli_codigo'],$_REQUEST['tipo_documento'],$_REQUEST['nro_documento'],$_REQUEST['serie_documento']);
	
		$rsv = $pedido->detalle_pedido_listar($_REQUEST['ped_codigo']);	
	
		while($campov = mysql_fetch_array($rsv))
		{
			$venta->grabar_detalle_venta($_SESSION['venta_codigo'],$campov['pro_id'],$campov['dped_cantidad'],$campov['dped_unidades'],$campov['dped_precio_cantidad'],$campov['dped_totalcantidad'],$campov['dped_preciounidades'],$campov['dped_preciototal']);
			$producto->disminuye_stock($campov['pro_id'],$campov['dped_totalcantidad']);
		}


				if($_REQUEST['tipo_documento']==1)
				{
					$campo = 'pcom_nro_factura';
				}
				
				if($_REQUEST['tipo_documento']==2)
				{
					$campo = 'pcom_nro_boleta';
				}
				
				if($_REQUEST['tipo_documento']==9)
				{
					$campo = 'pcom_nro_notacredito';	
				}

		$parametro->parametro_aumentar_codigo($campo);
	
		$rs2 = $pedido->pedido_cambiarestado($_REQUEST['ped_codigo'],'1');
	
		if($rs2)
		{

			if($_REQUEST['tipo_documento']==1)
			{
				echo "<script LANGUAGE='JavaScript'>
				
				ventana = window.open('factura_impresion.php?venta=".$_SESSION['venta_codigo']."', '_blank', 'resizable,height=550,width=700,scrollbars=yes');
				
				</script>";
			}
			if($_REQUEST['tipo_documento']==2 || $_REQUEST['tipo_documento']==9)
			{
				
				echo "<script LANGUAGE='JavaScript'>				
				ventana = window.open('boleta_impresion.php?venta=".$_SESSION['venta_codigo']."', '_blank', 'resizable,height=550,width=700,scrollbars=yes');
				
				</script>";
				
			}	
			
			
			echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'ventas.php';
			window.close();
			</script>";
		}
	}
}
?>

	
	<form name="form1"  id="form1">
	  <table width="100%" border="0" cellpadding="0">
      <tr>
            <td colspan="7" align="center" class="titulo">
			<?php 
			if($_REQUEST['id']=='1' && $disponible!=1)
			{
				echo "VENTA ".$_SESSION['venta_codigo'];
			}
			else
			{
				echo "PEDIDO ".$pedido->ped_id;
			}
			?>
			</td>
        </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td colspan="5" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="5" align="left"><?php echo $pedido->_util->obtiene_fecha($pedido->ped_fecha);?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Raz&oacute;n Social</td>
            <td width="24" align="center" class="enfasis"><strong>:</strong></td>
            <td colspan="5" align="left">
			<?php echo $pedido->cli_razonsocial;?>
            <input name="id" type="hidden" id="id">
            <span class="enfasis">
            <input name="ped_codigo" type="hidden" value="<?php echo $_REQUEST['ped_codigo']; ?>">
            <input name="cli_codigo" type="hidden">
</span></td>
          </tr>
		  
		  <?php if($_REQUEST['valor']!='1'){ ?>
          
          <?php if($_REQUEST['tipo_documento']==1){?>
          <tr>
            <td align="right" class="enfasis">RUC</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="5"><?php echo $pedido->cli_ruc; ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Direcci&oacute;n</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="5"><?php echo $pedido->cli_direccion; ?></td>
          </tr>
          <?php } ?>
          
          <tr>
            <td align="right" class="enfasis"> Comprobante </td>
            <td align="center" class="enfasis">:</td>
            <td width="213" align="left" class="enfasis">
			<?php
			if($_REQUEST['id']=='1' && $disponible!=1)
			{ 
				//$venta->ventas_ver($_SESSION['venta_codigo']);
				//echo $venta->ver_tipodocumento($venta->ven_tipodoc)." ";
				//echo $venta->ven_nrodoc;
			}
			else
			{
				
				$comprobante->generar_select_tipocomprobante('tipo_documento','mostrar()','');
			
				if($_REQUEST['tipo_documento']==1)
				{
					$numero = $parametro->parametro_ver_codigo('pcom_nro_factura');
					$serie = $parametro->parametro_ver_codigo('pcom_serie_factura');
				}
				
				if($_REQUEST['tipo_documento']==2)
				{
					$numero = $parametro->parametro_ver_codigo('pcom_nro_boleta');
					$serie = $parametro->parametro_ver_codigo('pcom_serie_boleta');
				}
				
				if($_REQUEST['tipo_documento']==9)
				{
					$numero = $parametro->parametro_ver_codigo('pcom_nro_notacredito');
					$serie = $parametro->parametro_ver_codigo('pcom_serie_notacredito');	
				}
			
			}
			?></td>
            <td width="50" align="left" class="enfasis">Serie:</td>
            <td width="89" align="left" class="enfasis"><input name="serie_documento" type="text" id="serie_documento" value="<?php echo $serie; ?>" size="10"></td>
            <td width="64" align="left" class="enfasis">N&uacute;mero:</td>
            <td width="146" align="left" class="enfasis"><input name="nro_documento" type="text" id="nro_documento" value="<?php echo $numero; ?>" size="10"></td>
          </tr>
		  <?php } ?>
		  
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td colspan="5" align="left" class="enfasis">&nbsp;            </td>
          </tr>
          <tr>
            <td colspan="7"><table width="100%"  border="0">
              <tr class="fondonegro">
                <td width="9%" align="center">Cantidad</td>
                <td width="59%" align="center">Producto</td>
                <td width="16%" align="center">P. Unitario </td>
                <td width="16%" align="center">Importe</td>
              </tr>
            <?php 
			$rs = $pedido->detalle_pedido_listar($_REQUEST['ped_codigo']);
			$suma=0;
			while($campo = mysql_fetch_array($rs)){

            $precio = $campo['dped_preciototal']/$campo['dped_totalcantidad'];

            ?>  
			  <tr bgcolor="#F0F0F0">
                <td align="center"><?php echo $campo['dped_totalcantidad'];?></td>
                <td><?php echo $campo['pro_descripcion'];?></td>
                <td align="center"><?php echo number_format($precio,2);?></td>
                <td align="center">S/. <?php echo $campo['dped_preciototal'];?></td>
              </tr>

            <?php 
			
				$suma = $suma + $campo['dped_preciototal'];
			}
			
			$subtotal = $suma/1.19;
			$igv = $suma - $subtotal;
			
			?>
            
            <?php if($_REQUEST['tipo_documento']==1){?>
            
			<tr bgcolor="#F0F0F0">
			  <td colspan="3" align="right"><em>Subtotal</em></td>
			  <td align="center">S/. <?php echo number_format($subtotal,2);?></td>
			  </tr>
			<tr bgcolor="#F0F0F0">
			  <td colspan="3" align="right"><em>IGV</em></td>
			  <td align="center">S/. <?php echo number_format($igv,2);?></td>
			  </tr>
            <?php } ?>  
              
			<tr bgcolor="#F0F0F0">
			    <td colspan="3" align="right"><em>Total</em></td>
			    <td align="center">S/. <?php echo number_format($suma,2);?></td>
		      </tr>
			</table></td>
          </tr>
          
          <tr>
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">
			<?php 
			
			if($_REQUEST['valor']=='1'){ }else{
			
				if($_REQUEST['id']=='1'  && $disponible!=1)
				{
			?>
						<input name="Submit" type="button" class="btn" value="Imprimir Venta" onClick="imprimir(<?php echo $_SESSION['venta_codigo']?>)">
			<?php
				}
				else
				{
			?>
			<input name="Submit5" type="button" class="btn" value="Generar Venta" onClick="grabar_venta(<?php echo $pedido->ped_id;?>,<?php echo $pedido->cli_id;?>)">
			<?php
				}
			}
			?>
              <span class="enfasis">
              <input name="Submit32" type="button" class="btn" value="Cerrar Ventana" onClick="javascript:window.close()">
            </span></td>
          </tr>
      </table>
</form>
</body>


</html>

<?php $pedido->_util->_cn->desconectar();?>

<script src="../javascript/eventos.js">  </script>
<script language="javascript">





function grabar_venta(ped_codigo,cli_codigo)
{

/*	if(document.forms.form1.nro_documento.value=='')
	{
		alert('Ingrese un numero de comprobante');
		document.forms.form1.nro_documento.focus();
		return false;
	}*/
	
	document.forms.form1.ped_codigo.value=ped_codigo;
	document.forms.form1.cli_codigo.value=cli_codigo;
	document.forms.form1.action='pedido_ver.php';
	document.forms.form1.method='POST';
	document.forms.form1.id.value='1'
	document.forms.form1.submit();
}

function mostrar(ped_codigo,cli_codigo)
{

	document.forms.form1.action='pedido_ver.php';
	document.forms.form1.method='POST';
	document.forms.form1.submit();
}


function imprimir(venta)
{
	ventana = window.open("venta_impresion.php?venta="+venta, "_blank", "resizable,height=550,width=700,scrollbars=yes");
}


</script>

