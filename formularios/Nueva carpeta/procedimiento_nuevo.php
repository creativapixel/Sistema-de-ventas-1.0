<?php session_start();
  	
require_once('../clases/consulta_data.php');
$consulta = new Consulta;

 if(!isset($_SESSION['sesion_id_usuario']))
 	{
		die("No tiene acceso  a esta seccion");
 	}



	if (isset($_REQUEST['codigo_consulta']))
	{
		$_SESSION['codigo_consulta']=$_REQUEST['codigo_consulta'];		
	}
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>NUEVO PROCEDIMIENTO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos/css_sistema.css" rel="stylesheet" type="text/css" />
<link href="../imagenes/logo.ico" type="image/x-icon" rel="shortcut icon">
</head>
<?php 
		if($_REQUEST['id']==='1')
		{
	  
			$rs=$consulta->procedimiento_nuevo($_REQUEST['procedimiento'],'0');
			if ($rs)
			{
			echo "<script  LANGUAGE='JavaScript'> window.opener.location.href = 'consulta_procedimiento.php?procedimiento=".$_SESSION['procedimiento_id']."&codigo_consulta=".$_SESSION['codigo_consulta']."';
window.close();  </script>";	
			}
		}

?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;
    </td>
  </tr>
  <tr>
    <td align="center">


	
	<form name="form1"  id="form1">
	  <table width="378" border="0" align="center" cellpadding="0">
          <tr>
            <td colspan="3" align="center"><h5>
              <input name="id" type="hidden" id="id">

            </h5>		    </td>
          </tr>
          
          <tr>
            <td width="87" align="left" valign="top" class="enfasis">Procedimiento</td>
            <td width="14" align="center" valign="top" class="enfasis">:</td>
            <td width="269" align="left" valign="top" class="enfasis"><input name="procedimiento" type="text" id="procedimiento" size="40"  onkeyup='fn(this.form,this)' ></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="enfasis"><input name="pagina" type="hidden" id="pagina"></td>
          </tr>
          <tr>
            <td colspan="3" align="center">
			
			<input name="enviar" type="button" class="btn" onClick="nuevo();" value="Grabar Procedimiento">
			&nbsp;&nbsp;
			<label>
              <input name="cerrar" type="button" class="btn" onClick="window.close();" value="Cerrar Ventana">
            </label>			</td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</body>


</html>
<script src="../javascript/valida.js">  </script>
<script language="javascript">


function nuevo()
{

	if (document.forms.form1.procedimiento.value=="")
	{ 
		document.forms.form1.procedimiento.focus();
		alert("Ingresar Procedimiento");
		return false; 
	}

document.forms.form1.action='procedimiento_nuevo.php';
document.forms.form1.method='post';
document.forms.form1.id.value='1';
document.forms.form1.submit();
}





</script>

