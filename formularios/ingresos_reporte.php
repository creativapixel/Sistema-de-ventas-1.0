<?php   session_start();

		require_once "../clases/ingresos_data.php";
		$ingreso = new Ingreso;	

		$producto = new Producto;
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
    <td align="center" class="titulo">REPORTE DE INGRESOS POR FECHA</td>
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
          <td width="126"  align="left"><input name="button2" type="button" class="btn" id="button2" value="Listar" onclick='enviar_form("POST","ingresos_reporte.php","")' /></td>
          <td width="154"  align="left"><input name="button" type="button" class="btn" id="button" value="Imprimir Reporte" onclick="vista_previa()" /></td>
        </tr>
      </table>
      <table width="800" border="0">
        <tr class="fondonegro">
          <td width="18%" align="center">Fecha</td>
          <td width="69%" align="center">Producto</td>
          <td width="13%" align="center">Cantidad</td>
          </tr>
        <?php  

			 $rs= $ingreso->ingresos_listar_fecha($_REQUEST['fecha'],$_REQUEST['fecha2']);

			 
			 if($rs)
			 {
				 $j=1;
			 
			 	while($campo =mysql_fetch_array($rs)) 
			 	{
			  ?>
        <tr bgcolor="#FFFFFF" style="cursor: hand" onmouseover="bgColor='#F3E212'" onmouseout ="bgColor='#FFFFFF'">
          <td align="center"><?php echo  $ingreso->_util->obtiene_fecha($campo['ing_fecha']);  ?></td>
          <td align="center"><?php echo $campo['pro_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['ing_cantidad'];  ?></td>
          </tr>
        <?php 
			  	$j=$j+1;			  	 
			  	} 
			  } 
			?>
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