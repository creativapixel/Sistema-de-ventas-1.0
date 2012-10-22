<?php

/*
******************************************************************************************************
**
**	Este script permanece libre mientras estas lineas permanezcan intactas
**
******************************************************************************************************
**	Nombre de 
**	Archivo		:		PHPPaging.lib.php
**
**	Autor		:		Marco A. Madue�o Mej�a <myokram@msn.com>
**
**	Version		:		1.0.3
**
**	Descripcion	:		PHPPaging es una clase basada en PHP, y opcionalmente MySQL, que recibe
**						una serie de datos y los procesa para as� lograr un paginado de �stos.
**						Es altamente personalizable, y su configuraci�n no requiere de conocimientos
**						avanzados sobre PHP.
**
**	URL			:		http://php.myokram.info/phppaging
**
**	Documentacion:		http://php.myokram.info/phppaging/docs | Se incluye con el 
**						script (Generada con phpDocumentor 1.3.2 <http://phpdoc.org/>)
**
******************************************************************************************************
*/

/**
*	Clase PHPPaging - Paginaci�n altamente personalizable con PHP
*
*	Paginaci�n altamente personalizable con PHP. Puede paginar resultados pasados
*	a trav�s de un arreglo (array), una consulta a una Base de datos MySQL, o el 
*	resultado de una consulta a una Base de datos MySQL.
*
*	Permite personalizar el n�mero elementos mostrados en cada p�gina, as� como el
*	formaTo de la barra de links, la cual contendr� un n�mero de links tambi�n 
*	personalizable.
*
*   @package PHPPaging
*	@author Marco A. Madue�o Mej�a (MyOkram)
*	@license http://opensource.org/licenses/gpl-license.php GNU Public License
*	@version v1.0.1
*   @copyright 2008
*   @access public
*/
class PHPPaging {
	
	/**
	*	N�mero de elementos por p�gina
	*
	*	Valor por default: 5
	*
	*	N�mero de elementos que ser� mostrado por p�gina. Puede ser definido en el script
	*	mediante la funcion porPagina()
	*
	*	<code>
	*	var $porPagina = 10;
	*	</code>
	*	@var int
	*/
	var $porPagina;
	
	/**
	*	N�mero de p�ginas anteriores a la actual a las que se mostrar� un link directo
	*
	*	Valor por default: 3
	*
	*	En barra de links, n�mero de p�ginas anteriores a la actual a mostrar. Puede ser 
	*	definido en el script mediante la funcion paginasAntes()
	*
	*	<code>
	*	var $paginasAntes = 5;
	*	</code>
	*	@var int
	*/
	var $paginasAntes;
	
	/**
	*	N�mero de p�ginas posteriores a la actual a las que se mostrar� un link directo
	*
	*	Valor por default: 3
	*
	*	En barra de links, n�mero de p�ginas posteriores a la actual a mostrar. Puede ser
	*	definido en el script mediante la funcion paginasDespues()
	*
	*	<code>
	*	var $paginasDespues = 5;
	*	</code>
	*	@var int
	*/
	var $paginasDespues;
	
	/**
	*	Estilo para los links en barra de links
	*
	*	Valor por default: NULL
	*
	*	Estilo (clase) que se usar� en la barra de links. Puede ser definido en el script 
	*	mediante la funcion linkClase()
	*
	*	<code>
	*	var $linkClase = "links_paging";
	*	</code>
	*	@var string
	*/
	var $linkClase;
	
	/**
	*	Separador para la barra de links
	*
	*	Valor por default: "&nbsp;"
	*
	*	Separador que se usara en la barra de links, entre p�gina y p�gina. 
	*	Puede ser definido en el script mediante la funcion linkSeparador()
	*
	*	<code>
	*	var $linkSeparador = " | ";
	*	</code>
	*	@var string
	*/
	var $linkSeparador = "&nbsp;";
	
	/**
	*	Cadena que se agregar� al final de cada link
	*
	*	Valor por default: NULL
	*
	*	A�adido que ser� agregado al final de cada link. Puede ser definido en el
	*	script mediante la funcion linkAgregar()
	*
	*	<code>
	*	var $linkAgregar = "#resultados";
	*	</code>
	*
	*	@var string
	**/
	var $linkAgregar;
	
	/**
	*	Mensaje para el atributo <i>title</i> de los links
	*
	*	Valor por default: "P�gina %d: Resultados del %d al %d de %d"
	*
	*	Mensaje a mostrar cuando el mouse es colocado sobre los links. Puede ser definido
	*	en el script mediante la funcion linkTitulo(). El mensaje debe estar en formato: 
	*	XXXX %1$s XXXX %2$s XXXX %3$s XXXX %4$s XXXX. Los caracteres %n$s seran reemplazados 
	*   seg�n el n�mero por:
	*		- %1$s = N�mero de p�gina
	*		- %2$s = Primer resultado mostrado
	*		- %3$s = �ltimo Resultado mostrado
	*		- %4$s = Total de resultados de la BD
	*
	*	<code>
	*	var $linkTitulo = "Resultados del %2\$s al %3\$s de %4\$s encontrados (P�gina %1\$s)";
	*	</code>
	*	Podria ser reemplazado por:
	*	"Resultados del 13 al 18 de 127 encontrados (P�gina 3)"
	*	@var string
	**/
	var $linkTitulo;
	
	/**
	*	Cadena que se mostrar� en el link hacia la PRIMERA p�gina
	*
	*	Valor por default: "&laquo; Primera"
	*
	*	Cadena de texto que se mostrar� en el enlace hacia la primera p�gina.
	*
	*	<code>
	*	var $mostrarPrimera = "- Ir a la primera p�gina";
	*	</code>
	*	@var string
	**/
	var $mostrarPrimera;
	
	/**
	*	Cadena que se mostrar� en el link hacia la �LTIMA p�gina
	*
	*	Valor por default: "�ltima &raquo;"
	*
	*	Cadena de texto que se mostrar� en el enlace hacia la �ltima p�gina.
	*
	*	<code>
	*	var $mostrarPrimera = "Ir a la �ltima p�gina -";
	*	</code>
	*	@var string
	**/
	var $mostrarUltima;
	
	/**
	*	Cadena que se mostrar� en el link hacia la p�gina ANTERIOR
	*
	*	Valor por default: "&lt;"
	*
	*	Cadena de texto que se mostrar� en el enlace hacia la p�gina anterior
	*
	*	<code>
	*	var $mostrarAnterior = "Anterior";
	*	</code>
	*	@var string
	**/
	var $mostrarAnterior;
	
	/**
	*	Cadena que se mostrar� en el link hacia la p�gina SIGUIENTE
	*
	*	Valor por default: "&gt;"
	*
	*	Cadena de texto que se mostrar� en el enlace hacia la p�gina siguiente
	*
	*	<code>
	*	var $mostrarSiguiente = "Siguiente";
	*	</code>
	*	@var string
	**/
	var $mostrarSiguiente;
	
	/**
	*	Cadena que se mostrar� en el link hacia las p�ginas accesibles en barra de links
	*
	*	Valor por default: "%d"
	*
	*	Cadena de texto que se mostrar� para indicar las p�ginas a las que se puede
	*	acceder desde la barra de links, y que S� SER�N LINKS. El lugar donde se desea 
	*	que vaya el n�mero de p�gina se debe indicar por medio del caracter %d.
	*
	*	<code>
	*	var $mostrarIntermedias = "Ir a la p. %d";
	*	</code>
	*	@var string
	**/
	var $mostrarIntermedias;
	
	/**
	*	Cadena que se mostrar� en vez del link hacia la p�gina ACTUAL
	*
	*	Valor por default: "%d"
	*
	*	Cadena de texto que se mostrar� para indicar la p�gina actual, que estar� en 
	*	la barra de links, pero NO SER� UN LINK. El lugar donde se desea que vaya el
	*	n�mero de p�gina se debe indicar por medio del caracter %d.
	*
	*	<code>
	*	var $mostrarActual = "P�gina <b>%d</b>";
	*	</code>
	*	@var string
	**/
	var $mostrarActual;
	
	/**
	*	Nombre de variable en la url
	*
	*	Valor por default: "page"
	*
	*	Cadena de texto que representar� el nombre de la variable que define
	*   el n�mero de p�gina en la url
	*
	*	<code>
	*	var $nombreVariable = "p";
	*	</code>
	*	@var string
	**/
	var $nombreVariable;
	
	/**
	*******************************************************
	*******************************************************
	***													***
	***		VARIABLES DE USO INTERNO. NO MODIFICAR!		***
	***													***
	*******************************************************
	*******************************************************
	**/
	/**
	*	@access private
	*/
	var $url;
	/**
	*	@access private
	*/
	var $style;
	/**
	*	@access private
	*/
	var $numTotalPaginas;
	/**
	*	@access private
	*/
	var $numEstaPagina;
	/**
	*	@access private
	*/
	var $numPrimerRegistro;
	/**
	*	@access private
	*/
	var $numUltimoRegistro;
	/**
	*	@access private
	*/
	var $numTotalRegistros;
	/**
	*	@access private
	*/
	var $numTotalRegistros_this;
	/**
	*	@access private
	*/
	var $data = array();
	/**
	*	@access private
	*/
	var $ejecutard = array();
	/**
	*	@access private
	*/
	var $mysql = null;
	/**
	*	@access private
	*/
	var $root;
	/**
	*	@access private
	*/
	var $conn;
	
	/**
	  ***********************************************************************
	  *																		*
	  *		FUNCIONES QUE ESTABLECEN LOS CRITERIOS PARA LA PAGINACION		*
	  *																		*
	  ***********************************************************************
	**/
	
	/**
	*	@access private
	*/
	function __construct ($conn = null) {
		$this->conn = $conn;
	}
	
	/**
	*	Array con datos para paginar
	*
	*	Define los datos para paginar
	*	@param array $input Array que contiene los datos a paginar
	*	@returns void
	**/
	function agregarArray ($input) {
		$this->data = (is_array($input)) ? $input : array();
	}
	
	/**
	*	Consulta SQL para obtener los datos para el paginado. La consulta no deber� especificar l�mites
    * 	pues de eso se encargar� el script	
	*
	*	Define una consulta SQL en base a la cual se realizar� el paginado
	*	@param string $sql Una consulta SQL estandar. La consulta no debe terminar con punto y coma. 	
	*	@returns bool
	**/
	function agregarConsulta ($sql) {
		$this->sql = $sql;
	}
	
	/**
	*	N�mero de elementos por p�gina
	*
	*	Define el n�mero de registros que ser�n mostrados en cada p�gina
	*	@param number $num N�mero de registros por p�gina que se usar�
	*	@returns bool
	**/
	function porPagina ($num) {
		if (is_numeric($num) && $num >= 1) $this->porPagina = intval($num);
		else return false;
		return true;
	}
	
	/**
	*	Nombre de variable en la URL
	*
	*	Define el nombre de la variable de url que indicar� el n�mero de p�gina
	*	@param string $var Nombre de la variable de url
	*	@returns bool
	**/
	function nombreVariable ($var) {
		if (ereg("(^[a-zA-Z0-9]+)$",$var)) $this->nombreVariable = $var;
		else return false;
		return true;
	}
	
	/**
	*	N�mero de p�ginas anteriores a la actual a las que se mostrar� un link directo
	*
	*	Define el n�mero de links a p�ginas anteriores a la actual que ser�n mostrados en
	*	la barra de links
	*	@param number $num N�mero de p�ginas anteriores a la actual
	*	@returns bool
	**/
	function paginasAntes ($num) {
		if (is_numeric($num) && $num >= 0) $this->paginasAntes = intval($num);
		else return false;
		return true;
	}
	
	/**
	*	N�mero de p�ginas posteriores a la actual a las que se mostrar� un link directo
	*
	*	Define el n�mero de links a p�ginas posteriores a la actual que ser�n mostrados en
	*	la barra de links
	*	@param number $num N�mero de p�ginas posteriores a la actual
	*	@returns bool
	**/
	function paginasDespues ($num) {
		if (is_numeric($num) && $num >= 0) $this->paginasDespues = intval($num);
		else return false;
		return true;
	}
  
	/**
	*	Separador para la barra de links
	*
	*	Define el separador que se usar� entre cada link en la barra de links
	*	@param string $separator Separador entre links
	*	@returns void
	**/
	function linkSeparador ($separator = '') {
		$this->linkSeparador = $separator;
	}
  
	/**
	*	Cadena que se mostrar� en el link hacia la PRIMERA p�gina
	*
	*	Define la cadena que ser� mostrada en el enlace hacia la primera p�gina
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarPrimera ($string) {
		$this->mostrarPrimera = $string;
	}
  
	/**
	*	Cadena que se mostrar� en el link hacia la �LTIMA p�gina
	*
	*	Define la cadena que ser� mostrada en el enlace hacia la �ltima p�gina
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarUltima ($string) {
		$this->mostrarUltima = $string;
	}
  
	/**
	*	Cadena que se mostrar� en el link hacia la p�gina ANTERIOR
	*
	*	Define la cadena que ser� mostrada en el enlace hacia la p�gina anterior
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarAnterior ($string) {
		$this->mostrarAnterior = $string;
	}
  
	/**
	*	Cadena que se mostrar� en el link hacia la p�gina SIGUIENTE
	*
	*	Define la cadena que ser� mostrada en el enlace hacia la p�gina siguiente
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarSiguiente ($string) {
		$this->mostrarSiguiente = $string;
	}
  
	/**
	*	Cadena que se mostrar� en el link hacia las p�ginas accesibles en barra de links
	*
	*	Define la cadena que ser� mostrada en el enlace hacia las p�ginas accesibles 
	*	desde la barra de links. El n�mero de p�gina deber� ser indicado como %d
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarIntermedias ($string) {
		$this->mostrarIntermedias = $string;
	}
  
	/**
	*	Cadena que se mostrar� en vez del link hacia la p�gina ACTUAL
	*
	*	Define la cadena que ser� mostrada como p�gina actual en la barra de links. El 
	*	n�mero de p�gina (P�gina actual) deber� ser indicado como %d
	*	@param string $string Cadena a mostrar
	*	@returns void
	**/
	function mostrarActual ($string) {
		$this->mostrarActual = $string;
	}
	
	/**
	*	Cadena que se agregar� al final de cada link
	*
	*	Agrega una cadena "addon" al final de cada link en la barra de links
	*	@param string $addon Cadena que ser� a�adida
	*	@returns void
	**/
	function linkAgregar ($addon) {
		$this->linkAgregar = $addon;
	}
	
	/**
	*	Estilo para los links en barra de links
	*
	*	Define la clase CSS que ser� aplicada a los links de la barra de links
	*	@param string $id Clase CSS a aplicar
	*	@returns void
	**/
	function linkClase ($id) {
		$this->linkClase = $id;
	}
	
	/**
	*	Mensaje para el atributo <i>title</i> de los links en barra de links
	*
	*	Define un mensaje para el atributo 'title' de los links de la barra de links. El 
	*	mensaje debe ser en formato: XXXX %1$s XXXX %2$s XXXX %3$s XXXX %4$s XXXX. 
	*   Los caracteres %n$s seran reemplazados en orden seg�n el n�mero por:
	*		- %1$s = N�mero de p�gina
	*		- $2$s = Primer resultado mostrado
	*		- $3$s = �ltimo Resultado mostrado
	*		- $4$s = Total de resultados de la BD
	*	@param string $msg Mensaje que ser� inclu�do en los links
	*	@returns void
	**/
	function linkTitulo ($msg) {
		$this->linkTitulo = $msg;
	}
	
	/**
	  *******************************************************************
	  *																	*
	  *		FUNCIONES QUE DEVUELVEN VALORES RELATIVOS AL PAGINADO		*
	  *																	*
	  *******************************************************************
	**/
	
	/**
	*	N�mero total de p�ginas
	*
	*	Devuelve el n�mero total de p�ginas
	*	@returns int
	**/
	function numTotalPaginas () {
		return $this->numTotalPaginas;
	}
	
	/**
	*	N�mero de p�gina actual
	*
	*	Devuelve el n�mero de p�gina actual
	*	@returns int
	**/
	function numEstaPagina () {
		return $this->numEstaPagina;
	}
	
	/**
	*	N�mero de primer registro mostrado
	*
	*	Devuelve el n�mero del primer registro mostrado, en relaci�n al total de registros
	*	@returns int
	**/
	function numPrimerRegistro () {
		return $this->numPrimerRegistro;
	}
	
	/**
	*	N�mero de �ltimo registro mostrado
	*
	*	Devuelve el n�mero del �ltimo registro mostrado, en relaci�n al total de registros
	*	@returns int
	**/
	function numUltimoRegistro () {
		return $this->numUltimoRegistro;
	}
	
	/**
	*	N�mero de total registros
	*
	*	Devuelve el n�mero total de registros encontrados
	*	@returns int
	**/
	function numTotalRegistros () {
		return $this->numTotalRegistros;
	}
	
	/**
	*	N�mero de registros mostrados en esta p�gina
	*
	*	Devuelve el n�mero de registros mostrados en la p�gina actual
	*	@returns int
	**/
	function numRegistrosMostrados () {
		return $this->numTotalRegistros_this;
	}
	
	/**
	*	Obtener los valores de configuraci�n
	*
	*	Devuelve un array con los valores de configuraci�n
	*	@returns void
	**/
	function superArray () {
		return array("numPrimerRegistro"=>$this->numPrimerRegistro, "numUltimoRegistro"=>$this->numUltimoRegistro, "numTotalRegistros"=>$this->numTotalRegistros, "porPagina"=>$this->porPagina, "numRegistrosMostrados"=>$this->numTotalRegistros_this, "nombreVariable"=>$this->nombreVariable, "linkAgregar"=>$this->linkAgregar, "linkClase"=>$this->linkClase, "linkSeparador"=>$this->linkSeparador, "numEstaPagina"=>$this->numEstaPagina, "numTotalPaginas"=>$this->numTotalPaginas, "paginasAntes"=>$this->paginasAntes, "paginasDespues"=>$this->paginasDespues, "mostrarPrimera"=>$this->mostrarPrimera, "mostrarUltima"=>$this->mostrarUltima, "mostrarAnterior"=>$this->mostrarAnterior, "mostrarSiguiente"=>$this->mostrarSiguiente, "mostrarIntermedias"=>$this->mostrarIntermedias, "mostrarActual"=>$this->mostrarActual);
	}
	
	/**
	*	Obtener los registros a mostrar
	*
	*	Devuelve un array con los registros seleccionados para mostrar
	*	@returns array
	**/
	function fetchResultado () {
		if(is_array($this->ejecutard)) {
			if(list($key, $row) = each($this->ejecutard)) return $row;
		} elseif($row = @mysql_fetch_array($this->ejecutard)) {
			return $row;
		}
		else return false;
	}
	
	function fetchTodo () {
		if(is_array($this->ejecutard))
			return (count($this->ejecutard) > 0) ? $this->ejecutard : null;		
		$r = array();
		while($f = $this->fetchResultado()) {
			$r[] = $f;
		}
		return (count($r) > 0) ? $r : null; 
	}
	
	/**
	*	Obtener barra de links
	*
	*	Devuelve una cadena conteniendo la barra de links en formato HTML
	*	@returns string
	**/
	function fetchNavegacion () {
		$this->check_vars();
		$i = array();
		foreach($_GET as $key=>$val) {
			if($key !== $this->nombreVariable) {
				$i[] = "$key=$val";
			}
		}
		$i[] = $this->nombreVariable;
		$this->query_string = implode('&',$i);
		$this->root = (empty($this->root)) ? "http://".$_SERVER['HTTP_HOST'] : $this->root;
		$this->url = basename($_SERVER['PHP_SELF']).'?'.$this->query_string;
		$this->style = (!empty($this->linkClase)) ? ' class="'.$this->linkClase.'"' : NULL;
		$before = $this->paginasAntes;
		$after = $this->paginasDespues;
		$pthis = $this->numEstaPagina;
		$ptotal = $this->numTotalPaginas;
		$before = (($pthis - $before) < 1) ? 1 : ($pthis - $before);
		$after = (($pthis + $after) > $ptotal) ? $ptotal : ($pthis + $after);
		$link_string = array();
		if($pthis > $this->paginasAntes+1) {
			$link_string[] = $this->do_link(1,$this->addlinkmsg(1,1,$this->porPagina,1),$this->mostrarPrimera);
		}
		if($pthis > 1) {
			$link_string[] = $this->do_link(($pthis-1),$this->addlinkmsg(($pthis-1),(($this->porPagina*($pthis-2))+1),($this->porPagina*($pthis-1)),2),$this->mostrarAnterior);
		}
		$i = 0;
		while($before <= $after) {
			$link_string[] = ($pthis <> $before) ? $this->do_link($before,$this->addlinkmsg($before,(($this->porPagina*($before-1))+1),($this->porPagina*($before)),3),sprintf($this->mostrarIntermedias,$before)) : sprintf($this->mostrarActual,$before);
			$before++;
		}
		if($pthis < $ptotal) {
			$link_string[] = $this->do_link($pthis+1,$this->addlinkmsg(($pthis+1),(($this->porPagina*$pthis)+1),($this->porPagina*($pthis+1)),4),$this->mostrarSiguiente);
		}
		if($pthis < ($ptotal-$this->paginasDespues)) {
			$link_string[] = $this->do_link($ptotal,$this->addlinkmsg($ptotal,(($this->porPagina*($ptotal-1))+1),$this->numTotalRegistros,5),$this->mostrarUltima);
		}
		$link_string = implode($this->linkSeparador,$link_string);
		return $link_string;
	}

	/**
	*******************************************************
	*******************************************************
	***													***
	***		FUNCIONES DE USO INTERNO. NO MODIFICAR!		***
	***													***
	*******************************************************
	*******************************************************
	**/
	/**
	*	@access private
	*/
	function addlinkmsg ($tp,$rs,$rt,$type = null) {
		$total = $this->numTotalRegistros;
		$rt = ($rt > $total) ? $total : $rt;
		if(!empty($this->linkTitulo)) {
			return sprintf($this->linkTitulo,$tp,$rs,$rt,$this->numTotalRegistros);
		} else {
			switch($type) {
				case 1: return "Primera p&aacute;gina. Resultados del $rs al $rt de $total"; break;
				case 2: return "P&aacute;gina anterior: Resultados del $rs al $rt de $total"; break;
				case 3: return "P&aacute;gina $tp: Resultados del del $rs al $rt de $total"; break;
				case 4: return "P&aacute;gina siguiente. Resultados del $rs al $rt de $total"; break;
				case 5: return "&Uacute;ltima p&aacute;gina. Resultados del $rs al $rt de $total"; break;
				default: return $this->addlinkmsg($tp,$rs,$rt,3);
			}
		}
	}
	
	/**
	*	@access private
	*/
	function check_vars () {
		$this->porPagina = ($this->porPagina >= 1) ? intval($this->porPagina) : 5;
		$this->mostrarPrimera = (!empty($this->mostrarPrimera)) ? $this->mostrarPrimera : "&laquo; Primera";
		$this->mostrarAnterior = (!empty($this->mostrarAnterior)) ? $this->mostrarAnterior : "&lt;";
		$this->mostrarSiguiente = (!empty($this->mostrarSiguiente)) ? $this->mostrarSiguiente : "&gt;";
		$this->mostrarUltima = (!empty($this->mostrarUltima)) ? $this->mostrarUltima : "&Uacute;ltima &raquo;";
		$this->mostrarIntermedias = (!empty($this->mostrarIntermedias)) ? $this->mostrarIntermedias : "%d";
		$this->mostrarActual = (!empty($this->mostrarActual)) ? $this->mostrarActual : "%d";
		$this->paginasAntes = (is_numeric($this->paginasAntes) && $this->paginasAntes >= 0) ? intval($this->paginasAntes) : 3;
		$this->paginasDespues = (is_numeric($this->paginasDespues) && $this->paginasDespues >= 0) ? intval($this->paginasDespues) : 3;
		$this->nombreVariable = (ereg("(^[a-zA-Z0-9]+)$",$this->nombreVariable)) ? $this->nombreVariable : "page";
	}
	
	/**
	*	@access private
	*/
	function do_link ($page,$title,$content) {
		$url = $this->url;
		$style = $this->style;
		return "<a href=\"$url=$page".$this->linkAgregar."\" title=\"$title\"$style>$content</a>";
	}
  
	/**
	*	@access private
	*/
	function ejecutar () {
		$this->check_vars();
		$numEstaPagina = (is_numeric($_GET[$this->nombreVariable]) && $_GET[$this->nombreVariable] >= 1) ? intval($_GET[$this->nombreVariable]) : 1;
		$this->numEstaPagina = &$numEstaPagina;
		$numPrimerRegistro = ($numEstaPagina - 1) * $this->porPagina;
		if(!empty($this->sql)) {
			$result = (isset($this->conn)) ? mysql_query($this->sql,$this->conn) : mysql_query($this->sql);
			$this->numTotalRegistros = mysql_num_rows($result);
		} else {
			$data = array_values($this->data);
			$data_keys = array_keys($this->data);
			$this->numTotalRegistros = count($data);
		}
		if($this->numTotalRegistros < $numPrimerRegistro) {
			$numPrimerRegistro = 0;
			$numEstaPagina = 1;
		}
		$this->numTotalPaginas = ceil($this->numTotalRegistros / $this->porPagina);
		if($this->numTotalRegistros >= 1) {
			$this->numPrimerRegistro = $numPrimerRegistro + 1;
			$pdata = array();
			if(!empty($this->sql)) {
				$result = (isset($this->conn)) ? mysql_query($this->sql." LIMIT $numPrimerRegistro, {$this->porPagina}",$this->conn) : mysql_query($this->sql." LIMIT $numPrimerRegistro, {$this->porPagina}");
				$this->ejecutard = $result;
				$this->numTotalRegistros_this = mysql_num_rows($result);
			} else {
				$numUltimoRegistro = $numPrimerRegistro + $this->porPagina - 1;
				while($numPrimerRegistro <= $numUltimoRegistro) {
					if(isset($data[$numPrimerRegistro])) {
						$key = (isset($data_keys[$numPrimerRegistro])) ? $data_keys[$numPrimerRegistro] : rand()."_".$numPrimerRegistro;
						$pdata[$key] = $data[$numPrimerRegistro];
						$numPrimerRegistro++;
					} else {
						break;
					}
				}
				$this->ejecutard = $pdata;
				$this->numTotalRegistros_this = count($pdata);
			}
			$this->numUltimoRegistro = $this->numPrimerRegistro + $this->numTotalRegistros_this - 1;
		} else {
			$this->numPrimerRegistro = 0;
			$numEstaPagina = 0;
			$this->numTotalRegistros_this = 0;
			$this->numUltimoRegistro = 0;
			$this->ejecutard = array();
		}
		return ($this->numTotalRegistros_this > 0);
	}
}
?>