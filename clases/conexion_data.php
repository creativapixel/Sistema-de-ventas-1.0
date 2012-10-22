<?php

class Conexion
{
	private $_bdata;
	private $_servidor;
	private $_usuario;
	private $_clave;
	
	//numero de error y texto del error */
	private  $_Erno=0;
	private  $_Error="";
	
	public function __construct($bdata='bdventas',$servidor='localhost',$usuario='root',$clave= '')
	{
		$this->_bdata = $bdata;
		$this->_servidor = $servidor;
		$this->_usuario = $usuario;
		$this->_clave = $clave;
	}

	public function conectar()
	{ 
	
		$this->_cn = @mysql_connect($this->_servidor,$this->_usuario,$this->_clave,$this->_bdata);
		mysql_select_db($this->_bdata);
	
		if (!($this->_cn))
  		{ 
		    $this->_Error="Ha fallado la conexion.";
			return 0;
 		}

		
    	if  (!mysql_select_db($this->_bdata))
  		{ 
	    	$this->_Error="Imposible abrir Base de datos.";
			return 0;
 		} 
		
		return $this->_cn;
	
	}   
	
	public function desconectar()
	{
		mysql_close($this->_cn);
	}
		
}

?>