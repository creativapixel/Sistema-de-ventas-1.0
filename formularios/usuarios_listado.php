<?php session_start();
require_once('../clases/usuario_data.php');
$usuario = new Usuario;

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
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>
<?php 

		if ($_REQUEST['id']==='2')
		{
			$usuario->usuario_borrar($_REQUEST['usuario_codigo']);
		}		
		
?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td><form  id="form1" name="form1">
      <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td width="31">&nbsp;</td>
          <td width="238">&nbsp;</td>
          <td width="229" colspan="-2">&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="3"><span class="titulo">LISTADO DE USUARIOS
            </span>            <input name="id" type="hidden" id="id" />
            <input type="hidden" name="usuario_codigo" id="usuario_codigo" /></td>
        </tr>
        <tr>
          <td colspan="3"><table width="800" border="0">
            <tr>
              <td colspan="6" align="right"><input name="Submit" type="button" class="btn" onclick="nuevo();" value="Nuevo Usuario" /></td>
              </tr>
            <tr class="fondonegro">
              <td width="16%" align="center"><span class="fondonegro">Usuario</span></td>
              <td width="42%" align="center"><span class="fondonegro">Nombres y Apellidos</span></td>
              <td width="26%" align="center">Tipo de Usuario </td>
              <td colspan="3" align="center"><span class="fondonegro">Opci&oacute;n</span></td>
              </tr>
            <?php  
			  //metodo para el paginado de productos por  subcategorias
			  //if ($_REQUEST['id']==='2')
			  if (isset($_REQUEST['usu_codigo']))
				{
			  $usuario->usuario_borrar($_REQUEST['usu_codigo']);
			  }
			 $rs= $usuario->usuario_listar('');
			 if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
            <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
              <td align="center"><?php echo $campo['usu_usuario']; ?></td>
              <td align="center"><?php echo $campo['nombres']; ?></td>
              <td align="center"><?php  if($campo['usu_tipo']=='1')  echo "ADMINISTRADOR"; else echo "USUARIO DE APOYO"; ?></td>
              <td width="5%" align="center"><a href="cambiar_clave.php?usu_codigo=<?php echo $campo['usu_id'];?>"><img src="../imagenes/clave.png" alt="Cambiar Clave" width="17" height="19" border="0" /></a></td>
              <td width="7%" align="center" valign="top"><a href="permisos_asignar.php?usu_codigo=<?php echo $campo['usu_id']?>"><img src="../imagenes/permisos.png" alt="Asignar Permisos" width="21" height="20" border="0" /></a></td>
              <td width="4%" align="center"><a href="#" onclick="borrar(<?php echo $campo['usu_id']?>)"><img src="../imagenes/icono_eliminar.gif" alt="Eliminar Registro" width="14" height="14" border="0" /></a></td>
              </tr>
            <?php 
			  $j=$j+1;
			  } 
			  } ?>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php $usuario->_util->_cn->desconectar();?>

<script language="javascript">

function nuevo()
{


   document.forms.form1.action='usuario.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}

function   borrar(usuario_codigo)
{
	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
		document.forms.form1.id.value='2';
		document.forms.form1.usuario_codigo.value=usuario_codigo;
		document.forms.form1.action='usuarios_listado.php';
		document.forms.form1.method='post';
		document.forms.form1.submit();
	}
	else
	{
	return false; 
	}
		
}

</script>