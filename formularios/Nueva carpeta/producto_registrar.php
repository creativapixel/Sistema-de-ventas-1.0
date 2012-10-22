<?php   session_start();
		//require_once "../clases/session_data.php";
		require_once "../clases/productos_data.php";
		include_once "../clases/PHPPaging.lib.php";
		
		$paging = new PHPPaging;		
		//$session= new sessiondata();
		$producto = new Producto();
		$tipoproducto = new Tipoproducto();	
	
 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	} 

	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=50;
	}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
<script src="../javascript/eventos.js"></script>
<div ID="waitDiv" style="position:absolute;left:300;top:300;visibility:hidden"> 
<table  border="0" align="center"> 
<tr><td> 
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


</head>

<?php

	if($_REQUEST['id']=='1')
	{
	
		$producto->productos_insertar($_REQUEST['tipoproducto'],$_REQUEST['descripcion'],$_REQUEST['stock'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['moneda']);

	}

	 
	if($_REQUEST['id']==='2')
	{
		$producto->productos_borrar($_REQUEST['campos']);
	}	  	  
	




?>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr height="5">
    <td height="23"> <?php  include("menu.php");?></td>
  </tr>
  <tr><td>&nbsp; </td></tr>
  <tr>
    <td align="center" class="titulo">REGISTRAR PRODUCTOS</td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1">
      <table width="487" border="0">
        <tr>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td width="93" align="right">Tipo de producto</td>
          <td width="10" align="center">:</td>
          <td colspan="2" align="left"><?php $tipoproducto->generar_select_tipoproducto('tipoproducto','enviar_form("POST","producto_registrar.php","")','')?>
            <input type="hidden" name="id" id="id" />
            <input name="button2" type="button" class="btn" id="button2" value="Nuevo Tipo de producto" onclick="nueva_ventana_parametros('tipoproducto_nuevo.php','100','400','')" /></td>
        </tr>
        <tr>
          <td align="right">Descripci&oacute;n</td>
          <td align="center">:</td>
          <td colspan="2" align="left"><input name="descripcion" type="text" id="descripcion" size="50" /></td>
        </tr>
        <tr>
          <td align="right">Stock</td>
          <td align="center">:</td>
          <td width="50"  align="left"><input name="stock" type="text" id="stock" size="8" /></td>
          <td width="318" align="left"><?php $producto->generar_select_unidadmedida('unidad','','')?></td>
        </tr>
        <tr>
          <td align="right">Precio</td>
          <td align="center">:</td>
          <td><label>
            <input name="precio" type="text" id="precio" size="8" />
            </label></td>
          <td  align="left"><?php $producto->generar_select_tipomoneda('moneda','','','')?></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2"><input name="button" type="button" class="btn" id="button" value="Registrar Producto" onclick="enviar_form('POST','producto_registrar.php','1')" /></td>
        </tr>
      </table>
 
      <table width="800" border="0">
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
          <td width="81" align="center">&nbsp;</td>
          <td colspan="3" align="center"><input name="Submit2" type="button" class="btn" 
							value="Eliminar Seleccionados" onclick="validar_checkbox_seleccionados(1)" /></td>
        </tr>
      
        <tr class="fondonegro">
          <td width="226" align="center">Tipo Producto</td>
          <td width="283" align="center">Descripci&oacute;n</td>
          <td align="center">Stock</td>
          <td width="83" align="center">Precio</td>
          <td width="58" align="center">Editar</td>
          <td width="43" align="center"><input name="grupo" type="checkbox" id="grupo" value="1" onClick="marcar_todos(this.form,this.checked)" /></td>
        </tr>
            <?php  
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $producto->producto_listar($_REQUEST['tipoproducto']);
			 
			  $paging->porPagina($_REQUEST['npaginas']);
			  $paging->mostrarAnterior("< Anterior");
			  $paging->mostrarSiguiente("Siguiente >");		  
			  $paging->agregarConsulta($rs);
			  
			  $paging->ejecutar();			 
			 
			 
			 if($rs)
			 
			 {
			 $j=1;
  			  while($campo = $paging->fetchResultado()) {
			  ?>          
        <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
          <td align="center"><?php echo $campo['tipp_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['prod_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['prod_stock'];  ?> <?php echo $campo['uni_descripcion'];  ?></td>
          <td align="center"><?php echo $campo['tipm_descripcion'];  ?> <?php echo $campo['prod_precio'];  ?></td>
          <td align="center"><a href="producto_editar.php?prod_id=<?php echo $campo['prod_id'];?>"><img src="../imagenes/icono_editar.gif" width="14" height="14" border="0" /></a></td>
          <td align="center"><input name="campos[<?php echo $campo['prod_id'];?>]" type="checkbox" /></td>
        </tr>

            <?php 
			  	$j=$j+1;			  	 
			  	} 
			  } 
			?>
          <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
          <td align="center">Listar
            <input name="npaginas" type="text" id="npaginas" size="3" onblur="enviar_form('GET','producto_registrar.php','')" value="<?php echo $_REQUEST['npaginas']?>" onkeyup='fn(this.form,this)' />
registros </td>
          <td align="center"><?php 
			  		$links = $paging->fetchNavegacion();
					echo $links;
				?></td>
          <td colspan="2" align="center"><?php echo "Mostrando ".$num_registros_aqui = $paging->numRegistrosMostrados()." registros. Desde ".$primer_elemento = $paging->numPrimerRegistro()." al ".$ultimo_elemento = $paging->numUltimoRegistro()."
 de un total de ".$total_registros = $paging->numTotalRegistros();
?></td>
          <td colspan="2" align="center"><?php echo "P&aacute;gina ".$pagina_actual = $paging->numEstaPagina()." de ".$num_paginas = $paging->numTotalPaginas();?></td>
        </tr>
      </table>   
      </form>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>

</table>

	</body>
</html>

<SCRIPT language="javascript"> 

function marcar_todos(form,marcar){
	for (i = 0; i < form.elements.length; i++){ 
		if(form.elements[i].type=="checkbox")
		{
			form.elements[i].checked = marcar;
		}
	}
}


function validar_checkbox_seleccionados(f)
  {
	todos=document.getElementsByTagName('input');	
	for(x=0;x<todos.length;x++)
	   {
		if(todos[x].type=="checkbox" && todos[x].checked)
		   {
			   return borrar();
		   }
	   }
	alert("Seleccione al menos 1 Elemento a Eliminar");
	return false;
  }
function  borrar()
  {
	if (confirm("¿Seguro que desea Eliminar todos los Registros Seleccionados?"))
		{
			document.forms.form1.id.value='2';
			document.forms.form1.action='producto_registrar.php';
			document.forms.form1.method='post';
			document.forms.form1.submit();
		}

	else
		{
			return false; 
		} 
  }




<!--  
ap_showWaitMessage('waitDiv', 0);  
//--> 
</SCRIPT> 

<?php $producto->_util->_cn->desconectar();?>