<?php
/*
YoDumpeo! 1.5 - Modificacion del script original por aLiEnMaStEr
-Info: Modificacion a partir de la version 1.0 del script, +Info: http://www.forosdelweb.com/f18/backup-bd-yodumpeo-1-0b-166532/
-MOD INFO ¿Que incluye la modificacion?: Pues etsa mod es muy simple, lo que incluye es una formulario desde el cual introducimos los<br>
 datos del SQL como la tabla, user, pass y el host, para tener un uso mas rapido del script.
*/

if(isset($_POST['host'])){
	

/* Usuario para la conexion a Mysql. */
$usurio = 'root';
/* Password para la conexion a Mysql. */
$passwd = '';
 /* Host para la conexion a Mysql. */
$host = 'localhost';
/* Base de Datos que se seleccionará. */
$bd = 'bdventas';
/* Nombre del fichero que se descargará. */
$nombre = date("d-m-y")."_bdventas_backup.txt";
/* Determina si la tabla será vaciada (si existe) cuando  restauremos la tabla. */            
$drop = false;
/* 
* Array que contiene las tablas de la base de datos que seran resguardadas.
* Puede especificarse un valor false para resguardar todas las tablas
* de la base de datos especificada en  $bd.
* 
* Ejs.:
* $tablas = false;
*    o
* $tablas = array("tabla1", "tabla2", "tablaetc");
* 
*/
$tablas = false;
/* 
* Tipo de compresion.
* Puede ser "gz", "bz2", o false (sin comprimir)
*/
$compresion = false;

/* Conexion y eso*/
$conexion = mysql_connect($host, $usurio, $passwd)
or die("No se conectar con el servidor MySQL: ".mysql_error());
mysql_select_db($bd, $conexion)
or die("No se pudo seleccionar la Base de Datos: ". mysql_error());


/* Se busca las tablas en la base de datos */
if ( empty($tablas) ) {
    $consulta = "SHOW TABLES FROM $bd;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
        $tablas[] = $fila[0];
    }
}


/* Se crea la cabecera del archivo */
$info['dumpversion'] = "1.1b";
$info['fecha'] = date("d-m-Y");
$info['hora'] = date("h:m:s A");
$info['mysqlver'] = mysql_get_server_info();
$info['phpver'] = phpversion();
ob_start();
print_r($tablas);
$representacion = ob_get_contents();
ob_end_clean ();
preg_match_all('/(\[\d+\] => .*)\n/', $representacion, $matches);
$info['tablas'] = implode(";  ", $matches[1]);
$dump = <<<EOT
# +===================================================================
# | YoDumpeo! {$info['dumpversion']}
# | por fran86 <fran86@myrealbox.com>
# |
# | Generado el {$info['fecha']} a las {$info['hora']} por el usurio '$usurio'
# | Servidor: {$_SERVER['HTTP_HOST']}
# | MySQL Version: {$info['mysqlver']}
# | PHP Version: {$info['phpver']}
# | Base de datos: '$bd'
# | Tablas: {$info['tablas']}
# |
# +-------------------------------------------------------------------

EOT;
foreach ($tablas as $tabla) {
    
    $drop_table_query = "";
    $create_table_query = "";
    $insert_into_query = "";
    
    /* Se halla el query que será capaz vaciar la tabla. */
    if ($drop) {
        $drop_table_query = "DROP TABLE IF EXISTS `$tabla`;";
    } else {
        $drop_table_query = "# No especificado.";
    }

    /* Se halla el query que será capaz de recrear la estructura de la tabla. */
    $create_table_query = "";
    $consulta = "SHOW CREATE TABLE $tabla;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
            $create_table_query = $fila[1].";";
    }
    
    /* Se halla el query que será capaz de insertar los datos. */
    $insert_into_query = "";
    $consulta = "SELECT * FROM $tabla;";
    $respuesta = mysql_query($consulta, $conexion)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_ASSOC)) {
            $columnas = array_keys($fila);
            foreach ($columnas as $columna) {
                if ( gettype($fila[$columna]) == "NULL" ) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'".mysql_real_escape_string($fila[$columna])."'";
                }
            }
            $insert_into_query .= "INSERT INTO `$tabla` VALUES (".implode(", ", $values).");\n";
            unset($values);
    }
    
$dump .= <<<EOT

# | Vaciado de tabla '$tabla'
# +------------------------------------->
$drop_table_query


# | Estructura de la tabla '$tabla'
# +------------------------------------->
$create_table_query


# | Carga de datos de la tabla '$tabla'
# +------------------------------------->
$insert_into_query

EOT;
}

/* Envio */
if ( !headers_sent() ) {
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Transfer-Encoding: binary");
    switch ($compresion) {
    case "gz":
        header("Content-Disposition: attachment; filename=$nombre.gz");
        header("Content-type: application/x-gzip");
        echo gzencode($dump, 9);
        break;
    case "bz2": 
        header("Content-Disposition: attachment; filename=$nombre.bz2");
        header("Content-type: application/x-bzip2");
        echo bzcompress($dump, 9);
        break;
    default:
        header("Content-Disposition: attachment; filename=$nombre");
        header("Content-type: application/force-download");
        echo $dump;
    }
} else {
    echo "<b>ATENCION: Probablemente ha ocurrido un error</b><br />\n<pre>\n$dump\n</pre>";
}

}
else
{
echo "
<link href='../estilos/css_sistema.css' rel='stylesheet' type='text/css' />
<link href='../imagenes/logo.ico' type='image/x-icon' rel='shortcut icon'>
<form name='form1' method='post' action='backup.php'> 
	<table width='100%' border='0' cellspacing='0' cellpadding='0'> 
	
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>	
	
		<tr>
			<td align='center'>
				<strong>
				<font size='4' face='Arial, Helvetica, sans-serif'>Backup de seguridad de base de datos</font>
				</strong>
			</td>
		</tr>
		<tr>
			<td align='center'>
				<table width='80%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan='2'><input type='hidden' name='host' value=''>
								<p style='font-size:12px;text-align:justify;'>Para realizar el respaldo o copia de seguridad a la base de datos, por favor haga clic en el bot&oacute;n &lt;Generar Respaldo&gt; y seleccione una Unidad de disco duro para guardar la copia. Haga este procedimiento, diariamente o el tiempo que usted crea conveniente. Cualquier problema con el sistema, las copias de seguridad ayudaran a recuperar la informaci&oacute;n.</p>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					
					<tr>
						<td colspan='2' align='center'>
							<font size='2' face='Arial, Helvetica, sans-serif'>
							<input type='submit' name='Submit' value='Generar Respaldo' class='btn' >
							<input name='cerrar' type='button' class='btn' onClick='window.close();' value='Cerrar Ventana'>
							</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
	</form>";
}
?> 

