<?php 
require_once( "usuario_data.php");
//require_once("carrito_data.php");
require_once("util_data.php");

class sessiondata
{
		var   $n='2';
		var   $usuario='';
		var   $util ='';

		function sessiondata()
		{   
			$this->usuario = new usuariodata();
			$this->util =  new   utildata();
			$this->util->cn =$this->usuario->con->cn;
		}
	
		function validausuario($email,$clave)
		{
			$email=mysql_escape_string($email);
			$clave=mysql_escape_string($clave);

	 		if( $this->usuario->usu_validar($email,$clave))
			{
				$_SESSION['usu_email'] =$email;
 			  	$_SESSION['usu_nombres'] =$this->usuario->usu_nombres;
			  	$_SESSION['usu_apellidos'] =$this->usuario->usu_apellidos;
			  	$_SESSION['usu_id'] =   $this->usuario->usu_id;
			  	$_SESSION['usu_direccion']=$this->usuario->usu_direccion;
			  	$_SESSION['usu_telefono']=$this->usuario->usu_telefono;
			  	$_SESSION['usu_dni']=$this->usuario->usu_dni;
				$_SESSION['usu_tipo']=$this->usuario->usu_tipo;
				$sistema=$_SESSION['usu_tipo'];
			  	$this->n='1';


			}
	
			$this->referencia($sistema,$this->n);
         }      
             
	

	function referencia($sistema,$n)
	{ 
		switch ($sistema)
		{
			 case '1':{
			 			if($n==='1')
					    $this->devuelve_ruta('administrador/consola.php'); 	 	
			 			break; 
					  }
			 case '2':{ 
			 
			 			if ($_SESSION['area']==='1')
						{
			 
			 						echo "<script> alert('Usted no tiene acceso a esta Area') </script>";
			 }
			 else
			 {
			         	 if($n==='1')
					     $this->devuelve_ruta('administrador/consola.php'); 
						 break;
					  }
			}		  
		}
	}

	function devuelve_ruta($href)
	{ 
	   
		 echo  "<script LANGUAGE='JavaScript'> document.location.href='$href';  </script>"; 
	
	
	}
	
	function  destruir_sesion($href,$n)
	{
	
	          unset($_SESSION['usu_email']);
 			  unset($_SESSION['usu_nombres']);
			  unset($_SESSION['usu_apellidos']);
			  unset($_SESSION['usu_id']);
			  unset($_SESSION['usu_direccion']);
			  unset($_SESSION['usu_dni']);
			  unset($_SESSION['usu_telefono']);
			  unset($_SESSION['usu_tipo']);
			  $this->n='2';
		
		if ($n !='1')
		{
			session_destroy();
		}

		if ($href!='')
		{
			$this->devuelve_ruta($href);  
		}
	}

}
	

?>
