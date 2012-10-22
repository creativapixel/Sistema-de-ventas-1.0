<?php
require_once 'util_data.php';
class Marca
{

	public function __construct()
	{
		$util = new Util;
		$this->_util = $util;	
	}

	public function marca_listar($paginado='0')
	{
		$query="SELECT * FROM marcas WHERE mar_eliminado='0' ORDER BY mar_descripcion ASC";
		
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
	
	public function marca_borrar($codigo)
 	{
 		$query="UPDATE marcas SET mar_eliminado='1' WHERE mar_id=$codigo";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
 		return $rs;
 	}
	
	
	public function marca_editar($codigo,$descripcion)
 	{
	$query="UPDATE marcas SET mar_descripcion='$descripcion' WHERE mar_id='$codigo' ";
		$rs = $this->_util->ejecutar_consulta($query,'','2');
 		return $rs;
 	}

	
	public function marca_nuevo($descripcion,$estado)
	{   
		
		$descripcion = strtoupper($descripcion);

 		$query="SELECT mar_descripcion FROM marcas WHERE mar_descripcion='".$descripcion."' AND mar_eliminado='0'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);
		if ($campo['mar_descripcion'])
		{
 			$this->_util->mensaje('La marca '.$descripcion.' ya existe','4');
		}
		else
		{ 
		 	$query="INSERT INTO marcas(mar_descripcion,mar_eliminado) VALUES ('$descripcion','$estado')";
    	 	$rs = $this->_util->ejecutar_consulta($query,'MARCA','5');
		
			$marca_id =mysql_insert_id(); 
			$_SESSION['marca_id']=$marca_id;		
			
			return $rs;
			
		}

   	}					


	public function  marca_ver($codigo)
	{
 	  	$query="SELECT * FROM marcas WHERE mar_id='$codigo' AND mar_eliminado='0'";
    	$rs = $this->_util->ejecutar_consulta($query,'','5');
		
		if (!($rs))
 	    	{
			echo "Hay problemas en la consulta";
	    	}
		else 
			{
			$campo=mysql_fetch_array($rs);
		 	$this->mar_id= $campo['mar_id'];
			$this->mar_descripcion= $campo['mar_descripcion'];
		    return  $this->mar_id;
		 	}
	}	

	public function generar_select_marca($nombre,$metodo,$rsp,$cero='',$cero_desc='')
	{
		if ($rsp==='')
		$rsp= $this->marca_listar($n);		
		$this->_util->genera_select($nombre,$metodo,'mar_id','mar_descripcion',$rsp,$cero,$cero_desc);
	}
	
}
?>