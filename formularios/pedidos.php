<?php
	session_start();
	require_once('../clases/pedidos_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	$pedido = new Pedido;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
	/*if(!isset($_REQUEST['fecha'])){
		$_REQUEST['fecha']=date('d/m/y');
	}*/

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=15;
	}
	
	/*if($_REQUEST['id']=='2')
	{

		$pedido->pedido_anular($_REQUEST['ped_id']);
	}*/

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

?>

	
	<form name="form1"  id="form1">
        <table width="658" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="4" class="titulo">PEDIDOS EN PROCESO</td>
          </tr>
          <tr>
            <td width="70" align="right" class="enfasis">&nbsp;</td>
            <td width="21" align="center" class="enfasis">&nbsp;</td>
            <td width="274" align="left">&nbsp;</td>
            <td width="329" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onKeyUp='fn(this.form,this)' class="date-pick" onBlur="listar_pedidos()"  /></td>
            <td align="left" class="titulo">Presionar la tecla &lt;F5&gt; para actualizar el listado.</td>
          </tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="nuevo_pedido();" value="Generar Nuevo Pedido">
            <input name="ped_id" type="hidden" id="ped_id">
            <input name="id" type="hidden" id="id"></td>
            <td align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="4"><table width="700" border="0" align="center" cellpadding="0" cellspacing="2">
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
			    <td align="center"><strong><?php echo $campo['ped_id']; ?></strong></td>
                <td align="center"><strong><?php echo $pedido->_util->obtiene_fecha($campo['ped_fecha']); ?></strong></td>
                <td align="center"><?php echo strtoupper($campo['cli_razonsocial']); ?></td>
                <td align="center"><?php echo $pedido->ver_estado($campo['ped_estado']); ?></td>
                <td align="center"><input name="button" type="button" class="btn" id="button" value="Ver" onClick="ver_pedido(<?php echo $campo['ped_id'];?>)"></td>
                <td align="center"><a href="#" onClick="anular(<?php echo $campo['ped_id']; ?>)">
                  <?php if($campo['ped_estado']=='0'){?>
                  <img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a>
                  <?php } ?></td>
                </tr>
			  <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="6"><table width="100%" border="0">
                  <tr>
                    <td width="19%">Listar
                      <input name="npaginas" type="text" id="npaginas" size="2" onblur="listar_pedidos()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
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


function listar_pedidos()
{
   document.forms.form1.action='pedidos.php';
   document.forms.form1.method='GET';
   document.forms.form1.submit();
}

function anular(ped_id)
{

	if (confirm("¿Seguro que desea anular el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.ped_id.value=ped_id;		
   		document.forms.form1.action='pedidos.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}

function nuevo_pedido()
{
	ventana = window.open("pedido_nuevo.php", "_blank", "resizable,height=550,width=700,scrollbars=yes");
}

function ver_pedido(pedido)
{
	ventana = window.open("pedido_ver.php?valor=1&ped_codigo="+pedido, "_blank", "resizable,height=550,width=700,scrollbars=yes");
}

</script>

