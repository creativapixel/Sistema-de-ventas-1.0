<?php session_start();
  	
require_once('../clases/paciente_data.php');
$paciente = new Paciente;

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}


 ?> 	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NUEVO SEGURO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>
<?php

		if($_REQUEST['id']==='1')
		{
	  
			$rs=$paciente->seguro_nuevo($_REQUEST['seguro'],'0');
			if ($rs)
			{

			if (!isset($_REQUEST['valor']))
			{
				echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'paciente_nuevo.php?seguro=".$_SESSION['seguro_id']."&tipo=".$_REQUEST['tipo']."&departamento=".$_REQUEST['departamento']."&provincia=".$_REQUEST['provincia']."&historia=".$_REQUEST['historia']."&fecha=".$_REQUEST['fecha']."&historia=".$_REQUEST['historia']."&nombres=".$_REQUEST['nombres']."&apellidos=".$_REQUEST['apellidos']."&fecha2=".$_REQUEST['fecha2']."&estadocivil=".$_REQUEST['estadocivil']."&sexo=".$_REQUEST['sexo']."&direccion=".$_REQUEST['direccion']."&ocupacion=".$_REQUEST['ocupacion']."&email=".$_REQUEST['email']."&telefono=".$_REQUEST['telefono']."&celular=".$_REQUEST['celular']."';
window.close();  </script>";	
			}
			else
			{			
				echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'paciente_editar.php?seguro=".$_SESSION['seguro_id']."';
window.close();  </script>";			
			}
			
			}
		}

  ?>
<body onload="centrar_pagina()">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;
    </td>
  </tr>
  <tr>
    <td align="center">


	
	<form name="form1"  id="form1">
	  <table width="356" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3" align="center">
              <input name="id" type="hidden" id="id">
			  <input name="departamento_codigo" type="hidden" id="departamento_codigo">
            <?php 
			if (isset($_REQUEST['valor']))
			{?>
			<input name="valor" type="hidden" value="1">
			<?php
			}
			?>		    </td>
          </tr>
          
          <tr>
            <td width="51" align="left" valign="top" class="enfasis">Seguro</td>
            <td width="9" align="center" valign="top" class="enfasis">:</td>
            <td width="288" align="center" valign="top" class="enfasis"><input name="seguro" type="text" id="seguro" size="40"  onkeyup='fn(this.form,this)' ></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="enfasis"><input name="pagina" type="hidden" id="pagina">
            <input name="fecha" type="hidden" id="fecha" value="<?php echo $_REQUEST['fecha']?>">
            <input name="historia" type="hidden" id="historia" value="<?php echo $_REQUEST['historia']?>">
            <input name="nombres" type="hidden" id="nombres" value="<?php echo $_REQUEST['nombres']?>">
            <input name="apellidos" type="hidden" id="apellidos" value="<?php echo $_REQUEST['apellidos']?>">
            <input name="fecha2" type="hidden" id="fecha2" value="<?php echo $_REQUEST['fecha2']?>">
            <input name="estadocivil" type="hidden" id="estadocivil" value="<?php echo $_REQUEST['estadocivil']?>">
            <input name="sexo" type="hidden" id="sexo" value="<?php echo $_REQUEST['sexo']?>">
            <input name="direccion" type="hidden" id="direccion" value="<?php echo $_REQUEST['direccion']?>">
            <input name="ocupacion" type="hidden" id="ocupacion" value="<?php echo $_REQUEST['ocupacion']?>">
            <input name="telefono" type="hidden" id="telefono" value="<?php echo $_REQUEST['telefono']?>">
            <input name="celular" type="hidden" id="celular" value="<?php echo $_REQUEST['celular']?>">
            <input name="email" type="hidden" id="email" value="<?php echo $_REQUEST['email']?>">
            <input name="provincia" type="hidden" id="provincia" value="<?php echo $_REQUEST['provincia']?>">
            <input name="tipo" type="hidden" id="tipo" value="<?php echo $_REQUEST['tipo']?>"></td>
          </tr>
          <tr>
            <td colspan="3" align="center">
			
			<input name="enviar" type="button" class="btn" onClick="nuevo();" value="Grabar Seguro">
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


function nuevo()
{

	if (document.forms.form1.seguro.value=="")
	{ 
		document.forms.form1.seguro.focus();
		alert("Ingresar Seguro");
		return false; 
	}

document.forms.form1.action='seguro_nuevo.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1';
document.forms.form1.submit();
}


</script>

