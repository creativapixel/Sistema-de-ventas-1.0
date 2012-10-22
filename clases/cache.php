<?php
/* file     : cache.class.php
 * Clase  : m2Cache
 * Original: http://www.calinsoft.com/2009/01/sistema-de-cache-simple-en-php.html
*/

//Algunos par�metros de configuraci�n
define('ABSPATH', dirname(__FILE__) );

//Directorio donde almacenaremos los archivos cacheados
define('CACHE_DIR',
	ABSPATH . '/../cache'); // tiene que tener permisos 777

//El tiempo que la copia se mantendr� vigente.
define('CACHE_TIME', 60 ); // 3600 segundos 1 hora.

// La direcci�n de la Pagina Donde nos encontramos
define('PAGE',
	'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
);

// La direcci�n de la pagina con el nombre encriptado
define('CACHE_LINK',
	CACHE_DIR . "/" . md5( PAGE ) . ".html"
);

class m2Cache
{
       //Variable para activar el Sistema de Cache
	var $enableCache;

	//Variable para almacenar el tiempo de la creaci�n del archivo
	var $time;

	function m2Cache(){
                //por defecto el sistema  de cache estar� desactivado
		$this->enableCache	= false;
                //el tiempo por defecto empieza en 0
		$this->time			= 0;

	}

	//Funci�n para activar el Sistema de cache.
	function enable(){

		$this->enableCache = true;

	}

        // Retorna el estado Actual del  Sistema.
	function status(){

		return $this->enableCache;
	}

        // Funci�n Inicio del Cache.
	function startCache()
	{
	         // verificamos estado
		if ($this->status()):
                       //verificamos que existe la pagina en cache
			if ( @file_exists( CACHE_LINK ) ):
			        // si existe obtenemos la hora de creaci�n del archivo.
				$this->time = @filemtime( CACHE_LINK );

                                // verificamos si est� adentro del tiempo permitido.
				if ( ( time() - CACHE_TIME ) < $this->time ):
					// si est� adentro del tiempo
                                       // mostramos la pagina cacheada.
					@readfile( CACHE_LINK );

					 die();

				 else:
				 	//Si Expiro se elimina, para prevenir conflictos.
				 	@unlink( CACHE_LINK );

				 endif;

			endif;

			//Habilitamos el uso de b�feres de salida
			ob_start();

		else:
		       // no est� el activado sistema de cache
			return false;

		endif;

	}

	//funci�n de t�rmino del sistema de cache
	function endCache()
	{
		//verificamos estado del sistema de cache
		if ($this->status()):

                        //Creamos el archivo
			$fp = fopen( CACHE_LINK , 'w' );
			// escribimos adentro de el.
			@fwrite( $fp , ob_get_contents() );
			//cerramos
			@fclose( $fp );

			//Volcamos el b�fer de salida y deshabilitamos el uso del b�fer
			ob_end_flush();

		else:
		        // no est� el activado sistema de cache
			return false;

		endif;

	}

}
?>