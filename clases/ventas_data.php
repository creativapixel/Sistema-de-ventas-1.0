<?php
require_once "util_data.php";
require_once "pedidos_data.php";
require_once "comprobante_data.php";

class Venta
{
	public $_util;
	
	public function __construct()
	{
		$this->_util = new Util;
		
	}
	
	public function grabar_venta($pedido,$cliente,$tipo_documento,$nro_documento,$serie_documento)
	{
		
		$query = "INSERT INTO ventas(ped_id,cli_id,ven_fecha,ven_estado,ven_nrodoc,tipc_id,ven_seriedoc) VALUES ('$pedido','$cliente','".date('y-m-d')."','0','$nro_documento','$tipo_documento','$serie_documento')";
		$rs = mysql_query($query);		
		$_SESSION['venta_codigo'] = mysql_insert_id(); 
		return $rs;		
	}
	
	public function grabar_detalle_venta($venta,$producto,$cantidad,$unidades,$precio_cantidad,$total_cantidad,$precio_unidad,$precio_total)
	{
		$query = "INSERT INTO detalle_ventas(ven_id,pro_id,ven_cantidad,ven_unidades,ven_precio_cantidad,ven_totalcantidad,ven_preciounidades,ven_preciototal) VALUES ('$venta','$producto','$cantidad','$unidades','$precio_cantidad','$total_cantidad','$precio_unidad','$precio_total')";
		$rs = $this->_util->ejecutar_consulta($query,'','5');		
		return $rs;			
	}
	
	public function ventas_ver($codigo)
	{
		$query = "SELECT v.ven_id,v.cli_id,v.ven_fecha,v.ven_estado,v.tipc_id,v.ven_nrodoc,c.cli_razonsocial,c.cli_ruc,c.cli_direccion FROM ventas v, clientes c WHERE v.cli_id=c.cli_id AND v.ven_id='".$codigo."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo = mysql_fetch_array($rs);
		$this->ven_id = $campo['ven_id'];
		$this->cli_id = $campo['cli_id'];		
		$this->cli_razonsocial = $campo['cli_razonsocial'];			
		$this->cli_ruc = $campo['cli_ruc'];			
		$this->cli_direccion = $campo['cli_direccion'];						
		$this->ven_fecha = $campo['ven_fecha'];		
		$this->ven_estado = $campo['ven_estado'];		
		$this->ven_tipodoc = $campo['ven_tipodoc'];		
		$this->ven_nrodoc = $campo['ven_nrodoc'];		
		return $this->ven_id;
	}
	
	public function ver_tipodocumento($codigo)
	{
		if($codigo=='1')
		{
			$valor = "BOLETA";
		}
		
		if($codigo=='2')
		{
			$valor = "NOTA DE CREDITO";
		}
		
		return $valor;		
	}
	
	public function ventas_listar($fecha,$paginado='0')
	{
		$fecha = $this->_util->convierte_fecha($fecha);
		$query ="SELECT v.ven_id,v.cli_id,v.ven_fecha,v.ven_estado,c.cli_razonsocial,c.cli_ruc,c.cli_direccion,v.tipc_id,v.ven_nrodoc,v.ven_seriedoc FROM ventas v, clientes c WHERE v.cli_id=c.cli_id AND v.ven_fecha='".$fecha."' ORDER BY ven_id DESC";

		if($paginado=='0')
		{
			return $query;
		}
		else
		{
			$rs = $this->_util->ejecutar_consulta($query,'','5');
			return $rs;
		}
	}
	
	public function detalle_ventas_listar($venta)
	{
		$query = "SELECT v.dve_id,v.pro_id,v.ven_id,v.ven_cantidad,v.ven_unidades,v.ven_precio_cantidad,v.ven_totalcantidad,v.ven_preciounidades,v.ven_preciototal,p.pro_descripcion FROM detalle_ventas v, productos p WHERE v.pro_id=p.pro_id AND v.ven_id='".$venta."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;		
	}
	
	public function ventas_ver_estado($estado)
	{
		/*if($estado=='2')
		{
			$valor = "<span style='color:#F00'>En Proceso</span>";
		}*/
		if($estado=='0')
		{
			$valor = "<span style='color:#03C'>Atendido</span>";
		}
		if($estado=='3')
		{
			$valor = "<span style='color:#F00'>Anulado</span>";
		}
		
		return $valor;
	}
	
	public function ventas_listar_fecha($fechai,$fechaf,$cliente='',$agrupacion='')
	{
	  	$fechai= $this->_util->convierte_fecha($fechai);
  		$fechaf= $this->_util->convierte_fecha($fechaf);			
		$query ="SELECT v.ven_id,v.ven_fecha,v.ped_id,c.cli_razonsocial,c.cli_id,v.ven_estado,v.tipc_id,v.ven_nrodoc FROM ventas v, clientes c WHERE v.cli_id=c.cli_id AND v.ven_fecha BETWEEN '".$fechai."' AND '".$fechaf."' AND v.ven_estado='0'";
		
		if($cliente!='')
		{
			$query2=" AND v.cli_id='".$cliente."'";
		}
		if($agrupacion!='')
		{
			$queryg=" GROUP BY ".$agrupacion."";
		}
		
		$queryf=" ORDER BY v.ven_fecha DESC";		
		
		$query = $query.$query2.$queryg.$queryf;
		
		$rs = $this->_util->ejecutar_consulta($query,'','5');		
		return $rs;
		
	}
	
	public function detalleventas_listar($comprobante)
	{
		echo $query ="SELECT dv.dve_id,dv.pro_id,dv.ven_id,dv.ven_cantidad,dv.ven_unidades.dv.ven_precio_cantidad,dv.ven_totalcantidad,dv.ven_preciounidades,dv.ven_preciototal,p.pro_id,p.pro_descripcion FROM detalle_ventas dv, productos p WHERE dv.pro_id=p.pro_id AND dv.ven_id='".$comprobante."'";		
		$rs = $this->_util->ejecutar_consulta($query,'','5');		
		return $rs;
		
	}	

	function venta_anular($venta)
	{
		
	   	$query="UPDATE ventas SET ven_estado='3' WHERE  ven_id='$venta'";
	   	$rs = $this->_util->ejecutar_consulta($query,'','5'); 
		
		$rsd = $this->detalle_ventas_listar($venta);
		
		while($campo = mysql_fetch_array($rsd))
	   	{
			$producto = $campo['pro_id'];
			$cantidad = $campo['ven_cantidad'] +  $campo['ven_unidades'];
			
			$query2="UPDATE productos SET pro_stock=pro_stock+'$cantidad' WHERE pro_id='$producto'";
			$rs2 = $this->_util->ejecutar_consulta($query2,'','5');
		}
		return $rs;
	}


}


?>
