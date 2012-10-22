<?php 
session_start();
require_once('../clases/marca_data.php');
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
<title>MANTENIMIENTO</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<script src="../javascript/eventos.js">  </script>
</head>

<body>
<?php 


if (isset($_REQUEST['marca_id']))
	{ 	
		$_SESSION['marca_codigo']=$_REQUEST['marca_id'];		
		
 	}

if ($_REQUEST['id']==='1')
 	{
		$marca->marca_editar($_SESSION['marca_codigo'],$_REQUEST['descripcion']);
    }

$marca->marca_ver($_SESSION['marca_codigo']);

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
    <td align="center">

	
	<form id="form1" name="form1" >
	  <table width="488" border="0" align="center" cellpadding="0" cellspacing="2">
		
        <tr align="left">
          <td colspan="4" >&nbsp;</td>
        </tr>
        <tr align="left">
          <td colspan="4" align="center" class="titulo" >EDITAR MARCA</td>
          </tr>
        <tr align="left">
          <td colspan="4" ><input name="id" type="hidden" id="id" />&nbsp;</td>
          </tr>
        <tr align="left">
          <td width="73" >Descripci&oacute;n</td>
          <td width="17" align="center" >:</td>
          <td colspan="2"><input name="descripcion" type="text" id="descripcion" value="<?php  echo $marca->mar_descripcion; ?>" size="40" onKeyUp="enter(this.form,this);" onChange='mayusculas(this);'/></td>
        </tr>
        <tr align="left">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="139"><input  name="editar"  type="button" class="btn" onclick="editar_marca();" value="Editar Marca" /></td>
          <td width="249"><a href="marcas.php">Regresar</a></td>
        </tr>

        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">&nbsp;</td>
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


<script language="javascript">

document.forms.form1.descripcion.focus();

function editar_marca()
{
	if (document.forms.form1.descripcion.value=="")
	{ 
	 document.forms.form1.descripcion.focus();
	 alert("Ingrese Nombre de la Marca");
	 return false; 
	}

  	document.forms.form1.action='marca_editar.php';
   	document.forms.form1.method='post';
	document.forms.form1.id.value='1'	
   	document.forms.form1.submit();
	
}



</script>


<?php $marca->_util->_cn->desconectar();  ?>