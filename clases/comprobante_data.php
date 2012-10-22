<?php
require_once "util_data.php";
require_once "parametros_data.php";

class Comprobante
{
	
	public function __construct()
	{
		$this->_util = new Util;	
	}
		
	
	public function tipocomprobante_listar()
	{
		
		$query ="SELECT tipc_id,tipc_descripcion FROM tipo_comprobantes ORDER BY tipc_descripcion ASC";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
		
	}
	
	public function generar_select_tipocomprobante($nombre,$metodo,$condicion,$cero='',$cero_desc='',$valorini='')
	{
		$rs= $this->tipocomprobante_listar();
		
		if($valorini=='')
		{
			$this->_util->genera_select($nombre,$metodo,'tipc_id','tipc_descripcion',$rs,$cero,$cero_desc);
		}
		else
		{
			$this->_util->genera_select_valorini($nombre,$metodo,'tipc_id','tipc_descripcion',$rs,$cero,$cero_desc);
		}
	}
	
	public function estadocomprobante_listar()
	{
		
		$query ="SELECT estc_id,estc_descripcion FROM estado_comprobantes ORDER BY estc_descripcion ASC";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
		
	}
	
	public function generar_select_estadocomprobante($nombre,$metodo,$condicion,$cero='',$cero_desc='')
	{
		$rs= $this->estadocomprobante_listar();
		$this->_util->genera_select($nombre,$metodo,'estc_id','estc_descripcion',$rs,$cero,$cero_desc);
	}
	
	public function modopago_listar()
	{
		
		$query ="SELECT modp_id,modp_descripcion FROM modo_pagos ORDER BY modp_descripcion ASC";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
		
	}
	
	public function generar_select_modopago($nombre,$metodo,$condicion,$cero='',$cero_desc='',$valorini='')
	{
		$rs= $this->modopago_listar();
		
		if($valorini=='')
		{
			$this->_util->genera_select($nombre,$metodo,'modp_id','modp_descripcion',$rs,$cero,$cero_desc);
		}
		else
		{
			$this->_util->genera_select_valorini($nombre,$metodo,'modp_id','modp_descripcion',$rs,$cero,$cero_desc);			
		}
	}
	
	public function devulve_nombre_tipo_comprobante($tipo)
	{
		$query = "SELECT tipc_id,tipc_descripcion FROM tipo_comprobantes WHERE tipc_id='".$tipo."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo = mysql_fetch_array($rs);
		return $campo['tipc_descripcion'];
	}


}


?>