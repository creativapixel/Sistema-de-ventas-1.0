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
<script language="Javascript" src="../javascript/PopCalendar.js"></script>
</head>

<body>
<script language="JavaScript">
	PopCalendar = getCalendarInstance();
	PopCalendar.initCalendar();
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
	
	if (!isset($_REQUEST['fecha']))
	{
		$_REQUEST['fecha']=date('d/m/y');
	}
	
	if($_REQUEST['id']==='1')
	{
	  
	  	$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
		$nombre_archivo = ereg_replace(" ", "", $nombre_archivo); 
		if (empty($HTTP_POST_FILES['userfile']['tmp_name']))
		{
			$ruta="";
		}
		else
		{
			$ruta='fotospacientes/'.$_REQUEST['historia'].'_'.$nombre_archivo;//ruta completa		
		}		
		
		$rs=$paciente->paciente_nuevo($_REQUEST['fecha'],$_REQUEST['historia'],$_REQUEST['nombres'],$_REQUEST['apellidos'],$_REQUEST['fecha2'],$_REQUEST['estadocivil'],$_REQUEST['sexo'],$_REQUEST['departamento'],$_REQUEST['provincia'],$_REQUEST['direccion'],$_REQUEST['ocupacion'],$_REQUEST['telefono'],$_REQUEST['celular'],$_REQUEST['email'],$ruta,'0');
		
	if($rs)
  	{
			if (!empty($HTTP_POST_FILES['userfile']['tmp_name']))
			{
    			if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'],'../'.$ruta))
				{ 
				 echo "<center><h5>Se ha cargado con exito la foto.</h5></center>";  
	      		}
	  		}
			else
			{
     	  	echo "<center><h5>No se ha seleccionado una foto. Puede adjuntarla mas adelnate editando al Paciente.</h5></center>"; // me da este error
       		} 
	}
	else
	{
		 "no entro";
	}		

	}
	
	if (!isset($_REQUEST['historia']))
	{
		$_REQUEST['historia']=$paciente->devuelve_nrohistoria();


	}
	
	if (!isset($_REQUEST['departamento']))
	{
		$_REQUEST['departamento']='2';
		$_REQUEST['provincia']='2';

	}	
	?>

	
	<form enctype="multipart/form-data" name="form1"  id="form1">
	  <table width="460" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3"><h5>AGREGAR NUEVO PACIENTE </h5></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="enfasis">
			<input name="pagina" type="hidden" id="pagina">
			<input name="id" type="hidden" id="id">
			<input name="marca_codigo" type="hidden" id="marca_codigo"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Fecha de registro </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="fecha" type="text" id="fecha" value="<?php echo $_REQUEST['fecha']; ?>" size="10"  onkeyup='fn(this.form,this)'/>
        <a style='cursor:hand;' onclick='document.form1.fecha.oldValue=document.form1.fecha.value;PopCalendar.selectWeekendHoliday(1,1);PopCalendar.show(document.form1.fecha, &quot;dd/mm/yyyy&quot;, null, &quot;&quot;, &quot;&quot;);'><img src="imagen/calendar.gif" width="23" height="21" /></a></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Nro. de Historia </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="historia" type="text" id="historia" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['historia']?>"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis"> Nombres</td>
            <td width="15" align="center" valign="top" class="enfasis">:</td>
            <td width="301" align="left" valign="top" class="enfasis"><input name="nombres" type="text" id="nombres"   onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['nombres']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Apellidos</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="apellidos" type="text" id="apellidos" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['apellidos']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Fecha de Nacimiento </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="fecha2" type="text" id="fecha2" value="<?php echo $_REQUEST['fecha2']; ?>" size="10"  onkeyup='fn(this.form,this)'/>
        <a style='cursor:hand;' onclick='document.form1.fecha2.oldValue=document.form1.fecha2.value;PopCalendar.selectWeekendHoliday(1,1);PopCalendar.show(document.form1.fecha2, &quot;dd/mm/yyyy&quot;, null, &quot;&quot;, &quot;&quot;);'><img src="imagen/calendar.gif" width="23" height="21" /></a></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Estado Civil </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><select name="estadocivil" id="estadocivil"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['estadocivil']==='1'){ echo "Selected";} ?>>SOLTERO</option>
              <option value="2" <?php if ($_REQUEST['estadocivil']==='2'){ echo "Selected";} ?>>CASADO</option>
              <option value="3" <?php if ($_REQUEST['estadocivil']==='3'){ echo "Selected";} ?>>DIVORCIADO</option>
              <option value="4" <?php if ($_REQUEST['estadocivil']==='4'){ echo "Selected";} ?>>VIUDO</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Sexo</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><select name="sexo" id="sexo"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['sexo']==='1'){ echo "Selected";} ?>>F</option>
              <option value="2" <?php if ($_REQUEST['sexo']==='2'){ echo "Selected";} ?>>M</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Departamento</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top"><span class="enfasis"><?php  	$paciente->generar_select_departamento('departamento','ver_datos()',''); ?> 
            </span><a href="nuevodepartamento.php" target="v" onclick="window.open(this.href, this.target, 'width=500,height=100'); return false">Agregar Departamento</a> </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Ciudad</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top"><span class="enfasis"><?php  $paciente->generar_select_provincia('provincia','',$_REQUEST['departamento']);  ?> 
            </span>
			<a href="nuevaprovincia.php?departamento=<?php echo $_REQUEST['departamento']?>" target="v" onclick="window.open(this.href, this.target, 'width=500,height=140'); return false">
			Agregar Ciudad 
			</a></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Direcci&oacute;n</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="direccion" type="text" id="direccion" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['direccion']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Ocupaci&oacute;n</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="ocupacion" type="text" id="ocupacion" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['ocupacion']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Tel&eacute;fono</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="telefono" type="text" id="telefono" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['telefono']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Celular</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="celular" type="text" id="celular" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['celular']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">E-mail</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="email" type="text" id="email" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['email']?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Foto</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="userfile" type="file" id="userfile" size="40" onkeyup='fn(this.form,this)'></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td width="136" align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Paciente"></td>
            <td colspan="2" align="center"> <a href="pacientes_listado.php">REGRESAR A LA LISTA DE PACIENTES </a></td>
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

	if (document.forms.form1.fecha.value=="")
	{ 
		document.forms.form1.fecha.focus();
		alert("Ingresar la fecha de consulta");
		return false; 
	}
	
	if (document.forms.form1.historia.value=="")
	{ 
		document.forms.form1.historia.focus();
		alert("Ingrese el Nro. de Historia del Paciente");
		return false; 
	}

	if (!Esnum(document.forms.form1.historia.value))
	{
		document.forms.form1.historia.focus();
	 	alert("Ingrese un valor numerico para la Historia del Paciente");
	 	return false;
	}	

	if (document.forms.form1.nombres.value=="")
	{ 
		document.forms.form1.nombres.focus();
		alert("Ingresar los Nombres del Paciente");
		return false; 
	}
	
	if (document.forms.form1.apellidos.value=="")
	{ 
		document.forms.form1.apellidos.focus();
		alert("Ingresar los Apellidos del Paciente");
		return false; 
	}	


document.forms.form1.action='pacientes.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}


function ver_datos()
{
   document.forms.form1.action='pacientes.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}




</script>

