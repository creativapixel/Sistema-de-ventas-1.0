<?php //session_start();
//require('../impresion/fpdf.php');
require('../impresion/mc_table.php');
require_once('../clases/ingresos_data.php');

$ingreso = new Ingreso;	
$producto = new Producto;
//$tipoproducto = new Tipoproducto;

		
$pdf=new PDF_MC_Table();



class PDF extends FPDF
{




//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}





$pdf->FPDF('P','mm','A4');






//$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(15);
$pdf->PageNo();
//$pdf->SetTopMargin(0);


$pdf->AddPage();
$pdf->SetFont('Arial','',7);



$pdf->Cell(190,10,'REPORTE DE INGRESO DE PRODUCTOS',0,0,'C');
$pdf->Ln(10);



$pdf->Cell(150,5,'INGRESOS REGISTRADOS DESDE EL '.$_REQUEST['fecha'].' AL '.$_REQUEST['fecha2'].'',0,0,'L');
$pdf->Ln(5);

$pdf->Cell(275,5,'',0,0,'C');
$pdf->Ln(5);




$pdf->SetWidths(array(27,120,20));	
//srand(microtime()*1000000);
$pdf->Row(array('FECHA DE INGRESO','DESCRIPCION','CANTIDAD'));

$rs= $ingreso->ingresos_listar_fecha($_REQUEST['fecha'],$_REQUEST['fecha2']);

//$rs= mysql_query($rs,$cargo->con->cn);

if($rs)
{
	
		$j=1;
		$suma_cantidad=0;
	while($campo =mysql_fetch_array($rs)) 
	{
		//cargamos a las variables los campos de la bd
		$fecha=$ingreso->_util->obtiene_fecha($campo['ing_fecha']);
		$descripcion=$campo['pro_descripcion'];
		$cantidad=$campo['ing_cantidad'];
		
	
		$pdf->Row(array($fecha,$descripcion,$cantidad));

		$suma_cantidad=$suma_cantidad + $cantidad;

		$j=$j+1;
				

  	 } 
}


//$pdf->Row(array('','','','Total',number_format($suma_cantidad,2).' '.$unidad));



//$ingreso->con->cerrar(); 

//$pdf->WriteHTML($htmlTable);
$pdf->Output();
?>

