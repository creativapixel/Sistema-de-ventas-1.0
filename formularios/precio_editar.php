<?php
	session_start();
	require_once('../clases/producto_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;

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
</head>
 <?php

     if($_REQUEST['id']==='1')
    {
        $producto->precio_editar($_REQUEST['pre_id'],$_REQUEST['producto'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['costo']);

	//echo "holaaaaaa";
    }

    $producto->precio_mostrar($_REQUEST['pre_id']);

    $_REQUEST['linea'] = $producto->lin_id;
    $_REQUEST['marca'] = $producto->mar_id;
    $_REQUEST['unidad'] = $producto->uni_id;
    $_REQUEST['producto'] = $producto->pro_id;


 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">

	
	<form name="form1"  id="form1">
        <table width="854" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3" class="titulo">EDITAR PRECIO </td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="200" align="right" class="enfasis"><strong>Linea</strong></td>
            <td width="15" align="center" class="enfasis"><strong>:</strong></td>
            <td width="631" align="left"><?php $linea->generar_select_linea('linea','ver_producto()',''); ?>
            <input name="pagina" type="hidden" id="pagina">
            <input name="id" type="hidden" id="id">
            <input name="pre_id" type="hidden" id="pre_id"  value="<?php echo $producto->pre_id; ?>"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"><strong>Marca </strong></td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  $marca->generar_select_marca('marca','ver_producto()','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  $producto->generar_select_producto('producto','',$_REQUEST['linea'],$_REQUEST['marca']);  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Unidad</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><?php  $producto->generar_select_unidad('unidad','','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Precio costo (S/.)  </td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="costo" type="text" id="costo" size="10" value="<?php echo $producto->pre_costo; ?>"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Precio venta (S/.)</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><input name="precio" type="text" id="precio" size="10" value="<?php echo $producto->pre_precio; ?>"></td>
          </tr>
          <tr>
            <td align="right"><a href="precios.php?linea=<?php echo $producto->lin_id; ?>&marca=<?php echo $producto->mar_id; ?>&producto=<?php echo $producto->pro_id; ?>">REGRESAR</a></td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="editar();" value="Editar Precio"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>

            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>

<?php $producto->_util->_cn->desconectar();?>

<script src="../javascript/eventos.js">  </script>
<script language="javascript">


function editar()
{

	if (document.forms.form1.costo.value=="")
	{ 
		document.forms.form1.costo.focus();
		alert("Ingresar el costo");
		return false; 
	}	

	if (document.forms.form1.precio.value=="")
	{ 
		document.forms.form1.precio.focus();
		alert("Ingresar el precio");
		return false; 
	}
	
document.forms.form1.action='precio_editar.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}


function ver_producto()
{
   document.forms.form1.action='precio_editar.php';
   document.forms.form1.method='POST';
   document.forms.form1.submit();
}

</script>

