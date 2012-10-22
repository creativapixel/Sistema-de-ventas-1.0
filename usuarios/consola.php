<?php   session_start();
		require_once('../clases/session_data.php');
		$session= new sessiondata();
		
	
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td>user </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="23"><form name= "form" action="busqueda_pedidos.php">
  <table width="799">
  <tr> 
    <td align="center">&nbsp;</td>
  </tr>
  </table>
 </form>
	
	
	</td>
  </tr>
</table>

<p>&nbsp;</p>
	</body>
</html>
<?php $session->usuario->con->cerrar();?>