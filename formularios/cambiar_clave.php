<?php session_start();
 require_once('../clases/usuario_data.php');
$usuario = new Usuario;
 if(!isset($_SESSION['sesion_id_usuario']))
 	{
	die("No tiene acceso  a esta seccion");
 	} 


 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NUEVA CLAVE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23">
    	<?php include('menu.php');?>  
	</td>
  
  <tr>
    <td height="23" align="left">

	<form name="form1">
 
	  <table border="0" align="center" cellpadding="1" cellspacing="0">
        <tr>
          <td colspan="3" align="center" class="texto">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><?php 	

if (isset($_REQUEST['usu_codigo']))
{
	$_SESSION['usuario_id']=$_REQUEST['usu_codigo']; 
}
	if ($_REQUEST['id']==='1')
 		{

 	$usuario->usuario_cambiarclave($_REQUEST['clavea'],$_REQUEST['clave'],$_SESSION['usuario_id']);


        }

	 ?>
	        <input name="id" type="hidden" id="id">
	        </td>
        </tr>
        <tr>
          <td width="197" align="right" class="enfasis">Nombres y Apellidos </td>
          <td width="25" align="center" class="enfasis">:</td>
          <td width="332" align="left">
		  <?php 
		  $usuario->usuario_ver($_SESSION['usuario_id']); 
		  echo $usuario->usu_nombres.' '.$usuario->usu_apellidos;;
		  ?>
        </tr>
        <tr>
          <td align="right" class="enfasis">Clave anterior </td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><input name="clavea" type="password" id="clavea"></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Nueva clave </td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><input name="clave" type="password" id="clave" value=""></td>
        </tr>
        <tr>
          <td align="right" class="enfasis">Vuelva a escribir la nueva clave </td>
          <td align="center" class="enfasis">:</td>
          <td align="left"><input name="clave1" type="password" id="clave1"></td>
        </tr>
        
        <tr>
          <td align="right"><a href="usuarios_listado.php">REGRESAR</a></td>
          <td align="left">&nbsp;</td>
          <td align="left"><input name="registrar" type="button" class="btn"  onclick="editar();" value="Cambiar clave" /></td>
        </tr>
      </table>
	  
	</form>
	
	
	</td>
  </tr>
</table>
<script language="javascript">

function editar()
{

		if (document.forms.form1.clavea.value=="")
 		{
 			document.forms.form1.clavea.focus();
	 		alert("Ingrese clave anterior");
	 		return false; 
 
 		}
 
		if (document.forms.form1.clave.value=="")
 		{
 		document.forms.form1.clave.focus();
	 	alert("Ingrese clave nueva");
	 	return false; 
 		} 
 
  		if (document.forms.form1.clave1.value=="")
 		{
 		document.forms.form1.clave1.focus();
	 	alert("Ingrese otra vez la clave nueva");
	 	return false; 
		}
 
 		if (document.forms.form1.clave.value!=document.forms.form1.clave1.value)
 		{  
		document.forms.form1.clave.focus();
		alert("Claves nuevas no coinciden");
		return false; 
 		}
 
 document.forms.form1.id.value='1';
 document.forms.form1.action="cambiar_clave.php";
 document.forms.form1.method='post';
 document.forms.form1.submit();
		
}


</script>
</body>
</html>
<?php  $usuario->_util->_cn->desconectar(); ?>
