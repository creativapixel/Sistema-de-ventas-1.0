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
	$producto->precio_insertar($_REQUEST['producto'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['costo']);

}

		
if ($_REQUEST['id']==='2')
{
	$producto->precio_borrar($_REQUEST['pre_id']);
}

?>

	
	<form name="form1"  id="form1">
        <table width="917" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3" class="titulo"> PRECIOS POR PRODUCTO</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center" class="enfasis"><table width="400" border="0">
              <tr>
                <td><input name="opt_accion" type="radio" checked></td>
                <td align="left">Registrar precio</td>
                <td><input name="opt_accion" type="radio" onClick="buscar()"></td>
                <td align="left">Buscar precio </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="200" align="right" class="enfasis"><strong>Linea</strong></td>
            <td width="15" align="center" class="enfasis"><strong>:</strong></td>
            <td width="694" align="left"><?php $linea->generar_select_linea('linea','ver_producto()',''); ?>
            <input name="pagina" type="hidden" id="pagina">
            <input name="id" type="hidden" id="id">
            <input name="pre_id" type="hidden" id="pre_id"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis"><strong>Marca </strong></td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  $marca->generar_select_marca('marca','ver_producto()','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  $producto->generar_select_producto('producto','ver_producto()',$_REQUEST['linea'],$_REQUEST['marca']);  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Unidad</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><?php  $producto->generar_select_unidad('unidad','','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Precio costo (S/.)  </td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="costo" type="text" id="costo" size="10" onchange='mayusculas(this);'></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Precio venta (S/.)</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><input name="precio" type="text" id="precio" size="10" onchange='mayusculas(this);'></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Agregar Precio"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="3"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="9%" align="center" class="cabecera_tabla">ORDEN</td>
                <td width="28%" align="center" class="cabecera_tabla">PRODUCTO</td>
                <td width="16%" align="center" class="cabecera_tabla">MARCA</td>
                <td width="11%" align="center" class="cabecera_tabla">CODIGO</td>
                <td width="10%" align="center" class="cabecera_tabla">UNIDAD</td>
                <td width="10%" align="center" class="cabecera_tabla">PRECIO COSTO </td>
                <td width="10%" align="center" class="cabecera_tabla">PRECIO VENTA </td>
                <td align="center" class="cabecera_tabla" colspan="2">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  
	$rs= $producto->precio_listar($_REQUEST['producto']);

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) {?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo strtoupper($campo['pro_descripcion']); ?></td>
                <td align="center"><?php echo strtoupper($campo['mar_descripcion']); ?></td>
                <td align="center"><?php echo strtoupper($campo['pro_codigo']) ?></td>
                <td align="center"><?php echo strtoupper($campo['uni_descripcion']) ?></td>
                <td align="center">S/. <?php echo $campo['pre_costo'] ?></td>
                <td align="center">S/. <?php echo $campo['pre_precio'] ?></td>
                <td width="3%" align="center"><a href="precio_editar.php?pre_id=<?php echo $campo['pre_id']; ?>"><img src="../imagenes/icono_editar.gif" width="14" height="14" border="0"></a></td>
                <td width="3%" align="center"><a href="#" onClick="borrar(<?php echo $campo['pre_id']; ?>)"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a></td>
                </tr>
			  <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="9"><table width="100%" border="0">
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
                <td colspan="9" align="right"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
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


function nuevo()
{

	if (document.forms.form1.costo.value=="")
	{ 
		document.forms.form1.costo.focus();
		alert("Ingresar el costo");
		return false; 
	}	

	if (document.forms.form1.precio.value=="")
	{ 
		document.forms.form1.precio.focus();
		alert("Ingresar el precio");
		return false; 
	}

document.forms.form1.action='precios.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}

function ver_producto()
{
   document.forms.form1.action='precios.php';
   document.forms.form1.method='GET';
   document.forms.form1.submit();
}

function buscar()
{
   document.forms.form1.action='precio_buscar.php';
   document.forms.form1.method='POST';
   document.forms.form1.submit();
}

function   borrar(pre_id)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.pre_id.value=pre_id;
   		document.forms.form1.action='precios.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}




</script>

