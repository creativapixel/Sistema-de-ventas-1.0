<?php session_start();
  require_once('../clases/consulta_data.php');

$consulta = new consultadata();


 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}


if (isset($_REQUEST['fecha']) and isset($_REQUEST['fechaf']))
{

$parametros="&fecha=".$_REQUEST['fecha']."&fechaf=".$_REQUEST['fechaf'];

}


 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
<link href="../estilos/css_print.css" rel="stylesheet" type="text/css" media="print">

<script language="Javascript" src="../javascript/PopCalendar.js"></script>
</head>

<body  >
<script language="JavaScript">
	PopCalendar = getCalendarInstance();
	PopCalendar.initCalendar();
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr  >
    <td ><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	


	
	<form name="form1"  id="form1">
        <table width="923" border="0" align="center" cellpadding="0">
          <tr >
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr align="center" >
            <td colspan="7"><h5>REPORTE DE DIAGNOSTICOS POR FECHA </h5></td>
          </tr>
		  
          <tr >
            <td  width="240" align="right" class="enfasis">Fecha inicio</td>
            <td width="12" align="left" class="enfasis" >:</td>
            <td width="120" align="left"><input name="fecha" type="text" id="fecha" value="<?php echo $_REQUEST['fecha']; ?>" size="10"   />
        <a style='cursor:hand;' onclick='document.form1.fecha.oldValue=document.form1.fecha.value;PopCalendar.selectWeekendHoliday(1,1);PopCalendar.show(document.form1.fecha, &quot;dd/mm/yyyy&quot;, null, &quot;&quot;, &quot;&quot;);'><img src="imagen/calendar.gif" width="23" height="21" /></a></td>
            <td width="78" align="right" class="enfasis">Fecha Final </td>
            <td width="12" align="left" class="enfasis">:</td>
            <td width="138" align="left"><input name="fechaf" type="text" id="fechaf" value="<?php echo $_REQUEST['fechaf']; ?>" size="10"/>
            <a style='cursor:hand;' onclick='document.form1.fechaf.oldValue=document.form1.fechaf.value;PopCalendar.selectWeekendHoliday(1,1);PopCalendar.show(document.form1.fechaf, &quot;dd/mm/yyyy&quot;, null, &quot;&quot;, &quot;&quot;);'><img src="imagen/calendar.gif" width="23" height="21" /></a></td>
            <td width="307" align="left"><input name="Submit" type="button" class="btn" onClick="buscar()" value="Buscar"></td>
          </tr>
		 
          <tr>
            <td colspan="7" align="left" class="enfasis">
              <input name="pagina" type="hidden" id="pagina">
              <input name="id" type="hidden" id="id">
            </a></td>
          </tr>
          <tr>
            <td colspan="7" align="center">&nbsp;</td>
          </tr>
          
          
          <tr>
            <td colspan="7">
		<?php

	
	function Descargar($excel){ 
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=".basename($excel)); 
@readfile($file); 
} 
		$shtml="<table width=500 border=0 align=center cellpadding=0 cellspacing=2  >";
        $shtml=$shtml."<tr >";
		$shtml=$shtml."<td colspan=3 align=center><h4>TOTAL DE ATENCIONES POR DIAGNOSTICO DESDE LA FECHA ". $_REQUEST['fecha']." HASTA EL ". $_REQUEST['fechaf']."</h4></td>";
		
        $shtml=$shtml."</tr>";
                $shtml=$shtml."<tr class=fondonegro>";
        $shtml=$shtml."<td width=6% align=center>N&deg;</td>
        ";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."<td align=center>DIAGNOSTICO</td>";
        $shtml=$shtml."";
        $shtml=$shtml."<td width=45% align=center>ATENCIONES</td>";
        $shtml=$shtml."";
        $shtml=$shtml."</tr>";
              
	
			 $rs= $consulta->reporte_diagnostico_consulta_listar($_REQUEST['fecha'],$_REQUEST['fechaf']);
			 if($rs)
			 
			 {
			 $j=1;
			 $total='0';
			  while($campo =mysql_fetch_array($rs)) {
			  
			  
        $shtml=$shtml."<tr bgcolor=#F0F0F0 style=cursor: hand onMouseOver=bgColor='#Ffffff' onMouseOut =bgColor='#F0F0F0'>";
        $shtml=$shtml."<td align=center >". $j ."</td>";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml.""; 
        $shtml=$shtml."";
        $shtml=$shtml."<td align=center >". $campo['diag_descripcion'] ."</td>
        ";
				
				
				
        $shtml=$shtml."";
		
        $shtml=$shtml."<td align=center >". $campo['TOTAL'] ."</td>
        ";
        $shtml=$shtml."";


        $shtml=$shtml."</tr>";
			  
			  $j=$j+1;
			  $total = $total + $campo['TOTAL'];

			  
			  		
			  } 
			  } 
              
			          $shtml=$shtml."<tr>";
        $shtml=$shtml."<td colspan=2 align=right>TOTAL DE ATENCIONES</td>";
       
	    $shtml=$shtml."";
        $shtml=$shtml."";        
		$shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."<td align=center bgcolor=#E0E0E0 class=enfasis>". $total ."</td>";
        $shtml=$shtml."";
        $shtml=$shtml."</tr>";
        $shtml=$shtml."<tr>";
        $shtml=$shtml."<td colspan=3 align=center>&nbsp;";
				 
        $shtml=$shtml."</td>";
        $shtml=$shtml."</tr>";
        $shtml=$shtml."</table>
		";
		
echo $shtml;


$scarpeta="../reportes"; //carpeta donde guardar el archivo. 
//debe tener permisos 775 por lo menos 
$sfile=$scarpeta."/reporte.xls"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp); 
echo "<a href='".$sfile."' target='blanck'><img src='../imagenes/export.gif' border='0'><br>Exportar a Excel</a>";		
		
		
		?>			</td>
          </tr>
          <tr>
            <td colspan="7"><?php //echo $consulta->util->devuelve_paginado($consulta->query,$parametros);?></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
<?php  $consulta->con->cerrar(); 

?>
</body>


</html>
<script language="javascript">

function buscar()
{
   document.forms.form1.action='reporte_diagnostico_consulta.php';
   document.forms.form1.method='get';
   document.forms.form1.id.value='1';
   document.forms.form1.submit();
}

</script>

