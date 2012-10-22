<?php
require_once "util_data.php";
require_once "producto_data.php";
require_once 'cliente_data.php';


class Pedido
{
	public $_util;
   	private $num_productos;
	private $array_id_prod;
	private $array_cant_prod;
	private $array_cant_unid;
	private $array_precio_cantidad_total;			
	private $array_precio_unidades_total;		
	private $array_producto_nombre;
	private $array_cant_total;
	private $array_precio_total;
	
	public function __construct()
	{
		$this->_util = new Util;

		$this->num_productos=0;
		
		}

	public function introduce_producto($id_prod,$cant_prod,$cant_unid,$prec_cant,$factor,$nombre_producto)
	{

		if(($this->verifica_producto_existe($id_prod)))
		{
			echo "<script>alert('El producto ya esta en el pedido'); </script>";
		}
		else
		{
		
			$cantidad_total = ($cant_prod * $factor) + $cant_unid;
		
			$precio_cantidad_total = $cant_prod * $prec_cant;
			$precio_unidades_total = ($prec_cant / $factor) * $cant_unid;
			$precio_total = $precio_cantidad_total + $precio_unidades_total;

			$this->array_id_prod[$this->num_productos]=$id_prod;
			$this->array_cant_prod[$this->num_productos]=$cant_prod;
			$this->array_cant_unid[$this->num_productos]=$cant_unid;
			$this->array_precio_cantidad_total[$this->num_productos]=$precio_cantidad_total;			
			$this->array_precio_unidades_total[$this->num_productos]=$precio_unidades_total;		
			$this->array_producto_nombre[$this->num_productos]=$nombre_producto;				
			$this->array_cant_total[$this->num_productos]=$cantidad_total;
			$this->array_precio_total[$this->num_productos]=$precio_total;
						
			$this->num_productos++;
		}
	}
	
	public function verifica_producto_existe($id){
		
		for ($i=0;$i<$this->num_productos;$i++){
			if(($this->array_id_prod[$i]==$id) && $this->array_id_prod[$i]!=0){
				
				return $this->array_id_prod[$i];
				 
			}
		}
	}
	
	public 	function elimina_producto($linea){
		$this->array_id_prod[$linea]=0;
	}
	
	public function vaciar_carrito()
	{
		unset($this->array_id_prod);
		unset($this->array_cant_prod);
		unset($this->array_cant_unid);
		unset($this->array_precio_cantidad_total);
		unset($this->array_precio_unidades_total);
		unset($this->array_producto_nombre);
		unset($this->array_cant_total);
		unset($this->array_precio_total);
   }	
	
	public function imprime_pedido(){
		$suma = 0;
		
		$cuerpo.= "<table border=0 width=100%>
			  	<tr class='fondonegro'>
      			<td width=5%  class='cabecera_tabla' align='center'><b>Nº</b></td>
				<td width=65%  class='cabecera_tabla'><b>Producto</b></td>
				<td width=10%  class='cabecera_tabla' align='center'><b>Cantidad</b></td>
				<td width=20%  class='cabecera_tabla' align='center'><b>Precio</b></td>								
				<td class='cabecera_tabla'>&nbsp;</td>
				</tr>";
			             $n = 1;
		for ($i=0;$i<$this->num_productos;$i++){
			if($this->array_id_prod[$i]!=0){
				
				$cuerpo.= "<tr bgcolor='#F0F0F0'>";
				$cuerpo.= "<td align='center'>" . $n . "</td>";
				$cuerpo.= "<td>" . $this->array_producto_nombre[$i] . "</td>";
				$cuerpo.= "<td align='center'>" . $this->array_cant_total[$i] . "</td>";
				$cuerpo.= "<td align='center'>S/. " . number_format($this->array_precio_total[$i],2) . "</td>";								
				$cuerpo.= "<td align='center'><a href='#' onClick='eliminar_producto(".$i.")'><img src='../imagenes/icono_eliminar.gif' border='0'></td>";
				$cuerpo.= "</tr>";
				
				$suma = $suma + $this->array_precio_total[$i];
                 $n = $n + 1;
			}
		}
				$cuerpo.= "<tr bgcolor='#F0F0F0'>";
				$cuerpo.= "<td>&nbsp;</td>";
				$cuerpo.= "<td align='center'>Total</td>";
				$cuerpo.= "<td align='center'>S/. " . number_format($suma,2)."</td>";								
				$cuerpo.= "<td align='center'>&nbsp;</td>";
				$cuerpo.= "</tr>";	

		$cuerpo.= "</table>";
		
		return $cuerpo;
		
	}			

	public function grabar_pedido($fecha,$cliente)
	{
		$fecha=$this->_util->convierte_fecha($fecha);		
		
		$query = "INSERT INTO pedidos(ped_fecha,cli_id,ped_estado) VALUES('$fecha','$cliente','0')";
		$rs = mysql_query($query);
		$_SESSION['pedido_id']=mysql_insert_id(); 				
		$this->grabar_detalle_pedido(mysql_insert_id());
		return $rs;
	}
	
	public function pedido_cambiarestado($codigo,$estado)
	{
 			$query="UPDATE pedidos SET ped_estado='".$estado."' WHERE ped_id='".$codigo."'";
			$rs = $this->_util->ejecutar_consulta($query,'','5');	
			return $rs;
	}	
	
	public function grabar_detalle_pedido($pedido)
	{

		for ($i=0;$i<$this->num_productos;$i++)
		{
	

			if($this->array_cant_prod[$i]!=0)
			{
				$query="INSERT INTO detalle_pedidos(ped_id,pro_id,dped_cantidad,dped_unidades,dped_precio_cantidad,dped_totalcantidad,dped_preciounidades,dped_preciototal)
			 	 values  ('$pedido','".$this->array_id_prod[$i]."','".$this->array_cant_prod[$i]."',
				'".$this->array_cant_unid[$i]."','".$this->array_precio_cantidad_total[$i]."','".$this->array_cant_total[$i]."','".$this->array_precio_unidades_total[$i]."','".$this->array_precio_total[$i]."')";
	 	 	}
			
			$rs= mysql_query($query);	
	 	}
		
		return $rs;

	}	
	
	public function ver_estado($estado)
	{
		if($estado=='0')
		{
			$estado = "<font color='red'>Por atender</font>";
		}
		elseif($estado=='1')
		{
			$estado = "<font color='blue'>Atendido</font>";
		}
		elseif($estado=='2')
		{
			$estado = "<font color='black'>Anulado</font>";
		}
		
		return $estado;	
	}
	
	public function pedido_listar($paginado,$fecha)
	{
		$fecha=$this->_util->convierte_fecha($fecha);		
			
		$query = "SELECT p.ped_id,p.cli_id,p.ped_fecha,p.ped_estado, c.cli_razonsocial,c.cli_ruc,c.cli_direccion FROM pedidos p,clientes c WHERE p.cli_id=c.cli_id AND p.ped_fecha='".$fecha."' ORDER BY p.ped_id DESC";
		
		if($paginado=='0')
		{
			$rs = $this->_util->ejecutar_consulta($query,'','5');				
			return $rs;
		}
		else
		{
			return $query;
		}
	}
	
	public function pedido_ver($codigo)
	{		
		$query = "SELECT p.ped_id,p.cli_id,p.ped_fecha,p.ped_estado, c.cli_razonsocial,c.cli_ruc,c.cli_direccion FROM pedidos p,clientes c WHERE p.cli_id=c.cli_id AND p.ped_id='".$codigo."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');	
		$campo = mysql_fetch_array($rs);
		
		$this->ped_id = $campo['ped_id'];
		$this->cli_id = $campo['cli_id'];		
		$this->ped_fecha = $campo['ped_fecha'];
		$this->cli_razonsocial = $campo['cli_razonsocial'];		
		$this->cli_ruc = $campo['cli_ruc'];			
		$this->cli_direccion = $campo['cli_direccion'];			
		return $this->ped_id;
	}
	
	public function detalle_pedido_listar($pedido)
	{
		$query = "SELECT dp.ped_id,p.pro_descripcion,dp.dped_cantidad,dp.dped_unidades,dp.dped_precio_cantidad,dp.dped_totalcantidad,dp.dped_preciototal,dp.dped_totalcantidad,dp.dped_preciounidades,dp.pro_id FROM detalle_pedidos dp, productos p WHERE dp.pro_id=p.pro_id AND dp.ped_id='".$pedido."'";
		$rs = $this->_util->ejecutar_consulta($query,'','5');	
		return $rs;
	}
	
}
session_start();
if (!isset($_SESSION["pedido"]))
{
	$_SESSION['pedido'] = new Pedido;
}
?>
