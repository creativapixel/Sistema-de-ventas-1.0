<?php session_start();
  	
require_once('../clases/paciente_data.php');
$paciente = new Paciente;

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}

	if ($_REQUEST['tipo']==='0' and $_REQUEST['id']!='1')
	{
		$_REQUEST['historia']='';

	}

	if ($_REQUEST['tipo']==='1' and $_REQUEST['id']!='1')
	{
		$_REQUEST['historia']=$paciente->devuelve_nrohistoria();
		$_SESSION['particular']=$_REQUEST['historia'];

	}
	
	
	if (($_REQUEST['tipo']==='2' && $_SESSION['particular']!="") and $_REQUEST['id']!='1')
	{
		$_REQUEST['historia']='';
		$_SESSION['particular']="";

	}	




	
	if (!isset($_REQUEST['departamento']) and $_REQUEST['id']!='1')
	{
		$_REQUEST['departamento']='2';
		$_REQUEST['provincia']='2';

	}	
 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NUEVO PACIENTE</title>


<div ID="waitDiv" style="position:absolute;left:300;top:300;visibility:hidden"> 
<table  border="0" align="center"> 
<tr><td > 
<img src="../imagenes/loading9.gif" border="0"> 
</td> 
</tr></table> 
</div> 
<SCRIPT> 
<!-- 
var DHTML = (document.getElementById || document.all || document.layers); 
function ap_getObj(name) { 
if (document.getElementById) 
{ return document.getElementById(name).style; } 
else if (document.all) 
{ return document.all[name].style; } 
else if (document.layers) 
{ return document.layers[name]; } 
} 
function ap_showWaitMessage(div,flag) { 
if (!DHTML) return; 
var x = ap_getObj(div); x.visibility = (flag) ? 'visible':'hidden' 
if(! document.getElementById) if(document.layers) x.left=280/2; return true; } ap_showWaitMessage('waitDiv', 3); 
//--> 
</SCRIPT> 



<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
		<!-- jQuery -->
		<script type="text/javascript" src="../librerias/jquery/jquery-1.2.6.pack.js"></script>
        <!-- required plugins -->
		<script type="text/javascript" src="../librerias/date_picker/date.js"></script>

        
        <!-- jquery.datePicker.js -->
		<script type="text/javascript" src="../librerias/date_picker/jquery.datePicker.js"></script>
        
        <!-- datePicker required styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="../librerias/date_picker/datePicker.css">
        
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
           
			  $(function()
			  {
				  $('.date-pick').datePicker({startDate:'01/01/1980'});
			  });
				  
		</script>
</head>

<body onload="centrar_pagina()">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" background="../imagenes/lin_menu.jpg"><h4><span class="textoblanco"><br>
AGREGAR NUEVO PACIENTE </span></h4></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
	
	if ($_REQUEST['id']=='6')
	{
		$paciente->evaluar_nro_historia($_REQUEST['historia'],$_REQUEST['tipo'],$_REQUEST['seguro']);

	}
	
	
	if (!isset($_REQUEST['fecha']))
	{
		$_REQUEST['fecha']=date('d/m/y');
	}
	
	if($_REQUEST['id']==='1')
	{
	  
	  	$nombre_archivo = $_FILES['userfile']['name'];
		$nombre_archivo = ereg_replace(" ", "", $nombre_archivo); 
		
		if (empty($_FILES['userfile']['name']))
		{
			$ruta="";
		}
		else
		{
			$ruta='fotospacientes/'.$_REQUEST['historia'].'_'.$_REQUEST['tipo'].'_'.$nombre_archivo;//ruta completa		
		}
		$rs=$paciente->paciente_nuevo($_REQUEST['fecha'],$_REQUEST['historia'],$_REQUEST['nombres'],$_REQUEST['apellidos'],$_REQUEST['fecha2'],$_REQUEST['estadocivil'],$_REQUEST['sexo'],$_REQUEST['departamento'],$_REQUEST['provincia'],$_REQUEST['direccion'],$_REQUEST['ocupacion'],$_REQUEST['telefono'],$_REQUEST['celular'],$_REQUEST['email'],$ruta,'0',$_REQUEST['tipo'],$_REQUEST['seguro'],$_REQUEST['registro'],$_REQUEST['procedencia']);
		
	if($rs)
  	{
			if (!empty($_FILES['userfile']['name']))
			{
    			if (move_uploaded_file($_FILES['userfile']['tmp_name'],'../fotospacientes/'.$nombre_archivo))
				{ 
				
				rename('../fotospacientes/'.$nombre_archivo,'../fotospacientes/'.$_REQUEST['historia']."_".$_REQUEST['tipo']."_".$nombre_archivo);
				
				
				 echo "<center><h5>Se ha cargado con exito la foto.</h5></center>";  
	      		}
	  		}
			else
			{
     	  	echo "<center><h5>No se ha seleccionado una foto. Puede adjuntarla mas adelante editando al Paciente.</h5></center>"; // me da este error
       		} 
			
			echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'consultas_generar.php?historia=".$_SESSION['historia_id']."';
window.close();  </script>";
	}
	else
	{
		 "no entro";
	}	
		

	}
	

	

	?>

	
	<form enctype="multipart/form-data" name="form1"  id="form1">
	  <table width="520" border="0" align="center" cellpadding="0">

          
          <tr>
            <td colspan="4" align="left" class="enfasis">
			<input name="pagina" type="hidden" id="pagina">
			<input name="id" type="hidden" id="id">
			<input name="marca_codigo" type="hidden" id="marca_codigo"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Tipo de Paciente </td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><select name="tipo" id="tipo" onChange="ver_datos()">
              <option value="0" <?php if($_REQUEST['tipo']==='0'){ echo "selected"; }?>>Seleccione Tipo Paciente</option>
              <option value="1" <?php if($_REQUEST['tipo']==='1'){ echo "selected"; }?>>PARTICULAR</option>
              <option value="2" <?php if($_REQUEST['tipo']==='2'){ echo "selected"; }?>>SEGURO</option>
            </select></td>
          </tr>
		  <?php if ($_REQUEST['tipo']==='2') {  ?>       
          <tr>
            <td align="right" class="enfasis">Seguro</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left"><?php $paciente->generar_select_seguro('seguro','',''); ?>
            <input name="boton_seguro" type="button" class="btn" id="boton_seguro" value="Agregar Seguro" onClick="agregar_seguro()"></td>
          </tr>
		  <?php } ?>
          <tr>
            <td width="140" align="right" class="enfasis">Fecha de registro </td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="fecha" type="text" id="fecha" value="<?php echo $_REQUEST['fecha']; ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick" />              &nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Nro. de Historia </td>
            <td align="center" class="enfasis">:</td>
            <td width="103" align="left" class="enfasis"><input name="historia" type="text" id="historia" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['historia']?>" size="10" onBlur="verifica_historia()"></td>
            <td width="256" align="left" class="enfasis"><?php if ($_REQUEST['tipo']==='2') {  ?>
              <table width="198" border="0">
                <tr>
                  <td width="85">&nbsp;</td>
                  <td width="11">&nbsp;</td>
                  <td width="88"><input name="registro" type="hidden" id="registro" onKeyUp='fn(this.form,this)' value="<?php echo $_REQUEST['registro']?>" size="10"></td>
                </tr>
              </table>
            <?php } ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"> Nombres</td>
            <td width="11" align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="nombres" type="text" id="nombres"   onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['nombres']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Apellidos</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="apellidos" type="text" id="apellidos" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['apellidos']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha de Nacimiento </td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="fecha2" type="text" id="fecha2" value="<?php echo $_REQUEST['fecha2']; ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick" /></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Estado Civil </td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><select name="estadocivil" id="estadocivil"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['estadocivil']==='1'){ echo "Selected";} ?>>SOLTERO</option>
              <option value="2" <?php if ($_REQUEST['estadocivil']==='2'){ echo "Selected";} ?>>CASADO</option>
              <option value="3" <?php if ($_REQUEST['estadocivil']==='3'){ echo "Selected";} ?>>DIVORCIADO</option>
              <option value="4" <?php if ($_REQUEST['estadocivil']==='4'){ echo "Selected";} ?>>VIUDO</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Sexo</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><select name="sexo" id="sexo"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['sexo']==='1'){ echo "Selected";} ?>>F</option>
              <option value="2" <?php if ($_REQUEST['sexo']==='2'){ echo "Selected";} ?>>M</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Departamento</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left"><span class="enfasis"><?php  	$paciente->generar_select_departamento('departamento','ver_datos()',''); ?> 
            </span> <input name="Submit2" type="button" class="btn" value="Agregar Departamento" onClick="ver_departamento()"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Ciudad</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left"><span class="enfasis"><?php  $paciente->generar_select_provincia('provincia','',$_REQUEST['departamento']);  ?> 
            </span>
			<input name="Submit3" type="button" class="btn" value="Agregar Ciudad" onClick="ver_provincia()"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Direcci&oacute;n</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="direccion" type="text" id="direccion" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['direccion']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Procedencia</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="procedencia" type="text" id="procedencia" value="<?php echo $_REQUEST['procedencia']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Ocupaci&oacute;n</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="ocupacion" type="text" id="ocupacion" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['ocupacion']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Tel&eacute;fono</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="telefono" type="text" id="telefono" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['telefono']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Celular</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="celular" type="text" id="celular" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['celular']?>" size="40"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">E-mail</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="email" type="text" id="email" onkeyup='fn(this.form,this)' value="<?php echo $_REQUEST['email']?>" size="40" onBlur="validar_email()"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Foto</td>
            <td align="center" class="enfasis">:</td>
            <td colspan="2" align="left" class="enfasis"><input name="userfile" type="file" id="userfile" size="40" onkeyup='fn(this.form,this)'></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Paciente">
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
	if (document.forms.form1.tipo.value=="0")
	{ 
		document.forms.form1.tipo.focus();
		alert("Seleccione el Tipo de Paciente");
		return false; 
	}

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

	if (document.forms.form1.fecha2.value=="")
	{ 
		document.forms.form1.fecha2.focus();
		alert("Ingrese la Fecha de Nacimiento");
		return false; 
	}	

document.forms.form1.action='paciente_nuevo.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}


function ver_datos()
{
   document.forms.form1.action='paciente_nuevo.php';
   document.forms.form1.method='POST';
   document.forms.form1.submit();
}


function ver_departamento()
{
	window.open("departamento2_nuevo.php?fecha="+document.forms.form1.fecha.value+"&historia="+document.forms.form1.historia.value+"&nombres="+document.forms.form1.nombres.value+"&apellidos="+document.forms.form1.apellidos.value+"&fecha2="+document.forms.form1.fecha2.value+"&estadocivil="+document.forms.form1.estadocivil.value+"&sexo="+document.forms.form1.sexo.value+"&direccion="+document.forms.form1.direccion.value+"&ocupacion="+document.forms.form1.ocupacion.value+"&email="+document.forms.form1.email.value+"&telefono="+document.forms.form1.telefono.value+"&celular="+document.forms.form1.celular.value, "ventana", "resizable,height=100,width=400");
}




function ver_provincia()
{
	window.open("provincia2_nuevo.php?departamento=<?php echo $_REQUEST['departamento']?>&fecha="+document.forms.form1.fecha.value+"&historia="+document.forms.form1.historia.value+"&nombres="+document.forms.form1.nombres.value+"&apellidos="+document.forms.form1.apellidos.value+"&fecha2="+document.forms.form1.fecha2.value+"&estadocivil="+document.forms.form1.estadocivil.value+"&sexo="+document.forms.form1.sexo.value+"&direccion="+document.forms.form1.direccion.value+"&ocupacion="+document.forms.form1.ocupacion.value+"&email="+document.forms.form1.email.value+"&telefono="+document.forms.form1.telefono.value+"&celular="+document.forms.form1.celular.value, "ventana", "resizable,height=140,width=500");
}


function agregar_seguro()
{
	window.open("seguro_nuevo.php?tipo="+document.forms.form1.tipo.value+"&departamento="+document.forms.form1.departamento.value+"&provincia="+document.forms.form1.provincia.value+"&fecha="+document.forms.form1.fecha.value+"&historia="+document.forms.form1.historia.value+"&nombres="+document.forms.form1.nombres.value+"&apellidos="+document.forms.form1.apellidos.value+"&fecha2="+document.forms.form1.fecha2.value+"&estadocivil="+document.forms.form1.estadocivil.value+"&sexo="+document.forms.form1.sexo.value+"&direccion="+document.forms.form1.direccion.value+"&ocupacion="+document.forms.form1.ocupacion.value+"&email="+document.forms.form1.email.value+"&telefono="+document.forms.form1.telefono.value+"&celular="+document.forms.form1.celular.value, "ventana", "resizable,height=140,width=500");
}

function verifica_historia()
{
   document.forms.form1.action='paciente_nuevo.php';
   document.forms.form1.method='POST';
   document.forms.form1.id.value='6'   
   document.forms.form1.submit();
}
</script>

<SCRIPT language="javascript"> 
<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 
