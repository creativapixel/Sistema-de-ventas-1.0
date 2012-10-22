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
<title>NUEVO USUARIO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23">
      <?php  include("menu.php");?>
<br></td>
  </tr>
  <tr>
    <td height="23" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" align="center">
<?php 	
	
	$usuario->usuario_ver($_REQUEST['usu_codigo']);
  
	if($_REQUEST['id']==='1')
	{
		$permiso->asignar_permisos($_REQUEST['usu_codigo'],$_REQUEST['permiso']);
	}
    
	if($_REQUEST['id']==='2')
	{
   		$permiso->eliminar_permiso($_REQUEST['usu_codigo'],$_REQUEST['per_codigo']);
    }
   
   
   
    ?>
 	
	<form name="form1" >

      <table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
        <tr>
          <td colspan="3" align="center" class="titulo">ASIGNAR PERMISOS A USUARIO</td>
        </tr>
        <tr>
          <td colspan="3" align="left" class="texto">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="top" class="enfasis">Nombres y Apellidos</td>
          <td width="18" align="center" valign="top" class="enfasis">:</td>
          <td width="268" align="left" valign="top"><?php   echo $usuario->usu_nombres.' '.$usuario->usu_apellidos;?><input name="id" type="hidden" id="id" />
            <input name="usu_codigo" type="hidden" id="usu_codigo" value="<?php echo $_REQUEST['usu_codigo'];  ?>"></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="enfasis">Usuario</td>
          <td align="center" valign="top" class="enfasis">:</td>
          <td align="left" valign="top"><?php   echo $usuario->usu_usuario;  ?></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="enfasis">Permisos</td>
          <td align="center" valign="top" class="enfasis">:</td>
          <td align="left" valign="top"><?php 
		 
		   $permiso->generar_select_permiso('permiso','',''); ?>
&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><a href="usuarios_listado.php">REGRESAR</a></td>
          <td align="left" class="enfasis">&nbsp;</td>
          <td align="left">
            <input name="registrar" type="button" class="btn"  onClick="asignar_perfil();" value="Asignar Permiso" />
          </td>
        </tr>
        </table>

	  <br>
	  <table width="330">
	    <tr align="center">
	      <td width="207" class="fondonegro"><strong>Permiso</strong></td>
	      <td class="fondonegro"><strong>Opcion</strong></td>
	      </tr>
	  <?php 
	  $rs2= $permiso->listar_permisos('1');
	  while ( $campo2=mysql_fetch_array($rs2))
	  {?>
	    <tr align="center" bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
	      <td><?php  echo $campo2['per_descripcion'];  ?></td>
	      <td><a href="permisos_asignar.php?per_codigo=<?php  echo $campo2['per_id']; ?>&usu_codigo=<?php echo $campo2['usu_id']; ?>&id=2" ><img src="../imagenes/icono_eliminar.gif" alt="Eliminar Registro" width="14" height="14" border="0"></a></td>
	    </tr>
	<?php  }?>	
</table>
	  </form>
		</td>
  </tr>
</table>
<script language="javascript">



 function asignar_perfil()
 {
document.forms.form1.id.value='1';
document.forms.form1.action='permisos_asignar.php';
document.forms.form1.method='post';
document.forms.form1.submit();
 
 
 }


</script>
</body>
<?php $usuario->_util->_cn->desconectar();?>
</html>
