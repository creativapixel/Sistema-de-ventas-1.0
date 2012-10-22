<?php
require_once 'conexion_data.php';

class Util
{

	public $_cn;
	public $_conecta;

	public function __construct()
	{
		$cn = new Conexion;
		$this->_cn = $cn;
		
		$this->_conecta = $this->_cn->conectar();
		return $this->_conecta;
		
		}

	public function eliminar_blancos($cadena){
         $cadena = trim($cadena);
         $cadena = preg_replace('/\s(?=\s)/', '', $cadena);
         $cadena = preg_replace('/[\n\r\t]/', ' ', $cadena);
         return $cadena;
	}  

	public function calcular_edad($fecha_nac)
	{
		$dia=date("j");
		$mes=date("n");
		$anno=date("Y");
		$dia_nac=substr($fecha_nac, 8, 2);
		$mes_nac=substr($fecha_nac, 5, 2);
		$anno_nac=substr($fecha_nac, 0, 4);
	
		if($mes_nac>$mes)
		{
			$calc_edad = $anno - $anno_nac - 1;
		}
		else
		{
			if($mes==$mes_nac AND $dia_nac>$dia)
			{
				$calc_edad = $anno - $anno_nac - 1; 
			}
			else
			{
				$calc_edad = $anno - $anno_nac;
			}
		}
	
		return $calc_edad;
	}
	
	public function devuelve_sexo($codigo)
	{
		if($codigo=='1')
		{
			$sexo='F';		
		}
		if($codigo=='2')
		{
			$sexo='M';
		}
		
		return $sexo;
	}
	
	public function ceros_izquierda($numero,$cant_ceros)
	{
	
		// Si no se necesita decimales cambiar esta linea 
		$decimales = explode(".",$numero); 

		//Si no se necesita los decimales cambiar $decimales[0] por $numero 
		$diferencia = $cant_ceros - strlen($decimales[0]); 

		for($i = 0 ; $i < $diferencia; $i++) 
		{ 
        	$numero_con_ceros .= 0; 
		} 

		$numero_con_ceros .= $numero; 

		return $numero_con_ceros;	
	
	}


	public function ver_nombre_mes($n)
	{
		if($n=='01')
		{
			$mes ='Enero';
		}
		elseif($n=='02')
		{
			$mes ='Febrero';
		}
		elseif($n=='03')
		{
			$mes ='Marzo';
		}
		elseif($n=='04')
		{
			$mes ='Abril';
		}
		elseif($n=='05')
		{
			$mes ='Mayo';
		}
		elseif($n=='06')
		{
			$mes ='Junio';
		}
		elseif($n=='07')
		{
			$mes ='Julio';
		}
		elseif($n=='08')
		{
			$mes ='Agosto';
		}
		elseif($n=='09')
		{
			$mes ='Setiembre';
		}
		elseif($n=='10')
		{
			$mes ='Octubre';
		}
		elseif($n=='11')
		{
			$mes ='Noviembre';
		}
		elseif($n=='12')
		{
			$mes ='Diciembre';
		}			

		return $mes;

	}

		
	public function obtiene_fecha($fecha)
	{ 
		$cadena=trim($fecha);
		$tamano=strlen($cadena);
	
		if($tamano>9)
		{
			$anno=substr($cadena,0,4);
			$mes=substr($cadena,5,2);
    		$dia=substr($cadena,8,2); 
		}
		
		else
		
		{
			$anno=substr($cadena,0,2);
			$mes=substr($cadena,3,2);
    		$dia=substr($cadena,6,2);
		
		
		}
		
		$fecha=$dia."/".$mes."/".$anno;
		
		if ($fecha==='//')
		{
		
			$fecha="";
		}
    	
		return $fecha;
   	}
		
	public function convierte_fecha($fecha)
	{
		$cadena=trim($fecha);
		$tamano=strlen($cadena);
		
		$anno=substr($cadena,6,$tamano);
		$dia=substr($cadena,0,2);
    	$mes=substr($cadena,3,2);
		
		$fecha=$anno."/".$mes."/".$dia;
	
		if ($fecha==='//')
		{
			$fecha="";
		}
		
		return $fecha;
 	}

	public function genera_boton($value,$metodo)
	{
		$cadena="";
		$cadena.="<input type='button' name='Submit' value='".$value."' onclick='".$metodo.";'/>";
		return $cadena;
	
	}

	public function genera_select($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='',$tipo_dato='')
	{
		$cadena = "";
		$metodo = "";
		
		if($metodojavasc!='')
		{
			$metodo=" onChange=".$metodojavasc.";";
		}
	
		$cadena ="<select name='".$nombre."' id='".$nombre."' ".$metodo." onkeyup='fn(this.form,this)'>";
		
		if($cero!='' && $cero_desc!='')
		{
			$cadena.="<option value='".$cero."' id='".$cero_desc."' ".$selected.">".$cero_desc."</option>";
		}
        
		$sw=0; $aux=0;
		
		while($campo= mysql_fetch_array($rs))
		{ 
			if($sw==0)
			{
				$valorini=$campo[$posicion1]; 
			    $sw=$sw+1;
			}
			 
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			{
				$selected="";
			}
			else
			{
				$selected=" Selected"; $aux=1; 
			}
		
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."' ".$selected.">".$campo[$posicion2]."</option>";
    	}  
		
		if ($aux==0)
		{
			$_REQUEST[$nombre]=$valorini;
		}

    	$cadena.="</select>";
	 	echo $cadena;
	}

	public function genera_select_fecha($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='')
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select name='".$nombre."' id='".$nombre."' ".$metodo." onkeyup='fn(this.form,this)'>";
	
	if($cero!='' && $cero_desc!='')
	$cadena.="<option value='".$cero."' id='".$cero."' ".$selected.">".$cero_desc."</option>";
        $sw=0; $aux=0;
		while($campo= mysql_fetch_array($rs))
		{ 
		    if($sw===0)
			{   $valorini=$campo[$posicion1]; 
			     $sw=$sw+1;
			 }
		 if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else   { $selected=" Selected"; $aux=1; }
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."' ".$selected.">".$this->obtiene_fecha($campo[$posicion2])."</option>";
    	}  
		if ($aux===0)
		{ $_REQUEST[$nombre]=$valorini;
		}

     $cadena.="</select>";
	 echo $cadena;
	
	}

	public function ejecutar_consulta($query,$parametro,$n)
	{

 		$rs= mysql_query($query,$this->_conecta);
	
		if(!$rs)
		{
			$this->Erno = mysql_errno();
			$this->Error = mysql_error();
			$this->mensaje($parametro,'0');
		}
	
		else 
		{
			if ($n!='5')
			{	
				$this->mensaje($parametro,$n); 
			}
		
		return $rs;
		}
		  
	}

	public function mensaje($parametro,$n)

	{	
	
		$mensaje='';
	
		switch($n)
		{
			
			case '0': 
			{
			  $mensaje.='OCURRIO UN ERROR EN LA BASE DE DATOS '.$parametro;break;
			}
			
			case '1': 
			{
			  $mensaje.='DATOS REGISTRADOS CON EXITO '.$parametro; break;
			}
			
			case '2':
			{
			 $mensaje.= 'DATOS ACTUALIZADOS CON EXITO '.$parametro; break;
			} 
			
			case '3':  
	 		{
			 $mensaje.= 'DATOS ELIMINADOS CON EXITO '.$parametro;break;
			} 
			
			case '4':  
	 		{
			 $mensaje.= $parametro;break;
			}
			
		}
		
		if($mensaje!=''){
			echo "<script> alert('$mensaje'); </script>";
			
		}
	}



	public function crea_carpeta($ruta)
	{  
	  $rights = 0777;
		
        if (!is_dir($ruta))
		{
        	mkdir($ruta, $rights);
		}
	}
	
	
	public function mk_dir($path, $rights = 0777)
	{
	  $folder_path = array(
      strstr($path, '.') ? dirname($path) : $path);

  		while(!@is_dir(dirname(end($folder_path)))
          && dirname(end($folder_path)) != '/'
          && dirname(end($folder_path)) != '.'
          && dirname(end($folder_path)) != '')
    	array_push($folder_path, dirname(end($folder_path)));

  		while($parent_folder_path = array_pop($folder_path))
    	if(!@mkdir($parent_folder_path, $rights))
      	{}//  user_error("Can't create folder \"$parent_folder_path\".");
	}


	public function generaclave($longitud)
	{
	/* Se valida la longitud proporcionada. Debe ser número y mayor de cero.
	Si es menor o igual a cero le asignamos la longitud por defecto.
	Si es mayor de 32 le asignamos 32.
	*/
	if(!is_numeric($longitud) || $longitud <= 0)
	{
	$longitud=4;
	}
	if($longitud> 32)
	{
	$longitud= 32;
	}

	/* Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
	Podemos añadir más caracteres para hacer más segura la contraseña.
	*/
	$caracteres= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	/* Introduce la semilla del generador de números aleatorios mejorado */
	mt_srand(microtime()*1000000);

	for($i = 0; $i <$longitud; $i++)
	{
	/* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
	$caracteres menos 1. Posteríormente vamos concatenando en la cadena $password
	los caracteres que se van eligiendo aleatoriamente.
	*/
	$key = mt_rand(0,strlen($caracteres)-1);
	$password = $password.$caracteres{$key};
	}

	return $password;
	}

	public function redondear2($numero,$decimales)
 	{	 
   		$factor = pow(10,$decimales); 
   		return (round($numero*$factor)/$factor);
 	} 
	
	public function redondear($numero,$decimales)
 	{ 
   	   return 	round($numero,$decimales);
 	} 

	public function devuelve_ruta($href)
	{ 
	   
		 echo  "<script LANGUAGE='JavaScript'> document.location.href='$href';  </script>"; 
	}
	
	public function cerrar_ventana()
	{ 
	   
		 echo  "<script LANGUAGE='JavaScript'> window.close();  </script>"; 
	}

function genera_select_valorini($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='')
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select onkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo."  >";
 	$cadena.="<option value='".$cero."' id='".$cero_descripcion."'   ".$selected.">".$cero_descripcion."</option>";
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion2]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}




























function genera_select_todos($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='')
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select onkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo."  >";
 	$cadena.="<option value='0' id='TODOS'   ".$selected.">TODOS</option>";
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion2]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}


function genera_select_ninguno($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='')
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select onkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo."  >";
 	$cadena.="<option value='0' id='ninguno'   ".$selected.">NINGUNO</option>";
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion2]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}


function genera_select_seleccionar($nombre,$metodojavasc,$posicion1,$posicion2,$rs,$cero='',$cero_desc='')
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select onkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo."  >";
 	$cadena.="<option value='0' id='seleccionar'   ".$selected.">SELECCIONAR</option>";
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion2]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}








function genera_select_rango($nombre,$metodojavasc,$posicion1,$posicion2,$posicion3,$caracter,$rs)
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select onkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo."  >";
 
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion2].$caracter.$campo[$posicion3]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}
	
	
	
	
	function genera_select_rango2($nombre,$metodojavasc,$posicion1,$posicion2,$posicion3,$posicion4,$caracter,$rs)
	{
	$cadena = "";
	$metodo ="";
	if($metodojavasc!='')
	$metodo=" onChange='".$metodojavasc.";'";
	$cadena.="<select nkeyup='fn(this.form,this)' name='".$nombre."' id='".$nombre."' ".$metodo.">";
 
		while($campo= mysql_fetch_array($rs))
		{
			if($_REQUEST[$nombre]!=$campo[$posicion1])
			 $selected="";  else    $selected=" Selected";
			$cadena.="<option value='".$campo[$posicion1]."' id='".$campo[$posicion2]."'   ".$selected.">".$campo[$posicion4].'&nbsp;'.$campo[$posicion2].$caracter.$campo[$posicion3]."</option>";
    	}  

     $cadena.="</select>";
	 echo $cadena;
	
	}

}


?>