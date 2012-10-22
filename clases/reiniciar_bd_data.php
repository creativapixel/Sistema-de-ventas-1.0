<?php
require_once "util_data.php";

class Reiniciar
{
	public $_util;
	
	public function __construct()
	{
		$this->_util = new Util;
	}
	
	public function vaciar_tabla($tabla)
	{
		echo $query = "TRUNCATE TABLE ".$tabla." ";
		$rs = mysql_query($query);		
		return $rs;		
	}
	
	public function actualizar_tabla($tabla,$campo,$valor,$where='')
	{
		$query = "UPDATE ".$tabla." SET ".$campo."='".$valor."' ".$where."";
		$rs = mysql_query($query);		
		return $rs;		
	}	

}


?>