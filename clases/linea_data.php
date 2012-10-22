<?php
require_once 'util_data.php';
class Linea
{
	public function __construct()
	{
		$util = new Util;
		$this->_util = $util;	
	}

	public function linea_listar($paginado='0')
	{
		$query="SELECT * FROM lineas WHERE lin_eliminado='0' ORDER BY lin_descripcion ASC";
		
		if($paginado=='1')
		{
			return $query;
		}
		else
		{
			$rs = $this->_util->ejecutar_consulta($query,'','5');		
			return $rs;
		}
	}
	
	public function linea_borrar($codigo)
 	{
 		$query="UPDATE lineas SET lin_eliminado='1' WHERE lin_id=$codigo";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
 		return $rs;
 	}
		
	public function linea_editar($codigo,$descripcion)
 	{
		$query="UPDATE lineas SET lin_descripcion='$descripcion' WHERE lin_id='$codigo' ";
		$rs = $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;
 	}

	public function linea_nuevo($descripcion,$estado)
	{   
		$descripcion = strtoupper($descripcion);	

 		$query="SELECT lin_descripcion FROM lineas WHERE lin_descripcion='".$descripcion."' AND lin_eliminado='0'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		if ($campo['lin_descripcion'])
		{
 			$this->_util->mensaje('La linea '.$descripcion.' ya existe','4');
		}
		else
		{ 
		 	$query="INSERT INTO lineas(lin_descripcion,lin_eliminado) VALUES ('$descripcion','$estado')";
    	 	$rs = $this->_util->ejecutar_consulta($query,'linea','5');
		
			$linea_id =mysql_insert_id(); 
			$_SESSION['linea_id']=$linea_id;		
			
			return $rs;
			
		}

   	}

	public function  linea_ver($codigo)
	{
 	  	$query="SELECT * FROM lineas WHERE lin_id='$codigo' AND lin_eliminado='0'";
    	$rs = $this->_util->ejecutar_consulta($query,'','5');
		
		if (!($rs))
 	    	{
			echo "Hay problemas en la consulta";
	    	}
		else 
			{
			$campo=mysql_fetch_array($rs);
		 	$this->lin_id= $campo['lin_id'];
			$this->lin_descripcion= $campo['lin_descripcion'];
		    return  $this->lin_id;
		 	}
	}	

	public function generar_select_linea($nombre,$metodo,$rsp,$cero='',$cero_desc='')
	{
		if ($rsp==='')
		$rsp= $this->linea_listar($n);		
		$this->_util->genera_select($nombre,$metodo,'lin_id','lin_descripcion',$rsp,$cero,$cero_desc);
	}
}
?>