<?php 
session_start();
require_once('../clases/producto_data.php');

$producto = new  Producto;
$linea = new Linea;
$marca = new Marca;

if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Ventas</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 


if (isset($_REQUEST['producto_id']))
	{ 	
		$_SESSION['producto_codigo']=$_REQUEST['producto_id'];		
		
 	}




if ($_REQUEST['id']==='1')
 	{
		$producto->producto_editar($_SESSION['producto_codigo'],$_REQUEST['linea'],$_REQUEST['marca'],$_REQUEST['descripcion'],$_REQUEST['stock'],$_REQUEST['codigo']);
    }
	
$producto->producto_ver($_SESSION['producto_codigo']);


$_REQUEST['marca']=$producto->mar_id;
$_REQUEST['linea']=$producto->lin_id;

?>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
  </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">

	
	<form id="form1" name="form1">
<span class="titulo">EDITAR PRODUCTO</span>
<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="left">
          <td width="67" align="right" class="enfasis" ><strong>Linea</strong></td>
          <td align="center" class="enfasis" ><strong>:</strong></td>
          <td><?php $linea->generar_select_linea('linea','',''); ?></td>
        </tr>
        <tr align="left">
          <td align="right" class="enfasis" ><strong>Marca</strong></td>
          <td align="center" class="enfasis" ><strong>:</strong></td>
          <td><?php  $marca->generar_select_marca('marca','','');  ?>
            <input name="id" type="hidden" id="id" /></td>
        </tr>
        <tr align="left">
          <td align="right" class="enfasis" ><strong>Descripci&oacute;n</strong></td>
          <td width="16" align="center" class="enfasis" ><strong>:</strong></td>
          <td width="322"><input name="descripcion" type="text" id="descripcion" value="<?php  echo htmlspecialchars($producto->pro_descripcion); ?>" size="50" /></td>
        </tr>
        <tr align="left">
          <td align="right" class="enfasis" ><strong>Codigo</strong></td>
          <td width="16" align="center" class="enfasis" ><strong>:</strong></td>
          <td width="322"><input name="codigo" type="text" id="codigo" value="<?php  echo htmlspecialchars($producto->pro_codigo); ?>" size="30" /></td>
        </tr>
        <tr align="left">
          <td align="right" class="enfasis">Stock</td>
          <td align="center" class="enfasis"><strong>:</strong></td>
          <td><input name="stock" type="text" id="stock" value="<?php  echo $producto->pro_stock; ?>" size="10" /></td>
        </tr>
        <tr align="left">
          <td align="right"><a href="productos.php?linea=<?php echo $producto->lin_id; ?>">REGRESAR</a></td>
          <td align="left">&nbsp;</td>
          <td align="left"><input  name="Submit3"  type="button" class="btn" onclick="editar();" value="Editar" /></td>
          </tr>

        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          </tr>
      </table>
    </form>    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>


 
<script src="../javascript/valida.js" language="javascript"></script>
<script language="javascript">
function editar()
{
	if (document.forms.form1.descripcion.value=="")
	{ 
		document.forms.form1.descripcion.focus();
		alert("Ingrese Nombre del producto");
		return false; 
	}
	
	if (document.forms.form1.stock.value=="")
	{ 
		document.forms.form1.stock.focus();
		alert("Ingrese el stock");
		return false; 
	}	
	
	document.forms.form1.id.value='1'
  	document.forms.form1.action='producto_editar.php';
   	document.forms.form1.method='POST';
   	document.forms.form1.submit();
	
}

</script>

<?php $producto->_util->_cn->desconectar();?>
