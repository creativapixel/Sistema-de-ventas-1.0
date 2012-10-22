<?php session_start();
require_once('../clases/producto_data.php');

$producto = new  Producto;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}



 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MANTENIMIENTO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
<script src="../javascript/eventos.js">  </script>
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
		  if($_REQUEST['id']==='1')
{
	  
$producto->unidad_nuevo($_REQUEST['unidad'],$_REQUEST['factor']);

}

		
if ($_REQUEST['id']==='2')
{

$producto->unidad_borrar($_REQUEST['unidad_codigo']);
}
		
		
		
		  
		  ?>

	
	<form name="form1"  id="form1" >
        <table width="552" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3"><span class="titulo">LISTADO DE UNIDADES</span> 
			  <input name="id" type="hidden" id="id">
			  <input name="unidad_codigo" type="hidden" id="unidad_codigo"></td>
          </tr>
          
          <tr>
            <td align="right"><span class="enfasis">Unidad</span></td>
            <td align="center"><span class="enfasis">:</span></td>
            <td align="left"><span class="enfasis">
              <input name="unidad" type="text" id="unidad" size="40" onKeyUp="enter(this.form,this);" onChange='mayusculas(this);'>
            </span></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Factor</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="factor" type="text" id="factor"> Cantidad en unidades</td>
          </tr>
          <tr>
            <td width="106" align="center">&nbsp;</td>
            <td width="15" align="center">&nbsp;</td>
            <td width="423" align="left"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Unidad"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><table width="79%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="10%" align="center">ORDEN</td>
                <td width="34%" align="center">DESCRIPCI&Oacute;N</td>
                <td width="35%" align="center">FACTOR</td>
                <td colspan="2" align="center">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  

	$rs= $producto->unidad_listar();


	
	$j='1';
	while($campo = mysql_fetch_array($rs)) { ?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo strtoupper($campo['uni_descripcion']) ?></td>
                <td align="center"><?php echo strtoupper($campo['uni_factor']) ?></td>
                <td width="10%" align="center"><a href="unidad_editar.php?unidad_id=<?php echo $campo['uni_id'];?>"><img src="../imagenes/icono_editar.gif" alt="Editar Registro" width="14" height="14" border="0"></a></td>
                <td width="11%" align="center"><a href="#" onClick="borrar(<?php echo $campo['uni_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" alt="Eliminar Registro" width="14" height="14" border="0"></a></td>
			  </tr>
			  <?php 
			  $j=$j+1;
			
			  } ?>
              <tr>
                <td colspan="5" align="center"></td>
              </tr>
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>

<script language="javascript">

document.forms.form1.linea.focus();

function nuevo()
{

if (document.forms.form1.unidad.value=="")
{ 
document.forms.form1.unidad.focus();
alert("Ingresar Nombre de la Unidad");
return false; 
}

if (document.forms.form1.factor.value=="")
{ 
document.forms.form1.factor.focus();
alert("Ingresar el factor para la unidad");
return false; 
}

document.forms.form1.action='unidades.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();

}





function   borrar(unidad_codigo)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
		document.forms.form1.id.value='2';
		document.forms.form1.unidad_codigo.value=unidad_codigo;
		document.forms.form1.action='unidades.php';
		document.forms.form1.method='POST';
		document.forms.form1.submit();
	}
	else
	{
	return false; 
	}
		
		
}
</script>

<?php $producto->_util->_cn->desconectar();?>
