<?php 
require_once 'util_data.php';
require_once 'usuario_data.php';

class Permiso
{
	public $_util;

	public function __construct()
	{
		$this->_util = new Util;
		
	}

	public function evalua_permiso($usuario,$permiso)
 	{
 		$query="SELECT pu.usu_id,pu.per_id FROM usuarios_permisos  pu, permisos p WHERE   pu.usu_id='".$usuario."' AND p.per_id=pu.per_id AND p.per_eliminado='0' AND pu.per_id='".$permiso."'";

		$rs= $this->_util->ejecutar_consulta($query,'','5');
		$campo =mysql_fetch_array($rs);
		return $campo['per_id'];
 	}	
	
	
	public function generar_select_permiso($nombre,$metodo,$rsp,$cero='',$cero_desc='')
	{
		//if ($rsp==='')
		$rsp= $this->listar_permisos($n);
		$this->_util->genera_select($nombre,$metodo,'per_id','per_descripcion',$rsp,$cero,$cero_desc);
	}


 	public function listar_permisos($n)
 	{
		if ($n!='1')
		{
			$query="SELECT * FROM permisos WHERE per_eliminado='0' ORDER BY per_descripcion ASC";
		}
		else
		{
			$query="SELECT  p.per_id,p.per_descripcion,p.per_eliminado, pu.usu_id FROM permisos  p, usuarios_permisos pu  WHERE p.per_eliminado='0' AND pu.usu_id= '".$_REQUEST['usu_codigo']."'  AND   p.per_id=pu.per_id order by p.per_descripcion ASC";
		}

		$rs= $this->_util->ejecutar_consulta($query,'','5');
		return $rs;

 	}
 
 	public function asignar_permisos($usu_codigo,$permiso)
 	{
 		$query="SELECT usu_id FROM usuarios_permisos WHERE usu_id='$usu_codigo' AND per_id='$permiso'";
		$rs= $this->_util->ejecutar_consulta($query,'','5');	
	
		if(mysql_num_rows($rs)>0)
		{
			$this->_util->mensaje('El permiso ya ha sido registrado para este usuario','4');
		}
		else 
		{
			$query="INSERT INTO usuarios_permisos(per_id,usu_id) VALUES ('$permiso','$usu_codigo')";
			$rs= $this->_util->ejecutar_consulta($query,'','5');
			return $rs; 
		}
 	}
 

 
	public function eliminar_permiso($usu_codigo,$permiso)
 	{
  		$query="DELETE FROM  usuarios_permisos WHERE per_id='$permiso' AND usu_id='$usu_codigo'";
		$this->_util->ejecutar_consulta($query,'','5');
 	}

}

?>
