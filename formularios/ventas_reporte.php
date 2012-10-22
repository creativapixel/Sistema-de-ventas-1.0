<?php   session_start();

		require_once "../clases/ventas_data.php";
		$venta = new Venta;	

		$producto = new Producto;
		$cliente = new Cliente;
		$comprobante = new Comprobante;
	
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



<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center" class="titulo">REPORTE DE VENTAS POR FECHA</td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="800" border="0">
        <tr>
          <td  align="left">&nbsp;</td>
          <td  align="center" class="enfasis">&nbsp;</td>
          <td  align="left">&nbsp;</td>
          <td  align="left" class="enfasis">&nbsp;</td>
          <td  align="center" class="enfasis">&nbsp;</td>
          <td  align="left">&nbsp;</td>
          <td  align="left">&nbsp;</td>
          <td  align="left">&nbsp;</td>
        </tr>
        <tr>
          <td width="87"  align="left"><span class="enfasis">Fecha desde</span></td>
          <td width="10"  align="center" class="enfasis">:</td>
          <td width="148"  align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick"/></td>
          <td width="85"  align="left" class="enfasis">Hasta</td>
          <td width="14"  align="center" class="enfasis">:</td>
          <td width="142"  align="left"><input name="fecha2" type="text" id="fecha2" value="<?php  echo $_REQUEST['fecha2']; ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick"/></td>
          <td width="126"  align="left"><input name="button2" type="button" class="btn" id="button2" value="Listar" onclick='enviar_form("POST","ventas_reporte.php","")' /></td>
          <td width="154"  align="left">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr class="fondonegro">
          <td colspan="3">Cliente</td>
          </tr>
        <?php  
		$rs= $venta->ventas_listar_fecha($_REQUEST['fecha'],$_REQUEST['fecha2'],'','cli_id'); 
		if($rs)
		{
			$j=1;
			 $total = 0;
			while($campo =mysql_fetch_array($rs)) 
			{
		?>
        <tr bgcolor="#FFFFFF">
          <td colspan="3"><?php echo $campo['cli_razonsocial'];  ?></td>
          </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%">&nbsp;</td>
              <td width="15%" class="fondonegro">Tipo Comprobante </td>
              <td width="14%" class="fondonegro">Nro Comprobante </td>
              <td width="48%" class="fondonegro">Fecha</td>
              <td width="11%" class="fondonegro">&nbsp;</td>
              <td width="1%">&nbsp;</td>
              <td width="2%">&nbsp;</td>
              <td width="3%">&nbsp;</td>
            </tr>
        <?php  
		$rsc= $venta->ventas_listar_fecha($_REQUEST['fecha'],$_REQUEST['fecha2'],$campo['cli_id']); 
		if($rsc)
		{		 
			$total_comprobante =0;
			while($campoc =mysql_fetch_array($rsc)) 
			{
		?>
			<tr>
              <td>&nbsp;</td>
              <td><?php echo $comprobante->devulve_nombre_tipo_comprobante($campoc['tipc_id'])?></td>
              <td><?php echo $campoc['ven_nrodoc']?></td>
              <td><?php echo $venta->_util->obtiene_fecha($campoc['ven_fecha']);?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="55%" class="fondonegro">Producto</td>
                  <td width="15%" align="center" class="fondonegro">Cantidad</td>
                  <td width="16%" align="center" class="fondonegro">Importe</td>
                  <td width="14%">&nbsp;</td>
                </tr>
        <?php  
		$rsd= $venta->detalle_ventas_listar($campoc['ven_id']); 
		if($rsd)
		{		 
			$suma_importe = 0;
			while($campod =mysql_fetch_array($rsd)) 
			{
		?>
                <tr>
                  <td><?php echo $campod['pro_descripcion'];?></td>
                  <td align="center"><?php echo $campod['ven_totalcantidad'];?></td>
                  <td align="center">S/. <?php echo $campod['ven_preciototal'];?></td>
                  <td>&nbsp;</td>
                </tr>
		<?php 		  
				$suma_importe = $suma_importe + $campod['ven_preciototal'];
			} 
		} 
		?>		
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">S/. <?php echo number_format($suma_importe,2);?></td>
                </tr>				
              
			  </table></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
		<?php 		$total_comprobante = $total_comprobante + $suma_importe;
			} 
		} 
		?>					
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2" align="right">Total Comprobantes --&gt; </td>
			  <td align="center">S/. <?php echo number_format($total_comprobante,2);?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
	
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="3">&nbsp;</td>
        </tr>
		<?php 
				$j=$j+1;
				
				$total = $total + $total_comprobante;		  	 
			} 
		} 
		?>
        <tr bgcolor="#FFFFFF">
          <td width="18%" align="center">&nbsp;</td>
          <td width="69%" align="right">Total de Ventas --&gt; </td>
          <td width="13%" align="center">S/. <?php echo number_format($total,2);?></td>
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

function vista_previa(){
	window.open("ingresos_reporte_impresion.php?fecha=<?php echo $_REQUEST['fecha'];?>&fecha2=<?php echo $_REQUEST['fecha2'];?>", "_blank", "resizable,height=600,width=800");
}

<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $producto->_util->_cn->desconectar();?>
