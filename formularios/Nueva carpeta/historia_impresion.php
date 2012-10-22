<?php //session_start();
require('../impresion/fpdf.php');
require_once('../clases/paciente_data.php');
$paciente = new Paciente;
$pdf=new FPDF('P','cm','A4','',''); //ingreso medida puntos 
//$pdf=new FPDF('P','cm','custom',595.4,842.3); 
$pdf->SetTopMargin(1.0); //margen superior
$pdf->SetLeftMargin(1.4); //margen izquierdo
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$paciente->paciente_ver($_REQUEST['codigo']);
$nro_historia=$paciente->pac_historia;
$nombres=strtoupper($paciente->pac_nombres);
$apellidos=strtoupper($paciente->pac_apellidos);
$direccion=strtoupper($paciente->pac_direccion);
$fecharegistro=$paciente->_util->obtiene_fecha($paciente->pac_fecharegistro);
$fechanac=$paciente->_util->obtiene_fecha($paciente->pac_fechanac);

if ($paciente->pac_estadocivil==='1')
{
	$estadocivil= 'SOLTERO';
}
elseif ($paciente->pac_estadocivil==='2')
{
	$estadocivil= 'CASADO';
}
elseif ($paciente->pac_estadocivil==='3')
{
	$estadocivil= 'DIVORCIADO';
}
else
{
	$estadocivil= 'VIUDO';		
};

if ($paciente->pac_sexo==='1'){	$sexo= 'FEMENINO';
}else{ $sexo= 'MASCULINO';	};


$ocupacion=$paciente->pac_ocupacion;
$telefono=$paciente->pac_telefono;
$celular=$paciente->pac_celular;
$email=$paciente->pac_email;

if ($paciente->pac_foto=='')
{
	$foto="../imagenes/silueta.jpg";
}
else
{
	$foto="../".$paciente->pac_foto;
}


if ($paciente->pac_tipo==='1'){	$tipo= 'PARTICULAR';
}else{ $tipo= 'SEGURO';	};

$procedencia=$paciente->pac_procedencia;

$seguro=$paciente->devuelve_seguro($paciente->seg_id);

$departamento=$paciente->devuelve_departamento($paciente->dep_id);

$provincia=$paciente->devuelve_provincia($paciente->prov_id);
$pdf->Cell(17.8,1.9,'HISTORIA CLINICA',0,0,'C');
$pdf->Ln(1.9);
$pdf->Cell(7.2,4,'',0,0,'L');
$pdf->Cell(3.5,4,'FOTO',1,0,'C');
$pdf->Image($foto,8.64,2.93,3.45,3.92,'');
$pdf->Cell(7.1,4,'',0,0,'L');
$pdf->Ln(4);
$pdf->Cell(17.8,1.3,'',0,0,'L');
$pdf->Ln(1.3);
$pdf->Cell(3.5,0.8,'Nº DE HISTORIA',1,0,'L');
$pdf->Cell(5.4,0.8,$nro_historia,1,0,'L');
$pdf->Cell(3.5,0.8,'FECHA REGISTRO',1,0,'L');
$pdf->Cell(5.4,0.8,$fecharegistro,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'NOMBRES',1,0,'L');
$pdf->Cell(5.4,0.8,$nombres,1,0,'L');
$pdf->Cell(3.5,0.8,'APELLIDOS',1,0,'L');
$pdf->Cell(5.4,0.8,$apellidos,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'SEXO',1,0,'L');
$pdf->Cell(5.4,0.8,$sexo,1,0,'L');
$pdf->Cell(3.5,0.8,'FEC. NACIMIENTO',1,0,'L');
$pdf->Cell(5.4,0.8,$fechanac,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'ESTADO CIVIL',1,0,'L');
$pdf->Cell(5.4,0.8,$estadocivil,1,0,'L');
$pdf->Cell(3.5,0.8,'TIPO PACIENTE',1,0,'L');
$pdf->Cell(5.4,0.8,$tipo,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'SEGURO',1,0,'L');
$pdf->Cell(14.3,0.8,$seguro,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'DEPARTAMENTO',1,0,'L');
$pdf->Cell(5.4,0.8,$departamento,1,0,'L');
$pdf->Cell(3.5,0.8,'CIUDAD',1,0,'L');
$pdf->Cell(5.4,0.8,$provincia,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'DIRECCION',1,0,'L');
$pdf->Cell(14.3,0.8,$direccion,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'PROCEDENCIA',1,0,'L');
$pdf->Cell(5.4,0.8,$procedencia,1,0,'L');
$pdf->Cell(3.5,0.8,'OCUPACION',1,0,'L');
$pdf->Cell(5.4,0.8,$ocupacion,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'TELEFONO',1,0,'L');
$pdf->Cell(5.4,0.8,$telefono,1,0,'L');
$pdf->Cell(3.5,0.8,'CELULAR',1,0,'L');
$pdf->Cell(5.4,0.8,$celular,1,0,'L');
$pdf->Ln(0.8);
$pdf->Cell(3.5,0.8,'EMAIL',1,0,'L');
$pdf->Cell(14.3,0.8,$email,1,0,'L');
$pdf->Output();


?>