<?php session_start();
  require_once('../clases/consulta_data.php');

$consulta = new Consulta;
$paciente = new Paciente;


 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}


if ($_REQUEST['id']==='1')
{

	for($n=1;$n<=$_SESSION['tfilas'];$n++)

			 
	{
	



		$consulta->consulta_recibo($_REQUEST['con_id'.$n.''],$_REQUEST['recibo'.$n.'']);
		

	}

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

		<!-- jQuery -->
		<script type="text/javascript" src="../librerias/jquery/jquery-1.2.6.pack.js"></script>
        <!-- required plugins -->
		<script type="text/javascript" src="../librerias/date_picker/date.js"></script>

        
        <!-- jquery.datePicker.js -->
		<script type="text/javascript" src="../librerias/date_picker/jquery.datePicker.js"></script>
        
        <!-- datePicker required styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="../librerias/date_picker/datePicker.css">
        
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
           
			  $(function()
			  {
				  $('.date-pick').datePicker({startDate:'01/01/1980'});
			  });
				  
		</script>
</head>

<body  >

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
            <td colspan="7" class="titulo">REGISTRO DE RECIBOS POR ASEGURADOS </td>
          </tr>
		  
          <tr >
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis" >&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right" class="enfasis">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr >
            <td  width="77" align="right" class="enfasis">Fecha inicio</td>
            <td width="11" align="left" class="enfasis" >:</td>
            <td width="125" align="left"><input name="fecha" type="text" id="fecha" value="<?php echo $_REQUEST['fecha']; ?>" size="10" class="date-pick"  /></td>
            <td width="73" align="right" class="enfasis">Fecha Final </td>
            <td width="18" align="left" class="enfasis">:</td>
            <td width="144" align="left"><input name="fechaf" type="text" id="fechaf" value="<?php echo $_REQUEST['fechaf']; ?>" size="10" class="date-pick"/></td>
            <td align="left" class="enfasis"><input name="Submit" type="button" class="btn" onClick="buscar()" value="Buscar"></td>
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
		$shtml="<table width=100% border=0 align=center cellpadding=0 cellspacing=2  >";
        $shtml=$shtml."<tr >";
		$shtml=$shtml."<td colspan=9 align=center><h4>ATENCIONES DE ASEGURADOS DESDE LA FECHA ". $_REQUEST['fecha']." HASTA EL ". $_REQUEST['fechaf']."</h4></td>";
		
        $shtml=$shtml."</tr>";
                $shtml=$shtml."<tr class=fondonegro>
                  <td width=11% align=center>FECHA</td>
                  ";
        $shtml=$shtml."<td width=14% align=center>SEGURO</td>
        <td width=9% align=center>N&deg; HISTORIA </td>
        <td width=9% align=center>N&deg; REGISTRO </td>
        <td width=11% align=center>NOMBRES</td>
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
        $shtml=$shtml."<td width=14% align=center>APELLIDOS</td>
        ";
        $shtml=$shtml."";
        $shtml=$shtml."<td width=11% align=center>INGRESOS  CONSULTAS </td>
        <td width=11% align=center>INGRESOS ADICIONALES </td>
        <td width=11% align=center>N&deg; RECIBO</td>
        ";
        $shtml=$shtml."";
        $shtml=$shtml."</tr>";
              
	
			 $rs= $consulta->reporte_seguro($_REQUEST['fecha'],$_REQUEST['fechaf']);
			 if($rs)
			 
			 {
			 $j=1;
			 $precio='0';
			 $precioa='0';	
			 $total='0';		 
			  while($campo =mysql_fetch_array($rs)) {
			  
			  
        $shtml=$shtml."<tr bgcolor=#FFFFFF style=cursor: hand onMouseOver=bgColor='#F3E212' onMouseOut =bgColor='#FFFFFF'>
          <td align=center >".$consulta->_util->obtiene_fecha($campo['con_fecha']) ."</td>
          ";
        $shtml=$shtml."<td align=center >". $campo['seg_descripcion'] ."</td>
        <td align=center >". $campo['pac_historia'] ."</td>
        <td align=center >". $campo['con_registro'] ."</td>
        <td align=center >". $campo['pac_nombres'] ."</td>
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
        $shtml=$shtml."<td align=center >". $campo['pac_apellidos'] ."</td>
        ";
				
				
				
        $shtml=$shtml."";
		
        $shtml=$shtml."<td align=center >S/. ". $campo['precio'] ."</td>
        <td align=center >S/. ". $campo['adicional'] ."</td>
        <td align=center >";
		
		if ($_REQUEST['id']!='1')
		{
		
		$shtml=$shtml."<input type=hidden name=con_id".$j." value=". $campo['con_id'] .">
          <input type=text name=recibo".$j." size=7 value=". $campo['con_recibo'] ."></td>";
		 }
		 else
		{
		
		$shtml=$shtml."". $campo['con_recibo'] ."</td>";
		 }		 
		  
        $shtml=$shtml."";


        $shtml=$shtml."</tr>";
			  
			  $j=$j+1;
			  $precio = $precio + $campo['precio'];
			  $precioa = $precioa + $campo['adicional'];
			  $total=$total + $campo['consultas'];
			  
			  		
			  } 
			 $_SESSION['tfilas']=$j-1;
			   $sumatotal=$precio + $precioa;
			  } 
              
			          $shtml=$shtml."<tr>
			            <td align=right>&nbsp;</td>
			            ";
        $shtml=$shtml."<td align=right>&nbsp;</td>
        <td align=center>&nbsp;</td>
        <td align=center>&nbsp;</td>
        <td align=center>&nbsp;</td>
        <td align=center>TOTALES</td>
        ";
       
	    $shtml=$shtml."";
        $shtml=$shtml."";        
		$shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."";
        $shtml=$shtml."<td align=center bgcolor=#E0E0E0 class=enfasis>S/. ". number_format($precio,2) ."</td>
        <td align=center bgcolor=#E0E0E0 class=enfasis>S/. ". number_format($precioa,2) ."</td>
        <td align=center class=enfasis>&nbsp;</td>
        ";
        $shtml=$shtml."";
        $shtml=$shtml."</tr>
			          <tr>
			            <td align=right>&nbsp;</td>
			            <td align=right>&nbsp;</td>
			            <td align=center>&nbsp;</td>
			            <td align=center>&nbsp;</td>
			            <td align=center>&nbsp;</td>
			            <td align=center>&nbsp;</td>
			            <td align=center bgcolor=#E0E0E0 class=enfasis>TOTAL INGRESOS </td>
			            <td align=center bgcolor=#E0E0E0 class=enfasis>S/. ".number_format($sumatotal,2)."</td>
	                    <td align=center class=enfasis>&nbsp;</td>
	            </tr>
	            ";
        $shtml=$shtml."<tr>";
        $shtml=$shtml."<td colspan=9 align=center>&nbsp;";
				 
        $shtml=$shtml."</td>";
        $shtml=$shtml."</tr>";
        $shtml=$shtml."</table>
		";
		
echo $shtml;


$scarpeta="../reportes"; //carpeta donde guardar el archivo. 
$sfile=$scarpeta."/reporte.xls"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp); 

if($_REQUEST['id']==='1'){
echo "<a href='".$sfile."' target='blanck'><img src='../imagenes/export.gif' border='0'><br>Exportar a Excel</a>";		
} 		
		
		?>			</td>
          </tr>
          <tr>
            <td colspan="7"><?php if($_REQUEST['id']!='1'){?>
            <input name="Submit2" type="button" class="btn" value="Grabar Recibos" onClick="grabar();">
			<?php } ?></td>
			
          </tr>
        </table>
    </form></td>
  </tr>
</table>
<?php  $consulta->_util->_cn->desconectar(); 

?>
</body>


</html>
<script language="javascript">

function buscar()
{
   document.forms.form1.action='asegurados_registro.php';
   document.forms.form1.method='get';
   document.forms.form1.submit();
}
function grabar()
{
   document.forms.form1.action='asegurados_registro.php';
   document.forms.form1.method='get';
   document.forms.form1.id.value='1';
   document.forms.form1.submit();
}
</script>

