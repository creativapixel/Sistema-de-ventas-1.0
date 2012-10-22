<?php
require_once('../clases/permiso_data.php');
$permiso = new Permiso;
$usuario = new Usuario;
?>
<link href="../estilos/menu.css" rel="stylesheet" type="text/css" />


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../imagenes/lin_menu.jpg">
  <tr >
    <td height="20" colspan="6"><div align="center" class="Estilo1">
     <img src="../imagenes/logo_mediconsult.png" />
    </div></td>
    <td width="62%" height="23" align="center"><table width="95%" border="0">
      <tr>
        <td width="70%" bgcolor="#FFFFCC"><p align="center"><strong>RECOMENDACION</strong><br />
          Realizar copia de seguridad de la base de datos diariamente o una vez por semana para evitar perdida de informaci&oacute;n en caso de problemas. Clic en &lt;Seguridad&gt;.</p>
          </td>
        <td width="30%" align="center" bgcolor="#86979F"><span class="textoblanco"> Este programa esta registrado a nombre de:<br /><?php echo "Creativa Pixel";?><br /><?php echo "Antonio Raymondi 219 3er Piso"?></span></td>
      </tr>
    </table></td>
    <td width="14%" height="23" colspan="5"> <br />
<h4 class="textoblanco">Caja:&nbsp;<br />
  <?php echo strtoupper($usuario->devuelve_area($_SESSION['sesion_id_area']));?></h4></td>
  </tr>
  <tr align="center" bgcolor="#0F4E5B" >
    <td height="24" colspan="12" valign="top">
	

	<ul id="menu">
	
	
<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'18')){ ?>
<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
<dl class="one">
	<dt><a href='#'  class='vinculoblanco'>Gestionar Productos</a></dt>
	<dd><a href='lineas.php'>Registrar Lineas</a></dd>
	<dd><a href='marcas.php'>Registrar Marcas</a></dd>	
	<dd><a href='productos.php'>Registrar Productos</a></dd>
	<dd><a href='unidades.php'>Registrar Unidades</a></dd>	
 	<dd><a href='precios.php'>Registrar Precios</a></dd>   		
</dl>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php }?>

<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'23')){?>
<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->

	<dt><a href="ingresos.php">Gestionar Ingresos</a></dt>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>



<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'24')){?>
<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->

	<dt><a href="pedidos.php">Gestionar Pedidos</a></dt>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>

<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'25')){?>
<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->

<dl class="one">
	<dt><a href='#'  class='vinculoblanco'>Gestionar Ventas</a></dt>
	<dd><a href='ventas.php'>Registrar ventas</a></dd>
	<dd><a href='parametros_configurar.php'>Parametros</a></dd>	
</dl>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>

<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'22')){?>
<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->

	<dt><a href="usuarios_listado.php">Gestionar Usuarios</a></dt>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>




<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'27')){?><li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
<dl class="one">
	<dt><a href='#'>Consultas</a></dt>
	<dd><a href='stock_actual.php'>Stock Actual</a></dd>
	<dd><a href='ingresos_reporte.php'>Ingresos por Fecha</a></dd>  	
	<dd><a href='ventas_reporte.php'>Ventas por Fecha</a></dd> 		
</dl>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>


<?php if ($permiso->evalua_permiso($_SESSION['sesion_id_usuario'],'26')){?><li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
<dl class="four3">
	<dt><a href="#">Seguridad</a></dt>
	<dd><a href='#' onClick="window.open('backup.php', '_blank', 'resizable,height=200,width=500,scrollbars=yes')" class='vinculoblanco'>Backup de base de datos</a></dd>
	<dd><a href='reiniciar_bd.php' class='vinculoblanco'>Reiniciar BD</a></dd>    
</dl>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<?php } ?>

<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
<dl class="four3">
	<dt><a href="#">Ayuda ?</a></dt>
	<dd><a href='#' onClick="window.open('soporte.php', '_blank', 'resizable,height=220,width=500,scrollbars=yes')" class='vinculoblanco'>Soporte Técnico</a></dd>
</dl>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>


<li>
<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->	

	<dt><a href="destruir_sesion.php"  class="vinculoblanco">Salir</a></dt>



<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
    </ul>
	
	
	
	</td>
  </tr>

</table>
