<?php 
require_once "util_data.php";

class Cliente{
	
	public $_util;
	
	public function __construct()
	{
		$util = new Util;
		$this->_util = $util;
	}

	public function cliente_listar()
	{
 		$query="SELECT cli_id,cli_razonsocial,cli_direccion,cli_ruc,cli_eliminado FROM clientes WHERE cli_eliminado='0' ORDER BY cli_razonsocial asc ";

		$rs= $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	
	public function cliente_nuevo($razonsocial,$direccion,$ruc)
	{
		$razonsocial = strtoupper($razonsocial);
				
		if ($this->existe_cliente($razonsocial,$ruc))
			{

		 		$mensaje=  $razonsocial." Ya existe en la base de datos, Registre otro correo para crear una cuenta de usuario ";

				$this->_util->mensaje($mensaje,'4');
							
			}
		else 
			{  

				$query="INSERT INTO clientes(cli_razonsocial,cli_direccion,cli_ruc,cli_eliminado) VALUES ('$razonsocial','$direccion','$ruc','0')";
				$rs = $this->_util->ejecutar_consulta($query,'','1');
				
				$_SESSION['cliente_id']=mysql_insert_id(); 		
				
				return $rs;
	 			
			}				
	}

	public function existe_cliente($razonsocial,$ruc)
	{
		$query="SELECT cli_id,cli_eliminado,cli_razonsocial FROM clientes WHERE ";
		
		if($ruc!='')
		{
			$queryr=" (cli_razonsocial='$razonsocial' OR cli_ruc='$ruc')";
		}
		else
		{	
			$queryr=" cli_razonsocial='$razonsocial'";
		}
		
		$queryf=" AND cli_eliminado='0'";
		
		$query = $query.$queryr.$queryf;
		
		$rs=$this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);

		return $campo['cli_id'];
	}

	public function cliente_borrar($codigo)
 	{
 		$query="UPDATE clientes SET cli_eliminado='1' WHERE cli_id='$codigo'";
 		$rs= $this->_util->ejecutar_consulta($query,'','3');
 		return $rs;
 	}
	
	public function cliente_ver($codigo)
	{
 	  	$query="SELECT * FROM clientes WHERE cli_id='$codigo' AND cli_eliminado='0'";
		
		$rs= $this->_util->ejecutar_consulta($query,'','5');

		if (!($rs))
 	    	{
			
	    	}
		else 
		{
			 $campo=mysql_fetch_array($rs);
		 	 $this->cli_id = $campo['cli_id'];
			 $this->cli_razonsocial = $campo['cli_razonsocial'];
 			 $this->cli_direccion = $campo['cli_direccion'];
			 $this->cli_ruc = $campo['cli_ruc'];
			 return  $this->cli_id;
		 }
	}
	
	public function cliente_editar($razonsocial,$direccion,$ruc,$codigo)
	{
		$query="UPDATE clientes SET cli_razonsocial='$razonsocial',cli_direccion='$direccion',cli_ruc='$ruc' WHERE cli_id='$codigo'";
		
		$rs =  $this->_util->ejecutar_consulta($query,'','2');
		
		return $rs;
	}

	public function generar_select_cliente($nombre,$metodo,$condicion,$cero='',$cero_desc='')
	{
		$rs= $this->cliente_listar();
		$this->_util->genera_select($nombre,$metodo,'cli_id','cli_razonsocial',$rs,$cero,$cero_desc);
	}

}


?>