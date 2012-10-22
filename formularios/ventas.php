<?php
	session_start();
	require_once('../clases/ventas_data.php');
	require_once "../clases/PHPPaging.lib.php";
	$venta = new Venta;	
	$paging = new PHPPaging;
	$pedido = new Pedido;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;
	$comprobante = new Comprobante;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
	/*if(!isset($_REQUEST['fecha'])){
		$_REQUEST['fecha']=date('d/m/y');
	}*/

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=7;
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

<?php
		
if ($_REQUEST['id']==='2')
{
	$pedido->pedido_cambiarestado($_REQUEST['ped_id'],'2');
}

if ($_REQUEST['id']==='3')
{
	$venta->venta_anular($_REQUEST['ven_id']);
}

?>

	
	<form name="form1"  id="form1">
        <table width="80%" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="5" class="titulo">PEDIDOS EN PROCESO</td>
          </tr>
          <tr>
            <td width="96" align="right" class="enfasis">&nbsp;</td>
            <td width="29" align="center" class="enfasis">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            <td width="375" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha</td>
            <td align="center" class="enfasis">:</td>
            <td width="174" align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onKeyUp='fn(this.form,this)' class="date-pick" onBlur="ver_pedidos()"  />
              <span class="enfasis">
              <input name="ped_id" type="hidden" id="ped_id">
              <input name="id" type="hidden" id="id2">
              <input name="ven_id" type="hidden" id="ven_id">
            </span></td>
            <td width="131" align="left"><span class="enfasis">
              <input name="Submit" type="button" class="btn" onClick="nuevo_pedido();" value="Generar Venta">
            </span></td>
            <td align="left" class="titulo">Presionar la tecla &lt;F5&gt; para actualizar el listado.</td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="12%" align="center" class="cabecera_tabla">NRO. PEDIDO</td>
                <td width="7%" align="center" class="cabecera_tabla">FECHA</td>
                <td width="56%" align="center" class="cabecera_tabla">CLIENTE</td>
                <td width="10%" align="center" class="cabecera_tabla">ESTADO</td>
                <td width="7%" align="center" class="cabecera_tabla">&nbsp;</td>
                <td width="8%" align="center" class="cabecera_tabla">ANULAR</td>
                </tr>
              
			  <?php  
	$rs= $pedido->pedido_listar('1',$_REQUEST['fecha']);

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) {?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
			    <td align="center"><?php echo $campo['ped_id']; ?></td>
                <td align="center"><?php echo $pedido->_util->obtiene_fecha($campo['ped_fecha']); ?></td>
                <td align="center"><?php echo strtoupper($campo['cli_razonsocial']); ?></td>
                <td align="center"><?php echo $pedido->ver_estado($campo['ped_estado']); ?></td>
                <td align="center"><?php if($campo['ped_estado']!='2' && $campo['ped_estado']!='1'){?><input name="button" type="button" class="btn" id="button" value="Atender" onClick="ver_pedido(<?php echo $campo['ped_id'] ?>)"><?php } ?></td>
                <td align="center"><?php if($campo['ped_estado']=='0'){?><a href="#" onClick="anular(<?php echo $campo['ped_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a><?php } ?></td>
                </tr>
			  <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="6"><table width="100%" border="0">
                  <tr>
                    <td width="19%">Listar
                      <input name="npaginas" type="text" id="npaginas" size="2" onblur="ver_pedidos()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
                    <td width="44%"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
                    <td align="right"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td colspan="6" align="right"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
              </tr>
            </table></td>
          </tr>
          <tr align="center">
            <td colspan="5" class="titulo">VENTAS REALIZADAS </td>
          </tr>
          <tr>
            <td colspan="5"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="9%" align="center" class="cabecera_tabla">FECHA</td>
                <td width="13%" align="center" class="cabecera_tabla">TIPO DOC. </td>
                <td width="15%" align="center" class="cabecera_tabla">NRO. DOC</td>
                <td width="38%" align="center" class="cabecera_tabla">CLIENTE</td>
                <td width="10%" align="center" class="cabecera_tabla">ESTADO</td>
                <td width="7%" align="center" class="cabecera_tabla">&nbsp;</td>
                <td width="8%" align="center" class="cabecera_tabla">ANULAR</td>
              </tr>
              <?php  
	$rsv= $venta->ventas_listar($_REQUEST['fecha'],'0');

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rsv);
	$paging->ejecutar(); 
	
	$j='1';
	while($campov = $paging->fetchResultado()) {?>
              <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $venta->_util->obtiene_fecha($campov['ven_fecha']); ?></td>
                <td align="center"><?php echo $comprobante->devulve_nombre_tipo_comprobante($campov['tipc_id']); ?></td>
                <td align="center"><?php echo $campov['ven_seriedoc']; ?> - <?php echo $campov['ven_nrodoc']; ?></td>
                <td align="center"><?php echo strtoupper($campov['cli_razonsocial']); ?></td>
                <td align="center"><?php echo $venta->ventas_ver_estado($campov['ven_estado']); ?></td>
                <td align="center"><input name="button2" type="button" class="btn" id="button2" value="Ver" onClick="imprimir(<?php echo $campov['ven_id']?>,<?php echo $campov['tipc_id']?>)"></td>
                <td align="center"><a href="#" onClick="anular_venta(<?php echo $campov['ven_id']; ?>)">
                  <?php if($campov['ven_estado']=='0'){?>
                  <img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a>
                  <?php } ?></td>
              </tr>
              <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="7"><table width="100%" border="0">
                    <tr>
                      <td width="19%">Listar
                          <input name="npaginas2" type="text" id="npaginas2" size="2" onblur="ver_pedidos()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
                      <td width="44%"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
                      <td align="right"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td colspan="7" align="right"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
              </tr>
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>

<?php $pedido->_util->_cn->desconectar();?>

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

function ver_pedidos()
{
   document.forms.form1.action='ventas.php';
   document.forms.form1.method='GET';
   document.forms.form1.submit();
}

function anular(ped_id)
{

	if (confirm("¿Seguro que desea anular el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.ped_id.value=ped_id;		
   		document.forms.form1.action='ventas.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}

function anular_venta(ven_id)
{

	if (confirm("¿Seguro que desea anular el registro?"))
	{
   		document.forms.form1.id.value='3';
   		document.forms.form1.ven_id.value=ven_id;		
   		document.forms.form1.action='ventas.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}

function ver_pedido(pedido)
{
	ventana = window.open("pedido_ver.php?ped_codigo="+pedido, "_blank", "resizable,height=550,width=700,scrollbars=yes");
}

function imprimir(venta,tipodoc)
{
	if(tipodoc=='1')
	{
		ventana = window.open("factura_impresion.php?venta="+venta, "_blank", "resizable,height=550,width=700,scrollbars=yes");
	}
	if(tipodoc=='2'||tipodoc=='9')
	{
		ventana = window.open("boleta_impresion.php?venta="+venta, "_blank", "resizable,height=550,width=700,scrollbars=yes");
	}	
}

function nuevo_pedido()
{
	ventana = window.open("pedido_nuevo.php", "_blank", "resizable,height=550,width=700,scrollbars=yes");
}

</script>

