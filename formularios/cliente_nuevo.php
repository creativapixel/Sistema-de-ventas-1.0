<?php session_start();
  	
require_once('../clases/cliente_data.php');
$cliente = new Cliente;

if(!isset($_SESSION['sesion_id_usuario']))
{
	die("No tiene acceso  a esta seccion");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NUEVO DEPARTAMENTO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>

<body>
<?php
if($_REQUEST['id']=='1')
{
	  
	$rs = $cliente->cliente_nuevo($_REQUEST['razonsocial'],$_REQUEST['direccion'],$_REQUEST['ruc']);
	if ($rs)
	{
		echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'pedido_nuevo.php?cliente=".$_SESSION['cliente_id']."';
		window.close();</script>";	
	}
}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;
    </td>
  </tr>
  <tr>
    <td align="center">


	
	<form name="form1"  id="form1">
	  <table width="454" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3" align="center"><h5>
              <input name="id" type="hidden" id="id">
              NUEVO CLIENTE
            </h5>		    </td>
          </tr>
          
          <tr>
            <td width="125" align="left" valign="top" class="enfasis">Raz&oacute;n Social / Nombre </td>
            <td width="15" align="center" valign="top" class="enfasis">:</td>
            <td width="306" align="left" valign="top" class="enfasis"><input name="razonsocial" type="text" id="razonsocial" size="40" onkeyup='fn(this.form,this)' ></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">RUC</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="ruc" type="text" id="ruc" onkeyup='fn(this.form,this)' ></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Direcci&oacute;n</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="direccion" type="text" id="direccion" size="40" onkeyup='fn(this.form,this)' ></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center">
			
			<input name="enviar" type="button" class="btn" onClick="nuevo();" value="Grabar Cliente">
			&nbsp;&nbsp;
			<label>
              <input name="cerrar" type="button" class="btn" onClick="window.close();" value="Cerrar Ventana">
            </label>			</td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">

document.forms.form1.razonsocial.focus();

function nuevo()
{

	if (document.forms.form1.razonsocial.value=="")
	{ 
		document.forms.form1.razonsocial.focus();
		alert("Ingresar Razon Social/Nombre");
		return false; 
	}

document.forms.form1.action='cliente_nuevo.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1';
document.forms.form1.submit();
}

</script>

