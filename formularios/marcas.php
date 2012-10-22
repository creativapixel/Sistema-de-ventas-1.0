<?php session_start();
require_once('../clases/marca_data.php');
require_once "../clases/PHPPaging.lib.php";
	
$paging = new PHPPaging;
$marca = new  Marca;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=15;
	}

 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MANTENIMIENTO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
<script src="../javascript/eventos.js">  </script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
		  if($_REQUEST['id']==='1')
{
	  
$marca->marca_nuevo($_REQUEST['marca'],'0');

}

		
if ($_REQUEST['id']==='2')
{

$marca->marca_borrar($_REQUEST['marca_codigo']);
}
		
		
		
		  
		  ?>

	
	<form name="form1"  id="form1" >
        <table width="552" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3"><span class="titulo">LISTADO DE MARCAS</span> 
			  <input name="pagina" type="hidden" id="pagina">
			  <input name="id" type="hidden" id="id">
			  <input name="marca_codigo" type="hidden" id="marca_codigo"></td>
          </tr>
          
          <tr>
            <td align="right"><span class="enfasis">Marca</span></td>
            <td align="center"><span class="enfasis">:</span></td>
            <td align="left"><span class="enfasis">
              <input name="marca" type="text" id="marca" size="40" onKeyUp="enter(this.form,this);" onChange='mayusculas(this);'>
            </span></td>
          </tr>
          <tr>
            <td width="106" align="center">&nbsp;</td>
            <td width="15" align="center">&nbsp;</td>
            <td width="423" align="left"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Marca"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><table width="79%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="10%" align="center">ORDEN</td>
                <td width="69%" align="center">DESCRIPCI&Oacute;N</td>
                <td colspan="2" align="center">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  

	$rs= $marca->marca_listar('1');

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) { ?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo strtoupper($campo['mar_descripcion']) ?></td>
                <td width="10%" align="center"><a href="marca_editar.php?marca_id=<?php echo $campo['mar_id'];?>"><img src="../imagenes/icono_editar.gif" alt="Editar Registro" width="14" height="14" border="0"></a></td>
                <td width="11%" align="center"><a href="#" onClick="borrar(<?php echo $campo['mar_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" alt="Eliminar Registro" width="14" height="14" border="0"></a></td>
			  </tr>
			  <?php 
			  $j=$j+1;
			
			  } ?>
              <tr>
                <td colspan="4"><table width="100%" border="0">
                  <tr>
                    <td width="19%">Listar
                      <input name="npaginas" type="text" id="npaginas" size="2" onblur="listar()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
                    <td width="44%"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
                    <td align="right"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
                    </tr>
                </table></td>
                </tr>
              <tr>
                <td colspan="4" align="right"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><?php  // echo $vinculo->util->devuelve_paginado($vinculo->query,$parametros,$idioma='1',$color='#006699');  ?></td>
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

document.forms.form1.marca.focus();

function nuevo()
{

if (document.forms.form1.marca.value=="")
{ 
document.forms.form1.marca.focus();
alert("Ingresar Nombre de Marca");
return false; 
}

document.forms.form1.action='marcas.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();

}


function listar()
{

document.forms.form1.action='marcas.php';
document.forms.form1.method='GET';
document.forms.form1.submit();

}


function   borrar(marca_codigo)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
		document.forms.form1.id.value='2';
		document.forms.form1.marca_codigo.value=marca_codigo;
		document.forms.form1.action='marcas.php';
		document.forms.form1.method='POST';
		document.forms.form1.submit();
	}
	else
	{
	return false; 
	}
		
		
}
</script>

<?php $marca->_util->_cn->desconectar();?>