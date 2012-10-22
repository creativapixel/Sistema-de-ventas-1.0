<?php
	session_start();
	require_once('../clases/producto_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;

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
<title>Sistema de Ventas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
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
	$producto->producto_nuevo($_REQUEST['linea'],$_REQUEST['marca'],$_REQUEST['descripcion'],$_REQUEST['stock'],'0',$_REQUEST['codigo']);

}

		
if ($_REQUEST['id']==='2')
{
	$producto->producto_borrar($_REQUEST['prod_id']);
}

?>

	
	<form name="form1"  id="form1">
        <table width="658" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3" class="titulo">LISTADO DE PRODUCTOS </td>
          </tr>
          <tr>
            <td width="135" align="right" class="enfasis"><strong>Linea</strong></td>
            <td width="17" align="center" class="enfasis"><strong>:</strong></td>
            <td width="498" align="left"><?php $linea->generar_select_linea('linea','ver_producto()',''); ?>
            <input name="pagina" type="hidden" id="pagina">
            <input name="id" type="hidden" id="id">
            <input name="prod_id" type="hidden" id="prod_id">
            <span class="enfasis">
            <input name="stock" type="hidden" id="stock" value="0">
            </span></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"><strong>Marca </strong></td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  $marca->generar_select_marca('marca','','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"><strong>Descripci&oacute;n</strong></td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><input name="descripcion" type="text" id="descripcion" size="50" onchange='mayusculas(this);'></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"><strong>Codigo</strong></td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><input name="codigo" type="text" id="codigo" size="30" onchange='mayusculas(this);'></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Agregar Producto"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="3"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="6%" align="center" class="cabecera_tabla">ORDEN</td>
                <td width="20%" align="center" class="cabecera_tabla">MARCA</td>
                <td width="52%" align="center" class="cabecera_tabla">DESCRIPCION</td>
                <td width="5%" align="center" class="cabecera_tabla">CODIGO</td>
                <td width="5%" align="center" class="cabecera_tabla">STOCK</td>
                <td colspan="2" align="center" class="cabecera_tabla">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  
	$rs= $producto->producto_listar($_REQUEST['linea']);

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) {?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo strtoupper($campo['mar_descripcion']); ?></td>
                <td align="center"><?php echo strtoupper($campo['pro_descripcion']) ?></td>
                <td align="center"><?php echo strtoupper($campo['pro_codigo']) ?></td>
                <td align="center"><?php echo strtoupper($campo['pro_stock']) ?></td>
                <td width="6%" align="center"><a href="producto_editar.php?producto_id=<?php echo $campo['pro_id'];?>"><img src="../imagenes/icono_editar.gif" width="14" height="14" border="0"></a></td>
                <td width="6%" align="center"><a href="#" onClick="borrar(<?php echo $campo['pro_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a></td>
			  </tr>
			  <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="6"><table width="100%" border="0">
                  <tr>
                    <td width="19%">Listar
                      <input name="npaginas" type="text" id="npaginas" size="2" onblur="ver_producto()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
                    <td width="44%"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
                    <td align="right"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td colspan="6" align="right"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
              </tr>
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>

<?php $producto->_util->_cn->desconectar();?>

<script src="../javascript/eventos.js">  </script>
<script language="javascript">

document.forms.form1.descripcion.focus();

function nuevo()
{

	if (document.forms.form1.descripcion.value=="")
	{ 
		document.forms.form1.descripcion.focus();
		alert("Ingrese el nombre del producto");
		return false; 
	}

	if (document.forms.form1.stock.value=="")
	{ 
		document.forms.form1.stock.focus();
		alert("Ingresar el stock inicial");
		return false; 
	}

document.forms.form1.action='productos.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}

function ver_producto()
{
   document.forms.form1.action='productos.php';
   document.forms.form1.method='GET';
   document.forms.form1.submit();
}

function   borrar(prod_id)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.prod_id.value=prod_id;
   		document.forms.form1.action='productos.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}




</script>

