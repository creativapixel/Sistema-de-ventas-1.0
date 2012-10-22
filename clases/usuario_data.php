<?php 
require_once "util_data.php";

class Usuario{
	
	public $_util;
	
	public function __construct()
	{
		$util = new Util;
		$this->_util = $util;
	}

	public function usuario_listar()
	{
 		$query="select usu_id,CONCAT(usu_nombres,', ', usu_apellidos) as nombres,usu_direccion,usu_clave,usu_eliminado,usu_telefono,usu_tipo,usu_usuario FROM usuarios WHERE usu_eliminado='0' ORDER BY usu_tipo,nombres asc ";

		$rs= $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	
	public function usuario_nuevo($tipo,$nombres,$apellidos,$direccion,$telefono,$clave,$estado,$usuario)
	{
		
		if ($this->existe_usuario($usuario))
			{

		 		$mensaje=  $usuario." Ya existe en la base de datos, Registre otro correo para crear una cuenta de usuario ";

				$this->_util->mensaje($mensaje,'4');
							
			}
		else 
			{  


				$usuario=trim($usuario);
  				$clave= md5($clave);
				$query="INSERT INTO usuarios(usu_tipo,usu_nombres,usu_apellidos,usu_direccion,usu_telefono,usu_clave,usu_eliminado,usu_usuario) VALUES ('$tipo','$nombres','$apellidos','$direccion','$telefono','$clave','$estado','$usuario')";
				$this->_util->ejecutar_consulta($query,'','1');
	 			

			}				
	}

	public function existe_usuario($usuario)
	{
		$query="SELECT usu_id,usu_eliminado,usu_usuario FROM usuarios WHERE usu_usuario='$usuario' AND usu_eliminado='0'";
		$rs=$this->_util->ejecutar_consulta($query,'','5');
		$campo=mysql_fetch_array($rs);

		return $campo['usu_id'];
	}

	public function  usuario_cambiarclave($clavea,$clave,$codigo_id)
	{
	
	    $query="SELECT usu_clave FROM usuarios WHERE usu_clave='".md5($clavea)."' AND usu_id='$codigo_id' AND usu_eliminado='0'";
	 	$rs= $this->_util->ejecutar_consulta($query,'CLAVE ANTIGUA','5');
		$campo =mysql_fetch_array($rs);
		
		if($campo['usu_clave'])
		{
			 	
			$query="UPDATE usuarios SET usu_clave='".md5(trim($clave))."' WHERE usu_id='$codigo_id'";
			$rs= $this->_util->ejecutar_consulta($query,'Clave cambiada con exito','4');
			echo "<h5> Nueva Clave: $clave </h5>";
			return $rs;		
		} 
		else
		{
				 echo "<script>alert('La clave anterior no existe en la base de datos');</script>";
		 }

	}

	public function usuario_borrar($codigo)
 	{
 		$query="UPDATE usuarios SET usu_eliminado='1' WHERE usu_id='$codigo'";
 		$rs= $this->_util->ejecutar_consulta($query,'','3');
 		return $rs;
 	}
	
	public function usuario_ver($codigo)
	{
 	  	$query="SELECT * FROM usuarios WHERE usu_id='$codigo' AND usu_eliminado='0'";
		
		$rs= $this->_util->ejecutar_consulta($query,'','5');

		if (!($rs))
 	    	{
			
	    	}
		else 
		{
			 $campo=mysql_fetch_array($rs);
		 	 $this->usu_id = $campo['usu_id'];
			 $this->usu_tipo = $campo['usu_tipo'];
			 $this->usu_nombres = $campo['usu_nombres'];
			 $this->usu_apellidos = $campo['usu_apellidos'];
 			 $this->usu_direccion = $campo['usu_direccion'];
			 $this->usu_clave = $campo['usu_clave'];
			 $this->usu_movil = $campo['usu_eliminado'];
			 $this->usu_usuario = $campo['usu_usuario'];
			 return  $this->usu_id;
		 }
	}
	
	public function usuario_editar($nombres,$apellidos,$direccion,$telefono,$usuario,$codigo,$tipo)
	{
		$query="UPDATE usuario SET usu_nombres='$nombres',usu_apellidos='$apellidos',usu_direccion='$direccion',usu_telefono='$telefono',usu_usuario='$usuario',usu_tipo='$tipo' WHERE usu_id='$codigo'";
		
		$rs =  $this->_util->ejecutar_consulta($query,'','2');
		
		return $rs;
	}

	public function usuario_validar($usuario,$clave,$area)
	{ 
		
		$usuario = mysql_escape_string($usuario);
		$clave = md5(mysql_escape_string($clave));
	 
		$query="SELECT usu_id,usu_tipo,usu_nombres,usu_apellidos,usu_direccion,usu_telefono,usu_usuario,usu_clave,usu_eliminado FROM usuarios WHERE usu_usuario='$usuario' and  usu_clave='$clave' and usu_eliminado='0'";
		
		$rs= $this->_util->ejecutar_consulta($query,'','5');
	
		$campo = mysql_fetch_array($rs);
	
		if (!($campo['usu_usuario']))
		{
			
			echo "<script> alert('Nombre de Usuario o Clave Incorrecta');</script>";
 		
		}
		
		else
		{

			$_SESSION['sesion_id_usuario']= $campo['usu_id'];
			$_SESSION['sesion_id_area'] = $area;
			$this->referencia('1');
		}
	 
		

	}
             
	
	public function referencia($sistema)
	{ 
		switch ($sistema)
		{
			case '1':
			{
				$this->devuelve_ruta('formularios/consola.php'); 	 	
				break; 
			}  
		}
	}

	public function devuelve_ruta($href)
	{ 
	   
		echo  "<script LANGUAGE='JavaScript'> document.location.href='$href';  </script>"; 
	
	
	}
	
	public function  usuario_destruir_sesion()
	{
	
		unset($_SESSION['sesion_id_usuario']);
		session_destroy();
		$this->devuelve_ruta('../index.php');  

	}
 
 	public function area_listar()
	{
		$query="SELECT are_id,are_descripcion,are_eliminado FROM areas WHERE are_eliminado='0' ORDER BY are_descripcion asc";
		
		$rs= $this->_util->ejecutar_consulta($query,'','5');
		return $rs;
	}
	
	public function generar_select_area($nombre,$metodo,$rs,$cero='',$cero_desc='')
	{
  		$rs= $this->area_listar();
		$this->_util->genera_select($nombre,$metodo,'are_id','are_descripcion',$rs,$cero,$cero_desc);
	}
	
	public function devuelve_area($area)
	{
		$query="SELECT are_descripcion FROM areas WHERE are_eliminado='0' AND are_id='$area'";
		$rs= $this->_util->ejecutar_consulta($query,'','5');
		$campo =mysql_fetch_array($rs);
		return $campo['are_descripcion'];
	}	
	
	
	
	
	
	
	


	/*function  area_ver($area)
	{
 	  	$query="select * from areas where area_id='$area' and area_eliminado='0'";
		$rs= mysql_query($query,$this->con->cn);
		if (!($rs))
 	    	{
			Echo "Hay problemas en la consulta";
	    	}
		else 
			{
			$campo=mysql_fetch_array($rs);
		 	$this->area_id= $campo['area_id'];
			$this->area_descripcion= $campo['area_descripcion'];
		    return  $this->area_id;
		 	}
	}







	function area_borrar($codigo)
 	{
 		$query="update areas set area_eliminado='1' where area_id=$codigo";
 		$rs= $this->util->query($query,'AREA: DATOS ELIMINADOS','1');
 		return $rs;
 	}*/


		

}


?>