<?php 
session_start();	
require_once "../clases/usuario_data.php";
$usuario = new Usuario(); 
$usuario->usuario_destruir_sesion();
$usuario->_util->_cn->desconectar(); 		
?>