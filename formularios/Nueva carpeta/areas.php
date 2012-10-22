<?php session_start();
  	
require_once('../clases/usuario_data.php');
$area= new  usuariodata();


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
    <td>
      <?php  include("menu.php");?></td>
  </tr>
  <tr>
    <td align="center">
	

	<?php 
		  if($_REQUEST['id']==='1')
{
	  
$area->area_nuevo($_REQUEST['txtarea'],'0');

}

		
if ($_REQUEST['id']==='2')
{

$area->area_borrar($_REQUEST['area_codigo']);
}
		
		
		
		  
		  ?>

	
	<form name="form1"  id="form1">
        <table width="552" border="0" align="center" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr align="center">
            <td><h5>LISTADO DE AREAS </h5></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">
			<input name="pagina" type="hidden" id="pagina">
			<input name="id" type="hidden" id="id">
			<input name="area_codigo" type="hidden" id="area_codigo"></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="enfasis">Area:
              <input name="txtarea" type="text" id="txtarea" size="40"></td>
          </tr>
          <tr>
            <td align="left" class="enfasis">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><input name="Submit" type="button" class="btn" onClick="nuevo();" value="Grabar Area"> </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="71%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr class="fondonegro">
                <td width="10%" align="center">ORDEN</td>
                <td width="64%" align="center">DESCRIPCI&Oacute;N</td>
                <td colspan="2" align="center">OPCI&Oacute;N</td>
                </tr>
              
			  <?php  
			 // $parametros="&programa=".$_REQUEST['programa'];
			  //metodo para el paginado de productos por  subcategorias
			 $rs= $area->area_listar('2');
			 if($rs)
			 
			 {$j=1;
			  while($campo =mysql_fetch_array($rs)) { ?>
			  <tr bgcolor="#F0F0F0" style="cursor: hand" onMouseOver="bgColor='#Ffffff'" onMouseOut ="bgColor='#F0F0F0'">
                <td align="center"><?php echo $j; ?></td>
                <td align="center"><?php echo strtoupper($campo['area_descripcion']) ?></td>
                <td width="13%" align="center"><?php if ($campo['area_id']==='1'){ echo "&nbsp;"; }else{?><a href="editararea.php?area_id=<?php echo $campo['area_id'];?>">Editar</a><?php }?></td>
                <td width="13%" align="center"><?php if ($campo['area_id']==='1'){ echo "&nbsp;"; }else{?><a href="#" onClick="borrar(<?php echo $campo['area_id']; ?>)">X Quitar</a><?php }?></td>
              </tr>
			  <?php 
			  $j=$j+1;
			  } 
			  } ?>
              <tr>
                <td colspan="4">&nbsp;</td>
                </tr>
              <tr>
                <td colspan="4" align="center"><?php  // echo $vinculo->util->devuelve_paginado($vinculo->query,$parametros,$idioma='1',$color='#006699');  ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>
<script language="javascript">


function nuevo()
{

document.forms.form1.action='areas.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1'
document.forms.form1.submit();
}


function   borrar(area_codigo)
{
   document.forms.form1.id.value='2';
   document.forms.form1.area_codigo.value=area_codigo;
   document.forms.form1.action='areas.php';
   document.forms.form1.method='post';
   document.forms.form1.submit();
}




</script>

