<?php
	session_start();
	require_once('../clases/ingresos_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	$ingreso = new Ingreso;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;

	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}
	
	/*if(!isset($_REQUEST['fecha'])){
		$_REQUEST['fecha']=date('d/m/y');
	}*/

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


<!-- combo autocompletable-->
<script>
window.dhx_globalImgPath = "../librerias/dhtmlxCombo/codebase/imgs/";
</script>
<link rel="STYLESHEET" type="text/css" href="../librerias/dhtmlxCombo/codebase/dhtmlxcombo.css">
<script  src="../librerias/dhtmlxCombo/codebase/dhtmlxcommon.js"></script>
<script  src="../librerias/dhtmlxCombo/codebase/dhtmlxcombo.js"></script>
<!-- final de combo autocompletable -->


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
	$ingreso->ingresos_insertar($_REQUEST['producto'],$_REQUEST['fecha'],$_REQUEST['cantidad']);

}

		
if ($_REQUEST['id']==='2')
{
	$ingreso->ingresos_borrar($_REQUEST['ing_id'],$_REQUEST['pro_id'],$_REQUEST['cant']);
}

?>

	
	<form name="form1"  id="form1">
        <table width="658" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3" class="titulo">REGISTRAR INGRESOS </td>
          </tr>
          <tr>
            <td width="186" align="right" class="enfasis">&nbsp;</td>
            <td width="14" align="center" class="enfasis">&nbsp;</td>
            <td width="450" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Fecha Ingreso</td>
            <td align="center" class="enfasis">:</td>
            <td align="left"><input name="fecha" type="text" id="fecha" value="<?php  echo $_REQUEST['fecha']; ?>" size="10"  onKeyUp='fn(this.form,this)' class="date-pick" onBlur="ver_ingresos()"  />
              <input name="id" type="hidden" id="id">
              <input name="ing_id" type="hidden" id="ing_id">
              <input type="hidden" name="pro_id" id="pro_id">
              <input type="hidden" name="cant" id="cant"></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php $producto->generar_select_producto_total('producto','','0','0','0','');  ?></td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Cantidad</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><input name="cantidad" type="text" id="cantidad" size="10" onchange='mayusculas(this);'></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Registrar Ingreso"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="3"><table width="700" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="9%" align="center" class="cabecera_tabla">FECHA</td>
                <td width="70%" align="center" class="cabecera_tabla">PRODUCTO</td>
                <td width="15%" align="center" class="cabecera_tabla">CANT. (UNID.)</td>
                <td width="6%" align="center" class="cabecera_tabla">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  
	$rs= $ingreso->ingresos_listar($_REQUEST['fecha']);

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) {?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><strong><?php echo $ingreso->_util->obtiene_fecha($campo['ing_fecha']); ?></strong></td>
                <td align="center"><?php echo strtoupper($campo['pro_descripcion']); ?></td>
                <td align="center"><?php echo $campo['ing_cantidad']; ?></td>
                <td align="center"><a href="#" onClick="borrar(<?php echo $campo['ing_id']; ?>,<?php echo $campo['pro_id']; ?>,<?php echo $campo['ing_cantidad']; ?>)"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a></td>
                </tr>
			  <?php 
			  $j=$j+1;
			  } ?>
              <tr>
                <td colspan="4"><table width="100%" border="0">
                  <tr>
                    <td width="19%">Listar
                      <input name="npaginas" type="text" id="npaginas" size="2" onblur="ver_ingresos()" value="<?php echo $_REQUEST['npaginas']?>"/></td>
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
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>



<script src="../javascript/eventos.js">  </script>

<!-- script combo autocompletable -->
<script>
var z = dhtmlXComboFromSelect("producto");
z.enableFilteringMode(true);

</script>		
<!-- script fin combo autocompletable -->

<script language="javascript">


	var fecha=new Date();
	var diames=fecha.getDate();
	
	if(diames<10)
	{
		diames = '0'+diames;
	}
	
	
	var diasemana=fecha.getDay();
	var mes=fecha.getMonth() +1 ;
	
	if(mes<10)
	{
		mes = '0'+mes;
	}	
	
	var ano=fecha.getFullYear();
	
	document.forms.form1.fecha.value= diames + "/" + mes + "/" + ano;
	

function nuevo()
{

	if (document.forms.form1.fecha.value=="")
	{ 
		document.forms.form1.fecha.focus();
		alert("Ingresar la fecha de ingreso");
		return false; 
	}

	if (document.forms.form1.cantidad.value=="")
	{ 
		document.forms.form1.cantidad.focus();
		alert("Ingresar la cantidad");
		return false; 
	}

document.forms.form1.action='ingresos.php';
document.forms.form1.method='POST';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}

function ver_ingresos()
{
   document.forms.form1.action='ingresos.php';
   document.forms.form1.method='GET';
   document.forms.form1.submit();
}

function   borrar(ing_id,pro_id,cant)
{

	if (confirm("¿Seguro que desea eliminar el registro?"))
	{
   		document.forms.form1.id.value='2';
   		document.forms.form1.ing_id.value=ing_id;
   		document.forms.form1.pro_id.value=pro_id;	
   		document.forms.form1.cant.value=cant;		
   		document.forms.form1.action='ingresos.php';
   		document.forms.form1.method='POST';
   		document.forms.form1.submit();
	}
	else
	{
		return false; 
	}
}




</script>
<?php $ingreso->_util->_cn->desconectar();?>
