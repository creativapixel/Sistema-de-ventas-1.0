<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	//session_start();
	require_once('../clases/producto_data.php');
	require_once "../clases/PHPPaging.lib.php";
	
	$paging = new PHPPaging;
	$producto = new  Producto;
	$linea = new Linea;
	$marca = new Marca;
	
/*	include '../clases/cache.php';	
	$cache = new m2Cache();
	$cache->enable();
	$cache->startCache();*/
	
	
	// medir tiempo ejecucion php
	/*include('../clases/benchmark.php');
	time_start();
	echo "Tiempo de consulta: ".time_end();	*/
	//fin		


	if (!isset($_REQUEST['npaginas'])){
		$_REQUEST['npaginas']=30;
	}
	
if($_REQUEST['operacion']==1)
{

			echo '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="9%" align="center" class="cabecera_tabla">ORDEN</td>
                <td width="28%" align="center" class="cabecera_tabla">PRODUCTO</td>
                <td width="16%" align="center" class="cabecera_tabla">MARCA</td>
                <td width="11%" align="center" class="cabecera_tabla">CODIGO</td>
                <td width="10%" align="center" class="cabecera_tabla">UNIDAD</td>
                <td width="10%" align="center" class="cabecera_tabla">PRECIO COSTO </td>
                <td width="10%" align="center" class="cabecera_tabla">PRECIO VENTA </td>
                <td align="center" class="cabecera_tabla" colspan="2">OPCI&Oacute;N</td>
                </tr>';
              
			
	$rs= $producto->precio_listar($_REQUEST['producto'],'1');

	$paging->porPagina($_REQUEST['npaginas']);
	$paging->mostrarAnterior("< Anterior");
	$paging->mostrarSiguiente("Siguiente >");		  
	$paging->agregarConsulta($rs);
	$paging->ejecutar(); 
	
	$j='1';
	while($campo = $paging->fetchResultado()) 
	{
			echo  '<tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver=bgColor="#FFCC00" onMouseOut =bgColor="#F0F0F0">
                <td align="center">'. $j .'</td>
                <td align="center">'. strtoupper($campo['pro_descripcion']) .'</td>
                <td align="center">'. strtoupper($campo['mar_descripcion']) .'</td>				
                <td align="center">'. strtoupper($campo['pro_codigo']) .'</td>
                <td align="center">'. strtoupper($campo['uni_descripcion']).'</td>
                <td align="center">S/. '. $campo['pre_costo'] .'</td>
                <td align="center">S/. '. $campo['pre_precio'] .'</td>
                <td align="center"><a href="precio_editar.php?pre_id='. $campo['pre_id'] .'"><img src="../imagenes/icono_editar.gif" width="14" height="14" border="0"></a></td>
                <td align="center"><a href="#" onClick="borrar('. $campo['pre_id'].')"><img src="../imagenes/icono_eliminar.gif" width="14" height="14" border="0"></a></td>
                </tr>';
			  
			  $j=$j+1;
			  }
			  
            echo "</table>";
}

	//$cache->endCache();
?>