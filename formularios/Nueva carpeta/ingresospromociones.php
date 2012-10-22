<?php session_start();
  require_once('../clases/ingresos_data.php');

$almacen = new  almacendata();
$producto = new  productodata();
$paciente = new ingresodata();

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}


if (!isset($_REQUEST['proveedor']) && !isset($_REQUEST['id']))
{
$_REQUEST['proveedor']='1';
//$_REQUEST['pagina']='0';
}


 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
<script language="Javascript" src="../javascript/PopCalendar.js"></script>
</head>

<body>
<script language="JavaScript">
	PopCalendar = getCalendarInstance();
	PopCalendar.initCalendar();
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
	
	if (!isset($_REQUEST['fecha']))
{
$_REQUEST['fecha']=date('d/m/y');
}
	
	
	
		  if($_REQUEST['id']==='1')
{
	  
$almacen->promocionalmacen_nuevo($_REQUEST['fecha'],$_REQUEST['promocion'],$_REQUEST['cantidad'],$_REQUEST['unidad'],$_SESSION['sesion_id_usuario']
);

}

		
if ($_REQUEST['id']==='2')
{

$almacen->promocion_almacenborrar($_REQUEST['codigo'],$_REQUEST['cantidad_b'],$_REQUEST['promo'],$_REQUEST['aread']);

}
		

		  
		  ?>

	
	<form name="form1"  id="form1">
        <table width="923" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="4"><h5>INGRESO DE  PROMOCIONES A ALMACEN </h5></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">Fecha de ingreso </td>
            <td align="left" class="enfasis" >:</td>
            <td colspan="2" align="left"><input name="fecha" type="text" id="fecha" value="<?php echo $_REQUEST['fecha']; ?>" size="10"   onBlur="ver_producto()"/>
        <a style='cursor:hand;' onclick='document.form1.fecha.oldValue=document.form1.fecha.value;PopCalendar.selectWeekendHoliday(1,1);PopCalendar.show(document.form1.fecha, &quot;dd/mm/yyyy&quot;, null, &quot;&quot;, &quot;&quot;);'><img src="imagen/calendar.gif" width="23" height="21" />
        <input name="pagina" type="hidden" id="pagina">
        <input name="id" type="hidden" id="id">
        <input name="codigo" type="hidden" id="codigo">
        <input name="cantidad_b" type="hidden" id="cantidad_b">
        <input name="promo" type="hidden" id="promo">
        <input name="aread" type="hidden" id="aread">
        </a></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">Promoci&oacute;n</td>
            <td align="left" class="enfasis" >:</td>
            <td colspan="2" align="left">


<?php 
					$producto->generar_select_promocion('promocion','',''); ?></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">Cantidad</td>
            <td align="left" class="enfasis" >:</td>
            <td colspan="2" align="left"><input name="cantidad" type="text" id="cantidad" size="10">
            </td>
          </tr>
          <tr>
            <td width="117" align="left" class="enfasis">Unidad</td>
            <td width="8" align="left" class="enfasis" >:</td>
            <td width="210" align="left">
            <?php 
					$producto->generar_select_unidad('unidad','',''); ?>&nbsp;</td>
            <td width="578" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Agregar Promoci&oacute;n a Almac&eacute;n">
&nbsp;&nbsp;&nbsp;&nbsp;            <?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'5')){ echo "<input name='salidas' type='button' value='Registrar Salidas a Tienda' class='btn' onClick='ir_salidas()'>";}?></td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><table width="82%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="7%" align="center">ORDEN</td>
                <td width="12%" align="center">FECHA</td>
                <td width="38%" align="center">DESCRIPCION</td>
                <td width="21%" align="center">CANTIDAD</td>
                <td width="11%" align="center">DESTINO</td>
                <td align="center">OPCI&Oacute;N</td>
              </tr>
              
			  <?php  
			//  $parametros="&marca=".$_REQUEST['marca'];
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $almacen->almacen_listarpromocionxfecha('1',$_REQUEST['fecha']);
			 if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo $almacen->util->obtienefecha(strtoupper($campo['ingresopro_fecha'])) ?></td>
                <td align="center"><?php echo strtoupper($producto->devuelve_promocion($campo['promo_id'])); ?></td>
                <td align="center"><?php echo $campo['ingresopro_cantidad']." ".strtoupper($producto->devuelve_unidad($campo['unidad_id'])); ?></td>
                <td align="center"><?php echo strtoupper($paciente->devuelve_area($campo['ingresopro_destino'])); ?></td>
                <td width="11%" align="center">
				
				<?php //if ($almacen->verificar_ingresopromocion_a_tienda($campo['promo_id'])){ echo "En tienda"; } else {?>
				
				<a href="#" onClick="borrar('<?php echo $campo['ingresopro_id']; ?>','<?php echo $campo['ingresopro_cantidad']; ?>','<?php echo $campo['promo_id']; ?>','<?php echo $campo['ingresopro_destino']; ?>')">X Quitar</a>
				
				
				<?php //}?></td>
			  </tr>
			  <?php 
			  $j=$j+1;
			  } 
			  } ?>
              <tr>
                <td colspan="6">&nbsp;</td>
                </tr>
              <tr>
                <td colspan="6" align="center"><?php  // echo $modelo->util->devuelve_paginado($modelo->query,$parametros,$idioma='1',$color='#006699');  ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
<?php  $almacen->con->cerrar(); 

?>
</body>


</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">


function nuevo()
{
if (document.forms.form1.fecha.value=="")
{ 
document.forms.form1.fecha.focus();
alert("Ingrese Fecha");
return false;
}
if (document.forms.form1.cantidad.value=="")
{ 
document.forms.form1.cantidad.focus();
alert("Ingrese Cantidad");
return false; 
}
	if (!Esnum(document.forms.form1.cantidad.value))
	{
		document.forms.form1.cantidad.focus();
	 	alert("Ingrese un valor numerico para cantidad");
	 	return false;
	}



document.forms.form1.action='ingresospromociones.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}



function ver_producto()
{
   document.forms.form1.action='ingresospromociones.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}
function ir_salidas()
{
   document.forms.form1.action='salidaspromociones.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}
function borrar(codigo,cantidad_b,promo,aread)
{
   document.forms.form1.id.value='2';
   document.forms.form1.codigo.value=codigo;
   document.forms.form1.cantidad_b.value=cantidad_b; 
   document.forms.form1.promo.value=promo;    
   document.forms.form1.aread.value=aread;    
   document.forms.form1.action='ingresospromociones.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}




</script>

