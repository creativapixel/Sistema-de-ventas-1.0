<?php
//require_once "util_data.php";
require_once "linea_data.php";
require_once "marca_data.php";

class Producto
{
	//public $_util;
	public function __construct()
	{
		$this->_util = new Util;
		
	}
		
	public function producto_listar($linea='0',$tipo_paginado='1',$marca='0')
	{
		$query ="SELECT p.pro_id,p.lin_id,p.mar_id,p.pro_descripcion,p.pro_codigo,p.pro_stock,p.pro_eliminado,m.mar_id,m.mar_descripcion,l.lin_id,l.lin_descripcion,CONCAT(p.pro_descripcion,' - ',p.pro_codigo,' - ',m.mar_descripcion) AS producto_marca FROM productos p, marcas m, lineas l WHERE p.lin_id=l.lin_id AND p.mar_id=m.mar_id AND p.pro_eliminado='0' AND m.mar_eliminado='0' AND l.lin_eliminado='0'";
		
		if($linea=='0')
		{
			$query1=" ";
			}
		else
		{
			$query1=" AND p.lin_id='".$linea."'";			
			}
			
		if($marca=='0')
		{
			$query2=" ";
			}
		else
		{
			$query2=" AND p.mar_id='".$marca."'";			
			}			
		
	    $query3=" ORDER BY p.mar_id,p.pro_descripcion ASC";
		
	    $query=$query.$query1.$query2.$query3;

		if ($tipo_paginado=='0')
		{
			$rs= $this->_util->ejecutar_consulta($query,'','5');
			return $rs;
		}
		
		if ($tipo_paginado=='1')
		{		
			return $query;
		}
	}
	
	public function producto_nuevo($linea,$marca,$descripcion,$stock,$estado,$codigo)
	{
		$descripcion = strtoupper($descripcion);
		
		$query="SELECT pro_id,mar_id,pro_descripcion,pro_eliminado FROM productos WHERE pro_descripcion='".$descripcion."'AND mar_id='".$marca."' AND pro_eliminado='0'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		
		if ($campo['pro_descripcion'])
		{
 			$this->_util->mensaje('El producto ya se encuentra registrado. Verifique por favor!!','4');
		}
		else
		{ 
			$query = "INSERT INTO productos(lin_id,mar_id,pro_descripcion,pro_stock,pro_eliminado,pro_codigo) VALUES ('$linea','$marca','$descripcion','$stock','$estado','$codigo')";
			$rs = $this->_util->ejecutar_consulta($query,'','1');		
			return $rs;
		}
	}

	public function producto_borrar($codigo)
	{
		$query="UPDATE productos SET  pro_eliminado='1'  WHERE  pro_id = '$codigo'";
	 	$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}	
	
	public function  producto_ver($codigo)
	{
 	  	$query="SELECT pro_id,lin_id,mar_id,pro_descripcion,pro_eliminado,pro_codigo,pro_stock FROM productos WHERE pro_id='$codigo' AND pro_eliminado='0'";
	  $rs = $this->_util->ejecutar_consulta($query,'','5');		
		
		if (!($rs))
 	    	{
			echo "Hay problemas en la consulta";
	    	}
		else 
			{
			$campo=mysql_fetch_array($rs);
		 	$this->pro_id= $campo['pro_id'];
		 	$this->lin_id= $campo['lin_id'];
		 	$this->mar_id= $campo['mar_id'];
		 	$this->pro_descripcion= $campo['pro_descripcion'];
		 	$this->pro_stock= $campo['pro_stock'];
		 	$this->pro_codigo= $campo['pro_codigo'];
		    return  $this->pro_id;
		 	}
	}	
//		$producto->productos_editar($_REQUEST['tipoproducto'],$_REQUEST['descripcion'],$_REQUEST['stock'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['moneda']);

	public function producto_editar($id,$linea,$marca,$descripcion,$stock,$codigo)
	{
 		$query="UPDATE productos SET lin_id='$linea', pro_descripcion='$descripcion',pro_stock='$stock',mar_id='$marca',pro_codigo='$codigo' WHERE pro_id='$id'";
 		$rs= $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;		
	}

	public function unidad_listar()
	{
		
		$query ="SELECT uni_id,uni_descripcion,uni_factor FROM unidades WHERE uni_eliminado='0' ORDER BY uni_descripcion ASC";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
		
	}
	
	public function generar_select_unidad($nombre,$metodo,$condicion,$cero='',$cero_desc='')
	{
		$rs= $this->unidad_listar();
		$this->_util->genera_select($nombre,$metodo,'uni_id','uni_descripcion',$rs,$cero,$cero_desc);
	}
	
	public function generar_select_unidad_precio($nombre,$metodo,$producto,$cero='',$cero_desc='')
	{
		$query= $this->precio_listar($producto);
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$this->_util->genera_select($nombre,$metodo,'pre_id','precio_unidad',$rs,$cero,$cero_desc);
	}
	
	public function generar_select_producto($nombre,$metodo,$linea,$marca,$cero='',$cero_desc='')
	{
		$rs= $this->producto_listar($linea,'0',$marca);
		$this->_util->genera_select($nombre,$metodo,'pro_id','producto_marca',$rs,$cero,$cero_desc);
	}
	
	public function generar_select_producto_total($nombre,$metodo,$linea,$marca,$cero='',$cero_desc='')
	{
		$rs= $this->producto_listar($linea,'0',$marca);
		$this->_util->genera_select_valorini($nombre,$metodo,'pro_id','producto_marca',$rs,$cero,$cero_desc);
	}	
	
	/*public function producto_listar_combo($linea='0',$marca='0')
	{
		
		$query ="SELECT p.pro_id,p.lin_id,p.mar_id,p.pro_descripcion,p.pro_stock,p.pro_eliminado,m.mar_id,m.mar_descripcion,l.lin_id,l.lin_descripcion FROM productos p, marcas m, lineas l WHERE p.lin_id=l.lin_id AND p.mar_id=m.mar_id AND p.pro_eliminado='0'"; 
		
		if($linea=='0')
		{
			$query1=" ";
		}
		else
		{
			$query1=" AND p.lin_id='".$linea."'";			
		}
		
		if($marca=='0')
		{
			$query2=" ";
		}
		else
		{
			$query2=" AND p.mar_id='".$marca."'";			
		}
		
		$query3=" ORDER BY p.pro_descripcion ASC";
		
		echo $query=$query.$query1.$query2.$query3;

		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}	*/
	
	public function precio_insertar($producto,$unidad,$precio,$costo)
	{
		$querys = "SELECT pre_id,uni_id,pro_id FROM precios WHERE uni_id='".$unidad."' AND pro_id='".$producto."' AND pre_eliminado='0'";
		$rss = $this->_util->ejecutar_consulta($querys,'','5');
		
		$campo=mysql_fetch_array($rss);
		
		if ($campo['uni_id'])
		{
 			$this->_util->mensaje('La unidad seleccionada ya tiene precio!','4');
		}
		else
		{ 	
			$query = "INSERT INTO precios(pro_id,uni_id,pre_precio,pre_eliminado,pre_costo) VALUES ('$producto','$unidad','$precio','0','$costo')";
			$rs = $this->_util->ejecutar_consulta($query,'','1');	
			return $rs;
		}
	}	
	
	public function precio_borrar($codigo)
	{
		$query="UPDATE precios SET  pre_eliminado='1'  WHERE  pre_id = '$codigo'";
	 	$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}	
	
	public function disminuye_stock($producto,$cantidad)
	{
		$query="UPDATE productos SET  pro_stock=pro_stock - ".$cantidad."  WHERE  pro_id = '".$producto."'";
	 	$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}		
	
	public function precio_listar($producto,$busqueda=0)
	{
		$query ="SELECT pr.pre_id,pr.pro_id,p.pro_codigo,pr.uni_id,pr.pre_precio,pr.pre_costo,pr.pre_eliminado, u.uni_descripcion, p.pro_descripcion, CONCAT(u.uni_descripcion,'  S/. ',pr.pre_precio) AS precio_unidad, CONCAT(p.pro_descripcion,' ',p.pro_codigo) AS precio_producto, m.mar_descripcion FROM precios pr, productos p, unidades u, marcas m WHERE pr.pro_id=p.pro_id AND p.mar_id=m.mar_id AND pr.uni_id=u.uni_id AND pr.pre_eliminado='0'";
		
		if($busqueda==0)
		{
			$query2 = " AND pr.pro_id='".$producto."'";
		}
		
		if($busqueda==1)
		{
			$query3 = " AND (p.pro_descripcion LIKE '%".$producto."%' OR p.pro_codigo LIKE '%".$producto."%')";
			
			//$query3 = " AND MATCH(p.pro_descripcion) AGAINST ('*".$producto."*' IN BOOLEAN MODE)";
			
		}
		
		$queryn = " ORDER BY pr.pre_precio ASC";
		
		$query = $query.$query2.$query3.$queryn;
				

		//$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $query;
	}
	
	public function tipomoneda_listar()
	{
		$query ="SELECT tipm_id,tipm_descripcion FROM tipo_moneda ORDER BY tipm_descripcion ASC";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	
	public function generar_select_tipomoneda($nombre,$metodo,$condicion,$cero='',$cero_desc='')
	{
		$rs= $this->tipomoneda_listar();
		$this->_util->genera_select($nombre,$metodo,'tipm_id','tipm_descripcion',$rs,$cero,$cero_desc);
	}

	public function unidad_nuevo($descripcion,$factor)
	{
		$descripcion = strtoupper($descripcion);
		
		$query="SELECT uni_id,uni_descripcion,uni_factor FROM unidades WHERE uni_descripcion='".$descripcion."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		
		if ($campo['uni_descripcion'])
		{
 			$this->_util->mensaje('La Unidad '.$descripcion.' ya existe','4');
		}
		else
		{ 
			$query = "INSERT INTO unidades(uni_descripcion,uni_factor,uni_eliminado) VALUES ('$descripcion','$factor','0')";
			$rs = $this->_util->ejecutar_consulta($query,'','1');		
	
			return $rs;
		}
	}

	public function unidad_borrar($codigo)
	{
		$query="UPDATE unidades SET uni_eliminado='1'  WHERE  uni_id = '$codigo'";
	 	$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	
	public function unidad_ver($codigo)
	{
 	  	$query="SELECT * FROM unidades WHERE uni_id='$codigo' AND uni_eliminado='0'";
    	$rs = $this->_util->ejecutar_consulta($query,'','5');
		
		if (!($rs))
 	    	{
			echo "Hay problemas en la consulta";
	    	}
		else 
			{
			$campo=mysql_fetch_array($rs);
		 	$this->uni_id= $campo['uni_id'];
			$this->uni_descripcion= $campo['uni_descripcion'];
			$this->uni_factor= $campo['uni_factor'];			
		    return  $this->uni_id;
		 	}
	}		

// $producto->precio_editar($_REQUEST['pre_id'],$_REQUEST['producto'],$_REQUEST['unidad'],$_REQUEST['precio'],$_REQUEST['costo']);

	public function precio_editar($codigo,$producto,$unidad,$precio,$costo)
 	{
		echo $query="UPDATE precios SET pro_id='$producto',uni_id='$unidad', pre_costo='$costo', pre_precio='$precio' WHERE pre_id='$codigo' ";
		$rs = $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;
 	}
	
	public function unidad_editar($codigo,$descripcion,$factor)
 	{
		$query="UPDATE unidades SET uni_descripcion='$descripcion',uni_factor='$factor' WHERE uni_id='$codigo' ";
		$rs = $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;
 	}	

	public function ver_precio($codigo)
	{
		$query="SELECT pre_precio FROM precios WHERE pre_id='$codigo'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		return $campo['pre_precio'];
	}
	
	public function precio_mostrar($codigo)
	{
 	  	$query="SELECT pre.pre_id,pre.pre_precio,pre.pre_costo,pre.pre_eliminado,pre.uni_id,p.pro_id,p.lin_id,p.mar_id FROM precios pre, productos p WHERE pre.pro_id=p.pro_id AND pre.pre_id='$codigo' AND pre.pre_eliminado='0'";
    	$rs = $this->_util->ejecutar_consulta($query,'','5');

		if (!($rs))
 	    	{
			echo "Hay problemas en la consulta";
	    	}
		else
			{
			$campo=mysql_fetch_array($rs);
		 	$this->pre_id= $campo['pre_id'];
		 	$this->uni_id= $campo['uni_id'];
			$this->lin_id= $campo['lin_id'];
			$this->mar_id= $campo['mar_id'];
			$this->pro_id= $campo['pro_id'];
			$this->pre_costo= $campo['pre_costo'];
			$this->pre_precio= $campo['pre_precio'];
		    return  $this->pre_id;
		 	}
	}

	public function ver_factor_precio($codigo)
	{
		$query="SELECT p.pre_id,p.uni_id,u.uni_factor FROM precios p, unidades u WHERE p.uni_id=u.uni_id AND p.pre_id='$codigo'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		return $campo['uni_factor'];
	}

	/*public function ver_precio_producto($producto)
	{
		$query="SELECT pro_precio FROM productos WHERE pro_id='$producto'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		return $campo['pro_precio'];
		
		}

	public function verificar_stock($producto,$cantidad)
	{
		echo $query="SELECT pro_id,pro_stock,pro_eliminado FROM productos WHERE pro_id='".$producto."' AND pro_eliminado='0' AND pro_stock<'".$cantidad."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		return $campo['pro_id'];
		
		
	}*/		

	public function ver_stock_producto($producto)
	{
		$query="SELECT pro_id,pro_eliminado,pro_stock FROM productos WHERE pro_id='$producto' AND pro_eliminado='0'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		return $campo['pro_stock'];
	}

}
?>
