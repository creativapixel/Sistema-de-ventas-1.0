<?php session_start();
  require_once('../clases/paciente_data.php');
$paciente = new  pacientedata();

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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
		if($_REQUEST['id']==='1')
		{
	  
$rs=$paciente->provincia_nuevo($_REQUEST['departamento'],$_REQUEST['provincia'],'0');
			if ($rs)
			{
			echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'pacientes.php?departamento=".$_REQUEST['departamento']."&provincia=".$_SESSION['provincia_id']."';
window.close();  </script>";	
			}
		}

		  
		  ?>

	
	<form name="form1"  id="form1">
        <table width="469" border="0" align="center" cellpadding="0">
          <tr>
            <td width="74" align="left" class="enfasis">Departamento</td>
            <td width="18" align="left" class="enfasis" >:</td>
            <td width="172" align="left">

			<?php echo strtoupper($paciente->devuelve_departamento($_REQUEST['departamento']));?>			
			<input name="pagina" type="hidden" id="pagina">
			<input name="id" type="hidden" id="id">
			<input name="provincia_codigo" type="hidden" id="provincia_codigo">
			<input name="departamento" type="hidden" id="departamento" value="<?php echo $_REQUEST['departamento']?>"></td>
			
            <td width="195" colspan="-2">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Ciudad</td>
            <td align="left" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left"><input name="provincia" type="text" id="provincia" size="55"  onkeyup="fn(this.form,this)"></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Ciudad">              
            &nbsp;
            <input name="cerrar" type="button" class="btn" onClick="window.close();" value="Cerrar Ventana"></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">


function nuevo()
{

if (document.forms.form1.provincia.value=="")
{ 
document.forms.form1.provincia.focus();
alert("Ingresar Provincia");
return false; 
}

document.forms.form1.action='nuevaprovincia.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}






</script>

