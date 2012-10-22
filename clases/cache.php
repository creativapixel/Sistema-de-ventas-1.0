<?php
/* file     : cache.class.php
 * Clase  : m2Cache
 * Original: http://www.calinsoft.com/2009/01/sistema-de-cache-simple-en-php.html
*/

//Algunos parámetros de configuración
define('ABSPATH', dirname(__FILE__) );

//Directorio donde almacenaremos los archivos cacheados
define('CACHE_DIR',
	ABSPATH . '/../cache'); // tiene que tener permisos 777

//El tiempo que la copia se mantendrá vigente.
define('CACHE_TIME', 60 ); // 3600 segundos 1 hora.

// La dirección de la Pagina Donde nos encontramos
define('PAGE',
	'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
);

// La dirección de la pagina con el nombre encriptado
define('CACHE_LINK',
	CACHE_DIR . "/" . md5( PAGE ) . ".html"
);

class m2Cache
{
       //Variable para activar el Sistema de Cache
	var $enableCache;

	//Variable para almacenar el tiempo de la creación del archivo
	var $time;

	function m2Cache(){
                //por defecto el sistema  de cache estará desactivado
		$this->enableCache	= false;
                //el tiempo por defecto empieza en 0
		$this->time			= 0;

	}

	//Función para activar el Sistema de cache.
	function enable(){

		$this->enableCache = true;

	}

        // Retorna el estado Actual del  Sistema.
	function status(){

		return $this->enableCache;
	}

        // Función Inicio del Cache.
	function startCache()
	{
	         // verificamos estado
		if ($this->status()):
                       //verificamos que existe la pagina en cache
			if ( @file_exists( CACHE_LINK ) ):
			        // si existe obtenemos la hora de creación del archivo.
				$this->time = @filemtime( CACHE_LINK );

                                // verificamos si está adentro del tiempo permitido.
				if ( ( time() - CACHE_TIME ) < $this->time ):
					// si está adentro del tiempo
                                       // mostramos la pagina cacheada.
					@readfile( CACHE_LINK );

					 die();

				 else:
				 	//Si Expiro se elimina, para prevenir conflictos.
				 	@unlink( CACHE_LINK );

				 endif;

			endif;

			//Habilitamos el uso de búferes de salida
			ob_start();

		else:
		       // no está el activado sistema de cache
			return false;

		endif;

	}

	//función de término del sistema de cache
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

			//Volcamos el búfer de salida y deshabilitamos el uso del búfer
			ob_end_flush();

		else:
		        // no está el activado sistema de cache
			return false;

		endif;

	}

}
?>