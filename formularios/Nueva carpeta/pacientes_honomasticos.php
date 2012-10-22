<?php session_start();
  	
require_once('../clases/paciente_data.php');
$paciente = new Paciente;

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}
 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA DE GESTION DE CONSULTORIO MEDICO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">

</head>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	



	
	<form name="form1"  id="form1">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="titulo">BUSQUEDAS  DE CUMPLEA&Ntilde;OS DE PACIENTES </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;<span class="enfasis">
              <input name="pagina" type="hidden" id="pagina">
              <input name="id" type="hidden" id="id">
              <input name="paciente_codigo" type="hidden" id="paciente_codigo">
            </span></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
              <tr>
                <td width="9%" align="right" class="enfasis">Desde</td>
                <td width="2%" align="center" class="enfasis">:</td>
                <td width="15%" align="left"><select name="mes1" id="mes1">
                  <option value="0" <?php if($_REQUEST['mes1']==='0'){ echo "Selected";}?>>Seleccionar</option>
                  <option value="1" <?php if($_REQUEST['mes1']==='1'){ echo "Selected";}?>>Enero</option>
                  <option value="2" <?php if($_REQUEST['mes1']==='2'){ echo "Selected";}?>>Febrero</option>
                  <option value="3" <?php if($_REQUEST['mes1']==='3'){ echo "Selected";}?>>Marzo</option>
                  <option value="4" <?php if($_REQUEST['mes1']==='4'){ echo "Selected";}?>>Abril</option>
                  <option value="5" <?php if($_REQUEST['mes1']==='5'){ echo "Selected";}?>>Mayo</option>
                  <option value="6" <?php if($_REQUEST['mes1']==='6'){ echo "Selected";}?>>Junio</option>
                  <option value="7" <?php if($_REQUEST['mes1']==='7'){ echo "Selected";}?>>Julio</option>
                  <option value="8" <?php if($_REQUEST['mes1']==='8'){ echo "Selected";}?>>Agosto</option>
                  <option value="9" <?php if($_REQUEST['mes1']==='9'){ echo "Selected";}?>>Setiembre</option>
                  <option value="10" <?php if($_REQUEST['mes1']==='10'){ echo "Selected";}?>>Octubre</option>
                  <option value="11" <?php if($_REQUEST['mes1']==='11'){ echo "Selected";}?>>Noviembre</option>
                  <option value="12" <?php if($_REQUEST['mes1']==='12'){ echo "Selected";}?>>Diciembre</option>
                </select>
                </td>
                <td width="10%" align="right"><span class="enfasis">Hasta</span></td>
                <td width="3%" align="center"><span class="enfasis">:</span></td>
                <td width="17%" align="left"><select name="mes2" id="mes2">
                  <option value="0" <?php if($_REQUEST['mes2']==='0'){ echo "Selected";}?>>Seleccionar</option>
                  <option value="1" <?php if($_REQUEST['mes2']==='1'){ echo "Selected";}?>>Enero</option>
                  <option value="2" <?php if($_REQUEST['mes2']==='2'){ echo "Selected";}?>>Febrero</option>
                  <option value="3" <?php if($_REQUEST['mes2']==='3'){ echo "Selected";}?>>Marzo</option>
                  <option value="4" <?php if($_REQUEST['mes2']==='4'){ echo "Selected";}?>>Abril</option>
                  <option value="5" <?php if($_REQUEST['mes2']==='5'){ echo "Selected";}?>>Mayo</option>
                  <option value="6" <?php if($_REQUEST['mes2']==='6'){ echo "Selected";}?>>Junio</option>
                  <option value="7" <?php if($_REQUEST['mes2']==='7'){ echo "Selected";}?>>Julio</option>
                  <option value="8" <?php if($_REQUEST['mes2']==='8'){ echo "Selected";}?>>Agosto</option>
                  <option value="9" <?php if($_REQUEST['mes2']==='9'){ echo "Selected";}?>>Setiembre</option>
                  <option value="10" <?php if($_REQUEST['mes2']==='10'){ echo "Selected";}?>>Octubre</option>
                  <option value="11" <?php if($_REQUEST['mes2']==='11'){ echo "Selected";}?>>Noviembre</option>
                  <option value="12" <?php if($_REQUEST['mes2']==='12'){ echo "Selected";}?>>Diciembre</option>
                </select></td>
                <td width="44%" align="left"><span class="enfasis">
                  <input name="Submit" type="button" class="btn" onClick="buscar();" value="Buscar Honomastico">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="665"><table width="776" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <th width="7%" align="center">NRO. HISTORIA </th>
                <th width="13%" align="center">NOMBRES</th>
                <th width="12%" align="center">APELLIDOS</th>
                <th width="9%" align="center">FECHA NACIMIENTO </th>
                <th width="11%" align="center">EDAD POR CUMPLIR </th>
                <th width="20%" align="center">TELEFONO / CELULAR </th>
                <th width="28%" align="center">E-MAIL</th>
              </tr>

              <tr>
                <td colspan="7"></td>
              </tr>
            </table></td>
            <td width="8">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center">
			
			<div style="position:static;width:800px; height:300px; overflow:scroll; z-index:1;  ">
			<table width="776" border="0" align="left" cellpadding="0" cellspacing="2">

              <?php  

			 if($_REQUEST['mes1']!=0 and $_REQUEST['mes2']!=0)
			 {
			 $rs= $paciente->paciente_honomastico($_REQUEST['mes1'],$_REQUEST['mes2']);
		
			  if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
              <tr bgcolor="#FFFFFF" style="cursor: hand" onMouseOver="bgColor='#F3E212'" onMouseOut ="bgColor='#FFFFFF'">
                <td width="7%" align="center"><?php echo $campo['pac_historia'] ?></td>
                <td width="13%" align="center"><?php echo strtoupper($campo['pac_nombres']) ?></td>
                <td width="12%" align="center"><?php echo strtoupper($campo['pac_apellidos']) ?></td>
                <td width="9%" align="center"><?php echo $paciente->_util->obtiene_fecha($campo['pac_fechanac']); ?></td>
                <td width="11%" align="center"><?php echo $paciente->_util->calcular_edad($campo['pac_fechanac'] ) + 1 ?> Años</td>
                <td width="20%" align="center"><?php echo $campo['pac_telefono'] ?>  / <?php echo $campo['pac_celular'] ?></td>
                <td width="28%" align="center"><a href="mailto:<?php echo $campo['pac_email'] ?>"><?php echo $campo['pac_email'] ?></a></td>
              </tr>
              <?php 
			  $j=$j+1;
			  		} 
			  	} 
			 }
			  ?>
            </table>
			</div>			</td>
          </tr>
          <tr>
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
	</form></td>
  </tr>
</table>
</body>
<?php $paciente->_util->_cn->desconectar();?>

</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">



function buscar()
{

document.forms.form1.action='pacientes_honomasticos.php';
document.forms.form1.method='post';
document.forms.form1.submit();

}








</script>

