<?php
require_once "util_data.php";


class Parametros
{
	public $_util;
	
	public function __construct()
	{
		$util = new Util;
		$this->_util = $util;
		
		}
	
	public function parametro_ver_codigo($nombre_campo)
	{
		$query = "SELECT ".$nombre_campo." FROM parametros_comprobantes";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		
		$campo= mysql_fetch_array($rs);
		
		$this->_campo = $campo[''.$nombre_campo.''];

		return $this->_campo;
		
	}
	
	public function parametro_aumentar_codigo($nombre_campo)
	{
		$query = "UPDATE parametros_comprobantes SET ".$nombre_campo."=".$nombre_campo."+1";
 		$rs = $this->_util->ejecutar_consulta($query,'','5');
 		return $rs;
	}

	public function parametros_listar()
	{
		
		$query ="SELECT pcom_id,pcom_guia_interna,pcom_recibo_interno,pcom_nro_boleta,pcom_nro_factura,pcom_nota_pedido,pcom_serie_boleta,pcom_serie_factura,pcom_nro_notacredito,pcom_serie_notacredito FROM parametros_comprobantes";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	

	public function parametros_ver($codigo)
	{
		
		$query ="SELECT pcom_id,pcom_guia_interna,pcom_recibo_interno,pcom_nro_boleta,pcom_nro_factura,pcom_nota_pedido,pcom_serie_boleta,pcom_serie_factura,pcom_nro_notacredito,pcom_serie_notacredito FROM parametros_comprobantes WHERE pcom_id='".$codigo."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo = mysql_fetch_array($rs);
		
		$this->_pcom_guia_interna = $campo['pcom_guia_interna'];
		$this->_pcom_recibo_interno = $campo['pcom_recibo_interno'];
		$this->_pcom_nro_boleta = $campo['pcom_nro_boleta'];
		$this->_pcom_nro_factura = $campo['pcom_nro_factura'];
		$this->_pcom_serie_factura = $campo['pcom_serie_factura'];
		$this->_pcom_nota_pedido = $campo['pcom_nota_pedido'];
		$this->_pcom_serie_boleta = $campo['pcom_serie_boleta'];
		$this->_pcom_nro_boleta = $campo['pcom_nro_boleta'];
		$this->_pcom_serie_notacredito = $campo['pcom_serie_notacredito'];
		$this->_pcom_nro_notacredito = $campo['pcom_nro_notacredito'];		
		$this->_pcom_id = $campo['pcom_id'];		
		
		return $this->_pcom_id;
		
	}

	public function parametros_editar($codigo,$guia_interna,$recibo_interno,$serie_notacredito,$numero_notacredito,$serie_factura,$numero_factura,$serie_boleta,$numero_boleta)
	{
		$query="UPDATE parametros_comprobantes SET pcom_guia_interna='".$guia_interna."',pcom_recibo_interno='".$recibo_interno."',pcom_nro_notacredito='".$numero_notacredito."',pcom_serie_notacredito='".$serie_notacredito."',pcom_serie_factura='".$serie_factura."', pcom_nro_factura='".$numero_factura."',pcom_serie_boleta='".$serie_boleta."', pcom_nro_boleta='".$numero_boleta."' WHERE pcom_id=".$codigo."";
 		$rs= $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;		
	}
	
	/**/
	public function parametros_producto_ver()
	{
		
		$query ="SELECT parp_id,parp_codigo FROM parametros_productos";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo = mysql_fetch_array($rs);
		
		return $campo['parp_codigo'];
		
	}	
	
	public function parametro_producto_actualizar()
	{
		$query="UPDATE parametros_productos SET parp_codigo=parp_codigo+1";
 		$rs= $this->_util->ejecutar_consulta($query,'','5');
 		return $rs;
	}

}


?>