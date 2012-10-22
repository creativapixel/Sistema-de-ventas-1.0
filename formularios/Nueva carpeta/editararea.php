<?php session_start();
require_once('../clases/usuario_data.php');

$area= new usuariodata();
 if(!isset($_SESSION['sesion_id_usuario']))
 	{
	die("No tiene acceso  a esta seccion");
 	} 

	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

if (isset($_REQUEST['area_id']))
	{ 	
		$_SESSION['area_codigo']=$_REQUEST['area_id'];
		
		$area->area_ver($_SESSION['area_codigo']);
		
		$_REQUEST['descripcion']=$area->area_descripcion;

 	}

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
    <td align="center">
	
<?php 	

	if ($_REQUEST['id']==='1')
 	{
		$area->area_editar($_SESSION['area_codigo'],$_REQUEST['descripcion'],'0');
    }
	
?>
	
	<form id="form1" name="form1" ENCTYPE="multipart/form-data" >
      <fieldset class="anchoframe">
      <legend>EDITAR CATEGORÍA</legend>
	  <table width="347" border="0" align="center" cellpadding="0" cellspacing="2">
 
        <tr align="left">
          <td width="87" height="33">Descripci&oacute;n:</td>
          <td width="298"><input name="descripcion" type="text" id="descripcion" value="<?php echo $_REQUEST['descripcion']; ?>" size="40" />
            <input name="id" type="hidden" id="id" /></td>
          </tr>

        <tr>
          <td align="center"><a href="areas.php">Regresar</a></td>
          <td align="center"><input  name="Submit3"  type="button" class="btn" onclick="editar();" value="EDITAR" /></td>
          </tr>
      </table>
    </fieldset></form>    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>

<script language="javascript">

function editar()
{ 
	document.forms.form1.id.value='1'; 
   document.forms.form1.action='editararea.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}


</script>

<?php  $area->con->cerrar(); 

?>
