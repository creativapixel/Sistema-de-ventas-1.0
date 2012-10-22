<?php
	session_start();
	require_once('../clases/producto_data.php');

	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;
	
	

/*	if (!isset($_SESSION['sesion_id_usuario']) and !isset($_SESSION['sesion_id_area']))
	{
		die("Usted no tiene acceso a esta area");
	}*/


 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema de Ventas</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css">
<script src="../librerias/jquery/jquery-1.3.2.min.js"></script>
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

if ($_REQUEST['id']==='2')
{
	$producto->precio_borrar($_REQUEST['pre_id']);
}

?>

	
	<form name="form1"  id="form1">
        <table width="854" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr align="center">
            <td colspan="3" class="titulo"> PRECIOS POR PRODUCTO</td>
          </tr>
          <tr>
            <td width="200" align="right" class="enfasis">&nbsp;</td>
            <td width="15" align="center" class="enfasis">&nbsp;</td>
            <td width="631" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="center" class="enfasis"><table width="400" border="0">
              <tr>
                <td><input name="opt_accion" type="radio" onClick="registrar()" ></td>
                <td align="left">Registrar precio</td>
                <td><input name="opt_accion" type="radio"checked></td>
                <td align="left">Buscar precio </td>
              </tr>
            </table>            </td>
          </tr>
          <tr>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="center" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="enfasis">Producto</td>
            <td align="center" class="enfasis"><strong>:</strong></td>
            <td align="left"><?php  //$producto->generar_select_producto('producto','ver_producto()',$_REQUEST['linea'],$_REQUEST['marca']);  ?>
            <input name="id" type="hidden" id="id">
            <input name="txtproducto" type="text" id="txtproducto" onKeyUp="ver_producto()" size="60"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          
          <tr>
            <td colspan="3">
			
			<div id="productos_lista">
			

			
			</div>
			
			</td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>

<?php 
$producto->_util->_cn->desconectar();


?>

<script src="../javascript/eventos.js">  </script>
<script language="javascript">




function ver_producto()
{

		var url = 'ajax_producto.php';  
	   
		var valor_producto = $("input#txtproducto").val();
		
		var datos = 'operacion=1&producto='+ valor_producto;  
		
		$.get(url, datos, function(resultado) {  
	
			$('#productos_lista').html(resultado);  
	   
		});	

}

function registrar()
{
   document.forms.form1.action='precios.php';
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

