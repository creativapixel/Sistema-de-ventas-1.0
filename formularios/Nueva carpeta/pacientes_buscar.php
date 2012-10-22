<?php session_start();
  	
require_once('../clases/consulta_data.php');
$consulta = new Consulta;
$paciente = new Paciente;

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
    <td><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
		
		if ($_REQUEST['id']==='2')
		{
			$paciente->paciente_borrar($_REQUEST['paciente_codigo']);
		}		
		
		  
		  ?>

	
	<form name="form1"  id="form1">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="titulo">BUSQUEDAS GENERAL DE PACIENTES </td>
          </tr>
          <tr>
            <td colspan="2"><span class="enfasis">
              <input name="pagina" type="hidden" id="pagina">
              <input name="id" type="hidden" id="id">
              <input name="paciente_codigo" type="hidden" id="paciente_codigo">
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><table width="57%" border="0">
              <tr>
                <td align="left">Nro Historia</td>
                <td align="left">:</td>
                <td align="left"><input name="historia" type="text" id="historia" value="<?php echo $_REQUEST['historia'] ?>" onkeyup='fn(this.form,this)' >                  </td>
              </tr>
              <tr>
                <td align="left">Nombres</td>
                <td align="left">:</td>
                <td align="left"><input name="nombres" type="text" id="nombres" value="<?php echo $_REQUEST['nombres'] ?>" size="40" onkeyup='fn(this.form,this)' ></td>
              </tr>
              <tr>
                <td align="left">Apellidos</td>
                <td align="left">:</td>
                <td align="left"><input name="apellidos" type="text" id="apellidos" value="<?php echo $_REQUEST['apellidos'] ?>" size="40" onkeyup='fn(this.form,this)' ></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2"><span class="enfasis">
              <input name="Submit" type="button" class="btn" onClick="buscar();" value="Buscar Registro">
            </span></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="785"><table width="639" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <th width="15%" align="center">NRO. HISTORIA </th>
                <th width="19%" align="center">TIPO</th>
                <th width="21%" align="center">NOMBRES</th>
                <th width="19%" align="center">APELLIDOS</th>
                <th width="26%" align="center">OPCI&Oacute;N</th>
              </tr>
              <?php  
			 // $parametros="&programa=".$_REQUEST['programa'];
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $paciente->paciente_buscar($_REQUEST['historia'],$_REQUEST['nombres'],$_REQUEST['apellidos']);
			 if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
              <?php 
			  $j=$j+1;
			  } 
			  } ?>
              <tr>
                <td colspan="5"></td>
              </tr>
            </table></td>
            <td width="23">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center">
			
			<div style="position:static;width:680px; height:300px; overflow:scroll; z-index:1;  ">
			<table width="642" border="0" align="center" cellpadding="0" cellspacing="2">

              <?php  
			 if ($_REQUEST['historia']!='' or $_REQUEST['nombres']!='' or $_REQUEST['apellidos']!='')
			 {

			 $rs= $paciente->paciente_buscar($_REQUEST['historia'],$_REQUEST['nombres'],$_REQUEST['apellidos']);
			 }
			  if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
              <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
                <td width="15%" align="center"><?php echo $campo['pac_historia'] ?></td>
                <td width="19%" align="center"><?php echo strtoupper($paciente->devuelve_tipo_paciente($campo['pac_tipo'])) ?></td>
                <td width="21%" align="center"><?php echo strtoupper($campo['pac_nombres']) ?></td>
                <td width="19%" align="center"><?php echo strtoupper($campo['pac_apellidos']) ?></td>
                <td width="6%" align="center">
				
				<a href='#' onClick="window.open('consulta_historial.php?cod_paciente=<?php echo $campo['pac_id'] ;?>&valor=1', '_blank', 'resizable,height=600,width=600,scrollbars=yes')">Consultas</a>				</td>
                <td width="12%" align="center"><a href='#' onClick="window.open('paciente_editar.php?cod_paciente=<?php echo $campo['pac_id'] ?>', '_blank', 'resizable,height=600,width=600,scrollbars=yes')">Editar Historia </a></td>
                <td width="8%" align="center">
				<a href="#" onClick="borrar(<?php echo $campo['pac_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" alt="Eliminar registro" width="14" height="14" border="0"></a>				</td>
              </tr>
              <?php 
			  $j=$j+1;
			  } 
			  } 
			  
			  ?>
            </table>
			</div>			</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><h5>&nbsp;</h5></td>
          </tr>
        </table>
        <p>&nbsp;</p>
	</form></td>
  </tr>
</table>
</body>

<?php $paciente->_util->_cn->desconectar();?>
</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">

function nuevo_paciente()
{
	ventana = window.open("paciente_nuevo.php", "_blank", "resizable,height=500,width=600");
}


function buscar()
{

document.forms.form1.action='pacientes_buscar.php';
document.forms.form1.method='post';
document.forms.form1.submit();

}


function   borrar(paciente_codigo)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
		document.forms.form1.id.value='2';
		document.forms.form1.paciente_codigo.value=paciente_codigo;
		document.forms.form1.action='pacientes_buscar.php';
		document.forms.form1.method='post';
		document.forms.form1.submit();
	}
	else
	{
	return false; 
	}
		
		
}




</script>

