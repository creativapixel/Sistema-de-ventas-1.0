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
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>

<body>
<script language="Javascript" src="../javascript/PopCalendar.js">
</script>
  
<script language="JavaScript">
	PopCalendar = getCalendarInstance();
	PopCalendar.initCalendar();
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23">
      <?php  include("menu.php");?>
<br></td>
  </tr>
  <tr>
    <td height="23" align="center"><?php 	

if ($_REQUEST['id']==='1')
{ 

$codigo=$usuario->usuario_nuevo($_REQUEST['tipouser'],$_REQUEST['nombres'],$_REQUEST['apellidos'],$_REQUEST['direccion'],$_REQUEST['telefono'],$_REQUEST['clave'],'0',$_REQUEST['usuario']);
}

if(!$codigo){ ?></td>
  </tr>
  <tr>
    <td height="23" align="center"><form name="form1" >
      
      <table width="507" border="0" align="center" cellpadding="1" cellspacing="0">
        <tr align="center">
          <td colspan="6" class="titulo" >REGISTRAR NUEVO USUARIO</td>
          </tr>
        <tr>
          <td align="right" class="enfasis">&nbsp;</td>
          <td align="center" class="enfasis">&nbsp;</td>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td width="139" align="right" class="enfasis">Tipo de Usuario 
            <input name="id" type="hidden" id="id3" /></td>
          <td width="13" align="center" class="enfasis">:</td>
          <td width="349" colspan="4" align="left"><select name="tipouser" id="tipouser">
            <option value="1" <?php if ($_REQUEST['tipouser']==='1'){ echo "Selected";} ?>>ADMINISTRADOR</option>
            <option value="2" <?php if ($_REQUEST['tipouser']==='2'){ echo "Selected";} ?>>USUARIO DE APOYO</option>
            </select></td>
          </tr>
        
        
        <tr>
          <td align="right" class="enfasis">Nombres</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><label>
            <input name="nombres" type="text" id="nombres" size="40"  value="<?php  echo $_REQUEST['nombres']; ?>"/>
  </label></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Apellidos</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="apellidos" type="text" id="apellidos" size="40"  value="<?php echo $_REQUEST['apellidos']; ?>"/></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Direcci&oacute;n</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="direccion" type="text" id="direccion2" size="40" value="<?php echo $_REQUEST['direccion']; ?>" /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Tel&eacute;fono/Mov&iacute;l</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="telefono" type="text" id="telefono" size="30" value="<?php echo $_REQUEST['telefono']; ?>" /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Usuario</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="usuario" type="text" id="usuario" size="35" value="<?php echo $_REQUEST['usuario']; ?>" /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Contrase&ntilde;a</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="clave" type="password" id="clave" size="20" maxlength="20" /></td>
          </tr>
        <tr>
          <td align="right" class="enfasis">Confirmar Contrase&ntilde;a</td>
          <td align="center" class="enfasis">:</td>
          <td colspan="4" align="left"><input name="clave2" type="password" id="clave2" size="20" maxlength="20" /></td>
          </tr>
        <tr>
          <td align="right"><a href="usuarios_listado.php">REGRESAR</a></td>
          <td align="left" class="enfasis">&nbsp;</td>
          <td colspan="4" align="left"><input name="registrar" type="button" class="btn"  onClick="registrar_usuario();" value="Registrar" /></td>
          </tr>
        <tr>
          <td align="left" class="enfasis">&nbsp;</td>
          <td align="left" class="enfasis">&nbsp;</td>
          <td colspan="4" align="left">&nbsp;</td>
          </tr>
        </table>	  
      
      <p><a href="../administrador/listado_usuarios.php"></a>	      </p>
	</form>
	
	<?php }?>	</td>
  </tr>
</table>
<script src="../javascript/valida.js">  </script>
<script language="javascript">

function registrar_usuario()
{



	
	if (document.forms.form1.nombres.value=="")
	{ 
	 document.forms.form1.nombres.focus();
	 alert("Ingresar Nombres");
	 return false; 
	}

	if (document.forms.form1.apellidos.value=="")
	{ 
	 document.forms.form1.apellidos.focus();
	 alert("Ingresar Apellidos");
	 return false; 
	}
	

  	if (document.forms.form1.clave.value=="")
	{ 
	 document.forms.form1.clave.focus();
	 alert("Clave en blanco");
	 return false; 
	}
		
	if (document.forms.form1.clave.value!= document.forms.form1.clave2.value)
	{
     document.forms.form1.clave.focus();
	 alert("Claves no coinciden");
	 return false;

     }
	 

	
document.forms.form1.id.value='1';
document.forms.form1.action='usuario.php';
document.forms.form1.method='post';
document.forms.form1.submit();


}

function ver_estado()
{
   document.forms.form1.action='usuario.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}
</script>
</body>
</html>
<?php $usuario->_util->_cn->desconectar();  
?>
