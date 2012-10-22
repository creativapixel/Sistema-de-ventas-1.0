<?php
require_once "util_data.php";
require_once "producto_data.php";


class Ingreso
{
	public $_util;
	
	public function __construct()
	{
		$this->_util = new Util;
		
		}
	
	public function ingresos_listar($fecha)
	{
		
		$fecha=$this->_util->convierte_fecha($fecha);
		
		$query ="SELECT i.ing_id,i.pro_id,i.ing_fecha,i.ing_cantidad,p.pro_id,p.pro_descripcion,p.pro_eliminado FROM ingresos i, productos p WHERE i.pro_id=p.pro_id AND p.pro_eliminado='0' AND i.ing_fecha='".$fecha."' ORDER BY ing_id DESC";

		return $query;
		
	}

	public function ingresos_insertar($producto,$fecha,$cantidad)
	{
		$fecha=$this->_util->convierte_fecha($fecha);		

 		$query1="UPDATE productos SET pro_stock=pro_stock+$cantidad WHERE pro_id=$producto";
		$rs = $this->_util->ejecutar_consulta($query1,'','5');
		
		$query = "INSERT INTO ingresos(pro_id,ing_cantidad,ing_fecha) VALUES ('$producto','$cantidad','$fecha')";
		$rs = $this->_util->ejecutar_consulta($query,'','1');		
		return $rs;
	
	}
	
	public function ingresos_borrar($ingreso,$producto,$cantidad)
	{
		
	   	$query="DELETE FROM ingresos WHERE  ing_id='$ingreso'";
	   	$rs = $this->_util->ejecutar_consulta($query,'','5'); 
	   	
		$query2="UPDATE productos SET pro_stock=pro_stock-'$cantidad' WHERE pro_id='$producto'";
		$rs2 = $this->_util->ejecutar_consulta($query2,'','5');
		
		return $rs2;
	}	


	public function ingresos_listar_fecha($fechai,$fechaf)
	{
	  	$fechai= $this->_util->convierte_fecha($fechai);
  		$fechaf= $this->_util->convierte_fecha($fechaf);	
		
		$query ="SELECT i.ing_id,i.pro_id,i.ing_fecha,i.ing_cantidad,p.pro_id,p.pro_descripcion,p.pro_eliminado FROM ingresos i, productos p WHERE i.pro_id=p.pro_id AND p.pro_eliminado='0' AND i.ing_fecha BETWEEN '".$fechai."' AND '".$fechaf."' ORDER BY i.ing_fecha DESC";
		
		$rs = $this->_util->ejecutar_consulta($query,'','5');		
		return $rs;
	}


}


?>