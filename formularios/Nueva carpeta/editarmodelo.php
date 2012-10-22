<?php 
session_start();
require_once('../clases/producto_data.php');
$producto = new  productodata();
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


if (isset($_REQUEST['mod_id']))
	{ 	
		$_SESSION['modelo_codigo']=$_REQUEST['mod_id'];		
		
 	}

if ($_REQUEST['id']==='1')
 	{
		$producto->modelo_editar($_SESSION['modelo_codigo'],$_REQUEST['marca'],$_REQUEST['descripcion']);
    }

$producto->modelo_ver($_SESSION['modelo_codigo']);


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

	
	<form id="form1" name="form1" method="post" action="">
      <fieldset class="anchoframe">
      <legend>EDITAR MODELO</legend>
	  <table width="488" border="0" align="center" cellpadding="0" cellspacing="2">
		
        <tr align="left">
          <td >Marca</td>
          <td >:</td>
          <td>			<?php  
		  
		  if (isset($_REQUEST['marca_id']))
		   	{
					$_REQUEST['marca']=$_REQUEST['marca_id'];
    		}
		  
		  	//$producto->marca_listar('1');
					$producto->generar_select_marca('marca','',''); ?></td>
        </tr>
        <tr align="left">
          <td width="73" >Descripcion</td>
          <td width="22" >:</td>
          <td width="246"><input name="descripcion" type="text" id="descripcion" value="<?php  echo $producto->mod_descripcion; ?>" size="40" />
            <input name="id" type="hidden" id="id" /></td>
        </tr>
        <tr align="left">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>

        <tr>
          <td align="center"><a href="../administrador/modelos.php">Regresar</a></td>
          <td align="center">&nbsp;</td>
          <td align="center"><input  name="Submit3"  type="button" class="btn" onclick="editar();" value="EDITAR" />		  </td>
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


 
<script src="../javascript/valida.js" language="javascript"></script>
<script language="javascript">
function editar()
{
	if (document.forms.form1.descripcion.value=="")
	{ 
	 document.forms.form1.descripcion.focus();
	 alert("Ingrese Nombre de la Marca");
	 return false; 
	}

	document.forms.form1.id.value='1'
  	document.forms.form1.action='editarmodelo.php';
   	document.forms.form1.method='post';
   	document.forms.form1.submit();
	
}



</script>


<?php  $producto->con->cerrar();  ?>