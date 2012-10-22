<?php session_start();
 require_once('../clases/paciente_data.php');
$paciente= new Paciente;

include_once "../clases/PHPPaging.lib.php";
$paging = new PHPPaging;


if(!isset($_SESSION['sesion_id_usuario']))
 	{
	die("No tiene acceso  a esta seccion");
 	}


if (!isset($_REQUEST['npaginas'])){
	$_REQUEST['npaginas']=20;
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

<body>
<?php 

		if ($_REQUEST['id']==='2')
		{
			$paciente->paciente_borrar($_REQUEST['paciente_codigo']);
		}		
		
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td><form  id="form1" name="form1">
      <table width="797" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td width="31">&nbsp;</td>
          <td width="460">&nbsp;</td>
          <td width="229" colspan="-2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><span class="titulo">LISTADO GENERAL DE PACIENTES</span>
            <input name="paciente_codigo" type="hidden" id="paciente_codigo" />              <input name="id" type="hidden" id="id" />          </td>
          </tr>
        <tr>
          <td colspan="3" align="center"><table width="100%" border="0">
                  
                  <tr bgcolor="#FFFFFF" class="fondonegro" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
                    <td align="center"><span class="Estilo2">Nombres y Apellidos </span></td>
                    <td align="center">Tipo</td>
                    <td align="center" ><span class="Estilo2">Nro. de Historia </span></td>
                    <td align="center"><span class="Estilo2">Opci&oacute;n</span></td>
                    </tr>
                  
                  <?php  
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $paciente->paciente_listar();
			 
			  $paging->porPagina($_REQUEST['npaginas']);
			  $paging->mostrarAnterior("< Anterior");
			  $paging->mostrarSiguiente("Siguiente >");		  
			  $paging->agregarConsulta($rs);
			  
			  $paging->ejecutar();			 
			 
			 
			 if($rs)
			 
			 {
			 $j=1;
			 $particulares='0';
			 $seguro='0';
			  //while($campo =mysql_fetch_array($rs)) { 
  			  while($campo = $paging->fetchResultado()) {
			  ?><tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
                    <td width="44%" align="center"><?php echo strtoupper($campo['pac_apellidos'].', '.$campo['pac_nombres']); ?></td>
                    <td width="28%" align="center"><?php echo $paciente->devuelve_tipo_paciente($campo['pac_tipo']);  ?></td>
                    <td width="19%" align="center" ><?php echo $campo['pac_historia'];  ?></td>
                    <td width="9%" align="center"><a href="#" onClick="borrar(<?php echo $campo['pac_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" alt="Eliminar registro" width="14" height="14" border="0" /></a></td>
                    </tr> 
                  
  <?php

$j=$j+1;	 
	  if ($campo['pac_tipo']==='1')
	  {
		   $particulares=$particulares+1;
	  }
	  else
	  {
		  $seguro=$seguro+1;
	  }			  	 
	} 
}

?>
                  <tr bgcolor="#FFFFFF">
                    <td colspan="4" align="center">
                      <table>
                        <tr>
                          <td width="174" class="enfasis">TOTAL PACIENTES : <?php echo $particulares + $seguro;?></td>
                          <td width="314" class="enfasis">&nbsp;</td>
                          <td width="164" align="center" class="enfasis">PARTICULARES : <?php echo $particulares;?></td>
                          <td width="115" align="center"><span class="enfasis">ASEGURADOS : <?php echo $seguro;?></span></td>
                          </tr>
                        <tr>
                          <td align="center" bgcolor="#FFFFFF">Listar 
                            <input name="npaginas" type="text" id="npaginas" size="3" onblur="listar_pacientes()" value="<?php echo $_REQUEST['npaginas']?>" onkeyup='fn(this.form,this)' /> 
                            registros                  </td>
                          <td align="center" bgcolor="#FFFFFF"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo "Mostrando desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
                          <td align="center" bgcolor="#FFFFFF"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
                        </tr></table></td>
                    </tr>
                  
                  </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>

<script language="javascript">


function nuevo()
{


   document.forms.form1.action='pacientes.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}

function   borrar(paciente_codigo)
{
	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
		document.forms.form1.id.value='2';
		document.forms.form1.paciente_codigo.value=paciente_codigo;
		document.forms.form1.action='pacientes_listado.php';
		document.forms.form1.method='post';
		document.forms.form1.submit();
	}
	else
	{
	return false; 
	}
		
}

function listar_pacientes(){
	document.forms.form1.action='pacientes_listado.php';
	document.forms.form1.method='get';
	document.forms.form1.submit();
}

</script>
<?php  $paciente->_util->_cn->desconectar(); ?>