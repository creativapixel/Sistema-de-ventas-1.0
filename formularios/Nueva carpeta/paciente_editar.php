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
<title>EDITAR HISTORIA CLINICA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<?php

	if($_REQUEST['id']==='1')
	{
	  
	  	$nombre_archivo = $_FILES['userfile']['name'];
		$nombre_archivo = ereg_replace(" ", "", $nombre_archivo); 
		
		if (empty($_FILES['userfile']['name']))
		{
			$ruta=$_REQUEST['foto'];	
		}
		else
		{
			$ruta='fotospacientes/'.$_REQUEST['historia'].'_'.$_REQUEST['tipo'].'_'.$nombre_archivo;//ruta completa		
		}
		$rs=$paciente->paciente_editar($_SESSION['paciente_codigo'],$_REQUEST['fecha'],$_REQUEST['historia2'],$_REQUEST['nombres'],$_REQUEST['apellidos'],$_REQUEST['fecha2'],$_REQUEST['estadocivil'],$_REQUEST['sexo'],$_REQUEST['departamento'],$_REQUEST['provincia'],$_REQUEST['direccion'],$_REQUEST['ocupacion'],$_REQUEST['telefono'],$_REQUEST['celular'],$_REQUEST['email'],$ruta,'0',$_REQUEST['tipo'],$_REQUEST['seguro'],$_REQUEST['registro'],$_REQUEST['procedencia']);
		
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
			

	}
	else
	{
		 "no entro";
	}
		

	}

	if ($_REQUEST['id']=='6')
	{
		$paciente->evaluar_nro_historia($_REQUEST['historia2'],$_REQUEST['tipo'],$_REQUEST['seguro']);

	}
		
	if (isset($_REQUEST['cod_paciente']))
	{
		$_SESSION['paciente_codigo']=$_REQUEST['cod_paciente'];

	}	
	
	$paciente->paciente_ver($_SESSION['paciente_codigo']);
	
	if (isset($_REQUEST['cod_paciente']))
	{	
		$_REQUEST['estadocivil']=$paciente->pac_estadocivil;
		$_REQUEST['sexo']=$paciente->pac_sexo;
		$_REQUEST['departamento']=$paciente->dep_id;					
		$_REQUEST['provincia']=$paciente->prov_id;
		$_REQUEST['tipo']=$paciente->pac_tipo;	
		$_REQUEST['seguro']=$paciente->seg_id;			
	}			
?>
<body onload="centrar_pagina()">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" background="../imagenes/lin_menu.jpg"><h5 class="textoblanco"><br>
    EDITAR HISTORIA CLINICA </h5></td>
  </tr>
  <tr>
    <td align="center">

	
	<form enctype="multipart/form-data" name="form1"  id="form1">
	  <table width="560" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="4" align="center">
			<input name="pagina" type="hidden" id="pagina">
			<input name="id" type="hidden" id="id"></td>
          </tr>
          
          <tr>
            <td width="128" align="left" valign="top" class="enfasis">Fecha de registro </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="fecha" type="text" id="fecha" value="<?php  echo $paciente->_util->obtiene_fecha($paciente->pac_fecharegistro); ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick"  /></td>
            <td width="138" rowspan="7" align="center" valign="top" class="enfasis">
			<?php if ($paciente->pac_foto!=""){ ?>
			<a href="../<?php echo $paciente->pac_foto; ?>" target="_blank"><img src="../<?php echo $paciente->pac_foto; ?>" width="110" height="131" border="0"></a>
			<?php } else { ?><img src="../imagenes/silueta.jpg" width="83" height="83" border="0"><?php } ?> 
            <input name="foto" type="hidden" id="foto" value="<?php  echo $paciente->pac_foto; ?>"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Tipo de Paciente </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><select name="tipo" id="tipo" onChange="ver_datos()">
              <option value="0" <?php if($_REQUEST['tipo']==='0'){ echo "selected"; }?>>Seleccione Tipo Paciente</option>
              <option value="1" <?php if($_REQUEST['tipo']==='1'){ echo "selected"; }?>>PARTICULAR</option>
              <option value="2" <?php if($_REQUEST['tipo']==='2'){ echo "selected"; }?>>SEGURO</option>
            </select></td>
          </tr>
		  <?php if ($_REQUEST['tipo']==='2'){?>
          <tr>
            <td align="left" valign="top" class="enfasis">Seguro</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><?php $paciente->generar_select_seguro('seguro','',''); ?>
            <input name="boton_seguro" type="button" class="btn" id="boton_seguro" value="Agregar Seguro" onClick="agregar_seguro()"></td>
          </tr>
		  <?php }?>
          <tr>
            <td align="left" valign="top" class="enfasis">Nro. de Historia </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="historia2" type="text" id="historia2" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_historia; ?>" <?php //if ($_REQUEST['tipo']!='2'){ echo "disabled='disabled'";}?>  onBlur="verifica_historia()">
            <input name="historia" type="hidden" id="historia" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_historia; ?>">
            <input name="registro" type="hidden" id="registro" onKeyUp='fn(this.form,this)' value="<?php  echo $paciente->pac_registro; ?>" size="10"></td>
          </tr>
		  <?php if ($_REQUEST['tipo']==='2'){?>		  
          
		  <?php }?>		  
          <tr>
            <td align="left" valign="top" class="enfasis"> Nombres</td>
            <td width="13" align="center" valign="top" class="enfasis">:</td>
            <td width="271" align="left" valign="top" class="enfasis"><input name="nombres" type="text" id="nombres"   onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_nombres; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Apellidos</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="apellidos" type="text" id="apellidos" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_apellidos; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Fecha de Nacimiento </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td align="left" valign="top" class="enfasis"><input name="fecha2" type="text" id="fecha2" value="<?php  echo $paciente->_util->obtiene_fecha($paciente->pac_fechanac); ?>" size="10"  onkeyup='fn(this.form,this)' class="date-pick"  /></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Estado Civil </td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><select name="estadocivil" id="estadocivil"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['estadocivil']==='1'){ echo "Selected";} ?>>SOLTERO</option>
              <option value="2" <?php if ($_REQUEST['estadocivil']==='2'){ echo "Selected";} ?>>CASADO</option>
              <option value="3" <?php if ($_REQUEST['estadocivil']==='3'){ echo "Selected";} ?>>DIVORCIADO</option>
              <option value="4" <?php if ($_REQUEST['estadocivil']==='4'){ echo "Selected";} ?>>VIUDO</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Sexo</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><select name="sexo" id="sexo"   onkeyup='fn(this.form,this)'>
              <option value="1" <?php if ($_REQUEST['sexo']==='1'){ echo "Selected";} ?>>F</option>
              <option value="2" <?php if ($_REQUEST['sexo']==='2'){ echo "Selected";} ?>>M</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Departamento</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top"><span class="enfasis"><?php  	$paciente->generar_select_departamento('departamento','ver_datos()',''); ?> 
            </span>
              <label>
                <input name="button" type="button" class="btn" id="button" value="Nuevo Departamento" onClick="nuevo_departamento()">
            </label>              
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Provincia</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top"><?php  $paciente->generar_select_provincia('provincia','',$_REQUEST['departamento']);  ?>
              <label>
                <input name="button2" type="button" class="btn" id="button2" value="Nueva Provincia" onClick="nueva_provincia()">
              </label> 
            
			</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Direcci&oacute;n</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="direccion" type="text" id="direccion" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_direccion; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Procedencia</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="procedencia" type="text" id="procedencia" value="<?php  echo $paciente->pac_procedencia; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Ocupaci&oacute;n</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="ocupacion" type="text" id="ocupacion" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_ocupacion; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Tel&eacute;fono</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="telefono" type="text" id="telefono" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_telefono; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Celular</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="celular" type="text" id="celular" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_celular; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">E-mail</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="email" type="text" id="email" onkeyup='fn(this.form,this)' value="<?php  echo $paciente->pac_email; ?>" size="40"></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="enfasis">Foto</td>
            <td align="center" valign="top" class="enfasis">:</td>
            <td colspan="2" align="left" valign="top" class="enfasis"><input name="userfile" type="file" id="userfile" size="40" onkeyup='fn(this.form,this)'></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="enfasis">
			<?php 
			if (isset($_REQUEST['valor2']))
			{?>
              <input name="valor2" type="hidden" value="1">
              <?php
			}
			?>
			
			<?php if (isset($_REQUEST['valor']))
			{?>			
              <input name="valor" type="hidden" id="valor" value="2">
              <?php
			}
			?>
			
			<?php if (isset($_REQUEST['valor3']))
			{?>			
              <input name="valor3" type="hidden" id="valor3" value="3">
              <?php
			}
			?>			</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Editar Paciente">
            &nbsp;            <input name="Submit2" type="button" class="btn" value="Imprimir  Historia Clinica" onClick="imprimir()">
            &nbsp;
			
	  		
			<input name="cerrar" type="button" class="btn" onClick="<?php if($_REQUEST['id']==='1'){ echo "cerrar_ventana()"; } else { echo "window.close();";}?>" value="Cerrar Ventana"></td>
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

document.forms.form1.action='paciente_editar.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}

function ver_datos()
{
   document.forms.form1.action='paciente_editar.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}

function verifica_historia()
{
   document.forms.form1.action='paciente_editar.php';
   document.forms.form1.method='post';
   document.forms.form1.id.value='6'   
   document.forms.form1.submit();
}

function cerrar_ventana()
{
	window.opener.location.href = '<?php if (isset($_REQUEST['valor2'])){ echo "pacientes_listado.php";}elseif(isset($_REQUEST['valor'])){echo "consultas_generar.php";} elseif(isset($_REQUEST['valor3'])){echo "consulta_atencion.php";}else{ echo "pacientes_buscar.php"; }?>?historia=<?php echo $_REQUEST['historia']?>';
	window.close();
}

function imprimir()
{
	window.open("historia_impresion.php?codigo=<?php echo $_SESSION['paciente_codigo'] ?>", "_blank", "resizable,height=500,width=700");
}

function agregar_seguro()
{
	window.open("seguro_nuevo.php?valor=1&tipo="+document.forms.form1.tipo.value, "ventana", "resizable,height=140,width=500");
}

function nuevo_departamento()
{
	window.open("departamento2_nuevo.php?valor=1", "_blank", "resize,width=500,height=100"); 
}

function nueva_provincia()
{
	window.open("provincia2_nuevo.php?departamento=<?php echo $_REQUEST['departamento']?>&valor=1","_blank","width=500,height=140");
}
</script>

