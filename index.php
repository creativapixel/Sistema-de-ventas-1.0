<?php  
session_start();
require_once("clases/usuario_data.php");
$usuario = new Usuario;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema de Ventas</title>


<link href="estilos/css_sistema.css" rel="stylesheet" type="text/css">
<link href="imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">


</head>

<?php
if ($_REQUEST['id']==='1')
{
	$usuario->usuario_validar($_REQUEST['usuario'],$_REQUEST['clave'],$_REQUEST['area']);
}
?>

<body ><div align="center">
  <p>&nbsp;</p>
<img name="logo_mediconsult" src="imagenes/logo_mediconsult.png" width="250" height="41" border="0" alt=""></div>
<table width="384" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
  <tr>
    <td width="380" background="imagenes/fondologin.jpg">
      <form name="form1">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td colspan="4" align="center" background="imagenes/lin_menu.jpg" class="textoblanco">Logearse</td>
          </tr>
          <tr>
            <td width="116" rowspan="4" align="center"><img src="imagenes/login_llave.png"></td>
            <td align="right">Area
              <input name="id" type="hidden" id="id" /></td>
            <td align="center">:</td>
            <td><?php $usuario->generar_select_area('area','',''); ?></td>
          </tr>
          <tr>
            <td width="67" align="right">Usuario</td>
            <td width="10" align="center">:</td>
            <td width="171"><input name="usuario" type="text" id="usuario" onkeyup="fn(this.form,this)" value="<?php echo $_REQUEST['usuario'];?>" /></td>
          </tr>
          <tr>
            <td align="right">Contrase&ntilde;a</td>
            <td align="center">:</td>
            <td><input name="clave" type="password" id="clave" onkeyup="fn(this.form,this)" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="Submit" type="button" class="btn"  onclick="logearse();" value="Ingresar" onkeyup='fn(this.form,this)'/></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<script src="javascript/valida.js">  </script>
<script language="javascript">

function  logearse()
{
document.forms.form1.id.value='1';
document.forms.form1.action='index.php';
document.forms.form1.method='POST';
document.forms.form1.submit();

}

</script>
